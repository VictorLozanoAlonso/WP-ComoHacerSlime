<?php

function disable_all_feeds() {
   wp_die( __('Lo siento, nuestro contenido no está disponible mediante RSS. Por favor, visita <a href="'. get_bloginfo('url') .'">la web</a> para leerla') );
}
 
add_action('do_feed', 'disable_all_feeds', 1);
add_action('do_feed_rdf', 'disable_all_feeds', 1);
add_action('do_feed_rss', 'disable_all_feeds', 1);
add_action('do_feed_rss2', 'disable_all_feeds', 1);
add_action('do_feed_atom', 'disable_all_feeds', 1);

remove_action( 'wp_head', 'feed_links', 2 );
remove_action('wp_head', 'feed_links_extra', 3 );

if ( ! function_exists( 'generate_header_items' ) ) {
	/**
	 * Build the header contents.
	 * Wrapping this into a function allows us to customize the order.
	 *
	 * @since 1.2.9.7
	 */
	function generate_header_items() {
		$order = apply_filters( 'generate_header_items_order',
			array(
				'site-branding',
				'logo',
				'header-widget',
			)
		);

		foreach ( $order as $item ) {
			if ( 'site-branding' === $item ) {
				generate_construct_site_title();
			}

			if ( 'logo' === $item ) {
				generate_construct_logo();
			}
			if ( 'header-widget' === $item ) {
				generate_construct_header_widget();
			}
		}
	}
}

if ( ! function_exists( 'generate_add_footer_info' ) ) {
	add_action( 'generate_credits', 'generate_add_footer_info' );
	/**
	 * Add the copyright to the footer
	 *
	 * @since 0.1
	 */
	function generate_add_footer_info() {
		$copyright = "Las mejores recetas de SLIME";

		echo apply_filters( 'generate_copyright', $copyright ); // WPCS: XSS ok.
	}
}

if ( ! function_exists( 'generate_widgets_init' ) ) {
	add_action( 'widgets_init', 'generate_widgets_init' );
	/**
	 * Register widgetized area and update sidebar with default widgets
	 */
	function generate_widgets_init() {
		$widgets = array(
			'sidebar-1' => __( 'Right Sidebar', 'generatepress' ),
			'sidebar-2' => __( 'Left Sidebar', 'generatepress' ),
			'header' => __( 'Header', 'generatepress' ),
			'content' => __( 'Content', 'generatepress' ),
			'footer-1' => __( 'Footer Widget 1', 'generatepress' ),
			'footer-2' => __( 'Footer Widget 2', 'generatepress' ),
			'footer-3' => __( 'Footer Widget 3', 'generatepress' ),
			'footer-4' => __( 'Footer Widget 4', 'generatepress' ),
            'footer-5' => __( 'Footer Widget 5', 'generatepress' ),
			'footer-bar' => __( 'Footer Bar','generatepress' ),
			'top-bar' => __( 'Top Bar','generatepress' ),
		);

		foreach ( $widgets as $id => $name ) {
			register_sidebar( array(
				'name'          => $name,
				'id'            => $id,
				'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => apply_filters( 'generate_start_widget_title', '<h2 class="widget-title">' ),
				'after_title'   => apply_filters( 'generate_end_widget_title', '</h2>' ),
			) );
		}
	}
}
//* Activate shortcode function in Post Title
add_filter( 'the_title', 'do_shortcode' );
//* Shortcode to display the current date, month and year in WordPress
//* shortcode: [date_month_year]
add_shortcode( 'date_month_year' , 'current_date_month_year' );
function current_date_month_year() {
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$year = date("Y");
	$month = $meses[date('n')-1];
	$date = date("j");
	return "$date de $month, $year";
}
?>