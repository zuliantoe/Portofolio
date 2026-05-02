<?php
session_start(); // Mulai session untuk menyimpan data login
include 'helper/con.php'; // Include file koneksi database, kalau tanpa include ini maka script mysql tidak bisa dijalankan karena koneksi ke database tidak ada
$title = "Company Profile Dasar | LOGIN";
$page = "login";
/*
$usernameBenar = "admin";
$passwordBenar = "12345";
*/
//debug untuk create password hash
//$passwordHash = password_hash("12345", PASSWORD_DEFAULT);
//echo "Password hash untuk '12345': " . $passwordHash . "<br>";
$pesan = "";
$berhasilLogin = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    // Cek username dan password di database menggunakan PDO
    // Gunakan prepared statement untuk mencegah SQL injection
    // pakai mysql_verify untuk memverifikasi password yang sudah di-hash di database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // Verifikasi password menggunakan password_verify
    if ($user && password_verify($password, $user['password'])) {
        $berhasilLogin = true;
        $_SESSION["username"] = $username; // Simpan username di session
        // Redirect ke halaman admin setelah login berhasil
        header("Location: admin.php");
        exit();
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
