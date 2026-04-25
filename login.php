<?php
session_start(); // Mulai session untuk menyimpan data login
$title = "Company Profile Dasar | LOGIN";
$page = "login";
$usernameBenar = "admin";
$passwordBenar = "12345";
$pesan = "";
$berhasilLogin = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username == $usernameBenar && $password == $passwordBenar) {
        $berhasilLogin = true;
        $_SESSION["username"] = $username; // Simpan username di session
        $pesan = "Login berhasil. Selamat datang, " . htmlspecialchars($username) . "!";
    } else {
        $pesan = "Username atau password salah.";
    }
}

include 'partial/meta.php';
include 'partial/header.php';
?>

    <section class="section gray">
        <div class="container login-container">
            <div class="login-box card">
                <div class="section-title login-title">
                    <h2>Login</h2>
                    <p>Masuk menggunakan username dan password yang sudah ditentukan di variable PHP.</p>
                </div>

                <?php if ($pesan != "") : ?>
                    <div class="<?php echo $berhasilLogin ? 'alert success' : 'alert error'; ?>">
                        <?php echo $pesan; ?>
                    </div>
                <?php endif; ?>

                <?php if (!$berhasilLogin) : ?>
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        </div>

                        <button type="submit" class="btn">Login</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php include 'partial/footer.php'; ?>
