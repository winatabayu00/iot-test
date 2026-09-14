<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1><?= esc($title) ?></h1>
<?php $isEdit = isset($customer['id']); ?>
<form method="post" action="<?= $isEdit ? '/customers/' . esc($customer['id']) : '/customers' ?>">
<?= csrf_field() ?>
<label>Name<br><input name="name" value="<?= esc(old('name', $customer['name'] ?? '')) ?>" required></label><br><br>
<label>Email<br><input name="email" type="email" value="<?= esc(old('email', $customer['email'] ?? '')) ?>"></label><br><br>
<label>Phone<br><input name="phone" value="<?= esc(old('phone', $customer['phone'] ?? '')) ?>"></label><br><br>
<button>Save</button> <a href="/customers">Cancel</a>
</form>
<?= $this->endSection() ?>
