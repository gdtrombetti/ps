<?php
session_start();
include 'database.php';
include 'header.php';
include 'ph-queries.php';

$ph_queries = new PHQUERIES( $conn );
// if signed in dont show 
if( isset( $_SESSION['signed_in'] ) && $_SESSION['signed_in'] == true) {
	echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
} else {
	if( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
		/*the form hasn't been posted yet, display it
		  note that the action="" will cause the form to post to the same page it is on */
		?>
		<div class="contact" id="touch">
		<div class="container">
			<h4>Sign <span class="m_1">In</span></h4>
				<form method="post" action="contact-post.php">
					<div class="contact_top">
						<div class="col-md-6 contact_left">
							<input type="text" class="text" placeholder="Username" name="user_name" required>
							<input type="password" class="text" placeholder="Password" name="pass" required>
							<input type="password" class="text" placeholder="Re-Type Password" name="retype_pass" required>
						</div>
					<div class="contact_but">
						<span class="btn1 btn4 btn-1 btn-1b"><input type="submit" value="Sign In"></span>
					</div>
					</div>
				</form>
		</div>
	</div>
	<?php
	} else {
		/* so, the form has been posted, we'll process the data in three steps:
			1.  Check the data
			2.  Let the user refill the wrong fields (if necessary)
			3.  Varify if the data is correct and return the correct response
		*/
		$errors = array();
		 
		if( !isset( $_POST['user_name'] ) ) {
			$errors[] = 'The username field must not be empty.';
		} 

		if( !isset( $_POST['user_pass'] ) ) {
			$errors[] = 'The password field must not be empty.';
		}
		if( !empty( $errors ) ) {
			echo 'Uh-oh.. a couple of fields are not filled in correctly..';
			echo '<ul>';
			foreach($errors as $key => $value) 
			{
				echo '<li>' . $value . '</li>'; /* this generates an error list */
			}
			echo '</ul>';
		} else {
			$result = $ts_query -> sign_in( $_POST['user_name'], sha1( $_POST['user_pass'] ) );
			if( !$result )
			{
				echo 'Something went wrong while signing in. Please try again later.';
				//echo mysql_error();
			} else {
				//the query was successfully executed, there are 2 possibilities
				//1. the query returned data, the user can be signed in
				//2. the query returned an empty result set, the credentials were wrong
				if( mysqli_num_rows( $result ) == 0 )
				{
					echo 'You have supplied a wrong user/password combination. Please try again.';
				}
				else
				{
					$_SESSION['signed_in'] = true;
					// Store session values so we can use again
					while( $row = mysqli_fetch_assoc($result) )
					{
						$_SESSION['user_id'] = $row['user_id'];
						$_SESSION['user_name']  = $row['user_name'];
						$_SESSION['user_level'] = $row['user_level'];
					}
					echo 'Welcome, ' . $_SESSION['user_name'] . '. <a href="index.php">Proceed to the forum overview</a>.';
				}
			}
		}
	}
}
 
include 'footer.php';
?>