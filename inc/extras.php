<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package sg-916
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function sg_916_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'sg_916_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function sg_916_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'sg_916_pingback_header' );


if ( ! function_exists('register_portfolio_piece') ) {

// Register Custom Post Type
function register_portfolio_piece() {

	$labels = array(
		'name'                  => _x( 'Pieces', 'Post Type General Name', 'sg-916' ),
		'singular_name'         => _x( 'Piece', 'Post Type Singular Name', 'sg-916' ),
		'menu_name'             => __( 'Pieces', 'sg-916' ),
		'name_admin_bar'        => __( 'Piece', 'sg-916' ),
		'archives'              => __( 'Piece Archives', 'sg-916' ),
		'parent_item_colon'     => __( 'Parent piece:', 'sg-916' ),
		'all_items'             => __( 'All pieces', 'sg-916' ),
		'add_new_item'          => __( 'Add New piece', 'sg-916' ),
		'add_new'               => __( 'Add New', 'sg-916' ),
		'new_item'              => __( 'New Item', 'sg-916' ),
		'edit_item'             => __( 'Edit Item', 'sg-916' ),
		'update_item'           => __( 'Update Item', 'sg-916' ),
		'view_item'             => __( 'View Item', 'sg-916' ),
		'search_items'          => __( 'Search Item', 'sg-916' ),
		'not_found'             => __( 'Not found', 'sg-916' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sg-916' ),
		'featured_image'        => __( 'Featured Image', 'sg-916' ),
		'set_featured_image'    => __( 'Set featured image', 'sg-916' ),
		'remove_featured_image' => __( 'Remove featured image', 'sg-916' ),
		'use_featured_image'    => __( 'Use as featured image', 'sg-916' ),
		'insert_into_item'      => __( 'Insert into item', 'sg-916' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sg-916' ),
		'items_list'            => __( 'Items list', 'sg-916' ),
		'items_list_navigation' => __( 'Items list navigation', 'sg-916' ),
		'filter_items_list'     => __( 'Filter items list', 'sg-916' ),
	);
	$args = array(
		'label'                 => __( 'Piece', 'sg-916' ),
		'description'           => __( 'Post type for my portfolio pieces', 'sg-916' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'revisions', 'custom-fields', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'piece', $args );

}
add_action( 'init', 'register_portfolio_piece', 0 );

}

function theme_settings_page()
{
    ?>
	    <div class="wrap">
	    <h1>Theme Panel</h1>
	    <form method="post" action="options.php">
	        <?php
	            settings_fields("section");
	            do_settings_sections("theme-options");      
	            submit_button(); 
	        ?>          
	    </form>
		</div>
	<?php
}

function add_theme_menu_item()
{
	add_submenu_page( "themes.php", "Theme Options", "Theme Options", "manage_options", "sg-916-options", "theme_settings_page" );
}

add_action("admin_menu", "add_theme_menu_item");

function display_twitter_element()
{
	?>
    	<input type="text" name="twitter_url" id="twitter_url" value="<?php echo get_option('twitter_url'); ?>" />
    <?php
}

function display_instagram_element()
{
	?>
    	<input type="text" name="instagram_url" id="instagram_url" value="<?php echo get_option('instagram_url'); ?>" />
    <?php
}

function display_youtube_element()
{
	?>
    	<input type="text" name="youtube_url" id="youtube_url" value="<?php echo get_option('youtube_url'); ?>" />
    <?php
}

function display_github_element()
{
	?>
    	<input type="text" name="github_url" id="github_url" value="<?php echo get_option('github_url'); ?>" />
    <?php
}

function display_theme_panel_fields()
{
	add_settings_section("section", "All Settings", null, "theme-options");
	
	add_settings_field("twitter_url", "Twitter Profile Url", "display_twitter_element", "theme-options", "section");
	add_settings_field("instagram_url", "Instagram Profile Url", "display_instagram_element", "theme-options", "section");
	add_settings_field("youtube_url", "YouTube Channel Url", "display_youtube_element", "theme-options", "section");
	add_settings_field("github_url", "GitHub Profile Url", "display_github_element", "theme-options", "section");

    register_setting("section", "twitter_url");
    register_setting("section", "facebook_url");
}

add_action("admin_init", "display_theme_panel_fields");