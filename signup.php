<?php
include 'database.php';
include 'header.php';
include 'ph-queries.php';

$ph_queries = new PHQUERIES( $conn );
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	?>
	<div class="contact" id="touch">
		<div class="container">
			<h4>Join Our <span class="m_1">Community</span></h4>
				<form method="post" action="">
					<div class="contact_top">
						<div class="col-md-6 contact_left">
							<input type="text" class="text" placeholder="Username" name="user_name" required>
							<input type="text" class="text" placeholder="Email" name="user_email" required>
							<input type="password" class="text" placeholder="Password" name="user_pass" required>
							<input type="password" class="text" placeholder="Re-Type Password" name="retype_pass" required>
						</div>
						<div class="col-md-6 about_right">
							<a href="#image-3">
								<img src="images/p6.jpg" class="img-responsive" alt="image03">
							</a>
						</div>
					</div>
					<div class="clearfix"> </div>
					<div class="contact_but">
						<span class="btn1 btn4 btn-1 btn-1b"><input type="submit" value="Submit"></span>
					</div>
				</form>
		</div>
	</div>
	 <?php
} else {
	$errors = array();
	if ( isset($_POST['user_name'] ) )
	{
		//the user name exists
		if ( !ctype_alnum( $_POST['user_name'] ) )
		{
			$errors[] = 'The username can only contain letters and digits.';
		}
		if ( strlen( $_POST['user_name'] ) > 30 )
		{
			$errors[] = 'The username cannot be longer than 30 characters.';
		}
	}
	else
	{
		$errors[] = 'The username field must not be empty.';
	}
	if( isset( $_POST['user_pass'] ) )
	{
		if( $_POST['user_pass'] != $_POST['retype_pass'] )
		{
			$errors[] = 'The two passwords did not match.';
		}
	}
	else
	{
		$errors[] = 'The password field cannot be empty.';
	}
	 
	if( !empty( $errors ) ) 
	{
		echo 'Uh-oh.. a couple of fields are not filled in correctly..';
		echo '<ul>';
		foreach( $errors as $key => $value )
		{
			echo '<li>' . $value . '</li>'; 
		}
		echo '</ul>';
	}
	else
	{
		$ph_queries->add_user ( $_POST['user_name'], sha1($_POST['user_pass']), $_POST['user_email'], 0 );
	}
}
include 'footer.php';
?>