<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<div class="webserves-view-title"><h1>Welcome to <?php echo CHtml::encode(Yii::app()->name); ?> web service listing</h1>

<p>click on each url to access related webservice. You can change the id,date parameters in the url manually to demonstrate the functionality.</p>

<ol>
<li>Get Advertisement List: <tt><small><a href="<?php echo Yii::app()->params['couponlist'] ?>"><?php echo Yii::app()->params['couponlist'] ?></a></small></tt></li>
<li>Get Advertisement Detail: <tt><small><a href="<?php echo Yii::app()->params['coupondetail'] ?>"><?php echo Yii::app()->params['coupondetail'] ?></a></small></tt></li>
<li>Get Advertisement Locations: <tt><small><a href="<?php echo Yii::app()->params['couponlocations'] ?>"><?php echo Yii::app()->params['couponlocations'] ?></a></small></tt></li>
<li>Get Weather Pages: <tt><small><a href="<?php echo Yii::app()->params['weatherpages'] ?>"><?php echo Yii::app()->params['weatherpages'] ?></a></small></tt></li>
<li>Get Advertisement All Detail: <tt><small><a href="<?php echo Yii::app()->params['couponalldetail'] ?>"><?php echo Yii::app()->params['couponalldetail'] ?></a></small></tt></li>
<li>Analytics: <tt><small><a href="<?php echo Yii::app()->params['hostname'] ?>/LogInfoReceiver/index.php/p/1/ci/2/sci/3/aid/140/f/1/di/0001/ts/1349926177/v/1/cid/1/"><?php echo Yii::app()->params['hostname'] ?>/LogInfoReceiver/index.php/p/1/ci/2/sci/3/aid/140/f/1/di/0001/ts/1349926177/v/1/cid/1/</a></small></tt></li>

</ol>
</div>
