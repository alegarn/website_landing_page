<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="profile" href="https://gmpg.org/xfn/11" />
<title>alegar.ch – One idea, one app</title>
<meta name="description" content="One idea, one app - Transform your ideas into powerful applications">
<link rel="preconnect" href="<?php echo admin_url(); ?>" crossorigin>
<link rel="dns-prefetch" href="//stats.wp.com">
<meta name="msapplication-TileImage" content="https://alegar.ch/wp-content/uploads/2024/02/cropped-logo-270x270.jpg">
<link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed" href="https://alegar.ch/wp-json/oembed/1.0/embed?url=https%3A%2F%2Falegar.ch%2F">
<link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed" href="https://alegar.ch/wp-json/oembed/1.0/embed?url=https%3A%2F%2Falegar.ch%2F&format=xml">

<!-- Load jQuery directly from WordPress installation -->
<script src="<?php echo site_url('/wp-includes/js/jquery/jquery.min.js'); ?>?ver=3.7.1" id="jquery-core-js"></script>

<?php
// Output AJAX data for landing page scripts
if ( function_exists( 'landing_page_js_data' ) ) {
    landing_page_js_data();
}
?>

<!-- Load AJAX script directly -->
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/ajax-script.js" id="landing-ajax-js"></script>

</head>