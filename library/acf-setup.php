<?php 
/**
 *  Install Add-ons
 *  
 *  The following code will include all 4 premium Add-Ons in your theme.
 *  Please do not attempt to include a file which does not exist. This will produce an error.
 *  
 *  The following code assumes you have a folder 'add-ons' inside your theme.
 *
 *  IMPORTANT
 *  Add-ons may be included in a premium theme/plugin as outlined in the terms and conditions.
 *  For more information, please read:
 *  - http://www.advancedcustomfields.com/terms-conditions/
 *  - http://www.advancedcustomfields.com/resources/getting-started/including-lite-mode-in-a-plugin-theme/
 */ 

// Add-ons 
// include_once('add-ons/acf-repeater/acf-repeater.php');
// include_once('add-ons/acf-gallery/acf-gallery.php');
// include_once('add-ons/acf-flexible-content/acf-flexible-content.php');
// include_once( 'add-ons/acf-options-page/acf-options-page.php' );


/**
 *  Register Field Groups
 *
 *  The register_field_group function accepts 1 array which holds the relevant data to register a field group
 *  You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_grant-fields',
		'title' => 'Grant fields',
		'fields' => array (
			array (
				'key' => 'field_5222f2829e49b',
				'label' => 'Short desc',
				'name' => 'short-desc',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'basic',
				'media_upload' => 'no',
			),
			array (
				'key' => 'field_5222f1cfe5207',
				'label' => 'Amount Awarded',
				'name' => 'amount-awarded',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5222f1f89e498',
				'label' => 'Awarded By',
				'name' => 'awarded-by',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5222f2c79e49c',
				'label' => 'Grant start date',
				'name' => 'grant-start',
				'type' => 'date_picker',
				'date_format' => 'yymmdd',
				'display_format' => 'yymmdd',
				'first_day' => 1,
			),
			array (
				'key' => 'field_5222f2059e499',
				'label' => 'Grant end date',
				'name' => 'grant-end',
				'type' => 'date_picker',
				'date_format' => 'yymmdd',
				'display_format' => 'yymmdd',
				'first_day' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'grant',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'excerpt',
				1 => 'custom_fields',
				2 => 'format',
				3 => 'featured_image',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_person-fields',
		'title' => 'Person fields',
		'fields' => array (
			array (
				'key' => 'field_521e7a34d8fe9',
				'label' => 'Title',
				'name' => 'title',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521de7a67616b',
				'label' => 'First name',
				'name' => 'first-name',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521e7953d2515',
				'label' => 'Middle names',
				'name' => 'middle-names',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521e7974d2516',
				'label' => 'Last name',
				'name' => 'last-name',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521e7a42d8fea',
				'label' => 'Job title',
				'name' => 'job-title',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521e79e0d8fe7',
				'label' => 'Short biog',
				'name' => 'short-biog',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_521e7bd2d8ff2',
				'label' => 'Photo',
				'name' => 'photo',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_521e7a1dd8fe8',
				'label' => 'Long Biog',
				'name' => 'long-biog',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_521e7a97d8feb',
				'label' => 'Phone',
				'name' => 'phone',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521e7aa2d8fec',
				'label' => 'Email',
				'name' => 'email',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521e7aaad8fed',
				'label' => 'Twitter',
				'name' => 'twitter',
				'type' => 'text',
				'instructions' => 'Include full url, i.e. https://twitter.com/imperialcollege',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521e7b77d8ff0',
				'label' => 'LinkedIn',
				'name' => 'linkedin',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521e7b2bd8fee',
				'label' => 'Blog link',
				'name' => 'blog-link',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521e7b40d8fef',
				'label' => 'External link',
				'name' => 'external-link',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521e7bc4d8ff1',
				'label' => 'Secretary',
				'name' => 'secretary',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'person',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
				1 => 'excerpt',
				2 => 'custom_fields',
				3 => 'format',
				4 => 'featured_image',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_project-fields',
		'title' => 'Project fields',
		'fields' => array (
			array (
				'key' => 'field_52230c3bcde83',
				'label' => 'Project icon',
				'name' => 'icon',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_521fadf77b5e9',
				'label' => 'Short desc',
				'name' => 'short-desc',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'project',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'excerpt',
				1 => 'custom_fields',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_publication-fields',
		'title' => 'Publication fields',
		'fields' => array (
			array (
				'key' => 'field_521fb90c88243',
				'label' => 'Bibtex',
				'name' => 'bibtex',
				'type' => 'textarea',
				'instructions' => '<p>Please add the BibTeX version of your reference here, <b><font color="red">making sure to change its name</font></b>. We need every publication to have a unique name, and to ensure that we suggest that you <b><font color="red">use the following format: [Pub ID][Last Name][Reference Year]</font></b>. So, for example, it might be 52Meyer2000. The Publication ID can be found at the top of this page (in the blue box).</p>
	<p>Note, to include this reference in your text, simply add the following—[cite key="52Meyer2000"] (using the appropriate name of course!)—immediately after the word or punctuation where you would like the reference to appear. Do not leave a space, as the reference will appear in the superscript format. </p>',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_521fbbb578761',
				'label' => 'Publication url',
				'name' => 'publication-url',
				'type' => 'text',
				'instructions' => 'Will be extracted automatically from the bibtex record.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_521fbbffcc6e6',
				'label' => 'Publish date',
				'name' => 'publish-date',
				'type' => 'date_picker',
				'date_format' => 'yymmdd',
				'display_format' => 'yymmdd',
				'first_day' => 1,
			),
			array (
				'key' => 'field_5223d2c3367fb',
				'label' => 'Cite key',
				'name' => 'citekey',
				'type' => 'text',
				'instructions' => 'Will be extracted automatically from the bibtex record.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'publication',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'the_content',
				1 => 'excerpt',
				2 => 'custom_fields',
			),
		),
		'menu_order' => 0,
	));
}
