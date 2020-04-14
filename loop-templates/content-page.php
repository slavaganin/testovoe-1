<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap-builder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

global $us_b_title_shown_already, $us_b_featured_image_already_shown;

// Load Customizer variables
$understrap_builder_headers_page = get_theme_mod( 'understrap_builder_headers_page', '');
$understrap_builder_headers_page_text = get_theme_mod( 'understrap_builder_headers_page_text', '');

global $builder_default_spacings;
$understrap_builder_spacings_page_image = get_theme_mod( 'understrap_builder_spacings_page_image', $builder_default_spacings );
$understrap_builder_spacings_page_title = get_theme_mod( 'understrap_builder_spacings_page_title', $builder_default_spacings );
$understrap_builder_spacings_page_content = get_theme_mod( 'understrap_builder_spacings_page_content', $builder_default_spacings );
$understrap_builder_spacings_page_meta = get_theme_mod( 'understrap_builder_spacings_page_meta', $builder_default_spacings );

// Unique page override header meta option
$understrap_builder_override_header = get_post_meta(get_the_ID(), '_us_b_override_header', true);
if($understrap_builder_override_header != ''){
  $understrap_builder_headers_page = $understrap_builder_override_header;
}

// Unique page override title showing
$understrap_builder_override_title = get_post_meta(get_the_ID(), '_us_b_hide_title', true);

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
  
  <?php if(has_post_thumbnail(get_the_ID()) && !$us_b_featured_image_already_shown){ ?>
  <div id="us_b_page_thumb" class="<?php echo esc_attr(understrap_builder_spacings_handler($understrap_builder_spacings_page_image)); ?>">
    <?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
  </div>
  <?php } ?>

  <?php if($understrap_builder_override_title != 'hide' && !$us_b_title_shown_already){ ?>
	<header class="entry-header <?php if($understrap_builder_headers_page=='centered'){echo ' text-center';}?>">
		<h1 class="entry-title <?php echo esc_attr(understrap_builder_spacings_handler($understrap_builder_spacings_page_title)); ?>"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
  <?php } ?>

	<div class="entry-content">

    <div class="content_spacings <?php echo esc_attr(understrap_builder_spacings_handler($understrap_builder_spacings_page_content)); ?>">
		  <?php the_content(); ?>
    </div>

    <div class="meta_spacings <?php echo esc_attr(understrap_builder_spacings_handler($understrap_builder_spacings_page_meta)); ?>">
      <?php
      wp_link_pages(
        array(
          'before' => '<div class="page-links">' . __( 'Pages:', 'understrap-builder' ),
          'after'  => '</div>',
        )
      );
      ?>
    </div>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap-builder' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
