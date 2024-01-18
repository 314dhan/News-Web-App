<div class="container mt-3">
    <?php if (session('role') === 'author'): ?>
        <a href="/" class="btn btn-primary">Kembali</a>
        <h2>Create News</h2>
        <?php if(session()->has('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach(session('errors') as $error): ?>
                    <?= esc($error) ?><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php echo form_open('auth/create', ['enctype' => 'multipart/form-data']); ?>
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="1">Technology</option>
                <option value="2">Olahraga</option>
                <option value="3">Otomotif</option>
                <option value="4">Kesehatan</option>
                <option value="5">Keuangan</option>
            </select>
        </div>
        <?php $session = session();$author_id = $session->get('user_id'); ?>
        <input type="hidden" id="author_id" name="author_id" value="<?= $author_id ?>">
        <input type="hidden" id="created_at" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
        <input type="hidden" id="updated_at" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
        <button type="submit" class="btn btn-success">Buat Berita</button>
        <?php echo form_close(); ?>
    <?php else: ?>
        <p>anda tidak memiliki hak akses</p>
    <?php endif; ?>
</div>
