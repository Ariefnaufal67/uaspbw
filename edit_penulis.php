<?php
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: penulis.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    try {
        $stmt = $pdo->prepare("UPDATE penulis SET nama = ? WHERE id = ?");
        $stmt->execute([$nama, $id]);
        header("Location: penulis.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Get current author data
$stmt = $pdo->prepare("SELECT * FROM penulis WHERE id = ?");
$stmt->execute([$id]);
$penulis = $stmt->fetch();

if (!$penulis) {
    header("Location: penulis.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penulis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Penulis</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Penulis</label>
                <input type="text" class="form-control" id="nama" name="nama" 
                       value="<?php echo htmlspecialchars($penulis['nama']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="penulis.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>