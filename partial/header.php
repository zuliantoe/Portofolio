 <!-- Navbar -->
    <header class="navbar">
        <div class="container row space-between center">
            <div class="logo">MyCompany</div>
            <nav>
                <ul class="nav-menu row">
                    <li><a class="<?php echo ($page == 'home') ? 'active' : ''; ?>" href="index.php">Home</a></li>
                    <li><a class="<?php echo ($page == 'about') ? 'active' : ''; ?>" href="about.php">About</a></li>
                    <li><a class="<?php echo ($page == 'services') ? 'active' : ''; ?>" href="services.php">Services</a></li>
                    <li><a class="<?php echo ($page == 'portfolio') ? 'active' : ''; ?>" href="portofolio.php">Portfolio</a></li>
                    <li><a class="<?php echo ($page == 'contact') ? 'active' : ''; ?>" href="contact.php">Contact</a></li>
                    <?php
                    // Tampilkan link admin hanya jika sudah login
                    if (isset($_SESSION['username'])) {
                        echo '<li><a class="' . (($page == 'admin') ? 'active' : '') . '" href="admin.php">Admin</a></li>';
                        echo '<li><a href="logout.php">Logout</a></li>';
                    } 
                    ?>
                    
                </ul>
            </nav>
        </div>
    </header>
