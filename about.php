<?php 
session_start();
$title = "Company Profile Dasar | ABOUT";   
$page = "about";
    include 'partial/meta.php'; 
    include 'partial/header.php';
?>

   <!-- About -->
    <section id="about" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Tentang Kami</h2>
                <p>Kami adalah tim kreatif yang fokus pada desain, pengembangan, dan pelayanan terbaik.</p>
            </div>

            <div class="row gap">
                <div class="col-2 card">
                    <h3>Siapa Kami</h3>
                    <p>
                        MyCompany adalah perusahaan yang bergerak di bidang digital service.
                        Kami membantu klien membangun identitas online yang profesional.
                    </p>
                </div>
                <div class="col-2 card">
                    <h3>Visi Kami</h3>
                    <p>
                        Menjadi partner terpercaya bagi bisnis yang ingin tumbuh lebih cepat
                        melalui teknologi dan kreativitas.
                    </p>
                </div>
            </div>
        </div>
    </section>

   <?php include 'partial/footer.php'; ?>