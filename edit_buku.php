<?php
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: buku.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $penulis_id = $_POST['penulis_id'];
    $tahun_terbit = $_POST['tahun_terbit'];

    try {
        $stmt = $pdo->prepare("UPDATE buku SET judul = ?, penulis_id = ?, tahun_terbit = ? WHERE id = ?");
        $stmt->execute([$judul, $penulis_id, $tahun_terbit, $id]);
        header("Location: buku.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Get current book data
$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    header("Location: buku.php");
    exit();
}

// Get all authors for dropdown
$stmt = $pdo->query("SELECT * FROM penulis ORDER BY nama");
$penulis = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Buku</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" 
                       value="<?php echo htmlspecialchars($book['judul']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="penulis_id" class="form-label">Penulis</label>
                <select class="form-control" id="penulis_id" name="penulis_id" required>
                    <?php foreach ($penulis as $p): ?>
                        <option value="<?php echo $p['id']; ?>" 
                                <?php echo ($p['id'] == $book['penulis_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($p['nama']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" 
                       value="<?php echo htmlspecialchars($book['tahun_terbit']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="buku.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>