<?php 
use yii\helpers\Html;

$this->title = $artical['title'].'-爱阅技术团队';
echo Html::cssFile('frontend/web/statics/css/view.css');
?>
<div class="jue-view">
    <div class="post-detail">
        <div class="detail-post">
            <header class="artical-title">
                <h1 class="title"><?php echo $artical['title']; ?></h1>
                <p class="info">
                    <span class="nick"><?php echo $artical['author']['username']; ?></span>
                    <span> ·</span>
                    <span class="date"><?php echo date('Y-m-d H:i', $artical['created_at']); ?></span>
                </p>
            </header>
            <div class="artical-content"><?php echo $artical['text']; ?></div>
        </div>
    </div>
</div>
