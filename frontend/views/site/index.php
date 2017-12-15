<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = '首页-云思技术团队';
echo Html::cssFile('@web/statics/css/index.css');
?>
<div class="taglk_header">
	<span class="pull-left">最新文章</span>

	<form class="search">
		<input type="text" name="搜索">
		<img class="searc-icon" src="//gold-cdn.xitu.io/v3/static/img/juejin-search-icon.6f8ba1b.svg" alt="搜索" >
	</form>
</div>
<div class="post-list">
	<div>
		<article class="post post-with-tags">
			<header class="post-title">
				<a href="">智能分析最佳实践——指标逻辑树</a>
			</header>
			<div class="post-meta">
				<span class="post-meta-author">蒋龙豪</span>
				<span class="post-meta-ctime">2017-12-04</span>
			</div>
			<p class="post-abstract"></p>
			<footer class="post-tags"></footer>
		</article>
	</div>
</div>

