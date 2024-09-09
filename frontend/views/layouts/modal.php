<?php

use yii\bootstrap5\Modal;

Modal::begin([
  'id'=>'modal-sm',
  'size'=>'modal-sm',
  'clientOptions'=>['backdrop'=>'static'],
  'title' => '<div class="header-text"></div>',
  'closeButton' => ['class' => 'btn-close', 'data-bs-dismiss' => 'modal', 'label' => '']  // <- required for bootstrap 5
]);
echo '<div id="modal-sm-loader" style="display: none;">';
echo $this->render('loader-modal.php');
echo '</div><div id="modal-sm-body"><br><br></div>';
Modal::end();

Modal::begin([
  'id'=>'modal-md',
  'size'=>'modal-md',
  'clientOptions'=>['backdrop'=>'static'],
  'title' => '<div class="header-text"></div>',
  'closeButton' => ['class' => 'btn-close', 'data-bs-dismiss' => 'modal', 'label' => '']  // <- required for bootstrap 5
]);
echo '<div id="modal-md-loader" style="display: none;">';
echo $this->render('loader-modal.php');
echo '</div><div id="modal-md-body"><br><br></div>';
Modal::end();

Modal::begin([
  'id'=>'modal-lg',
  'size'=>'modal-lg',
  'clientOptions'=>['backdrop'=>'static'],
  'title' => '<div class="header-text"></div>',
  'closeButton' => ['class' => 'btn-close', 'data-bs-dismiss' => 'modal', 'label' => '']  // <- required for bootstrap 5
]);
echo '<div id="modal-lg-loader" style="display: none;">';
echo $this->render('loader-modal.php');
echo '</div><div id="modal-lg-body"><br><br></div>';
Modal::end();

Modal::begin([
  'id'=>'modal-xl',
  'size'=>'modal-xl',
  'clientOptions'=>['backdrop'=>'static'],
  'title' => '<div class="header-text"></div>',
  'closeButton' => ['class' => 'btn-close', 'data-bs-dismiss' => 'modal', 'label' => '']  // <- required for bootstrap 5
]);
echo '<div id="modal-xl-loader" style="display: none;">';
echo $this->render('loader-modal.php');
echo '</div><div id="modal-xl-body"><br><br></div>';
Modal::end();
