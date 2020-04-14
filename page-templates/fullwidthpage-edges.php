<?php
/**
 * Template Name: Full Width Page [Screen Edges]
 *
 * Template for displaying a page without sidebars all the way to the screen edges.
 *
 * @package understrap-builder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();// Load Customizer variables

// Load Customizer variables
$understrap_builder_container_type = get_theme_mod( 'understrap_builder_container_type', 'container');
$understrap_builder_container_page_type = get_theme_mod( 'understrap_builder_container_page_type', 'default');
$understrap_builder_breadcrumbs_page_display = get_theme_mod( 'understrap_builder_breadcrumbs_page_display', '');

// Handle container
if($understrap_builder_container_page_type != 'default'){
  $understrap_builder_container_type = $understrap_builder_container_page_type;
}

?>

<?php get_template_part( 'global-templates/builder-hero-check' ); ?>

<?php if($understrap_builder_breadcrumbs_page_display == 'under-nav'){ get_template_part( 'global-templates/breadcrumbs-check', 'page' ); } ?>

<?php get_template_part( 'global-templates/headers-check', 'page' ); ?>

<?php if($understrap_builder_breadcrumbs_page_display == 'under-header'){ get_template_part( 'global-templates/breadcrumbs-check', 'page' ); } ?>

<div class="wrapper p-0" id="full-width-page-wrapper">

	<div class="container-fluid p-0" id="content">

    <main class="site-main" id="main" role="main">

      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'loop-templates/content', 'page' ); ?>
      
        <?php get_template_part( 'global-templates/child-pages-check' ); ?>
      
        <?php get_template_part( 'global-templates/author-box-check', 'page' ); ?>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
          comments_template();
        endif;
        ?>

      <?php endwhile; // end of the loop. ?>

    </main><!-- #main -->

	</div><!-- #content -->

</div><!-- #full-width-page-wrapper -->

<?php get_footer(); ?>
