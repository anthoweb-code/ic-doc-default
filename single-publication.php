<?php
/* 
This is the Publications single view template
*/

$cite = new CiteAndList();
//$cite->get_single_bibtex();

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

								</header> <!-- end article header -->

								<section class="entry-content clearfix">

									<pre><?php
									
									
									 echo do_shortcode('[publications]');
									 //print_r( $cite->get_single_bibtex() );
									 
									  ?></pre>

								</section> <!-- end article section -->

								<footer class="article-header">
									<p class="tags"><?php //echo get_the_term_list( get_the_ID(), 'custom_tag', '<span class="tags-title">' . __('Custom Tags:', 'bonestheme') . '</span> ', ', ' ) ?></p>

								</footer> <!-- end article footer -->

								<?php comments_template(); ?>

							</article> <!-- end article -->

							<?php endwhile; ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
										<header class="article-header">
											<h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e("This is the error message in the single-custom_type.php template.", "bonestheme"); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div> <!-- end #inner-content -->

				</div> <!-- end #inner-container -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
