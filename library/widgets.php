<?php

add_action( 'widgets_init', 'init_custom_widgets' );

function init_custom_widgets() {
	
	/* Custom widget areas */
	
	register_sidebar(array(
		'id' => 'sidebar-top',
		'name' => __('Sidebar top', 'bonestheme'),
		'description' => __('Top sidebar area, present on all pages (default: Main Menu)', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>'
	));
	
	register_sidebar(array(
		'id' => 'sidebar-projects',
		'name' => __('Projects sidebar', 'bonestheme'),
		'description' => __('Active on single project pages only (default: Related People, Grants & Publications)', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>'
	));
	
	register_sidebar(array(
		'id' => 'sidebar-people',
		'name' => __('People sidebar', 'bonestheme'),
		'description' => __('Active on single people pages only.', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>'
	));
	
	register_sidebar(array(
		'id' => 'sidebar-homepage',
		'name' => __('Homepage sidebar', 'bonestheme'),
		'description' => __('Active on homepage, lower side bar area.', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>'
	));
	
	register_sidebar(array(
		'id' => 'sidebar-homepage-content',
		'name' => __('Homepage main', 'bonestheme'),
		'description' => __('Active on homepage, below main content area.', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
	));
	
	

	/* Custom widget's */
	
	register_widget( 'All_People_Widget' );
	register_widget( 'Related_People_Widget' );

	register_widget( 'All_Projects_Widget' );
	register_widget( 'Related_Projects_Widget' );
	register_widget( 'Related_Grants_Widget' );
	register_widget( 'Related_Publications_Widget' );

}


class All_Projects_Widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			'all-projects', // Class name
			'All Projects', // Widget title
			array( 'description' => __( 'List of all projects A-to-Z (titles & links)', 'bonestheme' ))
		);
	}

	function widget( $args, $instance ) {
		$title = apply_filters('widget_title', $instance['title'] );
		if(!$title) $title = $args['widget_name'];
			
		$projects = new WP_Query('post_type=project&posts_per_page=-1');
	
		if ( $projects->have_posts() ): 
			
			echo $args['before_widget'].
				 $args['before_title'].$title.$args['after_title'].
				 '<ul>';
				 
			while ( $projects->have_posts() ) : $projects->the_post(); ?>
				<li><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></h3></a>
					<div><?php echo get_field('short-desc'); ?></div>				
					<a class="readmore" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">[+] more</a>
				</li><?
			endwhile;
			wp_reset_query();
			echo $args['after_widget'];
		endif; 
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;  
	    $instance['title'] = strip_tags( $new_instance['title'] );  
	    return $instance; 
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('', '') );  
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		// Widget Title: Text Input  ?>
		<p>  
		    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>  
		    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" />  
		</p>  
		<?php
	}
}

class All_People_Widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			'all-people', // Base ID
			'All people', // Name
			array( 'description' => __( 'List of all people A-to-Z (titles & links)', 'bonestheme' ))
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters('widget_title', $instance['title'] );
		if(!$title) $title = $args['widget_name'];
			
		$people = new WP_Query('post_type=person&posts_per_page=-1');
		
		if ( $people->have_posts() ): 
			
			echo $args['before_widget'].
				 $args['before_title'].$title.$args['after_title'].
				 '<ul>';
			
			while ( $people->have_posts() ) : $people->the_post(); ?>
	
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?
				
			endwhile;
			wp_reset_query();
			echo '</ul>'.$args['after_widget'];					
			
		endif; 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;  
	    $instance['title'] = strip_tags( $new_instance['title'] );  
	    return $instance; 
	}

	public function form( $instance ) {
		$defaults = array( 'title' => __('', '') );  
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		// Widget Title: Text Input  ?>
		<p>  
		    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>  
		    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" />  
		</p>  
		<?php
	}
}


class Related_People_Widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			'related-people', // Class name
			'Related people', // Widget title
			array( 'description' => __( 'List of people relating to a project/grant (titles & links)', 'bonestheme' ))
		);
	}

	function widget( $args, $instance ) {
		$title = apply_filters('widget_title', $instance['title'] );
		if(!$title) $title = $args['widget_name'];

		switch (get_post_type()) {
			case 'project':
				$relationship = 'projects_to_people';
				break;
			case 'grant':
				$relationship = 'people_to_grants';
				break;
		}
		$connected = new WP_Query( array(
			'connected_type' => $relationship,
			'connected_items' => get_queried_object(),
			'nopaging' => true,
		));
				
		if ( $connected->have_posts() ) :

			echo $args['before_widget'].
				 $args['before_title'].$title.$args['after_title'].
				 '<ul>';
			while ( $connected->have_posts() ) : $connected->the_post(); ?>
					<li>
						<a href="<?php echo get_permalink(); ?>">
							<?php echo get_the_title(); ?>
						</a>
					</li>
		<?php 
			endwhile; 
			wp_reset_query();
			echo '</ul>'.$args['after_widget']; 
		endif; 
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;  
	    $instance['title'] = strip_tags( $new_instance['title'] );  
	    return $instance; 
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('', '') );  
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
		<p>  
		    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>  
		    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" />  
		</p>  
		<?php
	}
}



class Related_Projects_Widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			'related-projects', // Class name
			'Related projects', // Widget title
			array( 'description' => __( 'List of projects relating to a person/grant (titles & links)', 'bonestheme' ))
		);
	}

	function widget( $args, $instance ) {
		// Widget output
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		if(!$title) $title = $args['widget_name'];
		
		switch (get_post_type()) {
			case 'person':
				$relationship = 'projects_to_people';
				break;
			case 'grant':
				$relationship = 'projects_to_grants';
				break;
		}
		$connected = new WP_Query( array(
			'connected_type' => $relationship,
			'connected_items' => get_queried_object(),
			'nopaging' => true,
		));
		
		if ( $connected->have_posts() ) :

			echo $args['before_widget'].
				 $args['before_title'].$title.$args['after_title'].
				 '<ul>';
			while ( $connected->have_posts() ) : $connected->the_post(); ?>
					<li>
						<a href="<?php echo get_permalink(); ?>">
							<?php echo get_the_title(); ?>
						</a>
					</li>
		<?php 
			endwhile; 
			wp_reset_query();
			echo '</ul>'.$args['after_widget']; 
		endif; 
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;  
	    $instance['title'] = strip_tags( $new_instance['title'] );  
	    return $instance; 
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('', '') );  
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		// Widget Title: Text Input  ?>
		<p>  
		    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>  
		    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" />  
		</p>  
		<?php
	}
}


class Related_Grants_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'related-grants', // Base ID
			'Related grants', // Name
			array( 'description' => __( 'List of grants relating to a project/person (titles & links)', 'bonestheme' ))
		);
	}

	function widget( $args, $instance ) {
		// Widget output
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		if(!$title) $title = $args['widget_name'];
		$connected=array();
		
		switch (get_post_type()) {
			case 'person':
				$relationship = 'people_to_grants';
				break;
			case 'project':
				$relationship = 'projects_to_grants';
				break;
		}
		$connected = new WP_Query( array(
			'connected_type' => $relationship,
			'connected_items' => get_queried_object(),
			'nopaging' => true,
		));
		
		if ( $connected->have_posts() ) :		
			
			echo $args['before_widget'].
				 $args['before_title'].$title.$args['after_title'].
				 '<ul>';
				 
			while ( $connected->have_posts() ) : $connected->the_post(); 
				?>
				<li>
					<a href="<?php echo get_permalink(); ?>">
						<?php echo get_the_title(); ?>
					</a>
				</li>
				<?php 
			endwhile; 
			wp_reset_query();
			echo '</ul>'.$args['after_widget'];
		endif; 
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;  
	    $instance['title'] = strip_tags( $new_instance['title'] );  
	    return $instance; 
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('', '') );  
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		// Widget Title: Text Input  ?>
		<p>  
		    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>  
		    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" />  
		</p>  
		<?php
	}
}


class Related_Publications_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'related-publications', // Base ID
			'Related publications', // Name
			array( 'description' => __( 'List of publications relating to a project/person (titles & links)', 'bonestheme' ))
		);
	}

	function widget( $args, $instance ) {
		// Widget output
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		if(!$title) $title = $args['widget_name'];
		$connected=array();
		
		echo  $args['before_widget']
				 .$args['before_title'].$title.$args['after_title']
				 .do_shortcode('[publications]')
				 .$args['after_widget'];				 
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;  
	    $instance['title'] = strip_tags( $new_instance['title'] );  
	    return $instance; 
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('', '') );  
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		// Widget Title: Text Input  ?>
		<p>  
		    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>  
		    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" />  
		</p>  
		<?php
	}
}

?>