<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->pageTitle; ?></title>
<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/admin/atlanta.global.css');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/common.js');
?>

<script language="javascript"  type="text/javascript">
function CheckLoginUser(txtUserName,txtPassword,spnUserName,spnPassword,spnInvalid,trerror){
	txtUserName = document.getElementById("txtUserName");
	txtPassword = document.getElementById("txtPassword");
	spnInvalid = document.getElementById("spnInvalid");
	trerror = document.getElementById("trerror");
	if (txtUserName.value == "" && txtPassword.value == ""){
			txtUserName.style.background = "#ff9f9f";
			txtPassword.style.background = "#ff9f9f";
			error.style.visibility = "";
		}
	else if (txtUserName.value == ""){
			txtUserName.style.background = "#ff9f9f";
			txtPassword.style.background = "#fff";
			error.style.visibility = "";
		}
	else if (txtPassword.value == ""){
			txtPassword.style.background = "#ff9f9f";
			txtUserName.style.background = "#fff";
			error.style.visibility = "";
		}
	else if (txtUserName.value == "robin" && txtPassword.value == "123")
		{
			window.location.href = "qr-search-coupon.html";
		}
	else if (txtUserName.value == "chris" && txtPassword.value == "123")
		{
			window.location.href = "m-search-coupon.html";
		}
	else
		{
			txtUserName.style.background = "#ff9f9f";
			txtPassword.style.background = "#ff9f9f";
			txtUserName.value = "";
			txtPassword.value = "";

		}
	}

</script>
</head>

<body>
<div class="middler"></div>
 <?php if(Yii::app()->user->hasFlash('success')):?>
            <div class="info">
               <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
            <?php endif; ?>
<div class="login-wrapper">
    <?php echo $content; ?>    
</div>
</body>
</html>