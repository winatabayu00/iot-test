<?php

namespace App\Services;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\TransactionItemModel;
use App\Models\TransactionModel;
use Config\Database;
use RuntimeException;

/**
 * Purchase flow. Price always comes from the database,
 * never from the browser. Stock decrement is conditional
 * so it can never go negative, even under race.
 */
class TransactionService
{
    /**
     * @param array{customer_id:int, payment_method:string, items:array<int,array{product_id:int, quantity:int}>} $payload
     */
    public function createTransaction(array $payload): int
    {
        $customer = (new CustomerModel())->find($payload['customer_id'] ?? null);
        if ($customer === null) {
            throw new RuntimeException('Customer not found.');
        }

        $items = $payload['items'] ?? [];
        if (! is_array($items) || $items === []) {
            throw new RuntimeException('At least one product item is required.');
        }

        // Normalize: merge duplicate product lines, drop invalid rows.
        $merged = [];
        foreach ($items as $row) {
            $pid = (int) ($row['product_id'] ?? 0);
            $qty = (int) ($row['quantity'] ?? 0);
            if ($pid <= 0 || $qty <= 0) {
                throw new RuntimeException('Each item needs a valid product and quantity > 0.');
            }
            $merged[$pid] = ($merged[$pid] ?? 0) + $qty;
        }

        // Build trusted lines from DB price/stock.
        $productModel = new ProductModel();
        $trusted      = [];
        $total        = '0';
        foreach ($merged as $pid => $qty) {
            $product = $productModel->find($pid);
            if ($product === null) {
                throw new RuntimeException("Product #{$pid} not found.");
            }
            if ((int) $product['stock'] < $qty) {
                throw new RuntimeException("Insufficient stock for {$product['name']} (have {$product['stock']}, need {$qty}).");
            }
            $price    = number_format((float) $product['price'], 2, '.', '');
            $subtotal = number_format((float) $price * $qty, 2, '.', '');
            $total    = number_format((float) $total + (float) $subtotal, 2, '.', '');
            $trusted[] = [
                'product_id' => $pid,
                'quantity'   => $qty,
                'unit_price' => $price,
                'subtotal'   => $subtotal,
            ];
        }

        $db = Database::connect();
        $db->transStart();

        try {
            $transactionModel = new TransactionModel();
            $transactionId    = $transactionModel->insert([
                'customer_id'        => $customer['id'],
                'transaction_number' => 'TRX-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3))),
                'payment_method'     => substr((string) ($payload['payment_method'] ?? 'cash'), 0, 30),
                'total_amount'       => $total,
            ], true);

            if (! $transactionId) {
                throw new RuntimeException('Failed to save transaction: ' . implode(', ', $transactionModel->errors()));
            }

            $itemModel = new TransactionItemModel();
            foreach ($trusted as $line) {
                $itemModel->insert([
                    'transaction_id' => $transactionId,
                    'product_id'     => $line['product_id'],
                    'quantity'       => $line['quantity'],
                    'unit_price'     => $line['unit_price'],
                    'subtotal'       => $line['subtotal'],
                ]);

                // Conditional decrement: affected rows must be 1, else stock changed underneath us.
                $db->query(
                    'UPDATE products SET stock = stock - ?, updated_at = NOW() WHERE id = ? AND stock >= ?',
                    [$line['quantity'], $line['product_id'], $line['quantity']]
                );
                if ($db->affectedRows() !== 1) {
                    throw new RuntimeException('Stock changed during checkout, transaction aborted.');
                }
            }

            $db->transComplete();
            if ($db->transStatus() === false) {
                throw new RuntimeException('Transaction failed, rolled back.');
            }

            return (int) $transactionId;
        } catch (\Throwable $e) {
            if ($db->transStatus() !== false) {
                $db->transRollback();
            }
            throw $e;
        }
    }
}
