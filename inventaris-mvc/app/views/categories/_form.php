<?php $value = fn(string $key, $default = '') => e($category[$key] ?? $default); ?>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="<?= $value('name') ?>" required>
    </div>
    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" rows="3" class="form-control"><?= $value('description') ?></textarea>
    </div>
</div>