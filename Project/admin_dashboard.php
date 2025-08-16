<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$currentSection = $_GET['section'] ?? 'clients';
$role = $currentSection === 'clients' ? 'client' : 'lawyer';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <style>
        .sidebar { min-height: 100vh; background-color: #343a40; color: white; }
        .sidebar a { color: white; display: block; padding: 10px 15px; text-decoration: none; }
        .sidebar a:hover, .sidebar .active { background-color: #495057; }
    </style>
</head>
<body>
<div class="row g-0">
    <div class="col-md-3 sidebar">
        <h4 class="p-3">Admin Panel</h4>
        <a href="?section=clients" class="<?= $currentSection == 'clients' ? 'active' : '' ?>">Clients</a>
        <a href="?section=lawyers" class="<?= $currentSection == 'lawyers' ? 'active' : '' ?>">Lawyers</a>
        <a href="logout.php" class="text-danger mt-3 d-block px-3">Logout</a>
    </div>
    <div class="col-md-9 p-4">
        <h3><?= ucfirst($role) ?> Profiles</h3>
        <?php
        $stmt = $conn->prepare("SELECT id, name, email FROM users WHERE role = ?");
        $stmt->bind_param("s", $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows) {
            echo "<table class='table table-bordered'><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr></thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>
                        <a href='edit_user.php?id={$row['id']}' class='btn btn-sm btn-primary'>Edit</a>
                        <a href='delete_user.php?id={$row['id']}' onclick=\"return confirm('Delete user?')\" class='btn btn-sm btn-danger'>Delete</a>
                    </td>
                </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No $role accounts found.</p>";
        }
        ?>
    </div>
</div>
</body>
</html>
