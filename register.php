<!doctype html>
<html>
	<head>
		<meta charset = "utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">

		<title>Sign in</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		
	</head>

	<body>
		
<!-- start of the navigation bar -->

		<nav class="navbar navbar-inverse navbar-static-top" roll="navigation"> <!-- navigation bar -->
			<div class="container-fluid"> <!-- reserve area for css fluid-for moved to left corner -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        
			      	</button>
					<a class="navbar-brand" href="#">Enter Your Details Here</a> <!-- for replace with image: <img src="path of the image file"> -->
				</div> 
				<!--</div>-->
				
					<!-- Collect the nav links, forms, and other content for toggling -->
	    			<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">  <!-- style="float:right; -->
				
						<ul class="nav navbar-nav nav-tabs"><!-- ul=url --><!-- and Tabs -->
							<li><a href="mainwindow.html">Home</a></li>
							
							<li><a href="about.html">About</a></li>
							<li><a href="contact.html">Contact</a></li>

							<li class="dropdown">
		          				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
		          				<ul class="dropdown-menu">
		            				<li><a href="#">link1</a></li>
		            				<li><a href="#">link2</a></li>
		            				<li><a href="#">link3</a></li>
						            
						            <li role="separator" class="divider"></li>
						            <li><a href="#">Separated link1</a></li>
						            
						            <li role="separator" class="divider"></li>
						            <li><a href="#">Separated link12</a></li>

		          				</ul>
		        			</li>
						</ul>


					</div>	
			</div>	
		</nav>
<!-- End of the navigation bar -->


<!-- php walin db connect karanna yanne-->
<?php

require('config.php');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "t_center";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


if(isset($_POST['submit'])){

	//varifications
	$email = $_POST['email'];
	$confirmemail=$_POST['confirmemail'];
	$password=$_POST['password'];
	$confirmpassword=$_POST['confirmpassword'];
	$privilage=$_POST['privilage'];
	$nic=$_POST['nic'];

	if($email==$confirmemail){
		if($password==$confirmpassword){
			//all good
			$firstname = mysql_real_escape_string($_POST['firstname']);
			$lastname = mysql_real_escape_string($_POST['lastname']);
			$username = mysql_real_escape_string($_POST['username']);
			$nic = mysql_real_escape_string($nic);
			$privilage = mysql_real_escape_string($privilage);
			$contactnumber = mysql_real_escape_string($_POST['contactnumber']);
			$email = mysql_real_escape_string($email);
			$password = mysql_real_escape_string($password);
			$contact_no=mysql_real_escape_string($_POST['contactnumber']);
			
			$password = md5($password);//this for the secure the password

			/*$sql = mysql_query("SELECT * FROM 'users' WHERE 'username'= '$username'");
			$num_rows=mysql_num_rows($sql);
			echo $num_rows;
			if($num_rows>0){
				echo "username already exist.!";
				exit();
			}*/
			//$query = mysqli_query($conn, "SELECT * FROM users WHERE username='".$username."'");

	        /*if(mysqli_num_rows($query) != 0){

	            echo "username already exists";
	        }else{
	            
	            
	        }*/
	        $sql = "INSERT INTO user (id, f_name, l_name, username, nic, password, privilege, contact_no, email) VALUES (NULL, '$firstname', '$lastname', '$username', '$nic', '$password', '$privilage', '$contact_no', '$email')";

				if ($conn->query($sql) === TRUE) {
				    echo "New record created successfully<br><br>";
				    echo "You can sign in to the site by using your username and the password<br>";
				} else {
				    echo "Error: " . $sql . "<br>" . $conn->error;
				}
				$conn->close();
				//mysql_query("INSERT INTO 'users' ('userid', 'firstname', 'lastname', 'username', 'email', 'password') VALUES (NULL, '$firstname', '$lastname', '$username', '$email', '$password')") or die(mysql_error());

			
		}else{
			echo "Your password is do not match.<br>";
			//header("Location:register.php");
			//exit();
		}
	}else{
		echo "Your email is do not match.<br>";
	}


}else{
	
$form = <<<EOT

<div class="container">
	<div class="row">
		

		<div class="col-md-7">
			<div class="panel panel-default">
				<div class="panel-body"><!--kotuwak athulata daganne me widiyata-->

					<!--form eke code eka copy paste karnna ona. see 21st video-->
				<form class="navbar-form navbar-left" id="registerForm" action="register.php" method="post">
  					<div class="form-group">
					    <input type="text" id="nameF" name="firstname" class="form-control" placeholder="First name">
					    <input type="text" id="nameF" name="lastname" class="form-control" placeholder="Last name">
					    <input type="text" id="textF" name="username" class="form-control" placeholder="username"><br>
					    <input type="text" id="textF" name="nic" class="form-control" placeholder="NIC"><br>


					    <div class="styleSelect" class="dropdown">
						  <select class="units" name="privilage">
						    <option value="Administrator">Administrator</option>
						    <option value="Customer">Customer</option>
						    
						  </select>
						</div>
					   				

					    <input type="text" id="textF" name="contactnumber" class="form-control" placeholder="Contact Number"><br>
					    <input type="email" id="textF" name="email" class="form-control" placeholder="Emai address"><br>
					    <input type="email" id="textF" name="confirmemail" class="form-control" placeholder="Re-Enter Email address"><br>
					    <input type="password" id="textF" name="password" class="form-control" placeholder="Password"><br>
					    <input type="password" id="textF" name="confirmpassword" class="form-control" placeholder="Confirm Password">
					    
					</div>
					
					<button type="submit" class="btn btn-primary" name="submit">Register</button>
					
				</form>


				</div>
			</div>
		</div>
	</div>


</div>


EOT;

echo $form;


}

?>
<!-- php walin db connect-->

<!-- End of the Forms -->

<!-- start of the footer -->
<footer class="site-footer">
	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<h4>Contact Address</h4>
				<address>
					Thilanka Tea Collecting Center,<br> Warakapalahena,<br> Nakiyadeniya,<br> Galle.

				</address>

			</div>
			
		</div>
		<div class="bottom-footer">
			<div class="col-md-5">@ Copyright Thilanka Tea Center 2015.</div>
			<div class="col-md-7">
				<ul class="footer-nav">
					<li><a href="mainwindow.html">Index</a></li>
					
					<li><a href="contact.html">Contact</a></li>
					<li><a href="about.html">About Us</a></li>
				</ul>	
			</div>
		</div>
	</div>
	

</footer>

<!-- End of the footer -->

		<script type="text/javascript" src = "js/jquery.js"> </script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</body>
</html> 