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
<form>
    <input type="file" class="upload-img">
</form>
<div class="pop-bd"></div>
<script type="text/javascript">
    window.onload = function(){
        var selectedNum = 0;
        if($('.jue-imglists').find('li').length > 0){
            $('.jue-imglists').css('border', '2px solid #32d3c3');
        }
        $(document).on('click', '.img-item-bd',function(){
            if($(this).hasClass('selected')){
                $(this).removeClass('selected');
                selectedNum--;
            }else{
                $(this).addClass('selected');
                selectedNum++;
            }
            updateSelectedStutus();
        })
        $(document).on('click','.upload-btn',function(){
            $('.upload-img').trigger('click',function(){
                
            })
        })
        function updateSelectedStutus()
        {
            $('.popwrap-inner p .js-selected').text(selectedNum);
            if(selectedNum !== 2){
                if(!$('.btn-confirm').hasClass('btn-disabled')){
                    $('.btn-confirm').addClass('btn-disabled')
                }
                if(!$('.btn-confirm button').prop('disabled')){
                    $('.btn-confirm button').prop('disabled','disabled');
                }
            }else{
                if($('.btn-confirm').hasClass('btn-disabled')){
                    $('.btn-confirm').removeClass('btn-disabled');
                }
                if($('.btn-confirm button').prop('disabled')){
                    $('.btn-confirm button').prop('disabled','');
                }
            }
        }
        $('.select-img').click(function(){
            $('.pop-bd').css('display','block');
            $('.detail-post').append('<div class="pop-wrap"></div>');
            $('.pop-wrap').append('<div class="popwrap-header"></div>');
            $('.pop-wrap').append('<div class="popwrap-inner"></div>');
            $('.pop-wrap').append('<div class="popwrap-fd"></div>');
            $('.popwrap-header').append('<span class="check-img">选择图片</span><button class="jue-desktop-dialog close-btn"><svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"><path d="M10.01 8.996l7.922-7.922c.086-.086.085-.21.008-.289l-.73-.73c-.075-.074-.208-.075-.29.007L9 7.984 1.077.062C.995-.02.863-.019.788.055l-.73.73c-.078.078-.079.203.007.29l7.922 7.92-7.922 7.922c-.086.086-.085.212-.007.29l.73.73c.075.074.207.074.29-.008l7.92-7.921 7.922 7.921c.082.082.215.082.29.008l.73-.73c.077-.078.078-.204-.008-.29l-7.921-7.921z"></path></svg></button>');
            $('.popwrap-inner').append('<div class="popwrap-inner-hd"><span class="popupload-img upload-btn">本地上传</span></div><ul class="popwrap-img-lists"></ul><p class="juepopwrap-ft-desc"></p>');
            $('.popwrap-img-lists').append('<li><label class="img-item-bd"><div class="jue_pic"><img style="height:124px;" class="img-list" src="/frontend/web/files/QQ截图20171120093834.png"></div></label></li><li><label class="img-item-bd"><div class="jue_pic"><img style="height:124px;" src="/frontend/web/files/QQ截图20171120163120.png"></div></label></li><li><label class="img-item-bd"><div class="jue_pic"><img style="height:124px;" src="/frontend/web/files/QQ截图20171122135052.png"></div></label></li><li><label class="img-item-bd"><div class="jue_pic"><img style="height:124px;" src="/frontend/web/files/QQ截图20171122151503.png"></div></label></li><li><label class="img-item-bd"><div class="jue_pic"><img style="width:124px;" src="/frontend/web/files/panfish.9be67f5.png"></div></label></li><li><label class="img-item-bd"><div class="jue_pic"><img style="width:124px;" src="/frontend/web/files/QQ截图20171220155930.png"></div></label></li><li><label class="img-item-bd"><div class="jue_pic"><img style="height:124px;" class="img-list" src="/frontend/web/files/QQ截图20171120093834.png"></div></label></li><li><label class="img-item-bd"><div class="jue_pic"><img style="height:124px;" src="/frontend/web/files/QQ截图20171120163120.png"></div></label></li><li><label class="img-item-bd"><div class="jue_pic"><img style="height:124px;" src="/frontend/web/files/QQ截图20171122135052.png"></div></label></li><li><label class="img-item-bd"><div class="jue_pic"><img style="height:124px;" src="/frontend/web/files/QQ截图20171122151503.png"></div></label></li><li><label class="img-item-bd"><div class="jue_pic"><img style="width:124px;" src="/frontend/web/files/panfish.9be67f5.png"></div></label></li><li><label class="img-item-bd"><div class="jue_pic"><img style="width:124px;" src="/frontend/web/files/QQ截图20171220155930.png"></div></label></li>');
            $('.popwrap-img-lists > li > label').each(function(){
                $(this).append('<span class="jueimg_name">QQ截图20171120163120.png</span><div class="selected_mask"><div class="selected_mask_inner"></div><div class="selected_mask-icon"></div></div>');
            });
            $('.popwrap-inner p').append('已选<span class="js-selected">0</span>个，只能选择2个');
            $('.popwrap-fd').append('<span class="btn btn-input btn-confirm btn-primary btn-disabled"><button class="js-btn" disabled="disabled">确定</button></span><span class="btn btn-default btn-input"><button class="js-btn">取消</button></span>');
        });
    }
</script>
