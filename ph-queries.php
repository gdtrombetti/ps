<?php
include 'database.php';

class PHQUERIES {
	var $db_conn;
	public function __construct( $conn ) {
		$this->db_conn = $conn;
	}
	function add_videos ( $iframe, $mid_image, $thumbnails, $title, $tags, $categories, $seconds, $views ) {
		$stmt = $this->db_conn->prepare("INSERT INTO videos ( iframe, mid_image, thumbnails, title, tags, categories, seconds, views) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param( 'ssssssss', $iframe, $mid_image, $thumbnails, $title, $tags, $categories, $seconds, $views );
		$stmt->execute();
		if ( $stmt == true) {
			echo 'data is in';
		} else {
		echo 'Something went wrong while registering. Please try again later.';
			echo mysql_error();
		} 
	}
	function add_user ( $user_name, $user_pass, $user_email, $user_level ) {
		$user_level = 0;
		$now = date('Y-m-d');
		$stmt = $this->db_conn->prepare("INSERT INTO users (user_name, user_pass, user_email ,user_date, user_level) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param( 'ssssi', $user_name, $user_pass, $user_email, $now, $user_level );
		$stmt->execute();
		if ( $stmt == true) {
			echo 'Successfully registered. You can now <a href="signin.php">sign in</a> and start posting!';
		} else {
		echo 'Something went wrong while registering. Please try again later.';
			echo mysql_error();
		}
	}
}