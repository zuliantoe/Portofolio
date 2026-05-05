<?php
session_start();
//include file koneksi database, kalau tanpa include ini maka script mysql tidak bisa dijalankan karena koneksi ke database tidak ada
include 'helper/con.php';
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to login page or show error
    header('Location: login.php'); 
    exit;
}

$portofolioItems = [];
//get portfolio items from database
$stmt = $pdo->prepare("SELECT * FROM portfolio_items ORDER BY created_at DESC");
$stmt->execute();
$portofolioItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

//simpan portfolio baru ke database ketika form tambah portfolio disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['description']) && !isset($_POST['id'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_POST['image'] ?? '';
    //gunakan prepared statement untuk mencegah SQL injection
    $stmt = $pdo->prepare("INSERT INTO portfolio_items (title, description, image_url) VALUES (?, ?, ?)");
    $stmt->execute([$title, $description, $image]);
    //redirect ke halaman admin setelah berhasil menambahkan portfolio baru untuk mencegah form resubmission ketika halaman di-refresh
    header("Location: admin.php");
    exit();
}

//tampilkan portofolio untuk di edit
//dari form get ?portofolio_id=1
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['portofolio_id'])) {
   // echo "ID portofolio yang akan diedit: " . $_GET['portofolio_id']; //debug untuk memastikan id portofolio yang akan diedit sudah diterima dengan benar   
    $id = $_GET['portofolio_id'];
    $stmt = $pdo->prepare("SELECT * FROM portfolio_items WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($item) {
        //tampilkan form edit dengan data portofolio yang sudah diambil dari database
        //form edit ini bisa dibuat di file terpisah misalnya edit_portfolio.php
        //atau bisa juga ditampilkan di halaman admin yang sama dengan form tambah portfolio
        //untuk kesederhanaan kita tampilkan di halaman admin yang sama
        //form edit ini akan memiliki action yang sama yaitu admin.php tapi methodnya POST dan ada input hidden untuk id portofolio yang diedit
    } else {
        //jika portofolio dengan id tersebut tidak ditemukan, redirect ke halaman admin atau tampilkan error
        header("Location: admin.php");
        exit();
    }
}

//handle udate portfolio ketika form edit disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['title']) && isset($_POST['description'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_POST['image'] ?? '';
    $stmt = $pdo->prepare("UPDATE portfolio_items SET title = ?, description = ?, image_url = ? WHERE id = ?");
    $stmt->execute([$title, $description, $image, $id]);
    header("Location: admin.php");
    exit();
}

//handle delete portfolio ketika tombol hapus di klik
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
    //echo "ID portofolio yang akan dihapus: " . $_POST['delete_index']; //debug untuk memastikan id portofolio yang akan dihapus sudah diterima dengan benar
    $id = $_POST['delete_index'];
    $stmt = $pdo->prepare("DELETE FROM portfolio_items WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit();

}


$title = "Company Profile Dasar | Admin Page";   
$page = "admin";
include 'partial/meta.php';
include 'partial/header.php';
?>
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Admin Panel</h2>
                <p>Halaman ini hanya bisa diakses setelah login. Di sini Anda bisa menambahkan item portfolio yang akan ditampilkan di halaman portfolio.</p>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <h2>Tambah Portfolio Item</h2>  
        </div>
    </section>        
    <section>
        <div class="container">
            <form action="admin.php" method="POST">
                <?php if (isset($item)): ?>
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input value="<?php echo isset($item['title']) ? htmlspecialchars($item['title']) : ''; ?>" type="text" id="title" name="title" placeholder="Masukkan judul portfolio" required>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="5" placeholder="Masukkan deskripsi portfolio" required><?php echo isset($item['description']) ? htmlspecialchars($item['description']) : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image">URL Gambar (opsional)</label>
                    <input value="<?php echo isset($item['image_url']) ? htmlspecialchars($item['image_url']) : ''; ?>" type="text" id="image" name="image" placeholder="Masukkan URL gambar portfolio">
                </div>
                <?php
                if (isset($item)) {
                    echo '<button type="submit" class="btn">Update Portfolio</button>';
                } else {
                    echo '<button type="submit" class="btn">Tambah Portfolio</button>';
                }
                ?>
            </form>
        </div>
    </section>
    <section>
            <div class="container">
                <div class="section-title">
                    <h2>Daftar Portfolio</h2>
                    <p>Berikut adalah daftar item portfolio yang sudah ditambahkan.</p>
                </div>
            
                <div class="table-wrapper">
                    <table class="portfolio-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($portofolioItems)){ ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;">Belum ada data portfolio.</td>
                                </tr>
                            <?php } else { ?>
                            <?php foreach ($portofolioItems as $index => $item): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td><?php echo htmlspecialchars($item['description']); ?></td>
                                    <td>
                                        <?php if (isset($item['image_url']) && !empty($item['image_url'])): ?>
                                            <img class="table-image" src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="Portfolio Image">
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="admin.php" method="POST">
                                            <input type="hidden" name="delete_index" value="<?php echo $item['id']; ?>">
                                            <button type="submit" class="btn">Hapus</button>
                                        </form>
                                        <form action="admin.php" method="GET">
                                            <input type="hidden" name="portofolio_id" value="<?php echo $item['id']; ?>">
                                            <button type="submit" class="btn">Edit</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
    <script>
        //tambahkan konfirmasi sebelum menghapus portfolio
        document.querySelectorAll('form[action="admin.php"][method="POST"]').forEach(form => {
            form.addEventListener('submit', function(event) {
                if (form.querySelector('input[name="delete_index"]')) {
                    const confirmed = confirm('Apakah Anda yakin ingin menghapus portfolio ini?');
                    if (!confirmed) {
                        event.preventDefault();
                    }
                }
            });
        });
    </script>

<?php include 'partial/footer.php'; ?>
