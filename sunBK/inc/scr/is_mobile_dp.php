<?php
/****************************************************************
* Switch template for smart phone
****************************************************************/
/* Check the User-Agent */
function is_mobile_dp(){
	if (is_admin())return;

	global $IS_MOBILE_DP;
	
	$arr_useragent = array(
		'iPhone', 			// iPhone
		'iPod', 			// iPod touch
		'Windows Phone',	// Windows Phone
		'dream', 			// Pre 1.5 Android
		'CUPCAKE', 			// 1.5+ Android
		'blackberry9500', 	// Storm
		'blackberry9530', 	// Storm
		'blackberry9520', 	// Storm v2
		'blackberry9550', 	// Storm v2
		'blackberry9800', 	// Torch
		'webOS', 			// Palm Pre Experimental
		'incognito', 		// Other iPhone browser
		'webmate' 			// Other iPhone browser
	);
	$pattern = '/'.implode('|', $arr_useragent).'/i';
	$result = preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);

	// Check Android device
	if (!$result) {
		// For Android mobile
		$arr_useragent = array('Android', 'Mobile');
		$pattern = '/^.*(?=.*'.implode(')(?=.*', $arr_useragent).').*$/i';
		$result = preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
	}
	$IS_MOBILE_DP = $result;
	return $IS_MOBILE_DP;
}
?>