<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '爱阅技术团队',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-jue',
        ],
    ]);
    $menuLeftItems = [
        ['label' => '最新文章', 'url' => ['/site/index']],
        ['label' => '文章归档', 'url' => ['/site/achieve']],
        ['label' => '关于我们', 'url' => ['/site/about']],
        ['label' => '技术沙龙', 'url' => ['/site/salon']],
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-menu'],
        'items' => $menuLeftItems,
    ]);

    // $menuSearchItems[] = '<li class="navbar-item search navbar-search">'
    //         . Html::beginForm(['www.baidu.com'], 'post', ['class' => 'search-form'])
    //         . Html::input('text', 'search-form', '', ['placeholder' => '搜索云思', 'class' => 'search-input'])
    //         .Html::img('//gold-cdn.xitu.io/v3/static/img/juejin-search-icon.6f8ba1b.svg', ['alt' => '搜索', 'class' => 'searc-icon'])
    //         . Html::endForm()
    //         . '</li>';
    // echo Nav::widget([
    //     'options' => ['class' => 'navbar-nav'],
    //     'items' => $menuSearchItems,
    // ]);
    NavBar::end();
    ?>

    <div class="jue-content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
   <div class="ft"><span>&copy; <?= date('Y') ?> 美团点评技术团队</span><br><span>All rights resiverd</span></div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
