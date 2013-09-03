<?php
/* 
	This is the Grant single view template
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
									
									<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
									<h2 class="subtitle-right">&nbsp;</h2>
									
									<div class="meta-fields">
										<dl><?php 
										if(get_field('awarded-by')) echo '
											<dt>Awarded by</dt>
												<dd>'.get_field('awarded-by').'</dd>';
										
										if(get_field('amount-awarded')) echo '
											<dt>Amount awarded</dt>
												<dd>'.get_field('amount-awarded').'</dd>';
										
										if(get_field('grant-start')) echo '
											<dt>Start</dt>
												<dd>'.get_field('grant-start').'</dd>';
											
										if(get_field('grant-end')) echo '
											<dt>End</dt>
												<dd>'.get_field('grant-end').'</dd>';
										
										?>
										</dl>
									</div>
																										
								</header> <!-- end article header -->

								<section class="entry-content clearfix">
								
									<?php the_content(); ?>									

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
