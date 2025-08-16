<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= ucfirst(htmlspecialchars($user['role'])) ?> Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="#">Lawyers Portal</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <span class="nav-link disabled">Hello, <?= htmlspecialchars($user['name']) ?></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <h1 class="mb-4"><?= ucfirst(htmlspecialchars($user['role'])) ?> Dashboard</h1>
  
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Welcome, <?= htmlspecialchars($user['name']) ?>!</h5>
      <p class="card-text">You are logged in as a <strong><?= htmlspecialchars($user['role']) ?></strong>.</p>

      <?php if ($user['role'] == 'client'): ?>
        <p>This is your client dashboard. You can view lawyers, book consultations, and manage your profile.</p>

      <?php elseif ($user['role'] == 'lawyer'): ?>
        <p>This is your lawyer dashboard. You can manage your cases, view clients, and update your availability.</p>

      <?php elseif ($user['role'] == 'admin'): ?>
        <p>This is your admin dashboard. You can manage users, monitor activities, and configure system settings.</p>

      <?php else: ?>
        <p>Your role is not recognized.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
