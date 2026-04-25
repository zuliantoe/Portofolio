<?php 
$title = "Company Profile Dasar | CONTACT";   
$page = "contact";
    include 'partial/meta.php'; 
    include 'partial/header.php';
?>


 <!-- Contact -->
    <section id="contact" class="section gray">
        <div class="container">
            <div class="section-title">
                <h2>Hubungi Kami</h2>
                <p>Silakan kirim pesan jika Anda ingin bekerja sama dengan kami.</p>
            </div>

            <div class="row gap">
                <div class="col-2 card">
                    <h3>Informasi Kontak</h3>
                    <p>Email: info@mycompany.com</p>
                    <p>Telepon: 0812-3456-7890</p>
                    <p>Alamat: Semarang, Indonesia</p>
                </div>

                <div class="col-2 card">
                    <form>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" placeholder="Masukkan nama">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" placeholder="Masukkan email">
                        </div>
                        <div class="form-group">
                            <label>Pesan</label>
                            <textarea rows="5" placeholder="Tulis pesan Anda"></textarea>
                        </div>
                        <button type="submit" class="btn">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php include 'partial/footer.php'; ?>