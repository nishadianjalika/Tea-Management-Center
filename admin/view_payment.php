<!doctype html>
<html>
	<head>
		<meta charset = "utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">

		<title>Payment Details</title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../css/style.css">
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
					<a class="navbar-brand" href="view_payment.php">View Payment Details</a> <!-- for replace with image: <img src="path of the image file"> -->
				</div> 
				<!--</div>-->
				
					<!-- Collect the nav links, forms, and other content for toggling -->
	    			<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">  <!-- style="float:right; -->
				
					<ul class="nav navbar-nav nav-tabs"><!-- ul=url --><!-- and Tabs -->
							
							<li><a href="admin.php">Home</a></li>

							<li class="dropdown">
		          				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Requests <b class="caret"></b></a>
		          				<ul class="dropdown-menu">
		            				<li><a href="fertilizer_req.php">Fertilizer request</a></li>
		            				<li><a href="advance_payment_req.php">Advance payment request</a></li>
						            
						            <li role="separator" class="divider"></li>
						            <li><a href="view_fer_req.php">View your fertilizer requests</a></li>
                                    
                                    <li role="separator" class="divider"></li>
						            <li><a href="view_ad_req.php">View your advance requests</a></li>
                                    
		          				</ul>
		        			</li>

		        			<li><a href="contact.html">Contact</a></li>
							<li><a href="about.html">About us</a></li>
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
<p class="head" > Payment Details...  <p\>
<br>
<br>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "t_center";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $dbname);
if(isset($_POST['delete'])){
$Deletequery = "DELETE FROM payment WHERE cus_id='$_POST[hidden]'";
mysqli_query($connection,$Deletequery);
};

if(isset($_POST['Update'])){
$Updatequery = "UPDATE payment SET cus_id='$_POST[id]',year_month='$_POST[year_month]',total_weight='$_POST[total_weight]',rate='$_POST[rate]',value='$_POST[value]',advanced='$_POST[advanced]',loan='$_POST[loan]' WHERE cus_id='$_POST[hidden]'";

mysqli_query($connection,$Updatequery);
};

$select = "SELECT * FROM payment";
$result = mysqli_query($connection, $select);



if (mysqli_num_rows($result) > 0) {
	// print table heads
	echo ("<table border=3 class=payment>
	
		<tr>
			<th>Customer ID</th>
			<th>Year & Month</th>
			<th>Total Weight</th>
			<th>Rate</th>
			<th>Value</th>
			<th>Advance</th>
			<th>Loan</th>
			<th>Payable Amount</th>
			
						
		</tr>");
		
    // output data from row by row
    while($record = mysqli_fetch_array($result)) {
    	echo "<form action=view_payment.php method=post>";
		echo "<tr>";
		echo "<td>" . "<input type=text value=" . $record["cus_id"] . " </td>";
		echo "<td>" . "<input type=text value=" . $record["year_month"] . " </td>";
		echo "<td>" . "<input type=text value=" . $record["total_weight"] . " </td>";
		echo "<td>" . "<input type=text value=" . $record["rate"] . " </td>";
		echo "<td>" . "<input type=text value=" . $record["value"] . " </td>";
		echo "<td>" . "<input type=text value=" . $record["advanced"] . " </td>";
		echo "<td>" . "<input type=text value=" . $record["loan"] . " </td>";
		echo "<td>" . "<input type=text value=" . $record["payble"] . " </td>";
		//echo "<td>" . "<input type=hidden name=hidden value=" . $record["cus_id"] . " </td>";
		//echo "<td>" . "<input type=submit name-Edit value=Edit " . " </td>";
		//echo "<td>" . "<input type=submit name-delete value=delete " . " </td>";
		echo "</tr>";
		echo "</form>";
    }
echo ("</table>");
} 

else {
    echo "0 results";
}


/*require_once("../includes/initialize.php");
require_once("../includes/bill.php");
require_once("../includes/t_data.php");

	echo "<div class=\"row\">
		

		<div class=\"col-md-12\">
			<div class=\"panel panel-default\">
				<div class=\"panel-body\">";
				
			echo "<div class=\"container\">
					<h2>Payment Details</h2>
						            
					<table class=\"table\">
				<thead>
				
				 <tr>
					<th>Customer ID</th>
					<th>Year & Month</th>
					<th>Total Weight</th>
					<th>Rate</th>
					<th>Value</th>
					<th>Advance</th>
					<th>Loan</th>
					<th>Payable Amount</th>
					
				</tr>
				</thead>
				<tbody>";
				
				$result=Bill::find_all();
				foreach ($result as $record){
				
				echo "<tr><td>";				
				echo $record->cus_id."</td><td>";
				echo $record->year_month."</td><td>";
				echo $record->total_weight."</td><td>";
				echo $record->rate."</td><td>";
				echo $record->value."</td><td>";
				echo $record->advanced."</td><td>";
				echo $record->loan."</td><td>";
				echo $record->payble."</td><td>";

								
				$idn=$st->req_id;
				echo "<a href='edit_fer_req.php?id=$idn'><h4>Edit Request</h4></a></td><td>";
				echo "<a href='del_fer_req.php?id=$idn'><h4>Cancel Request</h4></a></td>";
				echo "<br/></tr>";
				}*/
				
			
			echo "</tbody>
				</table>
				</div>";
		echo "</div>
			</div>
		</div>
	</div>";
			
		

?>


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