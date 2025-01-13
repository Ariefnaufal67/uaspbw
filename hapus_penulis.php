<?php
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        // Check if author has any books
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM buku WHERE penulis_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        
        if ($result['total'] == 0) {
            $stmt = $pdo->prepare("DELETE FROM penulis WHERE id = ?");
            $stmt->execute([$id]);
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

header("Location: penulis.php");
exit();
?>