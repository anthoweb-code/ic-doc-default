<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title(''); ?></title>

		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<!-- or, set /favicon.ico for IE10 win -->
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<!-- drop Google Analytics Here -->
		<!-- end analytics -->

	</head>

	<body <?php body_class('show-nav'); ?>>

		<div id="container">
			
			<!-- OPEN HEADER -->
			<div id="header"> 
			
				<div id="inner-header" class="wrap clearfix">
				
					<a href="http://www.imperial.ac.uk" id="logo" tabindex="2" accesskey="0"><img src="<?php echo get_template_directory_uri() ?>/library/images/logo_imperial_college_london.png" width="168" height="44" alt="Imperial College London"></a>
					
					<ul id="main-nav">
					 <li id="mn-home"><a href="<?=IC_SITE_ROOT?>/">Return to the Imperial homepage</a></li>
					 <li id="mn-research"><a href="<?=IC_SITE_ROOT?>/research" tabindex="3" accesskey="7">Research</a></li>
					 <li id="mn-courses"><a href="<?=IC_SITE_ROOT?>/courses" tabindex="4">Courses</a></li>
					 <li id="mn-faculties-departments"><a href="<?=IC_SITE_ROOT?>/a_to_z" tabindex="5">Faculties &amp; Departments</a></li>
					 <li id="mn-life"><a href="<?=IC_SITE_ROOT?>/campus_life" tabindex="6">Campus<br>Life</a></li>
					 <li id="mn-news"><a href="<?=IC_SITE_ROOT?>/news" tabindex="7">News</a></li>
					 <li id="mn-events"><a href="<?=IC_SITE_ROOT?>/events" tabindex="8">Events</a></li>
					 <li id="mn-services"><a href="<?=IC_SITE_ROOT?>/admin_services" tabindex="9">Admin &amp; Services</a></li>
					 <li id="mn-about"><a href="<?=IC_SITE_ROOT?>/aboutimperial" tabindex="10" accesskey="8">About Imperial</a></li>
					 </ul>			
					
					<div id="header-bar" class="clearfix">
					<div id="search-area">
					
					<form id="search" action="<?=IC_SITE_ROOT?>/search/results" method="post"><div id="search-inner-wrapper"><input type="text" name="searchbox" id="searchQuery" value="" class="clearDefault"><input type="image" value="search" src="<?php echo get_template_directory_uri() ?>/library/images/submit_search.png" alt="Search" id="searchSubmit" class="submitButton"></div><input type="hidden" name="sr" value="0"><input type="hidden" name="secure" value="1"><div><a href="<?=IC_SITE_ROOT?>/collegedirectory" id="search-people" title="Search for People">People</a></div></form>
								
					</div>
					<div id="audience-nav">					
						<p>For:</p>
						 <ul>
							 <li id="au-prospective-students"><a href="<?=IC_SITE_ROOT?>/prospectivestudents" tabindex="11" accesskey="1">Prospective Students</a></li>
							 <li id="au-students"><a href="<?=IC_SITE_ROOT?>/students" tabindex="12" accesskey="2">Students</a></li>
							 <li id="au-alumni"><a href="<?=IC_SITE_ROOT?>/alumni" tabindex="13" accesskey="3">Alumni</a></li>
							 <li id="au-staff"><a href="<?=IC_SITE_ROOT?>/staff" tabindex="14" accesskey="4">Staff</a></li>
							 <li id="au-business"><a href="<?=IC_SITE_ROOT?>/business" tabindex="15" accesskey="5">Business</a></li>
							 <li id="au-media"><a href="<?=IC_SITE_ROOT?>/media" tabindex="16" accesskey="6">Media</a></li>
						 </ul>					
						</div>
					</div>
					
					
					<div id="sub-header">				
						<a href="<?php bloginfo('url'); ?>" class="bannerTitle"><?php bloginfo(); ?></a>
						<p><?php bloginfo('description'); ?></p>
				        <img src="<?php echo get_template_directory_uri() ?>/library/images/sub_hdr_doc.png" width="250" height="86" alt="" id="sub-hdr-image" />
					</div>


				</div>
			</div>
			<!-- CLOSE HEADER -->
			
			
			<?php /*
			<header class="header" role="banner">

				<div id="inner-header" class="wrap clearfix">

					<!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
					<p id="logo" class="h1"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a></p>

					<!-- if you'd like to use the site description you can un-comment it below -->
					<?php // bloginfo('description'); ?>


					<nav role="navigation">
						<?php bones_main_nav(); ?>
					</nav>

				</div> <!-- end #inner-header -->

			</header> <!-- end header -->
			*/ ?>
			
			