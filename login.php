<?php
include('config.php');
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $email_check = "SELECT * FROM `user` WHERE `email` = '$email'";
    $result = mysqli_query($connection, $email_check);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $role;

            echo "<script>window.location.href = 'registration.php';</script>";
            exit;
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('Email not found');</script>";
    }
}
?>
























<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

  <style>
    body {
      background: #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-card {
      background-color: #fff;
      border-radius: 12px;
      padding: 2rem;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .login-card h4 {
      text-align: center;
      margin-bottom: 1.5rem;
      font-weight: 600;
      color: #333;
    }

    .form-group {
      position: relative;
      margin-bottom: 1.2rem;
    }

    .form-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #888;
      font-size: 1rem;
    }

    .form-control, .form-select {
      padding-left: 2.2rem;
      height: 42px;
      font-size: 0.95rem;
      border-radius: 6px;
    }

    .btn-primary {
      height: 42px;
      font-weight: 500;
      font-size: 0.95rem;
    }

    .form-footer {
      text-align: center;
      font-size: 0.85rem;
      margin-top: 1rem;
    }

    .form-footer a {
      color: #0d6efd;
      text-decoration: none;
    }

    .form-footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h4>Login to Your Account</h4>
    <form action="<?php $_SERVER["PHP_SELF"]?>" method= "POST">
      <!-- Role Dropdown -->
      <div class="form-group">
        <i class="fa-solid fa-user-tag form-icon"></i>
        <select class="form-select" name="role" required>
          <option value="" disabled selected>Select Role</option>
          <option value="client">Client</option>
          <option value="lawyer">Lawyer</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <!-- Email -->
      <div class="form-group">
        <i class="fa-solid fa-envelope form-icon"></i>
        <input type="email" class="form-control" name = "email" placeholder="Email address" required />
      </div>

      <!-- Password -->
      <div class="form-group">
        <i class="fa-solid fa-lock form-icon"></i>
        <input type="password" class="form-control" name= "password" placeholder="Password" required />
      </div>


      <!-- Login Button -->
      <button type="submit" class="btn btn-primary w-100" name = "submit">Login</button>

      <!-- Signup Link -->
      <div class="form-footer">
        Don't have an account? <a href="#">Sign up</a>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
