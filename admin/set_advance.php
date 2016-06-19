<!doctype html>
<html>
	<head>
		<meta charset = "utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">

		<title>Pay advanced</title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../css/style.css">
	</head>

	<body>
<nav class="navbar navbar-inverse navbar-static-top no-margin" roll="navigation"> <!-- navigation bar -->
			<div class="container-fluid"> <!-- reserve area for css fluid-for moved to left corner -->
				<div class="navbar-header">
				<!--	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> -->
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        
			      	</button>
					<a class="navbar-brand" href="">Thilanka Tea Collecting Center</a> <!-- for replace with image: <img src="path of the image file"> -->
				</div> 
				<!--</div>-->
				
					<!-- Collect the nav links, forms, and other content for toggling -->
	    			<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">  <!-- style="float:right; -->
				
						<ul class="nav navbar-nav nav-tabs"><!-- ul=url --><!-- and Tabs -->
							
							
							<li><a href="admin.html">Home</a></li><!--home nav-->
                            <li><a href="enter_data.php">Enetr data</a></li>
							<li><a href="set_advance.php">Pay Advance</a></li>
							<li><a href="bill_cal.php">Calculate Bill</a></li>
                                
							<li class="dropdown"><!--Request nav-->
		          				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Requests <b class="caret"></b></a>
		          				<ul class="dropdown-menu">
						            
						            <li role="separator" class="divider"></li>
						            <li><a href="view_fer_req.php">View fertilizer requests</a></li>
									
									 <li role="separator" class="divider"></li>
						            <li><a href="view_ad_req.php">View payment requests</a></li>
						            

		          				</ul>
		        			</li>

		        			<!--Start of the log out form-->
							<ul class="nav navbar-nav navbar-right">
						        <li><p class="navbar-text">Are you want to logout ?</p></li>
						        <li class="dropdown">
						          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Logout</b> <span class="caret"></span></a>
									<ul id="login-dp" class="dropdown-menu">
										<li>
											 <div class="row">
													<div class="col-md-12">
														Are you sure you want to log-out?
														
														 <form class="form" role="form" method="post" action="index.php">
																
													
															<li>
											        			<button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Logout</button>

																
															</li>

														
														 </form>


													</div>
													<div class="bottom text-center">
														Log as another user! <a href="index.php"><b>login As</b></a>
													</div>
													
											 </div>
										</li>
									</ul>
						        </li>
							</ul>
		        			<!--End of the log out form-->

						</ul>


					</div>

			</div>	

		</nav>
<!-- End of the navigation bar -->

<?php

require_once("../includes/initialize.php");

if(isset($_POST['submit'])){
	
	if(empty($_POST['cuz_id'])){
		$errors['cuz_id'] = "* Customer ID cannot be empty.";
	}
	if(empty($_POST['year_month'])){
		$errors['year_month'] = "* year month cannot be empty.";
	}elseif(!preg_match("/^[0-9]{6}$/",$_POST['year_month'])){
		$errors['year_month'] = "* Invalied year month.";
	}
	if(empty($_POST['ad'])){
		$errors['ad'] = "* ammount cannot be empty.";
	}

	
		if(empty($errors)){
			$cus_id=trim(mysql_prep($_POST['cuz_id']));
			$year_month=trim(mysql_prep($_POST['year_month']));
			$ad=trim(mysql_prep($_POST['ad']));
			
			$td=new Bill();
			$td->cus_id=$cus_id;
			$td->year_month=$year_month;
			$td->advanced=$ad;
			
			$result = mysql_query("SELECT * FROM user WHERE id='{$cus_id}' AND  privilege='Customer'");
			$rowExist = mysql_num_rows($result) > 0;
			$rslt="";
			
			if(!$rowExist){
				echo '<script language="javascript">';
				echo 'alert("error! Invalied Customer ID!")';
				echo '</script>';
			}else{
				$rslt=$td->enter_ad_data();
			}
			
			
			if($rslt) {
				echo '<script language="javascript">';
				echo 'alert("Data entered successfully")';
				echo '</script>';
				
			} else {
				echo '<script language="javascript">';
				echo 'alert("error! Cannot enter data!")';
				echo '</script>';
				
			}
			
				
		}

}else{
	$cuz_id="";
	$year_month="";
	$ad="";
}
?>


<div class="container">
	<div class="row">
		
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">

				<form class="navbar-form navbar-left" id="req_form" action="set_advance.php" method="post">
					<div class="form-group">
					    <label>Customer ID</label><br><input type="text" id="cus_id" name="cuz_id" class="form-control" placeholder="Ex.: 003"><br><br>
						<h6><?php if(isset($errors['cuz_id'])) echo $errors['cuz_id']; ?></h6>
					</div>
					<div class="form-group">
						<label>year & month:</label><br><input type="date" id="date" name="year_month" class="form-control" placeholder="Ex.: 201509"><br><br>
						<h6><?php if(isset($errors['year_month'])) echo $errors['year_month']; ?></h6>
					</div>

					<div class="form-group">
						<label>Advanced payment ammount:</label><br><input type="text" id="quan" name="ad" class="form-control" placeholder="Rs. "><br><br>
						<h6><?php if(isset($errors['ad'])) echo $errors['ad']; ?></h6>
					</div>
					
					<div>
					<button type="submit" class="btn btn-primary" name="submit">Pay advanced payment</button>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>


</div>


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