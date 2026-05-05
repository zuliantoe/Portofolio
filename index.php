<?php
session_start();
$title = "Company Profile Dasar | HOME";   //ini variabel untuk menyimpan judul halaman
$page = "home"; //ini variabel untuk menyimpan nama halaman, bisa digunakan untuk navigasi aktif
    include 'partial/meta.php'; //ini untuk menyisipkan file meta.php yang berisi tag meta dan link CSS
    include 'partial/header.php'; //ini untuk menyisipkan file header.php yang berisi kode HTML untuk navbar
?>


    <!-- Hero -->
    <section id="home" class="hero">
        <div class="container row center">
            <div class="col-2">
                <h1>Selamat datang , Solusi Digital untuk Bisnis Anda</h1>
                <p>
                    Kami membantu bisnis berkembang dengan layanan website,
                    branding, dan strategi digital yang tepat.
                </p>
                <a href="#contact" class="btn">Hubungi Kami</a>
            </div>
            <div class="col-2">
                <div class="hero-box">
                    <h3>Visual Hero</h3>
                    <p>Tempat untuk gambar, ilustrasi, atau banner utama.</p>
                </div>
            </div>
        </div>
    </section>

   

   

 

   

   <?php include 'partial/footer.php'; ?>

