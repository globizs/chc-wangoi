<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<?php $form = ActiveForm::begin(['id' => 'app-form']); ?>

<div class="row">
	<div class="col-md-6">
		<?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>
	</div>
	<div class="col-md-6">
		<?= $form->field($model, 'password', ['template' => '{label}<div class="input-group">{input}<span class="input-group-addon viewpass"><i class="fas fa-eye-slash"></i></span></div>{error}{hint}'])->passwordInput(['maxlength' => true]) ?>
	</div>
</div>

<?= $form->field($model, 'permissions')->checkBoxList($permissions)->label(false) ?>

<div class="form-group">
    <?= Html::submitButton('Add User', ['class' => 'btn btn-success', 'id' => 'submit-btn']) ?>
</div>

<?php ActiveForm::end(); ?>

<style type="text/css">
.viewpass {
	cursor: pointer;
}
#signupform-permissions label {
	width: 30%;
}
</style>

<?php
$this->registerJs(<<<JS
$(".viewpass").click(function() {
	let type = $("#signupform-password").attr("type");
	if(type === 'text') {
		$("#signupform-password").attr("type", "password");
		$(".fa-eye").addClass("fa-eye-slash");
		$(".fa-eye").removeClass("fa-eye");
	} else {
		$("#signupform-password").attr("type", "text");
		$(".fa-eye-slash").addClass("fa-eye");
		$(".fa-eye-slash").removeClass("fa-eye-slash");
	}
});
JS
);
