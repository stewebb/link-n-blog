<nav class="navbar navbar-expand-sm no-padding pt-0 pb-0">
    <div class="container-fluid d-flex align-items-center">

        <!-- Logo -->
        <div class="d-flex align-items-center">
            <?php
                if (function_exists('the_custom_logo') && has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<img class="custom-logo" src="' . get_template_directory_uri() . '/assets/images/LNB_Square.png" alt="LNB Default Logo">';
                }
            ?>
        </div>

        <!-- Navbar Toggler -->
        <button
            class="navbar-toggler ms-auto"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

        
                <li class="nav-item px-1">
                    <a class="nav-link navbar-border active" href="<?php echo home_url(); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar-border" href="<?php echo home_url('/about'); ?>">About</a>
                </li>

                <?php
        // Display the custom menu
        wp_nav_menu(array(
            'theme_location' => 'your_custom_menu_location', // Define this in functions.php
            'container' => false,
            'menu_class' => 'nav-item',
            'items_wrap' => '%3$s',
        ));
        ?>
            </ul>

            <!--
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link navbar-border" href="https://github.com/stewebb/MSH" target="_blank" rel="noopener noreferrer">GitHub</a>
                </li>
            </ul>
            -->
        </div>
        
    </div>
</nav>
