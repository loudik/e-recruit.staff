<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Application Type</title>
  <link rel="icon" href="<?= $logoPath ?>" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #2980b9, #6dd5fa);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .selection-container {
      background: #fff;
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      text-align: center;
      width: 350px;
    }
    .selection-container h2 {
      margin-bottom: 30px;
      color: #333;
    }
    .role-option {
      display: block;
      background: #3498db;
      color: #fff;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }
    .role-option:hover {
      background: #2c80b4;
    }
  </style>
</head>
<body>

  <div class="selection-container">
    <h2>Select Application Type</h2>
    <a href="<?= base_url('loginpage') ?>" class="role-option">
      <i class="fas fa-user-tie"></i> Recruitment Staff
    </a>
    <a href="<?= base_url('/home') ?>" class="role-option">
      <i class="fas fa-graduation-cap"></i> Internship
    </a>
  </div>

</body>
</html>
