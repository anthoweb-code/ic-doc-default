<?php 

$args = array('before_widget' => '<div id="%1$s" class="widget %2$s">',
			  'after_widget'  => '</div>',
			  'before_title'  => '<h4 class="widget-title">',
			  'after_title'   => '</h4>');
			  
?>
				<div id="sub-content" class="sidebar fourcol last clearfix" role="complementary">
					<?php 
						if(is_front_page()){
														
							if( !dynamic_sidebar('sidebar-homepage') ){
								// Display default widgets if none are enabled
								the_widget( 'All_People_Widget', array('title'=>'All People'), $args );
							}
							
						}elseif(!is_archive()){							
							
							if(get_post_type()=="project"){
							
								if( !dynamic_sidebar('sidebar-projects') ){
									// Display default widgets if none are enabled
									the_widget( 'Related_People_Widget', array('title'=>'Related People'), $args );
									the_widget( 'Related_Grants_Widget', array('title'=>'Related Grants'), $args );
									the_widget( 'Related_Publications_Widget', array('title'=>'Related Publications'), $args );
								}
							}
							
							if(get_post_type()=="person"){
							
								if( !dynamic_sidebar('sidebar-people') ){
									// Display default widgets if none are enabled
									the_widget( 'Related_Projects_Widget', array('title'=>'Related Projects'), $args );
									the_widget( 'Related_Grants_Widget', array('title'=>'Related Grants'), $args );
									the_widget( 'Related_Publications_Widget', array('title'=>'Related Publications'), $args );
								}
							}
							
							if(get_post_type()=="grant"){
							
								if( !dynamic_sidebar('sidebar-people') ){
									// Display default widgets if none are enabled
									the_widget( 'Related_Projects_Widget', array('title'=>'Related Projects'), $args );
									the_widget( 'Related_People_Widget', array('title'=>'Related People'), $args );
									the_widget( 'Related_Publications_Widget', array('title'=>'Related Publications'), $args );
								}
							}
							
						}elseif(is_archive()){
						
							// Archive specific Widget's can go here...
							
						}	
						?>
				</div>