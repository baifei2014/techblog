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
        'brandLabel' => 'Cloudxink',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-jue navbar-dynamic-top',
        ],
    ]);
    $menuLeftItems = [
        ['label' => '首页', 'url' => ['/site/index']],
        ['label' => '专栏', 'url' => ['/site/adfrom']],
        ['label' => '收藏集', 'url' => ['/site/layui']],
        ['label' => '发现', 'url' => ['/order/index']],
        ['label' => '开源库', 'url' => ['/site/contact']],
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $menuLeftItems,
    ]);

    $menuSearchItems[] = '<li class="navbar-item search navbar-search">'
            . Html::beginForm(['www.baidu.com'], 'post', ['class' => 'search-form'])
            . Html::input('text', 'search-form', '', ['placeholder' => '搜索云思', 'class' => 'search-input'])
            .Html::img('//gold-cdn.xitu.io/v3/static/img/juejin-search-icon.6f8ba1b.svg', ['alt' => '搜索', 'class' => 'searc-icon'])
            . Html::endForm()
            . '</li>';
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuSearchItems,
    ]);

    if (Yii::$app->user->isGuest) {
        $menuRightItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuRightItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuRightItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuRightItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>