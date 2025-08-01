<?php
session_start();

// Hardcoded password (change this to your secure password)
$correct_password = '08136cha';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_password = $_POST['password'] ?? '';
    
    if ($entered_password === $correct_password) {
        $_SESSION['authenticated'] = true;
        $_SESSION['login_time'] = time();
        header('Location: upload.php');
        exit;
    } else {
        $error = "Invalid password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Threat3D</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="login-container">
        <h1>Threat3D Admin</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
