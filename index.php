<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// it will never let you open index(login) page if session is set
	if ( isset($_SESSION['user'])!="" ) {
		header("Location: home.php");
		exit;
	}
	
	$error = false;
	
	if( isset($_POST['btn-login']) ) {	
		
		// prevent sql injections/ clear user invalid inputs
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		// prevent sql injections / clear user invalid inputs
		
		if(empty($email)){
			$error = true;
			$emailError = "Please enter your email address.";
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		}
		
		if(empty($pass)){
			$error = true;
			$passError = "Please enter your password.";
		}
		
		// if there's no error, continue to login
		if (!$error) {
			
			$password = hash('sha256', $pass); // password hashing using SHA256
		
			$res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
			$row=mysql_fetch_array($res);
			$count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
			
			if( $count == 1 && $row['userPass']==$password ) {
				$_SESSION['user'] = $row['userId'];
				header("Location: home.php");
			} else {
				$errMSG = "Incorrect Credentials, Try again...";
			}
				
		}
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>unique foundation</title>
<link href="css/style.css" rel="stylesheet" />
</head>

<body style="">
	<div class="bodyTemplate" style="">
    	<div class="Header" style="">
        <a class="logo" href="#"><img src="images/logo.png" alt="Title" /></a>
        <h1 class="site-title">unique foundation</h1>
        </div> <!-- End Header -->
        <div class="d_test">if you could not fail and it's absolute guaranteed to happen what are the top four things you would do ?</div>
        
        <div class="select_oprion">
        	<div class="option">
            	<div class="number">1</div>
                <h1 class="BigTitle">Option 1</h1>
                <div style="clear:both"></div>
                <div class="righttext">
                    <ul>
                    	<li>- Detail about their choice</li>
                        <li>- multiple lines</li>
                    </ul>
                </div>
            </div>
            
            <div class="option even">
            	<div class="number">2</div>
                <h1 class="BigTitle">Option 2</h1>
                <div style="clear:both"></div>
                <div class="righttext">
                    <ul>
                    	<li>- Detail about their choice</li>
                        <li>- multiple lines</li>
                    </ul>
                </div>
            </div>
            
            <div class="option">
            	<div class="number">3</div>
                <h1 class="BigTitle">Option 3</h1>
                <div style="clear:both"></div>
                <div class="righttext">
                    <ul>
                    	<li>- Detail about their choice</li>
                        <li>- multiple lines</li>
                    </ul>
                </div>
            </div>
            
            <div class="option even">
            	<div class="number">4</div>
                <h1 class="BigTitle">Option 4</h1>
                <div style="clear:both"></div>
                <div class="righttext">
                    <ul>
                    	<li>- Detail about their choice</li>
                        <li>- multiple lines</li>
                    </ul>
                </div>
            </div>
            
            <div style="clear:both"></div>
            <?php
			if ( isset($errMSG) ) {
				
				?>
				<div class="ContactTitle"><span><?php echo $errMSG; ?></span></div>
                <?php
			}
			?>
            <div class="ContactTitle"><span>@ Save register @ Load login</span></div>
            <form class="contactform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
            <p><label>First name</label>
            <input type="text" name="fname" style="width:106px"/></p>
            <p><label>Surname</label>
            <input type="text" name="surname" style="width:116px" /></p>
            <p><label>Date of birth </label>
            <input type="text" name="dateb"  style="width:96px"/></p>
            <p><label>Gender</label>
            <select name="gender"><option value="male">Male</option><option value="female">Female</option></select></p>
            <p><label>Email </label>
            <input type="email" name="email" class="form-control" placeholder="Your Email" style="width:135px" value="<?php echo $email; ?>" maxlength="40" />
                <span class="text-danger"><?php echo $emailError; ?></span></p>
            <p><label>Password </label>
              <input type="password" name="pass" style="width:108px" class="form-control" placeholder="Your Password" maxlength="15" />
                <span class="text-danger"><?php echo $passError; ?></span></p>
            <div class="submit">
            	<input type="submit" value="Submit" />
            </div>
            </form>
        </div> <!--End Select Option-->
        <div class="clr" style="clear:both"></div>
    </div> <!--End Main Template -->
</body>
</html>
<?php ob_end_flush(); ?>