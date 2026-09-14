<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1><?= esc($title) ?></h1>
<?php $isEdit = isset($product['id']); ?>
<form method="post" action="<?= $isEdit ? '/products/' . esc($product['id']) : '/products' ?>">
<?= csrf_field() ?>
<label>Name<br><input name="name" value="<?= esc(old('name', $product['name'] ?? '')) ?>" required></label><br><br>
<label>Price<br><input name="price" type="number" step="0.01" min="0.01" value="<?= esc(old('price', $product['price'] ?? '')) ?>" required></label><br><br>
<label>Stock<br><input name="stock" type="number" min="0" value="<?= esc(old('stock', $product['stock'] ?? 0)) ?>" required></label><br><br>
<label>Description<br><textarea name="description"><?= esc(old('description', $product['description'] ?? '')) ?></textarea></label><br><br>
<button>Save</button> <a href="/products">Cancel</a>
</form>
<?= $this->endSection() ?>
