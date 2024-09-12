<?php
ob_start();
require_once "header.php";

if(isset($_POST['submit']) && $_POST['submit']=='Login') {

		$sql = "SELECT * FROM userinfo WHERE username='".$_POST['email']."' AND password='".$_POST['password']."' ";
		$results=mysqli_query($dbhandle,$sql);
		
		$result = mysqli_fetch_assoc($results);
		//echo "<pre>";print_r($result);die;
		if(!empty($result)){
			$_SESSION['jk_conuser'] = $result['regid'];
			$_SESSION['jk_conuser_email'] = $_POST['email'];
			$_SESSION['jk_con'] = true;
			$_SESSION['loginid'] = $result['id'];
			echo "<script>window.location='certificates_verification.php';</script>";
		} 
		else {
			echo "<script>window.location='login.php?action=fail';</script>";
		}
}
?>
	<div class="container index">
	   <div class="container containerfff">
	      <div class="row">
	         <div class="col-md-12">
	            <div class="panel">
	               <div class="panel-body">
	                  <div class="login-page">
	                     <div style="text-align: center; color:red">
							<?php
								if(isset($_GET['action']) AND $_GET['action']=="fail") {
									echo "Login Failed";
								} 
								?>
						 </div>
	                     <div class="form form-log" style="box-shadow: 0 0 5px 1px #e4e2e2;">
	                        <p class="member" style="font-weight: 600;">User Login</p>
	                        <div class="message"></div>
	                        <br>
	                        <form class="login-form" id="login-form" method="post" novalidate="novalidate">
	                           <input type="email" id="email" name="email" placeholder="Username" autocomplete="off" required="" aria-required="true">
	                           <input type="password" id="password" name="password" placeholder="**********" autocomplete="off" required="" aria-required="true">
	                           <button type="submit" name="submit" class="login" value="Login">Login</button>
	                           <!-- 	<div class="pull-right" style="margin-top:10px;">
										<a  style="color:red; text-decoration: underline" href="forgotpassword.php" id="forgot_id" >Forgot Password?</a>
								</div> -->
	                        </form>
	                     </div>
	                  </div>
	               </div>
	            </div>
	         </div>
	      </div>
	   </div>
	</div>
<?php
require_once "./footer.php";

?>

