<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>


<!--META-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Form</title>

<!--STYLESHEETS-->
<?php
 echo $this->Html->css(array('login.css'));
 echo $this->Html->script(array('jquery.min.js'));
         
         ?>

<!--SCRIPTS-->
<!--Slider-in icons-->
<script type="text/javascript">
$(document).ready(function() {
	$(".username").focus(function() {
		$(".user-icon").css("left","-48px");
	});
	$(".username").blur(function() {
		$(".user-icon").css("left","0px");
	});
	
	$(".password").focus(function() {
		$(".pass-icon").css("left","-48px");
	});
	$(".password").blur(function() {
		$(".pass-icon").css("left","0px");
	});
});
</script>

</head>
<body>

<!--WRAPPER-->
<div id="wrapper">

	<!--SLIDE-IN ICONS-->
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
    <!--END SLIDE-IN ICONS-->

<!--LOGIN FORM-->

<form action="/ladybird/users/login" class="login-form" id="UserLoginForm" method="post" accept-charset="utf-8">

	<!--HEADER-->
    <div class="header" align="right">
    <!--TITLE<h1>Login Form</h1><!--END TITLE-->
    <!--TITLE--><h1 style="text-align: right;font-family:BMorvarid,BYekan, Tahoma, Arial, sans-serif">ورود به سیستم</h1><!--END TITLE-->
    <!--DESCRIPTION<span>Fill out the form below to login to your control panel.</span><!--END DESCRIPTION-->
    <!--DESCRIPTION--><span style="text-align: right;font-family:BMorvarid,BYekan, Tahoma, Arial, sans-serif">برای ورود به سیستم فرم زیر را پر کنید</span><!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->
	
	<!--CONTENT-->
    <div class="content" align="right">
	<!--USERNAME--><input name="data[User][username]" type="text" class="input username" value="نام کاربری" onfocus="this.value=''" style="text-align:right" style="font-family:BMorvarid, BYekan, Tahoma, Arial, sans-serif;"/><!--END USERNAME-->
    <!--PASSWORD--><input name="data[User][password]" type="password" class="input password" value="کلمع عبور" onfocus="this.value=''" style="text-align:right" /><!--END PASSWORD-->
    </div>
    <!--END CONTENT-->
    
    <!--FOOTER-->
    <div class="footer">
    <!--LOGIN BUTTON--><input type="submit" name="submit" value="ورود" class="button" style="font-family:BMorvarid, BYekan, Tahoma, Arial, sans-serif;"/><!--END LOGIN BUTTON-->
    </div>
    <!--END FOOTER-->

</form>
<!--END LOGIN FORM-->

</div>
<!--END WRAPPER-->

<!--GRADIENT--><div class="gradient"></div><!--END GRADIENT-->

</body>
</html>












<!--<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
    <?php
        echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login'));?>
</div>-->
