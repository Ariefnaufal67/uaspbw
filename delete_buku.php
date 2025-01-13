<?php
include "connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM buku WHERE id = ?");
        $stmt->execute([$id]);
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

header("Location: buku.php");
exit();
?>