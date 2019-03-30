<?php 
use yii\helpers\Html;

$this->title = $artical['title'].'-爱阅技术团队';
echo Html::cssFile('frontend/web/statics/css/view.css');
?>
    <div class="post-detail">
        <div class="detail-post">
            <header class="artical-title">
                <h1 class="title"><?php echo $artical['title']; ?></h1>
                <p class="info">
                    <span class="nick"><?php echo $artical['author']['username']; ?></span>
                    <span> ·</span>
                    <span class="date"><?php echo $artical['create_time']; ?></span>
                </p>
            </header>
            <div class="artical-content"><?php echo $artical['text']; ?></div>
        </div>
    </div>
