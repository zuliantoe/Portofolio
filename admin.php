<?php
session_start();
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to login page or show error
    header('Location: login.php'); 
    exit;
}

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
                            <?php foreach ($_SESSION['portfolio'] as $index => $item): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td><?php echo htmlspecialchars($item['description']); ?></td>
                                    <td>
                                        <?php if ($item['image']): ?>
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
                        </tbody>
                    </table>
                </div>
            </div>
    </section>

<?php include 'partial/footer.php'; ?>
