<?php
/**
 * single.php
 * Single blog post template.
 */
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<!-- ─── POST HERO ─── -->
<div class="bg-navy relative overflow-hidden" style="min-height: 420px;">
  <?php if ( has_post_thumbnail() ) : ?>
    <div class="absolute inset-0 bg-cover bg-center opacity-30"
         style="background-image:url('<?php the_post_thumbnail_url( 'anglo-hero' ); ?>');">
    </div>
  <?php endif; ?>
  <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(17,28,45,1) 20%, rgba(17,28,45,.6));"></div>
  <div class="relative z-10 max-w-3xl mx-auto px-6 py-20 text-center">
    <!-- Category -->
    <?php $cats = get_the_category(); if ( $cats ) : ?>
      <a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"
         class="inline-block bg-gold text-navy text-[0.62rem] font-bold tracking-widest uppercase px-3 py-1 rounded-sm mb-6 hover:bg-gold-light transition-colors">
        <?php echo esc_html( $cats[0]->name ); ?>
      </a>
    <?php endif; ?>

    <h1 class="font-serif text-4xl font-semibold text-white leading-snug mb-6">
      <?php the_title(); ?>
    </h1>

    <div class="flex items-center justify-center gap-4 text-[0.75rem] text-white/55 tracking-wide uppercase">
      <?php echo get_the_date( 'F j, Y' ); ?>
      <span class="text-gold">·</span>
      By <?php the_author(); ?>
      <span class="text-gold">·</span>
      <?php echo classic_anglican_reading_time(); ?>
    </div>
  </div>
</div>

<!-- ─── BREADCRUMB ─── -->
<div class="bg-cream border-b border-stone-200 px-10 py-3 text-[0.75rem] text-gray-400 tracking-wide">
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-gold transition-colors">Home</a>
  <span class="mx-2 text-stone-300">/</span>
  <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="hover:text-gold transition-colors">Blog</a>
  <span class="mx-2 text-stone-300">/</span>
  <span class="text-navy font-semibold"><?php the_title(); ?></span>
</div>

<!-- ─── ARTICLE BODY ─── -->
<div class="max-w-[1100px] mx-auto px-6 py-14 grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-14 items-start">

  <!-- Article -->
  <article class="min-w-0">

    <!-- Content -->
    <div class="prose max-w-none
                prose-p:text-gray-600 prose-p:leading-[1.9]
                prose-a:text-gold prose-a:no-underline hover:prose-a:text-navy
                prose-blockquote:border-l-4 prose-blockquote:border-gold prose-blockquote:pl-6
                prose-blockquote:font-serif prose-blockquote:italic prose-blockquote:text-gray-600">
      <?php the_content(); ?>
    </div>

    <!-- Tags -->
    <?php $tags = get_the_tags(); if ( $tags ) : ?>
      <div class="mt-10 pt-8 border-t border-stone-200">
        <span class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-gold mr-3">Tags:</span>
        <?php foreach ( $tags as $tag ) : ?>
          <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
             class="inline-block mr-2 mb-2 px-3 py-1 bg-cream text-navy text-[0.73rem] font-bold tracking-wide rounded-sm hover:bg-gold hover:text-white transition-colors">
            <?php echo esc_html( $tag->name ); ?>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Author bio -->
    <div class="mt-10 pt-8 border-t border-stone-200 flex gap-6 items-start">
      <div class="shrink-0">
        <?php echo get_avatar( get_the_author_meta( 'ID' ), 72, '', '', [ 'class' => 'rounded-full' ] ); ?>
      </div>
      <div>
        <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-gold mb-1">About the Author</p>
        <h4 class="font-serif text-lg text-navy mb-2"><?php the_author(); ?></h4>
        <p class="text-[0.85rem] text-gray-500 leading-relaxed">
          <?php echo esc_html( get_the_author_meta( 'description' ) ?: 'A member of the Grace Community Church pastoral and writing team.' ); ?>
        </p>
      </div>
    </div>

    <!-- Prev / Next post navigation -->
    <div class="mt-12 pt-8 border-t border-stone-200 grid grid-cols-2 gap-6">
      <?php
      $prev_post = get_previous_post();
      $next_post = get_next_post();
      ?>
      <?php if ( $prev_post ) : ?>
        <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>"
           class="group p-5 border border-stone-200 hover:border-gold transition-colors">
          <p class="text-[0.65rem] font-bold tracking-widest uppercase text-gold mb-2">← Previous Post</p>
          <p class="font-serif text-navy text-base leading-snug group-hover:text-gold transition-colors">
            <?php echo esc_html( $prev_post->post_title ); ?>
          </p>
        </a>
      <?php else : ?>
        <div></div>
      <?php endif; ?>

      <?php if ( $next_post ) : ?>
        <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>"
           class="group p-5 border border-stone-200 hover:border-gold transition-colors text-right">
          <p class="text-[0.65rem] font-bold tracking-widest uppercase text-gold mb-2">Next Post →</p>
          <p class="font-serif text-navy text-base leading-snug group-hover:text-gold transition-colors">
            <?php echo esc_html( $next_post->post_title ); ?>
          </p>
        </a>
      <?php endif; ?>
    </div>

    <!-- Comments -->
    <?php if ( comments_open() || get_comments_number() ) : ?>
      <div class="mt-14">
        <?php comments_template(); ?>
      </div>
    <?php endif; ?>

  </article>

  <!-- ─── SIDEBAR ─── -->
  <aside class="space-y-6 lg:sticky lg:top-24">

    <!-- Back to blog -->
    <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"
       class="flex items-center gap-2 text-[0.75rem] font-bold tracking-widest uppercase text-gold hover:text-navy transition-colors">
      ← Back to Blog
    </a>

    <!-- Search -->
    <div class="bg-cream border border-stone-200 p-6">
      <h3 class="font-serif text-lg text-navy mb-4">Search</h3>
      <?php get_search_form(); ?>
    </div>

    <!-- Recent Posts -->
    <div class="bg-white border border-stone-200 p-6">
      <h3 class="font-serif text-lg text-navy mb-5 pb-3 border-b border-stone-100">Recent Posts</h3>
      <?php
      $recent = new WP_Query( [
          'post_type'      => 'post',
          'posts_per_page' => 5,
          'post_status'    => 'publish',
          'post__not_in'   => [ get_the_ID() ],
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
                    <span class="font-serif italic text-gold text-xs">G</span>
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

    <!-- Categories -->
    <div class="bg-white border border-stone-200 p-6">
      <h3 class="font-serif text-lg text-navy mb-5 pb-3 border-b border-stone-100">Categories</h3>
      <ul class="space-y-1">
        <?php
        $cats = get_categories( [ 'hide_empty' => true ] );
        foreach ( $cats as $cat ) : ?>
          <li>
            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
               class="flex justify-between items-center py-2 px-3 text-[0.83rem] text-gray-600 hover:bg-cream hover:text-gold transition-colors rounded-sm">
              <span><?php echo esc_html( $cat->name ); ?></span>
              <span class="bg-stone-100 text-navy text-[0.7rem] font-bold px-2 py-0.5 rounded-full">
                <?php echo $cat->count; ?>
              </span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Tags -->
    <div class="bg-white border border-stone-200 p-6">
      <h3 class="font-serif text-lg text-navy mb-5 pb-3 border-b border-stone-100">Tags</h3>
      <div class="flex flex-wrap gap-2">
        <?php
        $all_tags = get_tags( [ 'hide_empty' => true, 'number' => 12 ] );
        foreach ( $all_tags as $tag ) : ?>
          <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
             class="px-3 py-1 bg-cream text-navy text-[0.73rem] font-bold tracking-wide rounded-sm hover:bg-gold hover:text-white transition-colors">
            <?php echo esc_html( $tag->name ); ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

  </aside>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
