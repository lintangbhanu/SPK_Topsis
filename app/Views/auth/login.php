<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>

<body class="login-body">
    <div class="form-container">
        <form method="post" action="/auth/prosesLogin" class="login-form">
            <h2 class="text-center mb-4">Login</h2>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="username" class="form-label fw-bold">Username:</label>
                <input type="text" id="username" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>

</html>