<?php
/*
This file handles the admin area and functions.
You can use this file to make changes to the
dashboard. Updates to this page are coming soon.
It's turned off by default, but you can call it
via the functions file.

Developed using the bones, by Eddie Machado
URL: http://themble.com/bones/

Special Thanks for code & inspiration to:
@jackmcconnell - http://www.voltronik.co.uk/
Digging into WP - http://digwp.com/2010/10/customize-wordpress-dashboard/

*/


/************* SET DEFAULTS ON THEME ACTIVATION *****************/
add_action('after_switch_theme', 'doc_theme_activation');
// Only fires after the theme is switched to DoC theme
function doc_theme_activation() {
	// Disallow comments on new pages (can be overridden with individual posts)
	// This option is usually set by from the Settings > Discussion administration panel.
	update_option( 'default_comment_status', 'closed' );

	// Unpublish the example blog post, if it exists...
	$first_post = get_post(1);
	if($first_post->post_title="Hello world!")
		wp_update_post( array( 'ID' => $first_post->ID, 'post_status' => 'draft' ));
		
	// Setup new homepage, if sameple page exists
	$first_page = get_page(2);
	if($first_page->post_title="Sample Page"){
		wp_update_post( array( 'ID' => $first_page->ID, 'post_title' => 'Home', 'post_name'=>'home', 'comment_status' => 'closed' ));
		// Set the homepage template
		update_post_meta($first_page->ID, 'page_template', 'page-home.php');
		// Set reading settings to show the homepage
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', 2 );
	}
	
	// Flush rewrites to setup custom post type single/archive URLs:
   	flush_rewrite_rules();
}


/************* DASHBOARD WIDGETS *****************/

// disable default dashboard widgets
function disable_default_dashboard_widgets() {
	// remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget
	remove_meta_box('tribe_dashboard_widget', 'dashboard', 'core');
	
	//remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	//remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

	// removing plugin dashboard boxes
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget

	/*
	have more plugin widgets you'd like to remove?
	share them with us so we can get a list of
	the most commonly used. :D
	https://github.com/eddiemachado/bones/issues
	*/
}
add_action('admin_menu', 'disable_default_dashboard_widgets');



/************* CUSTOM LOGIN PAGE *****************/
/*
Change the logo + link from WordPress default
*/
function bones_login_css() {
	wp_enqueue_style( 'bones_login_css', get_template_directory_uri() . '/library/css/login.css', false );
}
function bones_login_url() {  return home_url(); }
function bones_login_title() { return get_option('blogname'); }

add_action('login_enqueue_scripts', 'bones_login_css', 10 );
add_filter('login_headerurl', 'bones_login_url');
add_filter('login_headertitle', 'bones_login_title');


/************* CUSTOMIZE ADMIN *******************/
/*
 - Add custom admin.css
 - Add icons for custom post types
*/
function doc_admin_scripts() {
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/library/css/font-awesome.css', false );
	wp_enqueue_style( 'bones_admin', get_template_directory_uri() . '/library/css/admin.css', false );
    wp_register_style( 'fontawesome_ie7', get_template_directory_uri() . '/library/css/font-awesome-ie7.css', false );
    $GLOBALS['wp_styles']->add_data( 'fontawesome_ie7', 'conditional', 'lte IE 8' );
    wp_enqueue_style( 'fontawesome_ie7' );
    wp_enqueue_script( 'bones-admin-js', get_stylesheet_directory_uri() . '/library/js/admin.js', array( 'jquery' ), time(), true );
}
add_action( 'admin_enqueue_scripts', 'doc_admin_scripts', 10 );


/************* ADMIN NOTICES *******************/
/*
 - Add redirect to auto save new publications as drafts (to get the ID).
 - Display the ID of publications in a notice at the top of the post-edit screen.
*/
function edit_post_add_the_id() {
	global $pagenow;

	if($pagenow=="post-new.php" && $_GET['post_type']=="publication"){

		wp_enqueue_script( 'new-pub-redirect', get_template_directory_uri() . '/library/js/new-pub-redirect.js', array(), '1.0.0', true );

	}elseif($_GET['action']=="edit" ){   //&& get_post_type()=="publication"
		add_action('admin_notices', 'doc_admin_notices');
	}
}
add_action( 'admin_init', 'edit_post_add_the_id' );

function doc_admin_notices(){
    switch (get_post_type()) {
		case 'publication':
			$message = '<p><b>Publication ID: '.get_the_id().'</b> (use this if creating a new BibTex reference)';
			if($citekey = get_post_meta(get_the_id(), 'citekey', true)) 		  
				$message .=	'<p><b>Cite key</b> (copy & paste to reference this publication in project/person content).</p>
					<input type="text" id="citekey-input" value=\'[cite key="'.$citekey.'"]\' onfocus="this.select()" onMouseUp="return false" />';
					   		  
			$message .=	'</p>';
			break;
	}
    if($message)
    	echo '<div class="updated doc">'.$message.'</div>';
}



/************* THEME CUSTOMISATION OPTIONS *******************/
/*
Add options to the page under Appearance > Themes > Customize
see: https://codex.wordpress.org/Theme_Customization_API
*/
function doc_admin_customize_register( $wp_customize ) {
   
   class Doc_Customize_Textarea_Control extends WP_Customize_Control {
	    public $type = 'textarea';
	 
	    public function render_content() {
	        ?>
	        <label>
	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	        </label>
	        <input type="button" name="preview" id="preview" class="button button-primary preview" value="Preview">
	        <?php
	    }
	}
   // Change the defaults to allow previews
   $wp_customize->get_setting('blogname')->transport='postMessage';
   $wp_customize->get_setting('blogdescription')->transport='postMessage';
   $wp_customize->get_setting('header_textcolor')->transport='postMessage';
   $wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
   
   
   //All our sections, settings, and controls will be added here

   $wp_customize->add_setting( 'doc_custom_css_editor' , array(
    	'default'     => '',
		'transport'   => 'postMessage',
	));

   $wp_customize->add_section( 'doc_custom_css' , array(
    	'title'      => __( 'Custom CSS', 'mytheme' ),
    	'priority'   => 30,
	));

   $wp_customize->add_control( new Doc_Customize_Textarea_Control( $wp_customize, 'doc_custom_css_editor', array(
		'label'        => __( 'Custom CSS', 'bones' ),
		'section'    => 'doc_custom_css',
		'settings'   => 'doc_custom_css_editor',
	)));
	
	wp_enqueue_style( 'bones_admin', get_template_directory_uri() . '/library/css/admin.css', false );
	wp_enqueue_script('doc-themecustomizer', get_template_directory_uri().'/library/js/theme-customizer.js', array( 'jquery' ),	'', true);
}
add_action( 'customize_register', 'doc_admin_customize_register' );

function doc_customize_css()
{
    ?>
         <style type="text/css" id="docCustomCSS">
             <?php echo get_theme_mod('doc_custom_css_editor'); ?>
         </style>
    <?php
}
add_action( 'wp_head', 'doc_customize_css');




function doc_customizer_live_preview()
{
	wp_enqueue_script( 'customize-preview' );
	wp_enqueue_script('doc-themecustomizer', get_template_directory_uri().'/library/js/theme-customizer.js', array( 'jquery' ),	'', true);
	
}
add_action( 'customize_preview_init', 'doc_customizer_live_preview' );





?>
