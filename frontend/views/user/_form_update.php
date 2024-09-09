<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<?php $form = ActiveForm::begin(['id' => 'app-form']); ?>

<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

<?php if($id != 1) { ?>
	<?= $form->field($model, 'status')->radioList([10 => 'Active', 9 => 'Inactive']) ?>
<?php } ?>

<?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'reset_password')->checkbox() ?>

<div id="new_password">
	<?= $form->field($model, 'new_password', ['template' => '{label}<div class="input-group">{input}<span class="input-group-addon viewpass"><i class="fas fa-eye-slash"></i></span></div>{error}{hint}'])->passwordInput(['maxlength' => true]) ?>	
</div>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'id' => 'submit-btn']) ?>
</div> 

<?php ActiveForm::end(); ?>

<style type="text/css">
#new_password {
	display: none;
}
.viewpass {
	cursor: pointer;
}

</style>

<?php
$this->registerJs(<<<JS
$("#signupform-reset_password").change(function() {
	$("#new_password").slideToggle();
});

$(".viewpass").click(function() {
	let type = $("#signupform-new_password").attr("type");
	if(type === 'text') {
		$("#signupform-new_password").attr("type", "password");
		$(".fa-eye").addClass("fa-eye-slash");
		$(".fa-eye").removeClass("fa-eye");
	} else {
		$("#signupform-new_password").attr("type", "text");
		$(".fa-eye-slash").addClass("fa-eye");
		$(".fa-eye-slash").removeClass("fa-eye-slash");
	}
});
JS
);
