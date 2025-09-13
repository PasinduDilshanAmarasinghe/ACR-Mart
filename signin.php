<?php
session_start();
include('db.php'); // Make sure this file exists and $conn is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from database (optional, just for role assignment)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $role = $user['role']; // Get the role from database
    } else {
        // If user not found, assign default role (e.g., customer)
        $role = 'customer';
    }

    // Save session anyway
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;

    // Redirect based on role
    if ($role === 'admin') {
        header("Location: admin_dashboard.php");
        exit;
    } elseif ($role === 'manager') {
        header("Location: manager.php");
        exit;
    } else {
        header("Location: home.html"); // Customer page
        exit;
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ACR Mart - Sign In</title>
  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    html, body {
      height: 100%;
      margin: 0;
      overflow: hidden; /* remove all scrollbars */
    }

    body {
      background-image: url('piks/as.jpg'); /* Background image */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #f5f0e6;
      position: relative;
      min-height: 100vh;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(75, 46, 14, 0.7); /* dark brown overlay */
      z-index: 0;
    }

    main {
      position: relative;
      max-width: 400px;
      width: 90%;
      padding: 2.5rem 6.5rem;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.6);
      color: #f5f0e6;
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: center;
      background-color: #4B2E0E; /* solid brown */
      z-index: 1;
      max-height: 85vh;
    }

    /* Logo image */
    .logo {
      max-width: 300px;
      width: 75%;
      height: auto;
      margin-bottom: 0.111119rem;
      filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.7));
      align-self: center;
    }

    main h2 {
      font-size: 2.4rem;
      font-weight: 900;
      margin-bottom: 1.5rem;
      letter-spacing: 2px;
      color: #f0d87c;
      text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
    }

    form {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: stretch;
    }

    label {
      font-weight: 600;
      margin-bottom: 0.3rem;
      font-size: 0.9rem;
      letter-spacing: 0.5px;
      color: #f0d87c;
      text-shadow: 0 0 3px rgba(240,216,124,0.7);
    }

    input[type="text"],
    input[type="password"] {
      background: rgba(255, 255, 255, 0.12);
      border: none;
      border-radius: 12px;
      padding: 0.75rem 1rem;
      margin-bottom: 1rem;
      font-size: 0.9rem;
      color: #f5f0e6;
      box-shadow: inset 0 0 8px rgba(255, 255, 255, 0.15);
      transition: box-shadow 0.3s ease, background 0.3s ease;
      outline: none;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      background: rgba(255, 255, 255, 0.3);
      box-shadow: 0 0 12px 3px #f0d87c;
      color: #222;
    }

    button {
      background: linear-gradient(90deg, #f0d87c, #b69122);
      border: none;
      border-radius: 40px;
      padding: 0.85rem 0;
      font-weight: 700;
      font-size: 1.1rem;
      color: #4b2e0e;
      cursor: pointer;
      box-shadow: 0 6px 20px rgba(182,145,34,0.7);
      transition: background 0.3s ease, transform 0.2s ease;
      letter-spacing: 1px;
      user-select: none;
    }

    button:hover,
    button:focus {
      background: linear-gradient(90deg, #b69122, #f0d87c);
      transform: scale(1.07);
      outline: none;
    }

    .footer-inside {
      margin-top: 1.5rem;
      font-size: 0.8rem;
      font-weight: 500;
      color: #f0d87c;
      text-align: center;
      user-select: none;
      text-shadow: 0 0 3px rgba(240, 216, 124, 0.7);
    }

    @media (max-width: 480px) {
      main {
        padding: 1.5rem 1rem;
        max-height: 90vh;
      }

      .logo {
        max-width: 120px;
        margin-bottom: 1rem;
      }

      main h2 {
        font-size: 2rem;
        margin-bottom: 1rem;
      }

      input[type="text"],
      input[type="password"] {
        font-size: 0.85rem;
        padding: 0.6rem 10rem;
        margin-bottom: 0.9rem;
      }

      button {
        font-size: 1rem;
        padding: 0.75rem 0;
        margin-bottom: 5rem;
      }

      .footer-inside {
        font-size: 0.75rem;
        margin-top: 1rem;
      }
    }
  </style>
</head>
<body>

  <main role="main" aria-label="Sign In Form">
    <img src="piks/logo.png" alt="ACR Mart Logo" class="logo" />
    <h2>Sign In</h2>
    <form action="signin.php" method="POST" novalidate>
  <label for="username">Email</label>
  <input type="text" id="username" name="username" placeholder="Enter your email" required />

  <label for="password">Password</label>
  <input type="password" id="password" name="password" placeholder="Enter your password" required />

  <button type="submit">Sign In</button>
</form>
    <p>

    </p>

    <p>Don't have an account? <a href="register.php">Register Here</a></p>
    <div class="footer-inside">
      © 2025 ACR Mart. All rights reserved.
    </div>
  </main>

</body>
</html>
