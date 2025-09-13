<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ACR Mart - Get Started</title>
  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 2rem;
      color: #fff;

      background-image: url('piks/as.jpg'); /* Replace with your background image path */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      position: relative;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(75, 46, 14, 0.7); /* dark brown overlay */
      z-index: 0;
    }

    .hero {
      position: relative;
      z-index: 1;
      max-width: 480px;
      width: 100%;
      padding: 3rem 4rem;
      border-radius: 20px;
      overflow: hidden;
      background: rgba(75, 46, 14, 0.85); /* dark transparent background */
      box-shadow: 0 10px 25px rgba(0,0,0,0.4);
      color: #f0e4b8;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* Style for "WELCOME TO" */
    .hero .welcome-text {
      font-size: 1.5rem;
      font-weight: 700;
      letter-spacing: 3px;
      color: #f0d87c;
      margin-bottom: 1rem;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
      user-select: none;
    }

    /* Logo image styling */
    .hero img.logo {
      max-width: 240px;
      width: 100%;
      height: auto;
      margin-bottom: 2rem;
      filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.7));
    }

    .hero p.description {
      font-size: 1.3rem;
      margin-bottom: 2.5rem;
      font-weight: 500;
      color: #f5e9b1;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
    }

    .hero button {
      background-color: #D1A83F;
      color: #4B2E0E;
      font-size: 1.2rem;
      font-weight: 700;
      padding: 0.75rem 2.5rem;
      border: none;
      border-radius: 40px;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(209,168,63,0.6);
      transition: background-color 0.3s ease, transform 0.2s ease;
      user-select: none;
    }

    .hero button:hover,
    .hero button:focus {
      background-color: #b69122;
      transform: scale(1.05);
      outline: none;
    }

    /* Responsive */
    @media (max-width: 480px) {
      .hero {
        padding: 2rem 2.5rem;
      }

      .hero .welcome-text {
        font-size: 1.2rem;
        margin-bottom: 0.8rem;
      }

      .hero p.description {
        font-size: 1.1rem;
        margin-bottom: 1.8rem;
      }

      .hero img.logo {
        max-width: 180px;
        margin-bottom: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <section class="hero" role="main" aria-label="Welcome section">
    <p class="welcome-text">WELCOME TO</p>
    <img src="piks/logo.png" alt="ACR Mart Logo" class="logo" />
    <p class="description">Your one-stop shop for all your needs</p>
    <button onclick="location.href='signin.php'">Get Started</button>
  </section>
</body>
</html>
