<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';

?>

<div class="panel panel-primary">
	<div class="panel-heading">Logowanie</div>
	<div class="panel-body">
		<div class="form">
			
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php echo $form->error($model,'username'); ?></span>

	<div class="input-group" style="margin-bottom: 15px;">
		<span class="input-group-addon">Login</span>
		<?php echo $form->textField($model,'username', array('class'=>'form-control')); ?>
	</div>

	<?php echo $form->error($model,'password'); ?></span>
		
	<div class="input-group">
		<span class="input-group-addon">Hasło</span>
		<?php echo $form->passwordField($model,'password', array('class'=>'form-control')); ?>
	</div>

		</div>
	</div>
	<div class="panel-footer" style="text-align: center;">
		<p>
			<button type="submit" class="btn btn-primary single-btn">Zaloguj</button>
		</p>
	</div>
<?php $this->endWidget(); ?>
</div>
