<?php

function doc_connection_types() {

	p2p_register_connection_type( array(
		'name' => 'projects_to_people',
		'from' => 'project',
		'to' => 'person',
		'reciprocal' => true,
		'title' => array( 'from' => 'Related People', 'to' => 'Related Projects' ),
		'sortable' => 'any',
		'admin_column' => 'any'
	) );
	
	p2p_register_connection_type( array(
		'name' => 'projects_to_grants',
		'from' => 'project',
		'to' => 'grant',
		'reciprocal' => true,
		'title' => array( 'from' => 'Related Grants', 'to' => 'Related Projects' ),
		'sortable' => 'any'
	) );
	
	p2p_register_connection_type( array(
		'name' => 'projects_to_publications',
		'from' => 'project',
		'to' => 'publication',
		'reciprocal' => true,
		'title' => array( 'from' => 'Related Publications', 'to' => 'Related Projects' ),
		'sortable' => 'any',
		'admin_column' => 'any'		
	) );
	
	p2p_register_connection_type( array(
		'name' => 'people_to_publications',
		'from' => 'person',
		'to' => 'publication',
		'reciprocal' => true,
		'title' => array( 'from' => 'Related Publications', 'to' => 'Related People' ),
		'sortable' => 'any',
		'admin_column' => 'any'
	) );
	
	p2p_register_connection_type( array(
		'name' => 'people_to_grants',
		'from' => 'person',
		'to' => 'grant',
		'reciprocal' => true,
		'title' => array( 'from' => 'Related Grants', 'to' => 'Related People' ),
		'sortable' => 'any'
	) );
	
	p2p_register_connection_type( array(
		'name' => 'publications_to_grants',
		'from' => 'publication',
		'to' => 'grant',
		'reciprocal' => true,
		'title' => array( 'from' => 'Related Grants', 'to' => 'Related Publications' ),
		'sortable' => 'any'
	) );
}
add_action( 'p2p_init', 'doc_connection_types' );