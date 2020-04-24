<nav class="navbar has-background-grey-light" role="navigation" aria-label="main navigation">
            
    <div class="navbar-menu">

        <div class="navbar-start">
            
            <a class="navbar-item is-active" href="index.php">HJEM</a>
            <a class="navbar-item" href="index.php?page=courses">EMNER</a>

            <!-- Viser innstillinger hvis man er logget inn som student eller foreleser. -->
            <?php if (isset($_SESSION['student']) || isset($_SESSION['foreleser'])): ?>
                <a class="navbar-item" href="index.php?page=settings">INNSTILLINGER</a>
            <?php endif; ?>
                
        
        </div>

        <!-- Viser "Logg ut"-knappen hvis man er logget inn. -->
        <?php if (isset($_SESSION['loggedIn'])): ?>

            <div class="navbar-end">

                <p id="studentText" class="has-text-centered has-text-white">Logged in as <strong><?php echo $_SESSION['name'] ?></strong></p>
                <a href="index.php?page=logout" class="button is-primary has-text-centered ">Logg ut</a>

            </div>

        <?php endif; ?>

    </div>

</nav>