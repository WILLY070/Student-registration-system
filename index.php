<?php
$remembered_name = isset($_COOKIE['saved_username']) ? $_COOKIE['saved_username'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Student System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js"></script>
        
</head>

<?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials'): ?>
<script>
    window.onload = function() {
        showErrorModal();
    };
</script>
<?php endif; ?>

<body>
    <header><h1>Student Registration System</h1></header>
    <main>
        <section class="form-card">
            <div class="form-header" style="text-align: center;">
                <h2>Admin Login</h2>
                <p>Access the management dashboard</p>
            </div>
            <form action="action/login_action.php" method="POST" onsubmit="return checkLoginForm(event)">
                <div class="input-group">
                    <label>Username</label>
                    <input  id="username" type="text" name="username" value="<?php echo htmlspecialchars($remembered_name); ?>" minlength="3" required>
                </div>
                <div class="input-group" style="margin-top:15px;">
                    <label>Password</label>
                    <input id="passwordInput" type="password" name="password"  minlength="8" required>
                </div>
                <div class="input-group" style="margin-top:15px;">
                    <input type="checkbox" id="remember_user" name="remember_user" <?php echo !empty($remembered_name) ? 'checked' : ''; ?>>
                    <label for="remember_user">Remember Username</label>
                </div>
                <button type="submit" class="btn-primary"  style="width:100%; margin-top:20px;">Login</button>
            </form>
           
        </section>
    </main>
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeErrorModal()">&times;</span>
            <h2>Login Failed</h2>
            <p id="errorMessage">Incorrect username or password. Please try again.</p>
            <button class="btn-primary" onclick="closeErrorModal()" style="width: 100%; margin-top: 20px;">OK</button>
        </div>
    </div>
    <footer><p>&copy; 2026 Student Management System</p></footer>
</body>
</html>