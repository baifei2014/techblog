<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '技术沙龙-爱阅技术团队';
echo Html::cssFile('@web/frontend/web/statics/css/salon.css');
?>
<div class="post-detail">
    <div class="detail-post">
        <header class="artical-title">
            <h1 class="title">技术沙龙</h1>
        </header>
        <div class="artical-content">
            <div class="jue-aboutart">
                <span class="select-img">点击选择图片</span>
                <ul class="jue-imglists" >
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function(){
        if($('.jue-imglists').find('li').length > 0){
            $('.jue-imglists').css('border', '2px solid #32d3c3');
        }
        $('.select-img').click(function(){
            $('.detail-post').append('<div class="pop-wrap"></div>');
            $('.pop-wrap').append('<div class="popwrap-header"></div>');
            $('.pop-wrap').append('<div class="popwrap-inner"></div>');
            $('.popwrap-header').append('<span class="check-img">本地上传</span><button class="jue-desktop-dialog close-btn"><svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"><path d="M10.01 8.996l7.922-7.922c.086-.086.085-.21.008-.289l-.73-.73c-.075-.074-.208-.075-.29.007L9 7.984 1.077.062C.995-.02.863-.019.788.055l-.73.73c-.078.078-.079.203.007.29l7.922 7.92-7.922 7.922c-.086.086-.085.212-.007.29l.73.73c.075.074.207.074.29-.008l7.92-7.921 7.922 7.921c.082.082.215.082.29.008l.73-.73c.077-.078.078-.204-.008-.29l-7.921-7.921z"></path></svg></button>');

        });
    }
</script>