<?php
session_start();
//include file koneksi database, kalau tanpa include ini maka script mysql tidak bisa dijalankan karena koneksi ke database tidak ada
include 'helper/con.php';
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to login page or show error
    header('Location: login.php'); 
    exit;
}
/* disable portofolio dari session
//ini create portfolio array in session if not exists
if (!isset($_SESSION['portfolio'])) {
    $_SESSION['portfolio'] = [];
}

// Handle form submission to add new portfolio (POST) item
// data disimpan di session untuk sementara, nanti bisa diganti dengan database jika sudah belajar database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_POST['image'] ?? '';
    //validasi sederhana untuk memastikan title dan description tidak kosong sebelum disimpan
    if ($title && $description) {
        $_SESSION['portfolio'][] = [
            'title' => $title,
            'description' => $description,
            'image' => $image
        ];
    }
}

// Handle delete action
// data dihapus dari session berdasarkan index yang dikirim melalui form delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
    $deleteIndex = $_POST['delete_index'];
    if (isset($_SESSION['portfolio'][$deleteIndex])) {
        array_splice($_SESSION['portfolio'], $deleteIndex, 1);
    }
}
    * disable portofolio dari session */
//cek apakah ada data portfolio di database, kalau tidak ada maka tampilkan pesan bahwa belum ada data portfolio, kalau ada maka tampilkan data portfolio di tabel
$portofolioItems = [];
//kita coba pakai mysqli dulu untuk query data portfolio
$items = $conn->query("SELECT * FROM portfolio_items ORDER BY created_at DESC");
if ($items->num_rows > 0) {//kalau ada data portfolio di database maka kita fetch data portfolio dan simpan di array $portofolioItems untuk ditampilkan di tabel
    while ($row = $items->fetch_assoc()) {//fetch data portfolio dan simpan di array $portofolioItems untuk ditampilkan di tabel
        $portofolioItems[] = $row;
    }
}

//simpan portfolio baru ke database ketika form tambah portfolio disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['description'])) {
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



$title = "Company Profile Dasar | Admin Page";   
$page = "about";
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
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" id="title" name="title" placeholder="Masukkan judul portfolio" required>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="5" placeholder="Masukkan deskripsi portfolio" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">URL Gambar (opsional)</label>
                    <input type="text" id="image" name="image" placeholder="Masukkan URL gambar portfolio">
                </div>
                <button type="submit" class="btn">Tambah Portfolio</button>
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
                                        <?php if (isset($item['image']) && !empty($item['image'])): ?>
                                            <img class="table-image" src="<?php echo htmlspecialchars($item['image']); ?>" alt="Portfolio Image">
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="admin.php" method="POST">
                                            <input type="hidden" name="delete_index" value="<?php echo $index; ?>">
                                            <button type="submit" class="btn">Hapus</button>
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

<?php include 'partial/footer.php'; ?>
