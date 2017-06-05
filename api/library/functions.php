<?php
	function sec_session_start() {
		$session_name = 'sec_session_id';   // Set a custom session name
		/*Sets the session name. 
			*This must come before session_set_cookie_params due to an undocumented bug/feature in PHP. 
		*/
		session_name($session_name);
		
		$secure = false;
		// This stops JavaScript being able to access the session id.
		$httponly = true;
		// Forces sessions to only use cookies.
		if (ini_set('session.use_only_cookies', 1) === FALSE) {
			exit();
		}
		// Gets current cookies params.
		$cookieParams = session_get_cookie_params();
		session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
		
		session_start();            // Start the PHP session 
		session_regenerate_id(true);    // regenerated the session, delete the old one. 
	}
	
	function login_check($conn) {
		// Check if all session variables are set 
		if (isset($_SESSION['token'],$_SESSION['username'],$_SESSION['login_string'])) {
			
			$token = $_SESSION['token'];			
			$login_string = $_SESSION['login_string'];
			$user_browser = $_SERVER['HTTP_USER_AGENT'];
			$sql="select * from accesstoken where token='$token'";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if(mysqli_num_rows($rs)<=0){
				return false;
				}else{
				$rc=mysqli_fetch_assoc($rs);
				$current=date('Y-m-d H:i:s');
				if($rc['expireDate']<$current){
					return false;
					}else{
					$login_check = hash('sha512', $token . $user_browser);
					//echo 'Current PHP version: ' . phpversion();
					if (hash_equals($login_check, $login_string)){
						// Logged In!!!! 
						//echo 'success';
						
						return true;
						} else {
						//echo 'fail';
						// Not logged in 
						return false;
					}
				}
			}
			}else {
			// Not logged in 
			return false;
		}
	}
?>