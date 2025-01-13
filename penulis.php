<?php
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission for new author
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    try {
        $stmt = $pdo->prepare("INSERT INTO penulis (nama) VALUES (?)");
        $stmt->execute([$nama]);
        header("Location: penulis.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$stmt = $pdo->query("SELECT p.*, COUNT(b.id) as total_buku 
                     FROM penulis p 
                     LEFT JOIN buku b ON p.id = b.penulis_id 
                     GROUP BY p.id");
$penulis = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Penulis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="home.php">Perpustakaan</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Manajemen Penulis</h2>
        
        <!-- Form Tambah Penulis -->
        <form method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="nama" placeholder="Nama Penulis" required>
                        <button type="submit" class="btn btn-primary">Tambah Penulis</button>
                    </div>
                </div>
            </div>
        </form>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Total Buku</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($penulis as $p): ?>
                <tr>
                    <td><?php echo htmlspecialchars($p['id']); ?></td>
                    <td><?php echo htmlspecialchars($p['nama']); ?></td>
                    <td><?php echo htmlspecialchars($p['total_buku']); ?></td>
                    <td>
                        <a href="edit_penulis.php?id=<?php echo $p['id']; ?>" 
                           class="btn btn-sm btn-warning">Edit</a>
                        <?php if ($p['total_buku'] == 0): ?>
                            <a href="hapus_penulis.php?id=<?php echo $p['id']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Yakin ingin menghapus penulis ini?')">Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>