<?php
/**
 * searchform.php — Custom styled search form.
 * WordPress uses this automatically when get_search_form() is called.
 */
?>
<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex gap-0">
  <label for="search-field" class="sr-only"><?php _e( 'Search for:', 'classic-anglican' ); ?></label>
  <input type="search"
         id="search-field"
         name="s"
         value="<?php echo get_search_query(); ?>"
         placeholder="<?php esc_attr_e( 'Search posts…', 'classic-anglican' ); ?>"
         class="flex-1 border border-stone-200 px-4 py-2.5 text-sm focus:outline-none focus:border-gold text-gray-700 bg-white"/>
  <button type="submit"
          class="bg-navy text-white px-4 py-2.5 text-sm font-bold hover:bg-gold hover:text-navy transition-colors"
          aria-label="Search">
    →
  </button>
</form>
