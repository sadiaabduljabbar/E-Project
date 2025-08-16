<?php
session_start();
require 'db.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'role' => $user['role']
            ];
            if ($user['role'] === 'admin') {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: dashboard.php');
            }
            exit;
        }
    }
    $msg = "Invalid login.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <h2>Login</h2>
    <?php if ($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
    <form method="post" class="bg-white p-4 shadow-sm rounded">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select" required>
                <option value="client">Client</option>
                <option value="lawyer">Lawyer</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>
