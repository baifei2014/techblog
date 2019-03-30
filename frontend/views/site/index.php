<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */

$this->title = '首页-爱阅技术团队';
echo Html::cssFile('@web/frontend/web/statics/css/index.css');
?>
	<div class="taglk_header">
		<span class="pull-left">最新文章</span>

		<form class="search">
			<input type="text" name="keyword">
			<img class="searc-icon" src="https://tech.meituan.com/img/search_icon.png" alt="搜索" >
		</form>
	</div>
	<div class="post-list">
		<div>
	        <?php foreach($articals as $artical){ ?>
			<article class="post post-with-tags">
				<header class="post-title">
					<a href="/<?php echo $artical['id'] ?>.html"><?php echo $artical['title']; ?></a>
				</header>
				<div class="post-meta">
					<span class="post-meta-author"><?php echo $artical['author']['username']; ?></span>
					<span class="post-meta-ctime"><?php echo $artical['create_time'] ?></span>
				</div>
				<p class="post-abstract"><?php echo $artical['summary']; ?></p>
				<footer class="post-tags">
					<a class="tag">
						<span class="tag_name">BI</span>
					</a>
					<a class="tag">
						<span class="tag_name">指标</span>
					</a>
					<a class="tag">
						<span class="tag_name">逻辑树</span>
					</a>
					<a class="tag">
						<span class="tag_name">酒旅</span>
					</a>
					<a class="tag">
						<span class="tag_name">系统</span>
					</a>
				</footer>
			</article>
			<?php } ?>
		</div>
	</div>
	<div class="page-list">
	<?php echo LinkPager::widget([
	    'pagination' => $pagination
	]);
	?>
	</div>
