<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;

$this->title = '文章归档 - 爱阅技术团队';
echo Html::cssFile('frontend/web/statics/css/archieve.css');
?>
<div class="jue-view">
    <div class="jue-year year-header">
        <?php foreach ($year as $key => $value) { ?>
        <span class="<?php if($key == 0){echo 'active_year'; }else{echo 'enable_year';}?>"><?php echo $value ?></span>
        <?php } ?>
        <form class="search">
            <input type="text" name="搜索">
            <img class="searc-icon" src="https://tech.meituan.com/img/search_icon.png" alt="搜索" >
        </form>
    </div>
    <?php foreach ($articals as $key => $articals_list) { ?>
    <div class="post-list <?php if($key == $year[0]){echo 'active'; }else{echo 'hide'; }?>" data-year=<?php echo $key ?>>
        <div>
            <?php foreach($articals_list as $artical){ ?>
            <article class="post post-with-tags">
                <header class="post-title">
                    <a href="/<?php echo $artical['id'] ?>.html"><?php echo $artical['title']; ?></a>
                </header>
                <div class="post-meta">
                    <span class="post-meta-author"><?php echo $artical['author']['username']; ?></span>
                    <span class="post-meta-ctime"><?php echo date('Y-m-d', $artical['created_at']) ?></span>
                </div>
                <p class="post-abstract"><?php echo $artical['summary']; ?></p>
            </article>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
</div>
<script>
function changeShowYear(e){
    var ele = e.target;
    if(ele.tagName !== "SPAN"){
        return;
    }
    var text = ele.innerHTML;
    var yearTags = document.querySelectorAll(".year-header span");
    
    for(var i in yearTags){
        if(yearTags.hasOwnProperty(i)){
            yearTags[i].setAttribute("class", "enable_year");
        }
    }
    ele.setAttribute("class", "active_year");        
    
    var queryFlag = "[data-year='" + text + "']";
    var allList = document.querySelectorAll(".post-list");
    var showYearEle = document.querySelector(queryFlag);
    
    for(var i in allList){
        if(allList.hasOwnProperty(i)){
            allList[i].setAttribute("class", "post-list hide");
        }
    }
    showYearEle.setAttribute("class", "post-list active");
}

var tagYear = document.querySelector(".year-header");
if(tagYear){
    tagYear.addEventListener("click", changeShowYear, false);
}
</script>
