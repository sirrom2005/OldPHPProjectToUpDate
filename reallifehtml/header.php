<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Reelife
 * @since Reelife ver 1.0
 */
$user = wp_get_current_user(); 
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/styles.css" />
<!--link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" /-->
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="containerbody"> 
	<div id="<?php echo (!$user->ID)? "myLogin" : "myLoggedIn"; ?>">
    	<?php if(!$user->ID){ ?>
    	<h3>Already a member?</h3>
        <p>
            <a href="login?action=register" rel="nofollow">Register</a> |
            <a href="login?action=lostpassword" rel="nofollow">Lost Password</a>
        </p>
        <?php } ?>
        <?php theme_my_login();?>
    </div>
    <div id="menu"><?php wp_page_menu('sort_column=menu_order&title_li=&include=26,28,40,42,11,44'); ?></div>
    <div id="contentbody">
    	<div id="contentbg">
    	<div id="tl">
        	<h2 class="genre" title="genre">&nbsp;</h2>
            <div class="blkbox">fgfg</div>
            <p>&nbsp;</p>
            <h2 class="mood" title="mood">&nbsp;</h2>
            <div class="blkbox">fgfg</div>
        </div>
