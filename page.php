<?php
/**
 * page.php — Generic page template.
 * Used for all static Pages in WordPress (About, Contact, etc.)
 */
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<!-- Page title banner -->
<div class="bg-navy py-14 px-10 text-center">
  <p class="text-[0.68rem] font-bold tracking-[0.28em] uppercase text-gold mb-3">
    <?php bloginfo( 'name' ); ?>
  </p>
  <h1 class="font-serif text-4xl font-semibold text-white">
    <?php the_title(); ?>
  </h1>
</div>

<!-- Breadcrumb -->
<div class="bg-cream border-b border-stone-200 px-10 py-3 text-[0.75rem] text-gray-400 tracking-wide">
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-gold transition-colors">Home</a>
  <span class="mx-2 text-stone-300">/</span>
  <span class="text-navy font-semibold"><?php the_title(); ?></span>
</div>

<!-- Page content -->
<main class="max-w-4xl mx-auto px-6 py-14">
  <div class="prose prose-lg max-w-none
              prose-headings:font-serif prose-headings:text-navy
              prose-p:text-gray-600 prose-p:leading-[1.9]
              prose-a:text-gold hover:prose-a:text-navy
              prose-blockquote:border-l-4 prose-blockquote:border-gold prose-blockquote:font-serif prose-blockquote:italic">
    <?php the_content(); ?>
  </div>
</main>

<?php endwhile; ?>

<?php get_footer(); ?>
