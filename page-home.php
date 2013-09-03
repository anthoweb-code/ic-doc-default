<?php 
/*
	Template Name: Homepage
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

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<section class="entry-content clearfix" itemprop="articleBody">
									<?php the_content(); ?>
								</section> <!-- end article section -->

								<footer class="article-footer">
									<?php the_tags('<span class="tags">' . __('Tags:', 'bonestheme') . '</span> ', ', ', ''); ?>

								</footer> <!-- end article footer -->

								<?php comments_template(); ?>

							</article> <!-- end article -->
							
							<article class="wide-widget">
								<?php 
								if( !dynamic_sidebar('sidebar-homepage-content') ){
									// Display default widgets if none are enabled
									the_widget( 'All_Projects_Widget', array('title'=>'Projects'), $args );
								}
								?>
							</article>

							<?php get_sidebar('toolbar'); ?>
							
							<?php endwhile; endif; ?>

						</div> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div> <!-- end #inner-content -->

				</div> <!-- end #inner-container -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
