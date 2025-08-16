<?php
require 'db.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    if ($role === 'admin') {
        die("You cannot register as admin.");
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed, $role);

    if ($stmt->execute()) {
        $msg = "Registered successfully. <a href='login.php'>Login</a>";
    } else {
        $msg = "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <h2>Register</h2>
    <?php if ($msg): ?><div class="alert alert-info"><?= $msg ?></div><?php endif; ?>
    <form method="post" class="bg-white p-4 shadow-sm rounded">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required />
        </div>
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
            </select>
        </div>
        <button class="btn btn-primary">Register</button>
    </form>
</div>
</body>
</html>
