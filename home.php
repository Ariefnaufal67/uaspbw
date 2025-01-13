<?php
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Perpustakaan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-violet-light">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-book-reader me-2"></i>Perpustakaan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="buku.php">
                            <i class="fas fa-book me-1"></i> Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="penulis.php">
                            <i class="fas fa-pen-fancy me-1"></i> Penulis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pengguna.php">
                            <i class="fas fa-users me-1"></i> Pengguna
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4 text-center" style="color: var(--primary-violet-dark);">
            <i class="fas fa-home me-2"></i>
            Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
        </h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card stats-card mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-violet">
                            <i class="fas fa-books me-2"></i>Total Buku
                        </h5>
                        <?php
                        $stmt = $pdo->query("SELECT COUNT(*) as total FROM buku");
                        $total_buku = $stmt->fetch()['total'];
                        ?>
                        <p class="card-text display-4"><?php echo $total_buku; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-violet">
                            <i class="fas fa-pen-fancy me-2"></i>Total Penulis
                        </h5>
                        <?php
                        $stmt = $pdo->query("SELECT COUNT(*) as total FROM penulis");
                        $total_penulis = $stmt->fetch()['total'];
                        ?>
                        <p class="card-text display-4"><?php echo $total_penulis; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-violet">
                            <i class="fas fa-users me-2"></i>Total Pengguna
                        </h5>
                        <?php
                        $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
                        $total_users = $stmt->fetch()['total'];
                        ?>
                        <p class="card-text display-4"><?php echo $total_users; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>