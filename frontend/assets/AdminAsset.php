<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath='@bower/startbootstrap-sb-admin-2';
    public $baseUrl = '@web';

    public $css=[
        // 'startbootstrap-sb-admin-2/css/sb-admin-2.css',
        'vendor/fontawesome-free/css/all.min.css',
        'vendor/fontawesome-free/css/fontawesome.min.css',
        // 'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i',
        'css/sb-admin-2.min.css'
    ];

    public $js=[
        'vendor/jquery-easing/jquery.easing.min.js',
        // 'startbootstrap-sb-admin-2/js/sb-admin-2.min.js',
        // 'https://kit.fontawesome.com/a52a0ed3a8.js',
    ];

    public $depends = [
        // 'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
    ];

    public function init() {
        parent::init();
    }
}
