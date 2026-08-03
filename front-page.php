<?php
/**
 * front-page.php
 * Homepage template — shown when "A static page" is set as front page in
 * Settings → Reading, OR when no static page is set (uses latest posts fallback).
 */
get_header();
?>

<!-- ─── HERO SLIDER ─── -->
<section class="relative h-[520px] md:h-[520px] overflow-hidden bg-navy-deep">

  <?php
  /**
   * Build the hero slider with the original first slide and the latest post as a secondary slide.
   */
  $latest_post_slide = [
    'label'  => 'Latest Essay',
    'title'  => 'Read our latest reflection',
    'body'   => 'Explore our most recent article and join the conversation.',
    'cta'    => 'Read More',
    'url'    => home_url( '/blog/' ),
    'image'  => get_template_directory_uri() . '/images/slide1.jpg',
  ];

  $latest_post_query = new WP_Query( [
    'post_type'           => 'post',
    'posts_per_page'      => 1,
    'ignore_sticky_posts' => true,
  ] );

  if ( $latest_post_query->have_posts() ) {
    $latest_post_query->the_post();

    $latest_post_excerpt = get_the_excerpt();
    if ( empty( $latest_post_excerpt ) ) {
      $latest_post_excerpt = get_the_content();
    }

    $latest_post_slide = [
      'label'  => 'Latest Essay',
      'title'  => get_the_title(),
      'body'   => wp_trim_words( wp_strip_all_tags( $latest_post_excerpt ), 24 ),
      'cta'    => 'Read More',
      'url'    => get_permalink(),
      'image'  => has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : get_template_directory_uri() . '/images/slide1.jpg',
    ];

    wp_reset_postdata();
  }

  $slides = [
    [
      'label'  => 'Sunday Service · 09:45 AM · A local Chapel',
      'title'  => 'Worshipping the Lord in the beauty of holiness; ancient liturgy for the life of the world.',
      'body'   => 'Join us for worship, and celebrating the Holy Eucharist. All are welcome.',
      'cta'    => 'Plan Your Visit',
      'url'    => home_url( '/#/' ),
      'image'  => get_template_directory_uri() .'/images/slide1.jpg',
    ],
    $latest_post_slide,
    [
      'label'  => 'Theological Forum · 7:30 PM · A local Chapel',
      'title'  => 'Growing in faith through honest thinking, dialogue, and the pursuit of truth together.',
      'body'   => 'Join us for a fun and intellectual discussion about Christian theology, guided by theologians and priests.',
      'cta'    => 'Learn More',
      'url'    => home_url( '/#/' ),
      'image'  => get_template_directory_uri() .'/images/slide2.jpg',
    ],
  ];

  foreach ( $slides as $i => $slide ) :
    $active = $i === 0 ? 'active' : '';
  ?>
  <div class="slide <?php echo $active; ?>">
    <div class="slide-bg" style="background-image:url('<?php echo esc_url( $slide['image'] ); ?>');">
    </div>
    <div class="relative z-10 max-w-2xl ml-4 md:ml-16 px-4 md:px-8 flex flex-col justify-center h-full">
      <p class="text-[0.68rem] font-bold tracking-[0.22em] uppercase text-gold-light mb-3">
        <?php echo wp_kses_post( $slide['label'] ); ?>
      </p>
      <h1 class="font-serif text-2xl md:text-4xl font-semibold text-white leading-snug mb-4">
        <?php echo wp_kses_post( $slide['title'] ); ?>
      </h1>
      <p class="text-[0.85rem] md:text-[0.95rem] text-white/75 leading-relaxed mb-7 max-w-md">
        <?php echo esc_html( $slide['body'] ); ?>
      </p>
      <a href="<?php echo esc_url( $slide['url'] ); ?>"
         class="inline-block border-2 border-gold text-gold-light px-6 md:px-8 py-2 md:py-3 text-[0.7rem] md:text-[0.78rem] font-bold tracking-widest uppercase rounded-sm hover:bg-gold hover:text-navy transition-colors w-fit">
        <?php echo esc_html( $slide['cta'] ); ?>
      </a>
    </div>
  </div>
  <?php endforeach; ?>

  <!-- Dots -->
  <div class="absolute bottom-16 md:bottom-9 left-1/2 -translate-x-1/2 flex gap-2 z-20" id="sliderDots">
    <?php for ( $i = 0; $i < count( $slides ); $i++ ) : ?>
      <div class="slide-dot w-2 h-2 rounded-full <?php echo $i === 0 ? 'bg-gold' : 'bg-white/40'; ?> cursor-pointer transition-colors"
           onclick="goToSlide(<?php echo $i; ?>)"></div>
    <?php endfor; ?>
  </div>

  <!-- Arrows -->
  <div class="absolute bottom-4 md:bottom-7 right-4 md:right-12 flex gap-2.5 z-20">
    <div onclick="prevSlide()" class="w-10 h-10 md:w-11 md:h-11 border border-white/30 bg-navy/50 text-white flex items-center justify-center cursor-pointer text-lg md:text-xl rounded-sm hover:bg-gold hover:border-gold hover:text-navy transition-colors select-none">&#8249;</div>
    <div onclick="nextSlide()" class="w-10 h-10 md:w-11 md:h-11 border border-white/30 bg-navy/50 text-white flex items-center justify-center cursor-pointer text-lg md:text-xl rounded-sm hover:bg-gold hover:border-gold hover:text-navy transition-colors select-none">&#8250;</div>
  </div>
</section>

<!-- ─── LATEST ESSAYS ─── -->
<section id="essays" class="bg-white py-20 px-16">
  <div class="flex items-end justify-between mb-10">
    <div>
      <p class="text-[0.68rem] font-bold tracking-[0.22em] uppercase text-gold mb-2">Insights & Reflections</p>
      <h2 class="font-serif text-3xl text-navy">Latest Essays</h2>
    </div>
    <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"
       class="text-[0.78rem] font-bold tracking-widest uppercase text-gold border-b border-gold pb-0.5">
      View All Essays
    </a>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php
    /**
     * Query the 3 most recent blog posts (essays).
     */
    $essays = new WP_Query( [
      'post_type'      => 'post',
      'posts_per_page' => 3,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ] );

    if ( $essays->have_posts() ) :
      while ( $essays->have_posts() ) :
        $essays->the_post();
        $post_date = get_the_date( 'M j' );
        $post_image = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'medium' ) : 'https://images.unsplash.com/photo-1507842217343-583f7270aff4?w=700&auto=format&fit=crop&q=70';
    ?>
      <div class="border border-stone-200 overflow-hidden hover:shadow-xl transition-shadow group">
        <div class="h-44 bg-navy relative overflow-hidden">
          <div class="card-img absolute inset-0 bg-cover bg-center opacity-60"
               style="background-image:url('<?php echo esc_url( $post_image ); ?>');">
          </div>
          <div class="absolute top-4 left-4 bg-gold text-navy text-center py-2 px-3 rounded-sm z-10">
            <div class="text-[0.6rem] uppercase tracking-widest font-bold"><?php echo get_the_date( 'M' ); ?></div>
            <div class="text-2xl font-bold leading-tight"><?php echo get_the_date( 'd' ); ?></div>
          </div>
        </div>
        <div class="p-6">
          <h3 class="font-serif text-lg text-navy mb-2 leading-snug">
            <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="hover:text-gold transition-colors">
              <?php the_title(); ?>
            </a>
          </h3>
          <p class="text-[0.83rem] text-gray-500 leading-relaxed"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
          <p class="mt-4">
            <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="text-[0.73rem] font-bold tracking-wider uppercase text-gold hover:text-navy transition-colors">
              Read More »
            </a>
          </p>
        </div>
      </div>
    <?php
      endwhile;
      wp_reset_postdata();
    else :
    ?>
      <p class="text-gray-500 col-span-full text-center">No essays found.</p>
    <?php endif; ?>
  </div>
</section>


<!-- ─── WEEKLY ACTIVITIES ─── -->
<section id="services" class="bg-cream py-16 px-10 text-center">
  <h2 class="font-serif text-2xl text-navy mb-12">
    Our Weekly Activities
  </h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
    <?php
    $cards = [
      [ 'icon' => '🕊️', 'title' => 'Sunday Service',  'body' => 'Offline services every Sunday 09:45 AM at a local Chapel' ],
      [ 'icon' => '📖', 'title' => 'Theological Forum',     'body' => 'Engage in a fun and intellectual discussion about Christian theology, guided by theologians and priests, Every Friday 7:30 PM at a local Chapel' ],
      [ 'icon' => '🙏', 'title' => 'Daily Office', 'body' => 'Join us in praying the daily office as the Anglican tradition teaches together. Coming Soon.' ],
    ];
    foreach ( $cards as $card ) : ?>
      <div class="bg-white p-9 border-b-[3px] border-transparent hover:border-gold hover:-translate-y-1 hover:shadow-lg transition-all cursor-pointer">
        <div class="w-14 h-14 mx-auto mb-5 bg-navy rounded-full flex items-center justify-center text-2xl">
          <?php echo $card['icon']; ?>
        </div>
        <h3 class="font-serif text-lg text-navy mb-2"><?php echo wp_kses_post( $card['title'] ); ?></h3>
        <p class="text-sm text-gray-500 leading-relaxed"><?php echo esc_html( $card['body'] ); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ─── ABOUT US BANNER ─── -->
<div id="about-us" class="bg-navy text-white grid grid-cols-1 lg:grid-cols-1 gap-16 px-16 py-20 items-center">
  <div>
    <p class="text-[0.68rem] font-bold tracking-[0.22em] uppercase text-gold mb-3">About Classic Anglican</p>
    <h2 class="font-serif text-[2.2rem] font-semibold text-white leading-snug mb-5">
      <?php echo esc_html( get_theme_mod( 'vision_title', 'Rooted in the Oxford Movement. An Anglican church in a historical local chapel' ) ); ?>
    </h2>
    <div class="w-12 h-0.5 bg-gold mb-7"></div>
    <p class="text-[1rem] leading-[1.85] text-white/70">
      <?php echo esc_html( get_theme_mod( 'vision_body', 'Classic Anglican is affiliated with COE (Church of England), celebrating the Oxford Movement(Anglo-Catholic) tradition, we worship in a historic local chapel.' ) ); ?>
    </p>
    <div class="text-right mt-8">
      <a href="<?php echo esc_url( home_url( '/our-history/' ) ); ?>"
         class="inline-block border-2 border-gold text-gold px-8 py-3 text-[0.78rem] font-bold tracking-widest uppercase rounded-sm hover:bg-gold hover:text-navy transition-colors">
        Learn More About Us
      </a>
    </div>
  </div>
</div>

<!-- ─── VALUES SECTION ─── -->
<section id="values" class="bg-cream grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 px-6 md:px-16 lg:px-20 py-12 md:py-20 items-start">
  <div>
    <p class="text-[0.65rem] md:text-[0.68rem] font-bold tracking-[0.22em] uppercase text-gold mb-3">Our Values: The Sacramental Life</p>
    <h4 class="font-serif text-lg md:text-xl text-navy leading-snug mb-5">
      Classic Anglican embrace the fullness of the Seven Sacraments as taught by the Oxford Movement, we believe they're essential to the Apostolic and Catholic faith.
    </h4>
    <div class="w-12 h-0.5 bg-gold mb-7"></div>
    <?php
    $values = [
      [ 'num' => '01', 'title' => 'Holy Baptism','body' => 'Our new birth in Christ and entry into His Church.' ],
      [ 'num' => '02', 'title' => 'Confirmation','body' => 'The strengthening of the faithful by the Holy Spirit.' ],
      [ 'num' => '03', 'title' => 'The Holy Eucharist','body' => 'The Real Presence of Christ in the Holy Eucharist; the centre of our worship.' ],
      [ 'num' => '04', 'title' => 'Reconciliation(Confession)','body' => 'The sacramental grace of forgiveness and restoration, where we confess our sins and receive Absolution through the ministry of the Priest, acting by Christ’s authority.' ],
      [ 'num' => '05', 'title' => 'Holy Matrimony','body' => 'The sacrament of covenantal love reflecting the faithfulness of Christ and the Church.' ],
      [ 'num' => '06', 'title' => 'Holy Orders','body' => 'The sacrament through which the Church sets apart bishops, priests, and deacons for ministry.' ],
      [ 'num' => '07', 'title' => 'Anointing of the Sick','body' => 'The sacrament of healing, comfort, and grace in times of illness and suffering.' ],
    ];
    foreach ( $values as $v ) : ?>
      <div class="value-row flex items-start gap-4 md:gap-5 py-4 md:py-5 border-b border-stone-200 cursor-pointer">
        <div class="font-serif text-xl md:text-2xl font-bold text-gold min-w-[32px] md:min-w-[36px]"><?php echo $v['num']; ?></div>
        <div>
          <h4 class="text-[0.8rem] md:text-[0.9rem] font-bold tracking-wider uppercase text-navy mb-1">
            <?php echo wp_kses_post( $v['title'] ); ?>
          </h4>
          <p class="text-[0.75rem] md:text-[0.83rem] text-gray-500 leading-relaxed"><?php echo esc_html( $v['body'] ); ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Living Sacramentally -->
  <div class="bg-navy rounded-sm px-6 md:px-11 py-8 md:py-12 text-center lg:sticky lg:top-24">
    <span class="block font-serif italic text-3xl md:text-5xl text-gold mb-4 md:mb-6 leading-none">Living Sacramentally</span>
    <p class="text-[0.8rem] md:text-[0.88rem] text-white/70 leading-[1.7] md:leading-[1.8] mb-6 md:mb-7">
      While the Anglican tradition highlights Baptism and the Eucharist as the two principal Sacraments of the Gospel, the Oxford Movement heritage at <?php bloginfo( 'name' ); ?> treasuring the full sacramental heritage of the Oxford Movement, we believe God meets us through the tangible. From birth and vocation to reconciliation and healing, these sacred rites transform the ordinary into channels of divine presence, drawing our whole existence into the grace of God.
    </p>
    <a href="<?php echo esc_url( home_url( '/our-beliefs/' ) ); ?>"
       class="inline-block bg-gold text-navy px-5 md:px-7 py-2 md:py-3 text-[0.7rem] md:text-[0.75rem] font-bold tracking-[0.12em] uppercase rounded-sm hover:bg-gold-light transition-colors">
      Learn About Our Beliefs
    </a>
  </div>
</section>

<!-- ─── MINISTRIES GRID ─── -->
<section id="ministries" class="bg-white py-20 px-10 text-center">
  <p class="text-[0.68rem] font-bold tracking-[0.22em] uppercase text-gold mb-3">Our Ministries</p>
  <h2 class="font-serif text-3xl text-navy mb-4">Serving God and Neighbour</h2>
  <div class="w-12 h-0.5 bg-gold mx-auto mb-5"></div>
  <p class="text-base text-gray-500 leading-relaxed max-w-xl mx-auto mb-12">
    Each ministry serves a distinct part of our mission. Together they form the full expression of our faith, extending the grace and love of God into our daily lives and the local community.
  </p>
  <?php
  $ministries = [
    [ 'name' => 'Pastoral Care','url' => home_url( '/pastoral-care/' ) ],
    [ 'name' => 'Sacrament of Reconciliation','url' => home_url( '/absolution/' ) ],
    [ 'name' => 'Youth Ministry','url' => home_url( '/youth/' ) ],
    [ 'name' => 'Theological Forum', 'url' => home_url( '/forum-theology/' ) ],
    [ 'name' => 'Gratia House','url' => home_url( '/safe-house/' ) ],
    [ 'name' => 'Advocacy','url' => home_url( '/advocacy/' ) ],
  ];
  ?>
  <div class="ministry-grid-wrap grid grid-cols-2 lg:grid-cols-3 max-w-5xl mx-auto">
    <?php foreach ( $ministries as $min ) : ?>
      <div class="bg-white flex flex-col items-center gap-3 py-10 px-8 hover:bg-cream cursor-pointer transition-colors">
        <div class="w-20 h-12 bg-navy rounded flex items-center justify-center text-[0.7rem] font-serif italic text-white/70 text-center px-2">
          <?php echo wp_kses_post( $min['name'] ); ?>
        </div>
        <h4 class="text-[0.8rem] font-bold tracking-wider uppercase text-navy">
          <?php echo wp_kses_post( $min['name'] ); ?>
        </h4>
        <a href="<?php echo esc_url( $min['url'] ); ?>"
           class="text-[0.75rem] text-gold font-bold hover:text-navy transition-colors">Learn more »</a>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php get_footer(); ?>
