<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


// Default globals
global $us_b_potential_bootstrap_color_classes, $us_b_heading_sizes, $builder_default_spacings;
$us_b_potential_bootstrap_color_classes = array('Primary'   => '#6761A8', 
                                           'Secondary' => '#EEB902', 
                                           'Success'   => '#97CC04', 
                                           'Info'      => '#187BCA', 
                                           'Warning'   => '#F45D01', 
                                           'Danger'    => '#FE4A49', 
                                           'Light'     => '#FBFFF1', 
                                           'Dark'      => '#2A2D34');
$us_b_heading_sizes = array('H1' => array('default' => '2.5rem'), 
                            'H2' => array('default' => '2rem'), 
                            'H3' => array('default' => '1.75rem'), 
                            'H4' => array('default' => '1.5rem'), 
                            'H5' => array('default' => '1.25rem'), 
                            'H6' => array('default' => '1rem'));
$builder_default_spacings = '{"mt": "", "mr": "", "mb": "", "ml": "", "pt": "", "pr": "", "pb": "", "pl": ""}';



/* Actions */
add_action( 'wp_enqueue_scripts', 'understrap_builder_remove_scripts', 20 ); // Remove UnderStrap Defaults
add_action( 'wp_enqueue_scripts', 'understrap_builder_enqueue_styles' ); // Add in UnderStrap BUIDLER styles & scripts
add_action( 'after_setup_theme', 'understrap_builder_add_child_theme_textdomain' ); // Assign language folder



/* Includes */
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/customizer.php' );
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/builder_template_functions.php' );
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/onpage_styles.php' );
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/onpage_scripts.php' );
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/additional_menus.php' );
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/builder_wpadmin_functions.php' );
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/builder_options_page.php' );
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/builder_importables.php' );
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/builder-custom-comments.php' );
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/builder_admin_bar.php' );
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/post_page_meta.php' );
require_once( trailingslashit( get_stylesheet_directory() ). 'inc/builder_custom_customizers.php' );

require_once( trailingslashit( get_stylesheet_directory() ). 'inc/TGM-Plugin-Activation/class-tgm-plugin-activation.php' );

require_once( trailingslashit( get_stylesheet_directory() ). 'inc/Customizer-Custom-Controls/custom-controls.php' );





/* PUC Update For BUILDER*/
// https://github.com/YahnisElsts/plugin-update-checker
require( trailingslashit( get_stylesheet_directory() ). 'inc/plugin-update-checker.php' );
global $BUILDERUpdateChecker;
$BUILDERUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://understrap.com/update/understrap_builder_latest.json#'.urlencode(get_home_url()),
	__FILE__, 
	'understrap-builder'
);



/* Remove UnderStrap Defaults */
function understrap_builder_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );
    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );
}



/* Remove some UnderStrap page templates */
function understrap_builder_remove_page_templates( $templates ) {
  unset( $templates['page-templates/blank.php'] );
  unset( $templates['page-templates/empty.php'] );
  return $templates;
}
add_filter( 'theme_page_templates', 'understrap_builder_remove_page_templates' );



/* Remove some UnderStrap sidebar locations */
function understrap_builder_unregister_sidebars(){
  unregister_sidebar( 'hero' );
  unregister_sidebar( 'herocanvas' );
  unregister_sidebar( 'statichero' );
}
add_action( 'widgets_init', 'understrap_builder_unregister_sidebars', 99 );



/* Add in UnderStrap BUIDLER Styles & scripts */
function understrap_builder_enqueue_styles() {
  
	$the_theme = wp_get_theme();
  
  wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
  wp_enqueue_script( 'jquery');
  wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
  wp_enqueue_style( 'understrap-builder-styles', get_stylesheet_directory_uri() . '/css/understrap-builder.min.css', array(), $the_theme->get( 'Version' ) );
  //wp_enqueue_script( 'understrap-builder-scripts', get_stylesheet_directory_uri() . '/js/understrap-builder.min.js', array(), $the_theme->get( 'Version' ), true );
  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
  // BUILDER Google fonts
  $us_b_font_families = array();
  $us_b_subsets = 'latin';
  $understrap_builder_typography_default_font = json_decode(get_theme_mod( 'understrap_builder_typography_default_font', '{"font":"Open Sans","regularweight":"regular","italicweight":"italic","boldweight":"700","category":"sans-serif"}' ), true);
  $understrap_builder_typography_heading_font_custom = get_theme_mod('understrap_builder_typography_heading_font_custom', 1);
  $understrap_builder_typography_heading_font = json_decode(get_theme_mod( 'understrap_builder_typography_heading_font', '{"font":"Open Sans","regularweight":"regular","italicweight":"italic","boldweight":"700","category":"sans-serif"}' ), true);
  if('off' !== $understrap_builder_typography_default_font){
    $us_b_font_families[] = $understrap_builder_typography_default_font['font'] . ':' . $understrap_builder_typography_default_font['regularweight'] . ',' . $understrap_builder_typography_default_font['italicweight'] . ',' . $understrap_builder_typography_default_font['boldweight'];
  }
	if('off' !== $understrap_builder_typography_heading_font && $understrap_builder_typography_heading_font_custom == 0){
    $us_b_font_families[] = $understrap_builder_typography_heading_font['font'] . ':' . $understrap_builder_typography_heading_font['regularweight'] . ',' . $understrap_builder_typography_heading_font['italicweight'] . ',' . $understrap_builder_typography_heading_font['boldweight'];
  }	
  $us_b_query_args = array(
    'family' => urlencode(implode( '|', $us_b_font_families)),
    'subset' => urlencode($us_b_subsets),
    'display' => urlencode('fallback')
  );
  $us_b_fonts_url = add_query_arg( $us_b_query_args, "https://fonts.googleapis.com/css" );
  if (!empty( $us_b_fonts_url)){
		wp_enqueue_style( 'builder-fonts', esc_url_raw($us_b_fonts_url), array(), null );
	}  
  
}

/* Assign language folder */
function understrap_builder_add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-builder', get_stylesheet_directory() . '/languages' );
}


/* Allow HTML in Gutenberg HTML Block */
add_filter( 'wp_kses_allowed_html', 'understrap_builder_allow_iframe_in_editor', 10, 2 );
function understrap_builder_allow_iframe_in_editor( $tags, $context ) {
	if( 'post' === $context ) {
		$tags['iframe'] = array(
			'allowfullscreen' => TRUE,
			'frameborder' => TRUE,
			'height' => TRUE,
			'src' => TRUE,
			'style' => TRUE,
			'width' => TRUE,
		);
	}
	return $tags;
}



/* Convert BUILDER shortcodes to live data in string */
function understrap_builder_convert_text_date($original_string){
  $new_string_to_return = $original_string;
  $this_year = date('Y', time());
  $new_string_to_return = str_replace('[builder_current_year]', $this_year, $original_string);
  return $new_string_to_return;
}



/* Tidy the archive title for PRO headers */
add_filter( 'get_the_archive_title', function ($title) {    
  if ( is_category() ) {   
          $title = single_cat_title( '', false );    
      } elseif ( is_tag() ) {    
          $title = single_tag_title( '', false );    
      } elseif ( is_author() ) {    
          $title = '<span class="vcard">' . get_the_author() . '</span>' ;    
      } elseif ( is_tax() ) { //for custom post types
          $title = sprintf( __( '%1$s', 'understrap-builder' ), single_term_title( '', false ) );
      }    
  return $title;    
});



// Disable Post Formats for BUILDER */
add_action('after_setup_theme', 'understrap_builder_remove_formats', 100);
function understrap_builder_remove_formats(){
  remove_theme_support('post-formats');
}



// Suggested plugins
add_action( 'tgmpa_register', 'understrap_builder_register_required_plugins' );
function understrap_builder_register_required_plugins() {
	$plugins = array(
		array(
			'name'      => 'Bootstrap Blocks',
			'slug'      => 'wp-bootstrap-blocks',
			'required'  => false
		),
    array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false
		),
    array(
			'name'      => 'One Click Demo Import',
			'slug'      => 'one-click-demo-import',
			'required'  => false
		)
	);
	tgmpa( $plugins, array() );
}


/* BUILDER Image Sizes */

add_image_size( 'us_b_banner', 1600, 500, true);
add_image_size( 'us_b_button', 350, 350, true);


/* SkyRocket Sex Up Customizer Controls */
// https://github.com/maddisondesigns/customizer-custom-controls

// Enqueue scripts for Customizer preview
if ( ! function_exists( 'skyrocket_customizer_preview_scripts' ) ) {
	function skyrocket_customizer_preview_scripts() {
		wp_enqueue_script( 'skyrocket-customizer-preview', trailingslashit( get_stylesheet_directory_uri() ) . 'js/customizer-preview.js', array( 'customize-preview', 'jquery' ) );
	}
}
add_action( 'customize_preview_init', 'skyrocket_customizer_preview_scripts' );
















// Custom Changes Made by Ganin Vyacheslav


//Setup
add_theme_support('post-thumbnails', array('estate', 'city'));

//Includes
include(get_stylesheet_directory() . '/includes/init.php');
include(get_stylesheet_directory() . '/includes/metaboxes.php');

//Action & Filter Hooks
add_action('init', 'sg_custom_post_types_init', 15);
add_action('init', 'sg_custom_taxonomies_init', 10);
add_action('add_meta_boxes', 'sg_add_meta');
add_action('save_post', 'sg_save_meta', 10, 3);