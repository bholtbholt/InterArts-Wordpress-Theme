<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

// Customize the Admin Pages
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');
function my_admin_theme_style() {
  wp_enqueue_style('my-admin-theme', get_template_directory_uri() . '/css/wp-admin.css');
}

//Add TinyMCI Editor Options
add_theme_support( 'editor_style' );
add_action( 'init', 'my_admin_editor_options' );
function my_admin_editor_options() {
    add_editor_style('css/editor-style.css');
}

// enables wigitized sidebars
if ( function_exists('register_sidebar') )
// Sidebar Widget
register_sidebar(array('name'=>'Sidebar',
	'before_widget' => '<div class="widget-area widget-sidebar"><ul>',
	'after_widget' => '</ul></div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));
// Footer Widgets
register_sidebar(array('name'=>'Footer Menu 1',
	'before_widget' => '<div class="col-sm-6">',
	'after_widget' => '</div>'
));
register_sidebar(array('name'=>'Footer Menu 2',
	'before_widget' => '<div class="col-sm-6">',
	'after_widget' => '</div>'
));
register_sidebar(array('name'=>'Footer Menu 3',
	'before_widget' => '<div class="col-sm-6">',
	'after_widget' => '</div>'
));
register_sidebar(array('name'=>'Footer Menu 4',
	'before_widget' => '<div class="col-sm-6">',
	'after_widget' => '</div>'
));

// post thumbnail support
add_theme_support( 'post-thumbnails' );

// custom menu support
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'header-menu' => 'Header Menu'
		)
	);
}

// removes detailed login error information for security
add_filter('login_errors',create_function('$a', "return null;"));

// no more jumping for read more link
add_filter('excerpt_more', 'no_more_jumping');
function no_more_jumping($post) {
	return '&nbsp;<a href="'.get_permalink($post->ID).'" class="read-more">'.'keep reading &rarr;'.'</a>';
}

// Use Bootstrap pager formatting for nav links
function bootstrap_get_posts_nav_link( $args = array() ) {
	global $wp_query;
	$return = '';

	if ( !is_singular() ) {
		$defaults = array(
			'prelabel' => __('&larr; Previous Page'),
			'nxtlabel' => __('Next Page &rarr;'),
		);
		$args = wp_parse_args( $args, $defaults );
		$max_num_pages = $wp_query->max_num_pages;
		$paged = get_query_var('paged');

		if ( $max_num_pages > 1 ) {
			$return = '<ul class="pager"><li class="previous">';
			$return .= get_previous_posts_link($args['prelabel']);
			$return .= '</li><li class="next">';
			$return .= get_next_posts_link($args['nxtlabel']);
			$return .= '</li></ul>';
		}
	}
	return $return;
}
function bootstrap_posts_nav_link( $prelabel = '', $nxtlabel = '' ) {
	$args = array_filter( compact('prelabel', 'nxtlabel') );
	echo bootstrap_get_posts_nav_link($args);
}

// get the slug
function the_slug($echo=true){
	global $post;
	$slug = $post->post_name;
  if( $echo ) echo $slug;
  return $slug;
}

// Remove <br> from wpautop
//Author: Simon Battersby http://www.simonbattersby.com/blog/plugin-to-stop-wordpress-adding-br-tags/
function better_wpautop($pee){
	return wpautop($pee,false);
}
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'better_wpautop');
add_filter( 'the_content', 'shortcode_unautop', 12 );


//Add InterArts Logo in the centre of the menu
add_filter('wp_nav_menu_items','add_interarts_logo_to_menu', 10, 2);
function add_interarts_logo_to_menu( $items, $args ) {
	// only for primary menu
  if( $args->theme_location == 'header-menu' ) {
    $items_array = array();
    while ( false !== ( $item_pos = strpos ( $items, '<li', 3 ) ) ) {
      $items_array[] = substr($items, 0, $item_pos);
      $items = substr($items, $item_pos);
    }
    $items_array[] = $items;
    // insert logo after 3rd one
    array_splice($items_array, 3, 0, '<li><a href="'.home_url().'"><div id="logoDiv" class="logo-hexagon"><img id="logo" src="'.get_template_directory_uri().'/images/logos/InterArts-icon.svg"></div></a></li>');
    $items = implode('', $items_array);
  }
  return $items;
}

//Send Yoast to the bottom
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');
function yoasttobottom() {
  return 'low';
}

// Shortcodes - Dividers //////////////////////////////////////
// Double Slope Divider on the top of a new section
add_shortcode('double_slope_divider', 'interarts_double_slope_divider');
function interarts_double_slope_divider(){
	return '<div class="decor-top"><svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg"><path d="M0 100 L0 0 L55 100" stroke-width="0"></path><path d="M45 100 L100 0 L100 100" stroke-width="0"></path></svg></div>';
}

// Triangle Divider on the top of a new section
add_shortcode('triangle_divider', 'interarts_triangle_divider');
function interarts_triangle_divider(){
	return '<div class="decor-top"><svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg"><path d="M0 100 L50 0 L100 50" stroke-width="0"></path></svg></div>';
}

// Right Slash Divider on the top of a new section
add_shortcode('right_slash_divider_top', 'interarts_right_slash_divider_top');
function interarts_right_slash_divider_top(){
	return '<div class="decor-top"><svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg"><path d="M0 100 L100 0 L100 100" stroke-width="0"></path></svg></div>';
}

// Left Slash Divider on the top of a new section
add_shortcode('left_slash_divider_top', 'interarts_left_slash_divider_top');
function interarts_left_slash_divider_top(){
	return '<div class="decor-top"><svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg"><path d="M0 0 L100 100 L0 100" stroke-width="0"></path></svg></div>';
}

// Right Slash Divider on the bottom of a new section
add_shortcode('right_slash_divider_bottom', 'interarts_right_slash_divider_bottom');
function interarts_right_slash_divider_bottom(){
	return '<div class="decor-bottom"><svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg"><path d="M0 0 L100 0 L100 100" stroke-width="0"></path></svg></div>';
}

// Left Slash Divider on the bottom of a new section
add_shortcode('left_slash_divider_bottom', 'interarts_left_slash_divider_bottom');
function interarts_left_slash_divider_bottom(){
	return '<div class="decor-bottom"><svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg"><path d="M0 0 L100 0 L0 100" stroke-width="0"></path></svg></div>';
}

// Shortcodes - Bootstrap /////////////////////////////////////
// Bootstrap row
add_shortcode( 'row', 'bootstrap_row' );
function bootstrap_row( $atts, $content = null ) {
  return '<div class="row">'. do_shortcode($content) . '</div>';
}

// half_col column
add_shortcode( 'half_col', 'bootstrap_half_col' );
function bootstrap_half_col( $atts, $content = null ) {
  return '<div class="col-sm-6">'. do_shortcode($content) . '</div>';
}

// two_third_col column
add_shortcode( 'two_third_col', 'bootstrap_two_third_col' );
function bootstrap_two_third_col( $atts, $content = null ) {
  return '<div class="col-sm-8">'. do_shortcode($content) . '</div>';
}

// one_third column
add_shortcode( 'one_third_col', 'bootstrap_one_third_col' );
function bootstrap_one_third_col( $atts, $content = null ) {
  return '<div class="col-sm-4">'. do_shortcode($content) . '</div>';
}

// quarter_width column
add_shortcode( 'quarter_col', 'bootstrap_quarter_col' );
function bootstrap_quarter_col( $atts, $content = null ) {
  return '<div class="col-sm-3">'. do_shortcode($content) . '</div>';
}

// Bootstrap lead paragraph
add_shortcode( 'lead', 'bootstrap_lead_paragraph' );
function bootstrap_lead_paragraph( $atts, $content = null ) {
  return '<p class="lead">'. do_shortcode($content) . '</p>';
}

// Shortcodes - Colours ////////////////////////////////////////
// Colour Text span
// [text_color color="charcoal"][/text_color]
add_shortcode( 'text_color', 'interarts_text_color_span' );
function interarts_text_color_span( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'color' => 'charcoal',
	), $atts );
  return '<span class="' . esc_attr($a['color']) . '">'. do_shortcode($content) . '</span>';
}

// Contact Form
add_shortcode('contact_form', 'interarts_contact_form');
function interarts_contact_form(){
  ob_start();  
  include('snippets/contact-form.php'); 
  $return = ob_get_contents();  
  ob_end_clean();  
  return $return;
}

// Newsletter Form
add_shortcode('newsletter_form', 'interarts_newsletter_form');
function interarts_newsletter_form(){
  ob_start();  
  include('snippets/newsletter-form.php'); 
  $return = ob_get_contents();  
  ob_end_clean();  
  return $return;
}

// Get the contact page (for the footer)
add_shortcode('get_contact_page', 'interarts_get_contact_page');
function interarts_get_contact_page(){        
  ob_start();
  include('snippets/contact-page.php');
  $return = ob_get_contents();  
  ob_end_clean();  
  return $return;    
}

// Background Options Meta Box /////////////////////
add_action('add_meta_boxes', 'interarts_bg_meta_box');
function interarts_bg_meta_box() {
  add_meta_box('bg_meta_box', 'Background Options', 'interarts_bg_meta_box_formatting', 'page', 'side');
}

// Format the Options Meta Box
function interarts_bg_meta_box_formatting($post){
  // Add an nonce field so we can check for it later.
  wp_nonce_field('bg_meta_box', 'bg_meta_box_nonce');

  // All the background colours
  $bgColors = array('', 'green-bg', 'chartreuse-bg', 'sage-bg', 'sea-foam-bg', 'powder-blue-bg', 'baby-blue-bg', 'bright-bue-bg', 'teal-bg', 'blue-bg', 'teal-2-bg', 'dark-teal-bg', 'dark-blue-bg', 'rust-bg', 'bright-red-bg', 'red-bg', 'pinkish-red-bg', 'pink-bg', 'bright-yellow-bg', 'yellow-bg', 'orange-bg', 'brown-bg', 'brown-2-bg', 'cream-bg', 'tan-bg', 'light-grey-bg', 'sand-bg', 'grey-2-bg', 'grey-bg', 'charcoal-bg');

  // All the half background images
  $bgImages = array('', 'tool-bg');

  // Check for existing value
	$bg_color = get_post_meta($post->ID, 'bg_color', true);
	$half_bg = get_post_meta($post->ID, 'half_bg', true); ?>

  <p class="meta-box-title strong">Background Color:</p>
  <div id="bg_color_box" class="<?php echo $bg_color ?>"> </div>
  <div id="bg_color_select_wrapper">
	  <select id="bg_color" name="bg_color" class="full-width margin-bottom">
	  <?php foreach ($bgColors as $color) : ?>
	  	<option value="<?php echo $color ?>" <?php echo ($color == $bg_color)? 'selected' : ''; ?>><?php echo ucfirst(substr($color, 0, -3)) ?></option>
	  <?php endforeach; ?>
	  </select>
  </div>

  <p class="meta-box-title strong">Half-width Background Image:</p>
  <select id="half_bg" name="half_bg" class="full-width margin-bottom">
  <?php foreach ($bgImages as $image) : ?>
  	<option value="<?php echo $image ?>" <?php echo ($image == $half_bg)? 'selected' : ''; ?>><?php echo ucfirst(substr($image, 0, -3)) ?></option>
  <?php endforeach; ?>
  </select>
  <?php //open PHP again
}

// Live adjustment of the meta box color
add_action('admin_head', 'interarts_change_bg_color_box');
function interarts_change_bg_color_box() {
  global $current_screen;
  if('page' != $current_screen->id) return;

  echo <<<HTML
    <script type="text/javascript">
    jQuery(document).ready( function($) {
      $('#bg_color').live('change', function(){
        newColor = $(this).val();
        $('#bg_color_box').attr("class", newColor);
      });                
    });    
    </script>
HTML;
}

// Save Background Options Meta Box
add_action('save_post', 'interarts_bg_meta_box_save_data');
function interarts_bg_meta_box_save_data($post_id) {
  global $post;
  // Check if our nonce is set.
  if ( !isset( $_POST['bg_meta_box_nonce'] ) ) { return; }
  // Verify that the nonce is valid.
  if ( !wp_verify_nonce( $_POST['bg_meta_box_nonce'], 'bg_meta_box' ) ) { return; }
  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

  if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;   // Authenticate user

  // Check for Meta Value
  if (isset($_POST['bg_color'])) {
    $custom_type_meta_values['bg_color'] = $_POST['bg_color'];
  }
  if (isset($_POST['half_bg'])) {
    $custom_type_meta_values['half_bg'] = $_POST['half_bg'];
  }

  // Finally ready to save the data
  if (isset($custom_type_meta_values)) {
    foreach ($custom_type_meta_values as $key => $value) {
      if( $post->post_type == 'revision' ) return; // Don't store custom data twice
      $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
      if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
        update_post_meta($post->ID, $key, $value);
      } else { // If the custom field doesn't have a value
        add_post_meta($post->ID, $key, $value);
      }
      if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
  }

}

// Contact Information Meta Box /////////////////////
//add_action('add_meta_boxes', 'interarts_contact_info_meta_box');
function interarts_contact_info_meta_box() {
  global $post;
  if ( $post->ID == get_page_by_title('Contact')->ID) {
    add_meta_box('contact_information_meta_box', 'Interarts Contact Information', 'interarts_contact_meta_box_formatting', 'page', 'normal');
  }
}

// Format the Contact Information Meta Box
function interarts_contact_meta_box_formatting($post){
  // Add an nonce field so we can check for it later.
  wp_nonce_field('contact_information_meta_box', 'contact_information_meta_box_nonce');

  // Get value from the database and use it for the form.
  $value = get_post_meta( $post->ID); ?>

  <div class="meta-inline">
    <p class="meta-box-title">Phone Number:</p>
    <input type="text" class="meta-box-input" name="contact_phone_number" value="<?php echo get_post_meta( $post->ID, 'contact_phone_number', true ) ?>" />
  </div>
  <div class="meta-inline">
    <p class="meta-box-title">Email Address:</p>
    <input type="text" class="meta-box-input" name="contact_email" value="<?php echo get_post_meta( $post->ID, 'contact_email', true ) ?>" />
  </div>
  <div style="clear:both"></div>
  <p class="meta-box-title">Mailing Address:</p>
  <textarea class="meta-box-textarea" name="contact_address" id="contact_address" style="height:80px"><?php echo get_post_meta( $post->ID, 'contact_address', true ) ?></textarea>

  <?  // Open up PHP again 
}

// Save Contact Information Meta Box
//add_action('save_post', 'interarts_contact_info_meta_box_save_data');
function interarts_contact_info_meta_box_save_data($post_id) {
  global $post;
  // Check if our nonce is set.
  if ( !isset( $_POST['contact_information_meta_box_nonce'] ) ) { return; }
  // Verify that the nonce is valid.
  if ( !wp_verify_nonce( $_POST['contact_information_meta_box_nonce'], 'contact_information_meta_box' ) ) { return; }
  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

  if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;   // Authenticate user

  // Check for Meta Value
  if (isset($_POST['contact_phone_number'])) {
    $custom_type_meta_values['contact_phone_number'] = $_POST['contact_phone_number'];
  }
  if (isset($_POST['contact_email'])) {
    $custom_type_meta_values['contact_email'] = $_POST['contact_email'];
  }
  if (isset($_POST['contact_address'])) {
    $custom_type_meta_values['contact_address'] = $_POST['contact_address'];
  }

  // Finally ready to save the data
  if (isset($custom_type_meta_values)) {
    foreach ($custom_type_meta_values as $key => $value) {
      if( $post->post_type == 'revision' ) return; // Don't store custom data twice
      $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
      if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
        update_post_meta($post->ID, $key, $value);
      } else { // If the custom field doesn't have a value
        add_post_meta($post->ID, $key, $value);
      }
      if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
  }

}

// Custom Post Types ///////////////////////////////
// Artist Custom Posts
add_action( 'init', 'interarts_artists_custom_type' );
function interarts_artists_custom_type() {
  $labels = array(
    'name'               => 'Artists',
    'singular_name'      => 'Artist',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Artist',
    'edit_item'          => 'Edit Artist',
    'new_item'           => 'New Artist',
    'all_items'          => 'All Artists',
    'view_item'          => 'View Artist',
    'search_items'       => 'Search Artists',
    'not_found'          => 'No Artists found',
    'not_found_in_trash' => 'No Artists found in the Trash',
    'menu_name'          => 'Artists'
  );
  $args = array(
    'labels'        => $labels,
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
    //'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
    'exclude_from_search' => true,
    'query_var' => true,
    'register_meta_box_cb' => 'artists_meta_boxes',
    'has_archive'   => true
  );
  register_post_type( 'artists', $args ); 
}
function artists_meta_boxes() {
  custom_post_add_metabox('artist','Artist');
}

// Contributor Custom Posts
add_action( 'init', 'interarts_contributors_custom_type' );
function interarts_contributors_custom_type() {
  $labels = array(
    'name'               => 'Contributors',
    'singular_name'      => 'Contributor',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Contributor',
    'edit_item'          => 'Edit Contributor',
    'new_item'           => 'New Contributor',
    'all_items'          => 'All Contributors',
    'view_item'          => 'View Contributor',
    'search_items'       => 'Search Contributors',
    'not_found'          => 'No Contributors found',
    'not_found_in_trash' => 'No Contributors found in the Trash',
    'menu_name'          => 'Contributors'
  );
  $args = array(
    'labels'        => $labels,
    'public'        => true,
    'menu_position' => 6,
    'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
    //'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
    'exclude_from_search' => true,
    'query_var' => true,
    'register_meta_box_cb' => 'contributors_meta_boxes',
    //'has_archive'   => true
  );
  register_post_type( 'contributors', $args ); 
}
function contributors_meta_boxes() {
  custom_post_add_metabox('contributor','Contributor');
}

// Board Member Custom Posts
add_action( 'init', 'board_members_custom_type' );
function board_members_custom_type() {
  $labels = array(
    'name'               => 'Board members',
    'singular_name'      => 'Board member',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Board member',
    'edit_item'          => 'Edit Board member',
    'new_item'           => 'New Board member',
    'all_items'          => 'All Board members',
    'view_item'          => 'View Board member',
    'search_items'       => 'Search Board members',
    'not_found'          => 'No Board members found',
    'not_found_in_trash' => 'No Board members found in the Trash',
    'menu_name'          => 'Board members'
  );
  $args = array(
    'labels'        => $labels,
    'public'        => true,
    'menu_position' => 7,
    'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
    //'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
    'exclude_from_search' => true,
    'query_var' => true,
    'register_meta_box_cb' => 'board_members_meta_boxes',
    'has_archive'   => true
  );
  register_post_type( 'board_members', $args ); 
}
function board_members_meta_boxes() {
  custom_post_add_metabox('board_member','Board Member');
}

// Custom Post Saving functions /////////////////////////////////////
// Add Meta boxes to the custom post edit page
// Arguments take singular name: First with underscore, Second without
// Use: custom_post_add_metabox('team_member','Team Member'); 
function custom_post_add_metabox($metaSlug, $customTypeName){
  add_meta_box($metaSlug.'_meta_box', $customTypeName, 'custom_post_meta_box_view', $metaSlug.'s', 'normal', 'default', array('metaSlug'=>$metaSlug));
}

// Format the Meta Boxes
function custom_post_meta_box_view($post, $metaSlug) {
  global $post;
  $metaSlug = $metaSlug['args']['metaSlug'];
  // Noncename needed to verify where the data originated
  echo '<div class="'.$metaSlug.'_meta_box"><input type="hidden" name="'.$metaSlug.'_meta_noncename" id="'.$metaSlug.'_meta_noncename" value="' .wp_create_nonce( plugin_basename(__FILE__) ) . '" />';  
  include('snippets/metaboxes/'.$metaSlug.'.php');
  echo '</div>';
}

// Save the Metabox Data
add_action('save_post', 'interarts_save_meta_boxes', 1, 2); // save the custom fields
function interarts_save_meta_boxes($post_id, $post) {
  // verify this came from the our screen and with proper authorization because save_post can be triggered at other times
  //if ( !wp_verify_nonce( $_POST['team_members_meta_noncename'], plugin_basename(__FILE__) )) { return $post->ID; }

  if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;   // Authenticate user

  // Check for Meta Value
  if (isset($_POST['position'])) {
    $custom_type_meta_values['position'] = $_POST['position'];
  }
  if (isset($_POST['email'])) {
    $custom_type_meta_values['email'] = $_POST['email'];
  }
  if (isset($_POST['website'])) {
    $custom_type_meta_values['website'] = $_POST['website'];
  }

  // Finally ready to save the data
  if (isset($custom_type_meta_values)) {
    foreach ($custom_type_meta_values as $key => $value) {
      if( $post->post_type == 'revision' ) return; // Don't store custom data twice
      $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
      if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
        update_post_meta($post->ID, $key, $value);
      } else { // If the custom field doesn't have a value
        add_post_meta($post->ID, $key, $value);
      }
      if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
  }
}

// Social Media Meta Box /////////////////////////////
add_action('add_meta_boxes', 'interarts_social_media_meta_box');
function interarts_social_media_meta_box() {
  add_meta_box_array('social_media_meta_box', 'Social Media Links', 'interarts_social_media_meta_box_formatting', array('artists', 'page'), 'normal', 'low');
}

// accept arrays for the post type
// Use like regular add_meta_box
function add_meta_box_array($id, $title, $callback, $post_types, $context, $priority) {
    foreach( $post_types as $post_type ) {
        add_meta_box($id, $title, $callback, $post_type, $context, $priority);
    }
}

// Format the Contact Information Meta Box
function interarts_social_media_meta_box_formatting($post){
  // Add an nonce field so we can check for it later.
  wp_nonce_field('social_media_meta_box', 'social_media_meta_box_nonce');
  include('snippets/metaboxes/social_media.php');
}

// Save Contact Information Meta Box
add_action('save_post', 'interarts_social_media_meta_box_save_data');
function interarts_social_media_meta_box_save_data($post_id) {
  global $post;
  // Check if our nonce is set.
  if ( !isset( $_POST['social_media_meta_box_nonce'] ) ) { return; }
  // Verify that the nonce is valid.
  if ( !wp_verify_nonce( $_POST['social_media_meta_box_nonce'], 'social_media_meta_box' ) ) { return; }
  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

  if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;   // Authenticate user

  // Check for Meta Value
  if (isset($_POST['facebook'])) {
    $custom_type_meta_values['facebook'] = $_POST['facebook'];
  }
  if (isset($_POST['instagram'])) {
    $custom_type_meta_values['instagram'] = $_POST['instagram'];
  }
  if (isset($_POST['twitter'])) {
    $custom_type_meta_values['twitter'] = $_POST['twitter'];
  }
  if (isset($_POST['flickr'])) {
    $custom_type_meta_values['flickr'] = $_POST['flickr'];
  }
  if (isset($_POST['linkedin'])) {
    $custom_type_meta_values['linkedin'] = $_POST['linkedin'];
  }
  if (isset($_POST['vimeo'])) {
    $custom_type_meta_values['vimeo'] = $_POST['vimeo'];
  }
  if (isset($_POST['googlePlus'])) {
    $custom_type_meta_values['googlePlus'] = $_POST['googlePlus'];
  }
  if (isset($_POST['pinterest'])) {
    $custom_type_meta_values['pinterest'] = $_POST['pinterest'];
  }
  if (isset($_POST['youtube'])) {
    $custom_type_meta_values['youtube'] = $_POST['youtube'];
  }

  // Finally ready to save the data
  if (isset($custom_type_meta_values)) {
    foreach ($custom_type_meta_values as $key => $value) {
      if( $post->post_type == 'revision' ) return; // Don't store custom data twice
      $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
      if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
        update_post_meta($post->ID, $key, $value);
      } else { // If the custom field doesn't have a value
        add_post_meta($post->ID, $key, $value);
      }
      if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
  }

}

// Load scripts ////////////////////////////////////
add_action('wp_enqueue_scripts','interarts_scripts_init');
function interarts_scripts_init() {
	wp_enqueue_script( 'jquery' );

  wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js');
  wp_enqueue_script('bootstrap');

  wp_register_script( 'modernizr', get_template_directory_uri() . '/js/webshim/modernizr-custom.js', array( 'jquery') );
  wp_enqueue_script( 'modernizr' );

  wp_register_script( 'webshim', get_template_directory_uri() . '/js/webshim/polyfiller.js', array( 'jquery', 'modernizr' ) );
  wp_enqueue_script( 'webshim' );

  /*wp_register_script( 'masonry', get_template_directory_uri() . '/js/masonry.min.js');
  wp_enqueue_script('masonry');*/

  wp_register_script( 'interarts_scripts', get_template_directory_uri() . '/js/scripts.js');
  wp_enqueue_script('interarts_scripts');

  wp_localize_script('interarts_scripts', 'interarts_scripts_vars', array(
      'template_path' => get_bloginfo('template_directory')
    )
  );
}
