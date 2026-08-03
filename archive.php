<?php
/**
 * archive.php
 * Blog post archive — shown at /blog/ (or your Posts page).
 * Also used for category, tag, author, and date archives.
 */

// If main loop is empty, query all posts
if ( ! have_posts() ) {
    $query = new WP_Query( [
        'post_type'      => 'post',
        'posts_per_page' => get_option( 'posts_per_page' ),
        'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
    ] );
    
    $GLOBALS['wp_query'] = $query;
    $GLOBALS['wp_the_query'] = $query;
}

get_header();
?>

<!-- ─── PAGE HERO ─── -->
<div class="bg-navy py-16 px-10 text-center relative overflow-hidden">
  <div class="absolute inset-0 opacity-10"
       style="background-image: repeating-linear-gradient(45deg, #b8975a 0, #b8975a 1px, transparent 0, transparent 50%); background-size: 20px 20px;">
  </div>
  <div class="relative z-10">
    <h1 class="font-serif text-4xl font-semibold text-white mb-4">
      <?php
      if ( is_category() ) {
          single_cat_title();
      } elseif ( is_tag() ) {
          single_tag_title( 'Tag: ' );
      } elseif ( is_author() ) {
          echo 'Posts by ' . get_the_author();
      } elseif ( is_date() ) {
          echo get_the_date( 'F Y' );
      } else {
          echo 'Essays';
      }
      ?>
    </h1>
    <p class="text-white/60 text-base max-w-lg mx-auto leading-relaxed">
      <?php
      if ( is_category() ) {
          echo category_description();
      } else {
          echo 'Reflections, stories, and teachings from our community, exploring faith, life, and culture through an Anglican lens.';
      }
      ?>
    </p>
  </div>
</div>

<!-- ─── BREADCRUMB ─── -->
<div class="bg-cream border-b border-stone-200 px-10 py-3 text-[0.75rem] text-gray-400 tracking-wide">
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-gold transition-colors">Home</a>
  <span class="mx-2 text-stone-300">/</span>
  <span class="text-navy font-semibold">
    <?php is_category() ? single_cat_title() : _e( 'Blog', 'classic-anglican' ); ?>
  </span>
</div>

<!-- ─── MAIN CONTENT ─── -->
<main class="max-w-[1200px] mx-auto px-6 py-14 grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-12 items-start">

  <!-- LEFT: Post Grid -->
  <div>

    <!-- Category filter pills -->
    <div class="flex flex-wrap gap-2 mb-10">
      <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"
         class="px-4 py-1.5 text-[0.73rem] font-bold tracking-widest uppercase rounded-sm transition-colors
                <?php echo ( ! is_category() && ! is_tag() ) ? 'bg-navy text-white' : 'bg-stone-100 text-navy hover:bg-gold hover:text-white'; ?>">
        All
      </a>
      <?php
      // Output top-level categories as filter pills
      $uncategorized_id = get_cat_ID( 'Uncategorized' );
      $categories = get_categories( [ 
          'hide_empty' => true, 
          'number' => 8,
          'exclude' => $uncategorized_id
      ] );
      foreach ( $categories as $cat ) :
        $is_active = is_category( $cat->term_id );
      ?>
        <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
           class="px-4 py-1.5 text-[0.73rem] font-bold tracking-widest uppercase rounded-sm transition-colors
                  <?php echo $is_active ? 'bg-navy text-white' : 'bg-stone-100 text-navy hover:bg-gold hover:text-white'; ?>">
          <?php echo esc_html( $cat->name ); ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Post Grid -->
    <?php if ( have_posts() ) : ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-7">
        <?php while ( have_posts() ) : the_post(); ?>

          <article id="post-<?php the_ID(); ?>"
                   <?php post_class( 'post-card border border-stone-200 overflow-hidden hover:shadow-xl transition-shadow' ); ?>>

            <!-- Thumbnail -->
            <a href="<?php the_permalink(); ?>" class="block h-52 bg-navy overflow-hidden relative">
              <?php if ( has_post_thumbnail() ) : ?>
                <div class="card-img absolute inset-0 bg-cover bg-center opacity-70"
                     style="background-image:url('<?php the_post_thumbnail_url( 'anglo-card' ); ?>');">
                </div>
              <?php else : ?>
                <div class="card-img absolute inset-0 bg-cover bg-center opacity-50"
                     style="background-image:url('https://images.unsplash.com/photo-1618333604761-4148e9b0f1dd?w=700&auto=format&fit=crop&q=70');">
                </div>
              <?php endif; ?>

              <!-- Category badge -->
              <?php
              $cats = get_the_category();
              if ( $cats ) :
                $first_cat = $cats[0];
              ?>
                <a href="<?php echo esc_url( get_category_link( $first_cat->term_id ) ); ?>"
                   class="absolute top-4 left-4 bg-gold text-navy text-[0.62rem] font-bold tracking-widest uppercase px-3 py-1 rounded-sm z-10 hover:bg-gold-light transition-colors">
                  <?php echo esc_html( $first_cat->name ); ?>
                </a>
              <?php endif; ?>
            </a>

            <!-- Body -->
            <div class="p-6">
              <!-- Meta -->
              <p class="text-[0.7rem] text-gray-400 tracking-wider uppercase mb-2">
                <?php echo get_the_date( 'F j, Y' ); ?>
                &nbsp;·&nbsp;
                <?php the_author(); ?>
                &nbsp;·&nbsp;
                <?php echo classic_anglican_reading_time(); ?>
              </p>

              <!-- Title -->
              <h2 class="font-serif text-xl text-navy font-semibold leading-snug mb-3">
                <a href="<?php the_permalink(); ?>" class="hover:text-gold transition-colors">
                  <?php the_title(); ?>
                </a>
              </h2>

              <!-- Excerpt -->
              <p class="text-[0.85rem] text-gray-500 leading-relaxed line-clamp-3">
                <?php the_excerpt(); ?>
              </p>

              <a href="<?php the_permalink(); ?>"
                 class="inline-block mt-5 text-[0.75rem] font-bold tracking-widest uppercase text-gold border-b border-gold pb-0.5 hover:text-navy hover:border-navy transition-colors">
                Read More →
              </a>
            </div>
          </article>

        <?php endwhile; ?>
      </div>

      <!-- Pagination -->
      <?php classic_anglican_pagination(); ?>

    <?php else : ?>

      <!-- No posts found -->
      <div class="text-center py-20">
        <p class="font-serif text-2xl text-navy mb-4">No posts found</p>
        <p class="text-gray-500 mb-8">Try browsing all categories or use the search bar.</p>
        <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"
           class="inline-block bg-navy text-white px-8 py-3 text-[0.78rem] font-bold tracking-widest uppercase rounded-sm hover:bg-navy-deep transition-colors">
          View All Posts
        </a>
      </div>

    <?php endif; ?>

  </div><!-- end left col -->

  <!-- ─── SIDEBAR ─── -->
  <aside class="space-y-6 lg:sticky lg:top-24">

    <!-- Search widget -->
    <div class="bg-cream border border-stone-200 p-6">
      <h3 class="font-serif text-lg text-navy mb-4">Search</h3>
      <?php get_search_form(); ?>
    </div>

    <!-- Recent Posts widget -->
    <div class="bg-white border border-stone-200 p-6">
      <h3 class="font-serif text-lg text-navy mb-5 pb-3 border-b border-stone-100">Recent Posts</h3>
      <?php
      $recent = new WP_Query( [
          'post_type'      => 'post',
          'posts_per_page' => 5,
          'post_status'    => 'publish',
      ] );
      if ( $recent->have_posts() ) : ?>
        <div class="space-y-4">
          <?php while ( $recent->have_posts() ) : $recent->the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="flex gap-4 group">
              <div class="w-16 h-14 shrink-0 bg-navy overflow-hidden rounded-sm relative">
                <?php if ( has_post_thumbnail() ) : ?>
                  <div class="absolute inset-0 bg-cover bg-center opacity-70 group-hover:opacity-100 transition-opacity"
                       style="background-image:url('<?php the_post_thumbnail_url( 'anglo-sidebar' ); ?>');">
                  </div>
                <?php else : ?>
                  <div class="absolute inset-0 bg-gold/20 flex items-center justify-center">
                    <span class="font-serif italic text-gold text-xs">AC</span>
                  </div>
                <?php endif; ?>
              </div>
              <div>
                <p class="text-[0.78rem] font-semibold text-navy group-hover:text-gold transition-colors leading-snug line-clamp-2">
                  <?php the_title(); ?>
                </p>
                <p class="text-[0.7rem] text-gray-400 mt-1"><?php echo get_the_date( 'M j, Y' ); ?></p>
              </div>
            </a>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Categories widget -->
    <div class="bg-white border border-stone-200 p-6">
      <h3 class="font-serif text-lg text-navy mb-5 pb-3 border-b border-stone-100">Categories</h3>
      <ul class="space-y-1">
        <?php
        $uncategorized_id = get_cat_ID( 'Uncategorized' );
        
        // Get ALL categories (including Uncategorized) to calculate total count
        $all_cats_total = get_categories( [ 'hide_empty' => true ] );
        $all_count = array_sum( array_column( $all_cats_total, 'count' ) );
        
        // Get categories for display (excluding Uncategorized)
        $all_cats = get_categories( [ 
            'hide_empty' => true,
            'exclude' => $uncategorized_id
        ] );
        ?>
        <li>
          <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"
             class="w-full flex justify-between items-center py-2 px-3 text-[0.83rem] text-gray-600 hover:bg-cream hover:text-gold transition-colors rounded-sm">
            <span>All Posts</span>
            <span class="bg-stone-100 text-navy text-[0.7rem] font-bold px-2 py-0.5 rounded-full">
              <?php echo $all_count; ?>
            </span>
          </a>
        </li>
        <?php foreach ( $all_cats as $cat ) : ?>
          <li>
            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
               class="w-full flex justify-between items-center py-2 px-3 text-[0.83rem] text-gray-600 hover:bg-cream hover:text-gold transition-colors rounded-sm
                      <?php echo is_category( $cat->term_id ) ? 'text-gold font-bold' : ''; ?>">
              <span><?php echo esc_html( $cat->name ); ?></span>
              <span class="bg-stone-100 text-navy text-[0.7rem] font-bold px-2 py-0.5 rounded-full">
                <?php echo $cat->count; ?>
              </span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Newsletter CTA -->
    <!-- <div class="bg-navy p-7 text-center">
      <span class="block font-serif italic text-3xl text-gold mb-3 leading-none">stay connected</span>
      <p class="text-[0.83rem] text-white/65 leading-relaxed mb-5">
        Get our weekly reflections, sermon summaries, and community news delivered to your inbox.
      </p>
       Replace with your email plugin shortcode, e.g. Mailchimp for WP 
      <?php
       //echo do_shortcode('[mc4wp_form id="YOUR_FORM_ID"]');
       // Otherwise, static form:
      ?>
      <form action="<?php //echo esc_url( home_url( '/newsletter/' ) ); ?>" method="post" class="space-y-3">
        <?php //wp_nonce_field( 'newsletter_signup', 'newsletter_nonce' ); ?>
        <input type="email" name="email" placeholder="Your email address"
               class="w-full border border-white/20 bg-white/10 text-white placeholder-white/40 px-4 py-2.5 text-sm focus:outline-none focus:border-gold"
               required/>
        <button type="submit"
                class="w-full bg-gold text-navy font-bold text-[0.75rem] tracking-widest uppercase py-3 hover:bg-gold-light transition-colors">
          Subscribe
        </button>
      </form>
    </div> -->

    <!-- Tag Cloud -->
    <div class="bg-white border border-stone-200 p-6">
      <h3 class="font-serif text-lg text-navy mb-5 pb-3 border-b border-stone-100">Tags</h3>
      <div class="flex flex-wrap gap-2">
        <?php
        $tags = get_tags( [ 'hide_empty' => true, 'number' => 12 ] );
        foreach ( $tags as $tag ) : ?>
          <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
             class="px-3 py-1 bg-cream text-navy text-[0.73rem] font-bold tracking-wide rounded-sm cursor-pointer hover:bg-gold hover:text-white transition-colors">
            <?php echo esc_html( $tag->name ); ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Dynamic sidebar (registered in functions.php) -->
    <?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
      <?php dynamic_sidebar( 'blog-sidebar' ); ?>
    <?php endif; ?>

  </aside>
</main>

<?php get_footer(); ?>
