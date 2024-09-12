<?php 
session_start();
include_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<noscript>
<meta http-equiv="refresh" content="0; URL=nojavascript.php">
</noscript>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>RRC</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
        
		<script src="js/jquery-3.1.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery-ui.min.css">

		<link rel="stylesheet" type="text/css" href="css/jquery.datepick.css"> 
		<script type="text/javascript" src="js/jquery.plugin.js"></script> 
        <script type="text/javascript" src="js/jquery.datepick.js"></script>

		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">
	</head>
	<body oncontextmenu="return false;">
<style>
	.navbar-collapse ul li.dropdown:hover ul.dropdown-menu {
		display: block;
	}
	.navbar-collapse ul li ul li a{
		padding: 6px 15px;
	}
	.navbar-collapse ul li ul li{
		border-right: 0;
	}
	.navbar-collapse ul li ul{
		border-right: 0;
		background: -webkit-linear-gradient(#185086, #092f61);
		background: -o-linear-gradient(#185086, #092f61);
		background: -moz-linear-gradient(#185086, #092f61);
		background: linear-gradient(#185086, #092f61);
	}
	
	.wrap{
		float: left;
    margin: 13px;
}
 .wrap h4{
	color: #000 !important;
	font-size: 18px !important;
}
	
.container{
	padding-left: 0;
	padding-right: 0;
}	
	
</style>
<div class="wrapper">
<div id="masthead">  
  <div class="container">
  
  	<!-- <img src="images/top-stip.png" class="img-responsive"> -->
	<div class="text-center" style=" background: #fff;overflow: hidden;width: 100%; height: 40px;display: flex;
    align-items: center;
    justify-content: space-between;">
	  <div>
	  <div class="wrap">
	  <h3 class="text-left">CSBC</h3>
	</div> 
	  </div>

 </div>
  <div class="container">
    <nav class="collapse navbar-collapse" role="navigation">


      <ul class="nav navbar-right navbar-nav">

         
		<li style="padding-right: 10px;">
          <a href="<?php if(empty($_SESSION['jk_conuser'])):?>logout.php<?php endif;?>" style=" font-weight: 600">Logout</a>
        </li> 

        <li class="dropdown">
          <ul class="dropdown-menu" style="padding:12px;">
            <form class="form-inline">
              <button type="submit" class="btn btn-default pull-right"><i class="glyphicon glyphicon-search"></i></button><input type="text" class="form-control pull-left" placeholder="Search">
            </form>
          </ul>
        </li>
      </ul>
      
    </nav>
  </div>

  
</div>



