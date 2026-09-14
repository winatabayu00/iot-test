<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1>New Transaction</h1>
<p>Prices shown are indicative. Server recalculates from database.</p>
<form method="post" action="/transactions" id="trx-form">
<?= csrf_field() ?>
<label>Customer<br><select name="customer_id" required>
<option value="">-- choose --</option>
<?php foreach ($customers as $c): ?><option value="<?= esc($c['id']) ?>"><?= esc($c['name']) ?></option><?php endforeach; ?>
</select></label><br><br>
<label>Payment Method<br><select name="payment_method"><option>cash</option><option>transfer</option><option>qris</option></select></label><br><br>
<div id="rows">
<div class="row"><select name="product_id[]" required>
<option value="">-- product --</option>
<?php foreach ($products as $p): ?><option value="<?= esc($p['id']) ?>" data-price="<?= esc($p['price']) ?>"><?= esc($p['name']) ?> (<?= esc($p['stock']) ?>)</option><?php endforeach; ?>
</select> <input name="quantity[]" type="number" min="1" value="1" required></div>
</div>
<p><button type="button" onclick="addRow()">+ Add Item</button></p>
<button>Submit Transaction</button>
</form>
<script>
function addRow(){document.getElementById('rows').appendChild(document.querySelector('#rows .row').cloneNode(true));}
</script>
<?= $this->endSection() ?>
