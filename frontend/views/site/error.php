<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
echo Html::cssFile('@web/frontend/web/statics/css/error.css');
?>
<div class="site-e">
    <div class="site-errorimg">
        <img src="/frontend/web/statics/image/bg.1f516b3.png" class="error-back">
        <img src="/frontend/web/statics/image/panfish.9be67f5.png" class="error-fish">
        <img src="/frontend/web/statics/image/sea.892cf5d.png" class="error-sea">
        <img src="/frontend/web/statics/image/spray.bc638d2.png" class="error-spay">
        <a href="/" class="back-index">返回首页</a>
    </div>
</div>
