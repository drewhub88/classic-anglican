<?php get_header(); ?>

<main class="min-h-screen flex flex-col items-center justify-center text-center px-6">
    <h1 class="text-6xl font-bold text-maroon-deep mb-4">404</h1>
    <p class="text-navy-300 text-lg mb-8">Sorry, that page could not be found.</p>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
       class="px-6 py-3 bg-navy text-cream font-bold uppercase tracking-widest text-sm hover:bg-gold-light transition-colors">
        Return Home
    </a>
</main>

<?php get_footer(); ?>