 <!-- Navbar -->
    <header class="navbar">
        <div class="container row space-between center">
            <div class="logo">MyCompany</div>
            <nav>
                <ul class="nav-menu row">
                    <li><a class="<?php echo ($page == 'home') ? 'active' : ''; ?>" href="index.php">Home</a></li>
                    <li><a class="<?php echo ($page == 'about') ? 'active' : ''; ?>" href="about.php">About</a></li>
                    <li><a class="<?php echo ($page == 'services') ? 'active' : ''; ?>" href="services.php">Services</a></li>
                    <li><a class="<?php echo ($page == 'portfolio') ? 'active' : ''; ?>" href="portfolio.php">Portfolio</a></li>
                    <li><a class="<?php echo ($page == 'contact') ? 'active' : ''; ?>" href="contact.php">Contact</a></li>
                    <?php if(isset($_SESSION["username"])): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>  
                    <li><a class="<?php echo ($page == 'login') ? 'active' : ''; ?>" href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
