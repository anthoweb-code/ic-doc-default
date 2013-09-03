<?php

add_filter( 'manage_edit-publication_columns', 'doc_edit_pub_columns' ) ;

function doc_edit_pub_columns( $columns ) {
	$columns['cite-key'] = __( 'Cite key' );
	$columns['publish-date'] = __( 'Publish date' );	
	unset($columns['comments']);
	unset($columns['author']);
	unset($columns['date']);
	return $columns;
}

add_action( 'manage_publication_posts_custom_column', 'doc_manage_pub_columns', 10, 2 );

function doc_manage_pub_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'cite-key' :

			$citekey = get_post_meta( $post_id, 'citekey', true );

			if ( empty( $citekey ) )
				echo __( 'Unknown' );

			else
				echo '<input type="text" value=\'[cite key="'.$citekey.'"]\' onfocus="this.select()" onMouseUp="return false" />';

			break;

		case 'publish-date' :

			$pubdate = get_post_meta( $post_id, 'publish-date', true );
			$pubyear = substr($pubdate,0,4);
			$pubmonth = substr($pubdate,2,2);
			$pubday = substr($pubdate,4,2);
						
			if ( empty( $pubdate ) )
				echo __( 'Unknown' );
				
			else
				echo date('Y-m-d', strtotime($pubdate) );

			break;
					
		default :
			break;
	}
}
