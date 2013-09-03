<?php
/* 
	This is the Person single view template
*/

get_header(); ?>

			<div id="content">

				<div id="inner-container">

					<div id="inner-content" class="wrap clearfix">

						<div id="nav-widget" class="sidebar">
						<?php 	
							if(is_active_sidebar('sidebar-top'))
								dynamic_sidebar('sidebar-top'); 
							else
								get_sidebar('default-menu');
						?>
						</div>

						<div id="main" class="eightcol first clearfix" role="main">

							<div class="back-link"><a href="javascript:history.go(-1);">Back</a></div>
														
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

								<header class="article-header">
									
									<h1 class="single-title custom-post-type-title">
										<?php echo get_field( 'title' )." "
											  	  .get_field( 'first-name' )." "
											  	  .get_field( 'middle-name' )." "
											  	  .get_field( 'last-name' );
										?>
									</h1>
									<h2 class="subtitle-right"><?php echo get_field('job-title'); ?></h2>
									
									<?php if(get_field('photo')){ 
										
										$photo = get_field('photo');
									?>
									<img class="photo" src="<?php echo $photo['sizes']['medium']; ?>" />
									<?php } ?>
									
									<div class="meta-fields">
										<dl><?php 
										if(get_field('phone')) echo '
											<dt>Phone</dt>
												<dd>'.get_field('phone').'</dd>';
										
										if(get_field('secretary')) echo '
											<dt>Secretary</dt>
												<dd>'.get_field('secretary').'</dd>';
											
										if(get_field('email')) echo '
											<dt>Email</dt>
												<dd>'.get_field('email').'</dd>';
											
										if(get_field('twitter')) echo '
											<dt>Twitter</dt>
												<dd><a href="'.get_field('twitter').'">'.get_field('twitter').'</a></dd>';
										
										if(get_field('linkedin')) echo '
											<dt>LinkedIn</dt>
												<dd><a href="'.get_field('linkedin').'">'.get_field('linkedin').'</a></dd>';
										
										if(get_field('blog-link')) echo '
											<dt>Blog</dt>
												<dd><a href="'.get_field('blog-link').'">'.get_field('blog-link').'</a></dd>';
										
										if(get_field('external-link')) echo '
											<dt>External link</dt>
												<dd><a href="'.get_field('external-link').'">'.get_field('external-link').'</a></dd>';
										
										?>
										</dl>
									</div>
																										
								</header> <!-- end article header -->

								<section class="entry-content clearfix">
								
									<div class="long-bio"><?php echo apply_filters('the_content', get_field('long-biog')); ?></div>									

								</section> <!-- end article section -->

								<footer class="article-header">
									<p class="tags"><?php //echo get_the_term_list( get_the_ID(), 'custom_tag', '<span class="tags-title">' . __('Custom Tags:', 'bonestheme') . '</span> ', ', ' ) ?></p>

								</footer> <!-- end article footer -->

								<?php comments_template(); ?>

							</article> <!-- end article -->

							<?php get_sidebar('toolbar'); ?>

							<?php endwhile; endif; ?>

						</div> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div> <!-- end #inner-container -->

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
