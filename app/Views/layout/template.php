<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'APK Skripsi' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <header>
        <h1>APK Skripsi</h1>
        <nav>
            <a href="/dashboard">Dashboard</a> |
            <a href="/pemain">Pemain</a> |
            <a href="/user">User</a> |
            <a href="/logout">Logout</a>
        </nav>
    </header>
    <main>
        <?= $this->renderSection('content') ?>
    </main>
    <footer>
        <p>&copy; <?= date('Y') ?> APK Skripsi</p>
    </footer>
</body>

</html>