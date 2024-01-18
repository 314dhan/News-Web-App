<div class="container text-center">
    <?php if (session('role') === 'admin'): ?>
        <a href="<?= site_url('auth/logout') ?>" type="button" class="btn btn-danger mb-3">Keluar</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>name</th>
                <th>email</th>
                <th>role</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['username']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['role']; ?></td>
                    <td><a href="/delete/<?= $user['id']; ?>" class="btn btn-danger">Delete</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Anda tidak memiliki akses.</p>
    <?php endif; ?>
</div>
