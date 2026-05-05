<?php 
session_start();
include 'helper/con.php';
$title = "Company Profile Dasar | PORTFOLIO";   
$page = "portfolio";
    include 'partial/meta.php'; 
    include 'partial/header.php';

 //get portfolio items from database
$stmt = $pdo->query("SELECT * FROM portfolio_items ORDER BY created_at DESC");
$portfolioItems = $stmt->fetchAll(PDO::FETCH_ASSOC);   

?>

   <!-- Portfolio -->
    <section id="portfolio" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Portfolio</h2>
                <p>Contoh project yang pernah kami kerjakan.</p>
            </div>

            <div class="row gap wrap">
                <?php foreach ($portfolioItems as $item): ?>
                    <div class="col-2 portfolio-box">
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                        <?php if (!empty($item['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


<?php include 'partial/footer.php'; ?>
