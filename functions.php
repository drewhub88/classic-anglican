<?php
/**
 * Classic Anglican — functions.php
 * Theme setup, asset loading, menus, widget areas, custom hooks.
 */

// ─── 1. THEME SETUP ───────────────────────────────────────────────────────────
function classic_anglican_setup() {

    // Allow WordPress to manage the <title> tag
    add_theme_support( 'title-tag' );

    // Enable featured images on posts/pages
    add_theme_support( 'post-thumbnails' );

    // HTML5 markup for built-in WP elements
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ] );

    // Wide/full-width blocks (block editor)
    add_theme_support( 'align-wide' );

    // Custom logo in Customizer
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ] );

    // Register nav menu locations
    register_nav_menus( [
        'primary'  => __( 'Primary Navigation', 'classic-anglican' ),
        'footer'   => __( 'Footer Navigation',  'classic-anglican' ),
        'topbar'   => __( 'Top Bar Links',       'classic-anglican' ),
    ] );
}
add_action( 'after_setup_theme', 'classic_anglican_setup' );


// ─── 2. ENQUEUE STYLES & SCRIPTS ─────────────────────────────────────────────
function classic_anglican_enqueue_assets() {

    // Main theme stylesheet (style.css — contains Tailwind overrides)
    wp_enqueue_style(
        'classic-anglican-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get( 'Version' )
    );

    // Google Fonts: Playfair Display + Lato
    wp_enqueue_style(
        'classic-anglican-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap',
        [],
        null
    );

    // Font Awesome — Brand icons (v6.4 free CDN)
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        [],
        '6.4.0'
    );

    // Tailwind CSS (CDN — swap for a compiled build in production)
    wp_enqueue_script(
        'tailwindcss',
        'https://cdn.tailwindcss.com',
        [],
        null,
        false // load in <head> so config runs before body renders
    );

    // Tailwind config (custom colors + fonts) — must come after Tailwind CDN
    wp_add_inline_script( 'tailwindcss', '
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon:      { DEFAULT: "#83171c", deep: "#670d11" },
                        navy:       { DEFAULT: "#1b2e4b", deep: "#12203a" },
                        gold:      { DEFAULT: "#b8975a", light: "#F1D592" },
                        cream:     "#f7f4ef",
                        warmwhite: "#fffdf9",
                    },
                    fontFamily: {
                        serif: ["Playfair Display", "Georgia", "serif"],
                        sans:  ["Lato", "sans-serif"],
                    },
                }
            }
        };
    ' );

    // Theme JS (slider, back-to-top, mobile menu)
    wp_enqueue_script(
        'classic-anglican-js',
        get_template_directory_uri() . '/js/theme.js',
        [],
        wp_get_theme()->get( 'Version' ),
        true // load in footer
    );

    // Comment reply script (only on single posts with comments open)
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'classic_anglican_enqueue_assets' );


// ─── 3. WIDGET AREAS (SIDEBAR) ───────────────────────────────────────────────
function classic_anglican_widgets_init() {

    register_sidebar( [
        'name'          => __( 'Blog Sidebar', 'classic-anglican' ),
        'id'            => 'blog-sidebar',
        'description'   => __( 'Widgets shown on the blog archive page sidebar.', 'classic-anglican' ),
        'before_widget' => '<div class="bg-white border border-stone-200 p-6 mb-6" id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="font-serif text-lg text-navy mb-5 pb-3 border-b border-stone-100">',
        'after_title'   => '</h3>',
    ] );

    register_sidebar( [
        'name'          => __( 'Footer — Column 1', 'classic-anglican' ),
        'id'            => 'footer-1',
        'before_widget' => '<div id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-gold mb-4">',
        'after_title'   => '</h4>',
    ] );
}
add_action( 'widgets_init', 'classic_anglican_widgets_init' );


// ─── 4. CUSTOM EXCERPT LENGTH ────────────────────────────────────────────────
function classic_anglican_excerpt_length( $length ) {
    return 28; // words
}
add_filter( 'excerpt_length', 'classic_anglican_excerpt_length' );

function classic_anglican_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'classic_anglican_excerpt_more' );


// ─── 5. CUSTOM IMAGE SIZES ───────────────────────────────────────────────────
add_image_size( 'anglo-card',      800, 420, true );  // blog card thumbnail
add_image_size( 'anglo-sidebar',   320, 200, true );  // sidebar recent post thumb
add_image_size( 'anglo-hero',     1600, 700, true );  // hero slider


// ─── 6. READING TIME HELPER ──────────────────────────────────────────────────
function classic_anglican_reading_time() {
    $content    = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    $minutes    = max( 1, (int) ceil( $word_count / 200 ) );
    return $minutes . ' min read';
}


// ─── 7. BODY CLASSES ─────────────────────────────────────────────────────────
function classic_anglican_body_classes( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'singular';
    }
    return $classes;
}
add_filter( 'body_class', 'classic_anglican_body_classes' );


// ─── 8. PAGINATION HELPER ────────────────────────────────────────────────────
function classic_anglican_pagination() {
    global $wp_query;
    $total = $wp_query->max_num_pages;
    if ( $total < 2 ) return;

    $current = max( 1, get_query_var( 'paged' ) );

    echo '<div class="flex items-center justify-between mt-12 pt-8 border-t border-stone-200">';

    // Previous
    $prev = get_previous_posts_link( '← Previous' );
    if ( $prev ) {
        echo '<a class="flex items-center gap-2 px-5 py-2.5 text-[0.75rem] font-bold tracking-widest uppercase rounded-sm border border-gold text-gold hover:bg-gold hover:text-navy transition-colors">' . $prev . '</a>';
    } else {
        echo '<span class="px-5 py-2.5 text-[0.75rem] font-bold tracking-widest uppercase rounded-sm border border-stone-300 text-gray-400 opacity-40 cursor-not-allowed">← Previous</span>';
    }

    // Page numbers
    echo '<div class="flex items-center gap-1">';
    for ( $i = 1; $i <= $total; $i++ ) {
        $active = $i === $current ? 'bg-navy text-white' : 'text-navy hover:bg-gold hover:text-white transition-colors';
        $url    = get_pagenum_link( $i );
        echo "<a href=\"{$url}\" class=\"w-10 h-10 text-sm font-bold rounded-sm flex items-center justify-center {$active}\">{$i}</a>";
    }
    echo '</div>';

    // Next
    $next = get_next_posts_link( 'Next →' );
    if ( $next ) {
        echo '<a class="flex items-center gap-2 px-5 py-2.5 text-[0.75rem] font-bold tracking-widest uppercase rounded-sm border border-gold text-gold hover:bg-gold hover:text-navy transition-colors">' . $next . '</a>';
    } else {
        echo '<span class="px-5 py-2.5 text-[0.75rem] font-bold tracking-widest uppercase rounded-sm border border-stone-300 text-gray-400 opacity-40 cursor-not-allowed">Next →</span>';
    }

    echo '</div>';
}


// ─── 9. ALLOW SVG UPLOADS ────────────────────────────────────────────────────
function classic_anglican_allow_svg( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'classic_anglican_allow_svg' );


// ─── 10. CUSTOM NAV WALKER ───────────────────────────────────────────────────
// Applies Tailwind classes to WordPress nav menu output.
// Must live in functions.php so it's available before header.php runs.

if ( ! class_exists( 'Classic_Anglican_Nav_Walker' ) ) :

class Classic_Anglican_Nav_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item      = $data_object;
        $classes   = empty( $item->classes ) ? [] : (array) $item->classes;
        $is_active = in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-ancestor', $classes );

        if ( $depth === 0 ) {
            $output .= '<div class="group relative">';
            $output .= '<a href="' . esc_url( $item->url ) . '" class="block px-4 py-[26px] text-[0.78rem] font-bold tracking-[0.12em] uppercase transition-colors '
                . ( $is_active ? 'text-gold-light border-b-2 border-gold' : 'text-stone-300 hover:text-gold-light' ) . '">';
            $output .= esc_html( $item->title );
            $output .= '</a>';
        } elseif ( $depth === 1 ) {
            $output .= '<a href="' . esc_url( $item->url ) . '" class="block px-5 py-[11px] text-[0.78rem] text-stone-300 border-b border-white/5 hover:bg-gold/10 hover:text-gold-light transition-colors">';
            $output .= esc_html( $item->title );
            $output .= '</a>';
        }
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '</div>';
        }
    }

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '<div class="dropdown absolute top-full left-0 bg-navy-deep border-t-2 border-gold min-w-[200px] z-50 shadow-xl">';
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '</div>';
        }
    }
}

endif;

// Fallback shown when no menu is assigned in Appearance → Menus
function classic_anglican_fallback_nav( $args ) {
    echo '<div class="flex items-center gap-1 text-stone-400 text-sm px-4">
        <span>No menu assigned. Go to </span>
        <a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" class="text-gold underline ml-1">Appearance → Menus</a>
    </div>';
}

class Mobile_Anglican_Nav_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item      = $data_object;
        $classes   = empty( $item->classes ) ? [] : (array) $item->classes;
        $is_active = in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-ancestor', $classes );

        if ( $depth === 0 ) {
            $output .= '<a href="' . esc_url( $item->url ) . '" class="block py-3 text-[0.85rem] font-bold tracking-[0.12em] uppercase border-b border-white/10 transition-colors '
                . ( $is_active ? 'text-gold-light' : 'text-stone-300 hover:text-gold-light' ) . '">';
            $output .= esc_html( $item->title );
            $output .= '</a>';
        } elseif ( $depth === 1 ) {
            $output .= '<a href="' . esc_url( $item->url ) . '" class="block py-2 pl-4 text-[0.8rem] text-stone-400 border-b border-white/5 hover:text-gold-light transition-colors">';
            $output .= esc_html( $item->title );
            $output .= '</a>';
        }
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        // nothing needed — links are self-contained
    }

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '<div class="pl-2 flex flex-col">';
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '</div>';
        }
    }
}