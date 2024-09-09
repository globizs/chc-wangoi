<?php

use yii\helpers\Html;

?>

<nav class="navbar navbar-expand navbar-light bg-white mb-2 topbar static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fas fa-bars text-muted"></i>
    </button>
    <ul class="navbar-nav" style="margin-left: auto !important;">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-2x"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a herf="#!" class="dropdown-item"><?= Yii::$app->user->identity->username ?></a>
                <?= Html::a('<i class="fas fa-lock fa-sm fa-fw mr-2 text-muted"></i>Change password', ['/site/change-password'], ['class' => 'dropdown-item openModal', 'size' => 'sm', 'header' => 'Change password']) ?>
                <div class="dropdown-divider"></div>
                <?= Html::a('<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-muted"></i>Logout', ['/site/logout'], ['data-method' => 'post', 'class' => 'dropdown-item']) ?>
            </div>
        </li>
    </ul>
</nav>
