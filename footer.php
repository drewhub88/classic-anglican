<!-- ─── CTA BANNER ─── -->
<div class="bg-maroon flex flex-col md:flex-row items-center justify-between gap-10 px-20 py-14">
  <div>
    <h2 class="font-serif text-[1.9rem] text-gold font-semibold">
      New to <?php bloginfo( 'name' ); ?>?
    </h2>
    <p class="text-[0.92rem] text-cream/70 mt-1.5">
      We welcomes all who seek a deeper encounter with God through prayer, sacrament, and Christian fellowship, and who desire to grow in faith while serving the wider community.
    </p>
  </div>
  <a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>"
     class="shrink-0 bg-navy text-white px-9 py-4 text-[0.8rem] font-bold tracking-[0.12em] uppercase rounded-sm hover:bg-navy-deep transition-colors">
    Plan Your Visit
  </a>
</div>

<!-- ─── FOOTER ─── -->
<footer class="bg-maroon-deep text-stone-400 px-16 pt-16 pb-0">
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-12 border-b border-white/10">

    <!-- Branding column -->
    <div>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 mb-5" rel="home">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.svg" 
             alt="<?php bloginfo( 'name' ); ?>" 
             class="w-auto" 
             style="max-height: 60px;">
      </a>
      <p class="text-[0.83rem] text-white/50 leading-relaxed">
        <?php echo esc_html( get_theme_mod( 'footer_about_text', 'Oxford Movement based Anglican Church' ) ); ?>
      </p>
      <address class="not-italic text-[0.82rem] text-white/40 mt-5 leading-[1.85]">
        <?php echo nl2br( esc_html( get_theme_mod( 'footer_address', "Bakerstreet" ) ) ); ?>
      </address>
    </div>

    <!-- About Us -->
    <div>
      <h4 class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-gold mb-5">About Us</h4>
      <ul class="space-y-2.5">
        <li><a href="<?php echo esc_url( home_url( '/our-history/' ) ); ?>"    class="text-[0.83rem] text-white/50 hover:text-gold-light transition-colors">Our Story</a></li>
        <li><a href="<?php echo esc_url( home_url( '/our-beliefs/' ) ); ?>"      class="text-[0.83rem] text-white/50 hover:text-gold-light transition-colors">Beliefs &amp; Vision</a></li>
        <li><a href="<?php echo esc_url( home_url( '/our-team/' ) ); ?>"       class="text-[0.83rem] text-white/50 hover:text-gold-light transition-colors">Clergy &amp; Staff</a></li>

      </ul>
    </div>

    <!-- Ministries -->
    <div>
      <h4 class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-gold mb-5">Ministries</h4>
      <ul class="space-y-2.5">
        <li><a href="<?php echo esc_url( home_url( '/youth/' ) ); ?>" class="text-[0.83rem] text-white/50 hover:text-gold-light transition-colors">Youth Ministry</a></li>
        <li><a href="<?php echo esc_url( home_url( '/advocacy/' ) ); ?>" class="text-[0.83rem] text-white/50 hover:text-gold-light transition-colors">Advocacy</a></li>
        <li><a href="<?php echo esc_url( home_url( '/pastoral-care/' ) ); ?>"     class="text-[0.83rem] text-white/50 hover:text-gold-light transition-colors">Pastoral Care</a></li>
        <li><a href="<?php echo esc_url( home_url( '/absolution/' ) ); ?>"      class="text-[0.83rem] text-white/50 hover:text-gold-light transition-colors">Sacrament of Reconciliation</a></li>
      </ul>
    </div>

    <!-- Resources -->
    <div>
      <h4 class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-gold mb-5">Resources</h4>
      <ul class="space-y-2.5">
        <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"         class="text-[0.83rem] text-white/50 hover:text-gold-light transition-colors">Our Essays</a></li>
        <li><a href="<?php echo esc_url( home_url( '/give/' ) ); ?>"         class="text-[0.83rem] text-white/50 hover:text-gold-light transition-colors">Donation</a></li>
        <li><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>"      class="text-[0.83rem] text-white/50 hover:text-gold-light transition-colors">Contact Us</a></li>
      </ul>
    </div>

  </div><!-- end footer grid -->

  <!-- Bottom bar -->
  <div class="flex flex-col sm:flex-row items-center justify-between py-6 text-[0.75rem] text-white/30 gap-4">
    <span>
      &copy; <?php echo date( 'Y' ); ?>
      <?php bloginfo( 'name' ); ?>.
      All rights reserved. • <a href="<?php echo esc_url( home_url( 'https://drewhub88.github.io/AE-is-here/' ) ); ?>" class="text-white/50 hover:text-gold transition-colors">Æ was here</a>
    </span>

    <!-- Social icons -->
    <div class="flex gap-3">
      <?php if ( $instagram = get_theme_mod( 'social_instagram' ) ) : ?>
        <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener"
           class="w-9 h-9 border border-white/15 rounded-sm flex items-center justify-center text-white/50 hover:bg-gold hover:border-gold hover:text-navy transition-colors"
           aria-label="Instagram"><i class="fab fa-instagram"></i></a>
      <?php else : ?>
        <a href="" target="_blank" rel="noopener" class="w-9 h-9 border border-white/15 rounded-sm flex items-center justify-center text-white/50 hover:bg-gold hover:border-gold hover:text-navy transition-colors" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
      <?php endif; ?>

      <?php if ( $youtube = get_theme_mod( 'social_youtube' ) ) : ?>
        <a href="<?php echo esc_url( $youtube ); ?>" target="_blank" rel="noopener"
           class="w-9 h-9 border border-white/15 rounded-sm flex items-center justify-center text-white/50 hover:bg-gold hover:border-gold hover:text-navy transition-colors"
           aria-label="YouTube"><i class="fab fa-youtube"></i></a>
      <?php else : ?>
        <a href="" target="_blank" rel="noopener" class="w-9 h-9 border border-white/15 rounded-sm flex items-center justify-center text-white/50 hover:bg-gold hover:border-gold hover:text-navy transition-colors" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
      <?php endif; ?>
    </div>
  </div>
</footer>

<!-- Back to top -->
<div id="backTop"
     class="fixed bottom-7 right-7 w-11 h-11 bg-gold text-navy flex items-center justify-center cursor-pointer rounded-sm text-xl opacity-0 transition-opacity duration-300 z-50"
     aria-label="Back to top">↑</div>

<?php wp_footer(); ?>
</body>
</html>
