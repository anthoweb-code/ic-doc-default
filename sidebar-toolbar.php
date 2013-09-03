<div id="toolbar">
								
	<ul id="actions">
		<li id="action-print"><a href="#" class="print-link">Print</a></li>
		<li id="action-email"><a href="#">Email to a Friend</a></li>
		<li id="action-report"><a href="#" class="reportOC">Report incorrect content</a></li>
	</ul>
			
									
	<div id="emailFriendForm" class="hidden">

		<h2>Email to a Friend</h2>
		<form method="post" action="http://www.imperial.ac.uk/emailafriend.asp">					 
		
			<h3>Page URL:</h3>
			<p id="emailHref"><?php echo get_permalink(); ?></p>


			<fieldset>

				<div id="your-info">
					<h3>Your Information:</h3>

					<label for="yourName">Your Name</label>
					<input type="text" name="yourName" id="yourName" placeholder="Your Name" class="clearDefault">

					<label for="yourEmail">Your Email</label>
					<input type="text" name="yourEmail" id="yourEmail" class="emailAddress clearDefault" placeholder="Your Email Address">

				</div>
				<div id="friend-info">
					<h3>Friend’s Information:</h3>

					<label for="friendsName">Friend’s Name</label>
					<input type="text" name="friendsName" id="friendsName" class="clearDefault" placeholder="Friend’s Name">
					
					<label for="friendsEmail">Friend’s Email</label>
	  				<input type="text" name="friendsEmail" id="friendsEmail" class="emailAddress clearDefault" placeholder="Friend’s Email">
		
				</div>
				<div class="clear"><span>&nbsp;</span></div>

			</fieldset>
		
			<div class="form-actions">

				<a href="#" class="close">Close</a>&nbsp;&nbsp;<input type="image" src="<?php echo get_template_directory_uri(); ?>/library/images/submit_send_email.gif" value="Send Email to Friend" name="emailFriendSubmit" id="emailFriendSubmit" class="submitButton">
					
</div> 
<input type="hidden" name="emailHref" value="emailHref">
		</form>

	</div>
	
	<dl class="socialBoMa">
	<a target="_blank" rel="nofollow" title="Share this on Delicious" href="http://www2.imperial.ac.uk/imedia/share/delicious?title=<?php echo urlencode(get_the_title()); ?>&amp;ref=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url'); ?>/library/images/icon_delicious.gif" alt="Delicious"></a>
	<a target="_blank" rel="nofollow" title="Tweet this" href="http://www2.imperial.ac.uk/imedia/share/twitter?title=<?php echo urlencode(get_the_title()); ?>&amp;ref=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url'); ?>/library/images/twitter.gif" alt="Twitter"></a>
	<a target="_blank" rel="nofollow" title="Digg this" href="http://www2.imperial.ac.uk/imedia/share/digg?title=<?php echo urlencode(get_the_title()); ?>&amp;ref=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url'); ?>/library/images/icon_digg.png" alt="Digg this"></a>
	<a target="_blank" rel="nofollow" title="Stumble this" href="http://www2.imperial.ac.uk/imedia/share/stumble?title=<?php echo urlencode(get_the_title()); ?>&amp;ref=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url'); ?>/library/images/icon_stumbleupon.gif" alt="StumbleUpon"></a>
	<a target="_blank" rel="nofollow" title="Share this on Facebook" href="http://www2.imperial.ac.uk/imedia/share/facebook?title=<?php echo urlencode(get_the_title()); ?>&amp;ref=<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url'); ?>/library/images/facebook.gif" alt="Facebook"></a>
	</dl>
	
	<div id="report-wrap"><div id="overlay-window"><div class="OChead"><span>Report incorrect content</span><a href="#"><img border="0" src="http://www3.imperial.ac.uk/icimages?p_imgid=23076" alt="Close" class="OCclose"></a></div><form method="get" action=""><fieldset><p>Name (optional)</p><input type="text" name="username"><p><br>Email address (optional)</p><input type="text" name="useremail"><p><br>Please give a brief description of the problem:</p><label for="Description"></label><textarea name="Description" id="reportContent"></textarea><div id="submitOutdatedContent" class="form-buttons"><input type="submit"></div></fieldset></form></div></div>
		
</div><!-- /#toolbar -->