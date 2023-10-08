<?php

/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets
 */

if (!defined('THEME_DIR')) {
	define('THEME_DIR', trailingslashit(get_template_directory()));
}
if (!defined('THEME_URL')) {
	define('THEME_URL', trailingslashit(get_template_directory_uri()));
}

if (!defined('THEME_STYLE')) {
	define('THEME_STYLE', THEME_URL . 'assets/css/');
}

if (!defined('THEME_SCRIPT')) {
	define('THEME_SCRIPT', THEME_URL . 'assets/js/');
}

if (!defined('THEME_IMAGE')) {
	global $folder_img;
	if ($folder_img != '') {
		define('THEME_IMAGE', THEME_URL . 'assets/images/' . $folder_img . '/');
	} else {
		define('THEME_IMAGE', THEME_URL . 'assets/images/');
	}
}

//-------------------------------------------------------
//-- Theme styles and scripts, images
//-------------------------------------------------------

if (!function_exists('theme_styles')) {
	/**
	 * Theme style: styles
	 * Hooks: add_action('wp_enqueue_scripts', 'theme_styles', 1000);
	 */
	function theme_styles()
	{
		wp_enqueue_style('destyle', THEME_STYLE . 'destyle.css', 'all');
		wp_enqueue_style('theme-style', THEME_URL . 'style.css', array(), null);
		wp_enqueue_style('themes', THEME_STYLE . 'theme.css', 'all');
		wp_enqueue_style('commons', THEME_STYLE . 'common.css', 'all');
		wp_enqueue_style('header', THEME_STYLE . 'header.css', 'all');
		wp_enqueue_style('footer', THEME_STYLE . 'footer.css', 'all');

		if (is_front_page()) {
			wp_enqueue_style('top', THEME_STYLE . 'top.css', 'all');
		}
		if (is_page('about')) {
			wp_enqueue_style('about', THEME_STYLE . 'about.css', 'all');
		}
	}
}

if (!function_exists('theme_scripts')) {
	/**
	 * Theme style: scripts
	 * Hooks: add_action('wp_enqueue_scripts', 'theme_scripts', 1000);
	 */
	function theme_scripts()
	{
		wp_enqueue_script('commons', THEME_SCRIPT . 'common.js', 'all');
		if (is_front_page()) {
			wp_enqueue_script('contact', THEME_SCRIPT . 'top.js', 'all');
		}
	}
}

//-------------------------------------------------------
//-- Theme pagination
//-------------------------------------------------------

if (!function_exists('theme_pagination_template')) {
	/**
	 * Theme pagination template
	 * Hooks: add_action('theme_pagination', 'theme_pagination_template', 1500);
	 */
	function theme_pagination_template($pages = '', $range = 1)
	{
		$showitems = $range + 1;

		global $paged;
		if (empty($paged)) $paged = 1;
?>

		<ul class="pagination_inner">
			<?php
			if (1 != $pages) {
				if ($paged > 1) {
			?>
					<li class="pagination_item">
						<a class="pagination_link pagination_prev" href="<?= get_pagenum_link($paged - 1) ?>">&#8249;</a>
					</li>
				<?php } else {
				?>
					<li class="pagination_item">
						<div class="pagination_link pagination_prev pagination_disable">&#8249;</div>
					</li>
					<?php
				}
				for ($i = 1; $i <= $pages; $i++) {
					if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
						if ($paged == $i) {
					?>
							<li class="pagination_item">
								<div class="pagination_link pagination_current"><?= $i ?></div>
							</li>
						<?php } else {
						?>
							<li class="pagination_item">
								<a class="pagination_link pagination_inactive" href="<?= get_pagenum_link($i) ?>"><?= $i ?></a>
							</li>
					<?php
						}
					}
				}
				if ($paged < $pages) {
					?>
					<li class="pagination_item">
						<a class="pagination_link pagination_next" href="<?= get_pagenum_link($paged + 1) ?>">&#8250;</a>
					</li>
				<?php } else {
				?>
					<li class="pagination_item">
						<div class="pagination_link pagination_next pagination_disable">&#8250;</div>
					</li>
			<?php
				}
			} ?>
		</ul>
	<?php
	}
}

//-------------------------------------------------------
//-- Create post types
//-------------------------------------------------------
function create_post_type()
{
	register_post_type('recruit', [
		'labels' => [
			'name'          => 'Recruit',
			'singular_name' => 'Recruit',
		],
		'public'        => true,
		'has_archive'   => false,
		'menu_position' => 9,
		'rewrite' => array('slug' => 'recruit'),
		'supports' => array('title'),
		// 'hierarchical' => true
	]);

	register_post_type('faq', [
		'labels' => [
			'name'          => 'FAQ',
			'singular_name' => 'FAQ',
		],
		'public'        => true,
		'supports' => array('title', 'editor'),
		'has_archive'   => false,
		'menu_position' => 9,
		'rewrite' => array('slug' => 'faq'),
	]);
}
add_action('init', 'create_post_type');


function pagination($pages = '', $range = 1)
{
	$showitems = $range + 1;

	global $paged;
	if (empty($paged)) $paged = 1;

	if (1 != $pages) {
		if ($paged > 1) {
			echo "<a href='" . get_pagenum_link($paged - 1) . "' class='prevBtn'>
            <img src='" . get_template_directory_uri() . "/assets/images/right.svg' alt=''></a>";
		} else {
			echo "<div href='" . get_pagenum_link($paged - 1) . "' class='prevBtn disableBtn'>
            <img src='" . get_template_directory_uri() . "/assets/images/right.svg' alt=''></div>";
		}

		for ($i = 1; $i <= $pages; $i++) {
			if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
				echo ($paged == $i) ? "<span class=\"current\">" . $i . "</span>" : "<a href='" . get_pagenum_link($i) . "' class=\"inactive\">" . $i . "</a>";
			}
		}

		if ($paged < $pages) {
			echo "<a href='" . get_pagenum_link($paged + 1) . "' class='nextBtn'>
        <img src='" . get_template_directory_uri() . "/assets/images/right.svg' alt=''></a>";
		} else {
			echo "<a href='" . get_pagenum_link($paged + 1) . "' class='nextBtn disableBtn'>
        <img src='" . get_template_directory_uri() . "/assets/images/right.svg' alt=''></a>";
		}
	}
}

//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

if (!function_exists('theme_setup')) {
	add_action('after_setup_theme', 'theme_setup');
	/**
	 * A general theme setup: add a theme supports, navigation menus, hooks for other actions and filters.
	 */
	function theme_setup()
	{
		// Add post thumbnail
		add_theme_support('post-thumbnails');

		// Add required meta tags in the head
		add_action('wp_head', 'theme_wp_head', 0);

		// Enqueue scripts and styles for the frontend
		add_action('wp_enqueue_scripts', 'theme_styles', 1000);

		// Enqueue scripts for the frontend
		add_action('wp_enqueue_scripts', 'theme_scripts', 1000);
		add_action('wp_footer', 'theme_wp_footer');

		// Add pagination
		add_action('theme_pagination', 'theme_pagination_template', 1500);
	}
}

//-------------------------------------------------------
//-- Head, body and footer
//-------------------------------------------------------

if (!function_exists('theme_wp_head')) {
	/**
	 * Add meta tags to the header for the frontend
	 * Hooks: add_action('wp_head', 'theme_wp_head', 0);
	 */
	function theme_wp_head()
	{
		global $title;
		$keywords = "";
		$description = "";
		$site_name = "";
	?>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="format-detection" content="telephone=no">
		<link rel="profile" href="//gmpg.org/xfn/11">
		<title><?= $title ?></title>
		<link rel="icon" href="<?= THEME_IMAGE ?>favicon.ico">
		<meta name="keywords" content="<?= $keywords ?>">
		<meta name="description" content="<?= $description ?>">
		<meta property="og:type" content="website">
		<meta property="og:title" content="<?= $title ?>">
		<meta property="og:url" content="<?= site_url() ?>">
		<meta property="og:site_name" content="<?= $site_name ?>">
		<meta property="og:image" content="<?= THEME_IMAGE ?>ogp.jpg">
		<meta property="og:description" content="<?= $description ?>">

		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<?php
	}
}

if (!function_exists('theme_wp_footer')) {
	/**
	 * Add script to the footer for the frontend
	 * Hooks: add_action('wp_footer', 'theme_wp_footer');
	 */
	function theme_wp_footer()
	{
		wp_register_script('handle-name', THEME_SCRIPT . 'common.js', 'all');
		wp_enqueue_script('handle-name');
	}
}


//-------------------------------------------------------
//-- Util
//-------------------------------------------------------
