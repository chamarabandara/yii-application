<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>

</div>
<div class="sub">
	<?php echo CHtml::link('Back To Login',array('site/login')); ?>
			  <!-- <a href="admin/login">Back </a> -->
			</div>
<style type="text/css">
#content{
  text-align: center;
  font-size: medium;
  border-left: 1px solid #A2CF36;
  border-right: 1px solid #A2CF36;
}
.tab-right-top-corner {
  background-position: -49px -87px;
  width: 11px;
  height: 11px;
  margin-top: -12px;
}
.sub a {
  color: #fff;
  background: #272727;
  text-decoration: none;
  padding: 10px 20px;
  font-size: 13px;
  font-family: arial, serif;
  font-weight: bold;
  -webkit-border-radius: .5em;
  -moz-border-radius: .5em;
  -border-radius: .5em;
}
.sub {
  margin: 25px 0px 1px 0px;
  padding-bottom: 5px;
}
</style>