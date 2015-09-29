<?php
/*
Plugin Name: WPShout Cookie Demo
Description: A demo of PHP session cookies in a WordPress environment.
Author: WPShout
Author URI: http://wpshout.com
*/

/*
* Setting and retrieving cookie
*/
add_action( 'init', 'wpcd_set_cookie' );
function wpcd_set_cookie() {
	if(isset( $_POST[ 'fave_food' ] ) ) :
		$cookie_value = sanitize_text_field( $_POST[ 'fave_food' ] );
		setcookie( wpcd_get_cookie_name(), $cookie_value, time() + (86400 * 999), "/" ); // 86400 = 1 day

		// Now refresh so the header changes get captured
		header("Refresh:0");
	endif;
}

function wpcd_get_cookie_name() {
	return 'fave_food';
}

function wpcd_get_cookie() {
	return $_COOKIE[ wpcd_get_cookie_name() ];
}

function wpcd_is_cookied() {
	return isset( $_COOKIE[ wpcd_get_cookie_name() ] );
}

/*
* Displying cookie value and form through shortcodes
*/
add_shortcode( 'cookie_demo', 'wpcd_show_cookie_result' );
function wpcd_show_cookie_result() {
	ob_start();
	if( wpcd_is_cookied() ) :
		echo 'Your most recent favorite food was ' . wpcd_get_cookie() . '!';
	else :
		echo 'You haven\'t yet told us your favorite food!';
	endif;
	return ob_get_clean();
}

add_shortcode( 'cookie_form', 'wpcd_show_cookie_form' );
function wpcd_show_cookie_form() {
	ob_start(); ?>
		<form method="post">
			<label for="name">Fave Food:<label><br><input type="text" name="fave_food" placeholder="Fave food?" />
			<p><input type="submit"></p>
		</form>
	<?php return ob_get_clean();
}