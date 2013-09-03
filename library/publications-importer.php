<?php
/*
Publications Importer
Imports publication data to a WordPress Site
Author: gcorrall
Version: 0.0.1
*/


if ( ! defined( 'WP_LOAD_IMPORTERS' ) )
	return;

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require $class_wp_importer;
}



/**
 * WordPress Importer class for managing the import process of a WXR file
 *
 * @package WordPress
 * @subpackage Importer
 */
if ( class_exists( 'WP_Importer' ) ) {
class Pub_Import extends WP_Importer {

	var $publications = array();
	var $authors = array();


	function WP_Import() { /* nothing */ }

	/**
	 * Registered callback function for the WordPress Importer
	 *
	 * Manages the three separate stages of the import process
	 */
	function dispatch() {
		$uploads = wp_upload_dir();
		$step = empty( $_GET['step'] ) ? 0 : (int) $_GET['step'];
		$bib_loaded = false;
		if (file_exists($this->get_authors_file_path())){
			$this->authors = unserialize(file_get_contents($this->get_authors_file_path()));
		}


		if (file_exists($this->get_publications_file_path())){
			$this->publications = unserialize(file_get_contents($this->get_publications_file_path())); 
			$bib_loaded = true;
		}
		switch ( $step ) {
			case 0:
				$this->greet($bib_loaded);
				break;
			case 1:
				if ($bib_loaded){
					$this->import_options();
				}
				else {
					check_admin_referer( 'import-upload' );
					if ( $this->handle_upload() )
						$this->import_options();
				}		
				break;
			case 2:
				check_admin_referer( 'import-publications' );
				$this->begin_import();
				break;
			case 3: // new step - we've chosen to start again so delete temp files
				check_admin_referer( 'import-upload' );
				unlink($this->get_publications_file_path());
				unlink($this->get_authors_file_path());
				if ( $this->handle_upload() )
					$this->import_options();
				break;	
			case 4: // pausing between import and import options
				check_admin_referer( 'import-publications' );
				$this->import_options();
				break;
		}
	}


	function get_publications_file_path(){
		$uploads = wp_upload_dir();
		$publications_file = $uploads['basedir'];;
		$publications_file.='/'.get_current_user_id().'_publications.bib';
		return $publications_file;
	}

	function get_authors_file_path(){
		$uploads = wp_upload_dir();
		$authors_file = $uploads['basedir'];
		$authors_file.= '/'.get_current_user_id().'_authors.bib';
		return $authors_file;
	}



	/**
	* Extracts a given field from a bibtex reference using regexs
	*
	* Returns an empty string if the field is not found
	*/
	function get_field($field, $string){
		if (preg_match('/\b'.$field.'\s*=\s*{(.*?)}\s*(,|$)/i', $string, $matches)){
			return $matches[1];
		}

		// process in quotes
		if (preg_match('/\b'.$field.'\s*=\s*"(.*?)"\s*(,|$)/i', $string, $matches)){
			return $matches[1];
		}
		return "";
	}


        /**
        * Extracts the bibtex key from a bibtex reference using a regex
        *
        * Returns an empty string if the key is not found
        */

	function get_bibtex_key ($bibtex){
		$bibtex = preg_quote($bibtex);
		if (preg_match('/^\s*@.*?{\s*(.*?),/i', $bibtex, $matches )){
			return $matches[1];
		}
		return "";
	}

        /**
        * Adds a given prefix to a bibtex reference using a regex
        *
        * Returns the new bibtex string
        */

	function set_bibtex_key ($newkey, $bibtex){
		if (preg_match('/(^\s*@.*?{\s*)(.*?),/i', $bibtex, $matches)){
			$prefix = $matches[1];
			$bibtex = preg_replace('/(^\s*@.*?{\s*)(.*?),/i', "$prefix$newkey,", $bibtex );	


		}
		return $bibtex;
	}



        /**
        * Returns the full-name (first, middle and last) from a people post id
        */
	function get_full_name($post_id){
		$first_name = get_post_meta( $post_id, 'first-name', true );
		$middle_name = get_post_meta( $post_id, 'middle-names', true );
		$last_name = get_post_meta( $post_id, 'last-name', true );
		return $first_name." ".$middle_name." ".$last_name;
	}



	function begin_import(){

		$process = $_POST['process'];
		$selection = $_POST['selection'];	
	
		$processed_author_index = array();

		foreach ($this->publications as $one_publication){
			
			$publication_title = $this->get_field('title', $one_publication);

			if (substr($publication_title, 0, 1) == '{' && substr($publication_title, -1) == '}'){
				$publication_title = trim ($publication_title, '{}');
			}	



			if ($publication_title == "") continue; // doesn't seem to have a title; drop and go to next 
			
			$existing_pubs = get_posts('post_type=publication&numberposts=-1'); 
			$new_key = $this->get_bibtex_key($one_publication);

			$title_exists = false;
			$bibkey_exists = false;


			foreach ($existing_pubs as $one_pub) {
				// does a publication with this title already exist?
				$one_pub_title = $one_pub->post_title;
				$match = similar_text ($publication_title, $one_pub_title, $percent);
		
				if ($percent > 97.0){ // check for very similar titles
						$title_exists = true;
						$title_id = $one_pub->ID;
				}
				//  does a publication with this bibtex key already exist?
				$bibtex = get_post_meta( $one_pub->ID, 'bibtex', true ); 
				if ($new_key == $this->get_bibtex_key($bibtex)){
					$bibkey_exists = true;
					$bibfound = $bibtex;
					$bibfound_id = $one_pub->ID;
				}
			}

	
			$pub_post = array(
				'post_title'    => $publication_title,
				'post_type'	=> 'publication', 
				'post_status'   => 'publish'
			);
		
			$giving_up = false;

			$create = false; // only create publication if there is an attached author
			$author_field = $this->get_field('author', $one_publication);
			if ($author_field != ""){ // if there are authors in the bibtex text process them!
				$new_authors = array_map('trim', explode (" and ", $author_field));
				foreach($new_authors as $one_new_author){
					if (substr($one_new_author, 0, 1) == '{' && substr($one_new_author, -1) == '}'){
						$one_new_author = trim ($one_new_author, '{}');
					}	
					$index = array_search($one_new_author,$this->authors); // get index of current author from our constructed, sorted array
					if ($index === false) continue;  
					if ($process[$index] =="attach"){ // if not ignoring this author
						$create = true;
					}
				}
			}
		
			if ($title_exists && $create){
                               	echo "A publication with the title '<em>".$publication_title."</em>' already exists; won't create a new publication <br>";
				$pub_id = $title_id; 
                       	}
			else {

				if ($create)
					$pub_id = wp_insert_post( $pub_post );

				if ($bibkey_exists && $create){
					$generated_bib_key = $pub_id.$new_key; // try new bibkey with post id prefix
					echo "<strong>The bibkey '<em>".$new_key."</em>' from </strong>".$one_publication." <strong>already exists in </strong>".$bibfound."; <strong>Trying generated bibkey <em>".$generated_bib_key."</em></strong><br>";
					foreach ($existing_pubs as $one_pub) {
						$bibtex = get_post_meta( $one_pub->ID, 'bibtex', true );
						if ($generated_bib_key == $this->get_bibtex_key($bibtex)){
							$bibfound = $bibtex;
							$giving_up = true; // even this exists; give up
							echo "<strong>Generated bibkey also already exists; <span style=\"color:red\">won't create a new record</span></strong></br>";
							wp_delete_post( $pub_id, true );
						}
					
					}
					$one_publication = $this->set_bibtex_key($generated_bib_key, $one_publication);
					if (!$giving_up)
						echo "<strong>New key succesful: </strong>".$one_publication."<br>";
				 }
			}
				
			if (!$giving_up && !$title_exists && $create){

					add_post_meta ($pub_id, 'bibtex', str_replace('{ ','{',$one_publication) );
					
					require_once(ABSPATH.'wp-content/plugins/cite-list-p2p/bib2tpl/bibtex_converter.php');
					
					$bibtex_parsed = BibtexConverter::parse($one_publication);
					foreach($bibtex_parsed as $attr){ 
						$citekey = $attr['cite']; 
						$url = $attr['url']; 
						$year = $attr['year'];
						$month = $attr['month'];						
					}
					

					if ($url != "") {
						add_post_meta ($pub_id, 'publication-url', $url);
					}

					if ($citekey != "") {
						add_post_meta ($pub_id, 'citekey', $citekey);
					}
					
					if(strlen($month)==2){
						$month = date('d', strtotime( $month ));
					}else{
						$month='01';
					}
					
					if (is_numeric($year)) {
						add_post_meta ($pub_id, 'publish-date', $year.$month.'01');
					}
				}	
	
					// get authors
					$author_field = $this->get_field('author', $one_publication);
					if ($author_field != ""){ // if there are authors in the bibtex text process them!
						$new_authors = array_map('trim', explode (" and ", $author_field));
						foreach($new_authors as $one_new_author){
							if (substr($one_new_author, 0, 1) == '{' && substr($one_new_author, -1) == '}'){
								$one_new_author = trim ($one_new_author, '{}');
							}	
							$index = array_search($one_new_author,$this->authors); // get index of current author from our constructed, sorted array
							if ($index === false) continue;  
							if ($process[$index] =="attach"){ // if not ignoring this author
								$person_id = $selection[$index];
								$user_name = $this->get_full_name ($person_id);
								array_push($processed_author_index, $index);
								p2p_type( 'people_to_publications' )->connect( $person_id, $pub_id );
							}
							if ($process[$index] == "ignore") {
								array_push($processed_author_index, $index);

							}
						}

					}
		}

		foreach($processed_author_index as $one_index){
			unset($this->authors[$one_index]);
			
		}
		
		$out = array_values($this->authors);
		file_put_contents($this->get_authors_file_path(), serialize($out), LOCK_EX);	

		wp_nonce_field( 'import-publications' ); 
		echo '<div class="narrow">';
		echo '<p>'.__( 'Finished processing. Click to continue', 'publications-importer' ).'</p>';
		?>
		<form enctype="multipart/form-data" method="post" action="<?php echo esc_url( wp_nonce_url( 'admin.php?import=publications&amp;step=4', 'import-publications' ) ); ?>">
		<input type="submit" value="Continue"></form>
		</div>

	<?php
	}





	/**
	 * Display introductory text and file upload form
	 */
	function greet ($bib_loaded) {
		if (!$bib_loaded){
			echo '<div class="narrow">';
			echo '<p>'.__( 'Upload your bib file to import publications into this site.', 'publications-importer' ).'</p>';
			echo '<p>'.__( 'Choose a bib file to upload, then click Upload file and import.', 'publications-importer' ).'</p>';
			wp_import_upload_form( 'admin.php?import=publications&amp;step=1' );
			echo '</div>';
		}
		else {
			wp_nonce_field( 'import-publications' ); 
			echo '<div class="narrow">';
			echo '<p>'.__( 'Do you wish to continue working on the current file or choose a new one?', 'publications-importer' ).'</p>';
			?>
			<form enctype="multipart/form-data" method="post" action="<?php echo esc_url( wp_nonce_url( 'admin.php?import=publications&amp;step=1', 'import-publications' ) ); ?>">
			<input type="submit" value="Continue"></form>
			<?php

			echo '<p>'.__( 'Or choose a bib file to upload, then click Upload file and import.', 'publications-importer' ).'</p>';
			wp_import_upload_form( 'admin.php?import=publications&amp;step=3' );
			echo '</div>';

		}
		

	}


	function handle_upload() {
		$this->publications = array();
		$this->authors = array();
		
		$file = wp_import_handle_upload();
		if ( isset( $file['error'] ) ) {
			echo '<p><strong>' . __( 'Sorry, there has been an error.', 'publications-importer' ) . '</strong><br />';
			echo esc_html( $file['error'] ) . '</p>';
			return false;
		}
		$data = file($file['file']);

		// capture each publication - between line beginning with @ and line ending with }
		$balance = 0;
		foreach ($data as $line){
			$line = trim($line);
			$balance+= substr_count($line, '{');
			$balance-= substr_count($line, '}');
			if (preg_match('/^\s*@/', $line)){
				$capture = true;
				
			}
			if ($capture == true){
				$result.=$line;
			}
			if (substr($line, -1) == '}' && $balance == 0){
				$this->publications[] = $result;
				$capture = false;
				$result = "";
			}
		}

		if (count($this->publications) < 1) {
			echo '<p><strong>' . __( 'Sorry, there has been an error. This does not appear to be a valid bibtex document', 'publications-importer' ) . '</strong><br />';
			echo esc_html( $file['error'] ) . '</p>';
			return false;
		}
		
		file_put_contents($this->get_publications_file_path(), serialize($this->publications), LOCK_EX);
		return true;
	}

	function import_options(){
	

$users = get_posts('post_type=person&numberposts=-1');

if (file_exists($this->get_authors_file_path())){
	$this->authors = unserialize(file_get_contents($this->get_authors_file_path()));
}
else {
	for ($count = 0; $count < count($this->publications); ++$count){
		$one_publication = $this->publications[$count]; 


		$author_field = $this->get_field('author', $one_publication);


		if ($author_field != ""){
			$new_authors = array_map('trim', explode (" and ", $author_field));
			foreach($new_authors as $one_new_author){
				if (substr($one_new_author, 0, 1) == '{' && substr($one_new_author, -1) == '}'){
					$one_new_author = trim ($one_new_author, '{}');
				}	
				if (!in_array($one_new_author, $this->authors))
				{
					array_push($this->authors, $one_new_author);
				}
			}
		}

	}

	sort($this->authors, SORT_STRING);


	$uploads = wp_upload_dir();
	file_put_contents($this->get_authors_file_path(), serialize($this->authors), LOCK_EX);
}


	if (count($this->authors) < 1){ // finished?
		unlink($this->get_publications_file_path());
		unlink($this->get_authors_file_path());
		
		echo '<form action="'.admin_url('admin.php?import=publications&amp;step=0' ).'" method="post">';

		echo '<p> <strong>All publications have now been processed</strong> </p>';
		echo '<p class="submit"><input type="submit" class="button" value="Finished"></p>';
	}

else {

?>
<form action="<?php echo admin_url( 'admin.php?import=publications&amp;step=2' ); ?>" method="post">
	<?php wp_nonce_field( 'import-publications' ); ?>
	<input type="hidden" name="import_id" value="<?php echo $this->id; ?>" />
<p> Here is a list of the authors that have been found in the bibtex file. Please match them to the correct people names.</p><p> A best guess has been made for each.</p><p> Check the ignore box to ignore that author and make no matches for them.</p><p> Check the 'Attach to' box to link the 'Author's Name' to the 'Person's Name'.
</p> 
<table border="1">
<tr><th>Ignore  </th><th>Attach To  </th><th>Author's Name</th><th>Person's Name</th></tr>
<?php


$count = 0;
foreach ($this->authors as $one_author){
	$best_match_percent = 0.0;
	foreach ($users as $one_user){ 
		$user_name = $this->get_full_name($one_user->ID);
		$match = similar_text ($one_author, $user_name, $percent);
		if ($percent > $best_match_percent) {
			$best_match = $user_name;
			$best_match_percent = $percent;
		}
	}

	$user_select = "";
	
	$all_user_names = array();
	foreach ($users as $one_user){
		$all_user_names[] = array('name' => $this->get_full_name($one_user->ID) , 'id' => $one_user->ID);
	}
	
	usort($all_user_names, sort_usernames);
	

	foreach ($all_user_names as $one_user){ // construct select options

		$user_name = $one_user['name'];
		$user_select.=' <option value="'.$one_user['id'].'" ';
		if ($user_name == $best_match) {
			$user_select.= 'selected="selected">';
		} else {
			$user_select.='>';
		}
		$user_select.=$user_name.'</option>';
	}


?><tr>
	<td> <input type="radio" name="process[<?echo $count;?>]" value="ignore"></td><td><input type="radio" name="process[<?echo $count;?>]" value="attach"></td><td><?php echo $one_author;?></td><td> <select name="selection[<?echo $count;?>]"><?php echo $user_select;?></select> </td>
</tr><?php $count++;} ?>
</table>


<p class="submit"><input type="submit" class="button" value="<?php esc_attr_e( 'Submit', 'publications-importer' ); ?>" /></p>
</form>
<?php		
		} // else count empty

	}

}

} // class_exists( 'WP_Importer' )


function sort_usernames($a, $b) { // sort names for select
	return strcmp($a['name'], $b['name']);
}

function publications_importer_init() {

	/**
	 * WordPress Importer object for registering the import callback
	 * @global WP_Import $wp_import
	 */
	$GLOBALS['pub_import'] = new Pub_Import();
	register_importer( 'publications', 'Publications', __('Import <strong>publications</strong> from a bib file.', 'publications-importer'), array( $GLOBALS['pub_import'], 'dispatch' ) );
}
add_action( 'admin_init', 'publications_importer_init' );

