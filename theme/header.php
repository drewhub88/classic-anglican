<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-warmwhite text-gray-800 overflow-x-hidden' ); ?>>
<?php wp_body_open(); ?>

<!-- ─── MAIN HEADER ─── -->
<header class="sticky top-0 z-50 bg-maroon-deep shadow-[0_2px_20px_rgba(0,0,0,.4)]">
  <div class="flex items-center justify-between px-10 h-[72px]">

    <!-- Logo -->
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-left gap-3 shrink-0" rel="home">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.svg" 
          alt="<?php bloginfo( 'name' ); ?>" 
          class="h-16">
    </a>

    <!-- Desktop Navigation -->
    <nav class="hidden lg:flex items-center gap-1" aria-label="Primary navigation">
      <?php
      wp_nav_menu( [
          'theme_location'  => 'primary',
          'menu_class'      => 'flex items-center gap-1',
          'container'       => false,
          'depth'           => 2,
          'fallback_cb'     => 'classic_anglican_fallback_nav',
          'walker'          => new Classic_Anglican_Nav_Walker(),
      ] );
      ?>
      <!-- Give button (always visible) -->
      <a href="<?php echo esc_url( home_url( '/give/' ) ); ?>"
         class="ml-2 px-6 py-2.5 bg-navy text-cream text-[0.75rem] font-bold tracking-[0.1em] uppercase rounded-sm hover:bg-maroon transition-colors">
        Give
      </a>
    </nav>

    <!-- Mobile Hamburger -->
    <button id="mobileMenuBtn"
            class="lg:hidden flex flex-col gap-1.5 cursor-pointer p-2"
            aria-label="Toggle mobile menu"
            aria-expanded="false">
      <span class="w-6 h-0.5 bg-white rounded transition-all" id="ham1"></span>
      <span class="w-6 h-0.5 bg-white rounded transition-all" id="ham2"></span>
      <span class="w-6 h-0.5 bg-white rounded transition-all" id="ham3"></span>
    </button>
  </div>

  <!-- Mobile Menu Drawer -->
  <div id="mobileMenu"
       class="lg:hidden hidden bg-maroon-deep border-t border-white/10 px-6 py-4">
    <?php
    wp_nav_menu( [
        'theme_location' => 'primary',
        'menu_class'     => 'flex flex-col gap-1',
        'container'      => false,
        'depth'          => 2,
        'fallback_cb'    => false,
        'walker'         => new Mobile_Anglican_Nav_Walker(),
    ] );
    ?>
    <a href="<?php echo esc_url( home_url( '/give/' ) ); ?>"
       class="mt-4 block text-center px-6 py-3 bg-gold text-navy text-[0.75rem] font-bold tracking-widest uppercase rounded-sm">
      Give
    </a>
  </div>
</header>


<?php
// Walker class and fallback nav are defined in functions.php
// which WordPress loads before any template file.
?>
