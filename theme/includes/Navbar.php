<nav class="navbar navbar-expand-sm no-padding pt-0 pb-0">
    <div class="container-fluid d-flex align-items-center">
        <!-- Logo -->
        <div class="d-flex align-items-center">
            <!--
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/MSH_Wide.png" style="max-height: 40px;" alt="Logo" />
            -->
            <?php

                // function_exists('the_custom_logo') ? the_custom_logo() : echo "Logo";
                if (function_exists('the_custom_logo')) {
                    the_custom_logo();
                } else {
                    echo "Logo";
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
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link navbar-border" href="https://github.com/stewebb/MSH" target="_blank" rel="noopener noreferrer">GitHub</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
