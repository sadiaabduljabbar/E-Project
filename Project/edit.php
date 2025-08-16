<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $id);
    $stmt->execute();

    $msg = "User updated successfully.";
}

// Fetch user
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <h3>Edit User</h3>
    <?php if ($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>

    <form method="post" class="bg-white p-4 shadow-sm">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control" required />
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control" required />
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="admin_dashboard.php?section=<?= $user['role'] ?>" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
