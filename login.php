<?php
session_start();
include 'database.php'; // Include your database connection file

$error_message = ''; // Initialize an empty error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if it's the default admin login
    if ($username === 'admin' && $password === 'adminpass') {
        $_SESSION['username'] = 'admin';
        $_SESSION['role'] = 'admin'; // Optional: Store role if needed
        header("Location: dashboard.php"); // Redirect to admin dashboard
        exit();
    }

    // Query to check if the user exists
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) { // Raw password comparison
            // Password is correct
            $_SESSION['user_id'] = $user['id']; // Store user_id in session
            $_SESSION['username'] = $username;
            header("Location: page1.php"); // Redirect to the registration form
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with this username.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="log.css">
  <style>
    .error-message {
      color: red;
      margin-bottom: 20px;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <section>
    <div class="signin">
      <div class="content">
        <h2>Login Trainee</h2>
        <?php if ($error_message): ?>
          <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form class="form" action="login.php" method="POST">
          <div class="inputBox">
            <input type="text" name="username" required>
            <label>Username</label>
          </div>
          <div class="inputBox">
            <input type="password" name="password" required>
            <label>Password</label>
          </div>
          <div class="inputBox">
            <input type="submit" value="Login">
          </div>
        </form>
        <div class="signup">
          <p>Don't have an account? <a href="signup.php" class="sign-up-link" onclick="openSignUpModal()">Sign up</a></p>
        </div>
      </div>
    </div>
  </section>

  <!-- Sign Up Modal -->
  <div id="signupModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeSignUpModal()">&times;</span>
      <h2>Sign Up</h2>
      <form class="form" action="signup.php" method="POST">
        <div class="inputBox">
          <input type="text" name="username" required>
          <label>Username</label>
        </div>
        <div class="inputBox">
          <input type="password" name="password" required>
          <label>Password</label>
        </div>
        <div class="inputBox">
          <input type="email" name="email" required>
          <label>Email</label>
        </div>
        <div class="inputBox">
          <input type="submit" value="Sign Up">
        </div>
      </form>
    </div>
  </div>

  <script>
    function openSignUpModal() {
      document.getElementById('signupModal').style.display = 'block';
    }

    function closeSignUpModal() {
      document.getElementById('signupModal').style.display = 'none';
    }
  </script>
</body>
</html>

