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
            </div>
            <ul class="jue-imglist">
                <li><img src="/frontend/web/upload/s8FHqSA13z3lIAvUu9kPlcg5rK5ChdGDBLcqJo8yDAAobOPDUma1Lf2NdI4F3cX0AoBE8f8bHBHedB10SAEKLRbF2.png"></li>
                <li><img src="/frontend/web/upload/uxzO5Cm0R9Yxnl85Eu0qpdPt1o6cFEcGja3tO5dBU5JAOOlfOQPaN0MmPPLAV6Fr8JHfAFaPD6q2fCaCfQ4sucm90.png"></li>
            </ul>
            <div class="jue-checktech">
                <span class="juestart-testimg test-btn">开始比对</span>
            </div>
        </div>
    </div>
</div>
<form style="display: none;" action="/site/upimg">
    <input type="file" class="upload-img" id="jueup-img">
</form>
<div class="pop-bd"></div>
<script type="text/javascript">
    window.onload = function(){
        var selectedNum = 0;
        var oFReader = new FileReader();
        var oImg;
        var rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
        $('.jue-imglist li').css('height', $('.jue-imglist li').width());
        console.log($('.jue-imglist li').width());
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
            $('.upload-img').trigger('click');
        })
        $(document).on('change','.upload-img',function(){
            if (document.getElementById("jueup-img").files.length === 0) { return; }
            var oFile = document.getElementById("jueup-img").files[0];
            if (!rFilter.test(oFile.type)) { alert("You must select a valid image file!"); return; }
            oFReader.imgname = oFile.name;
            oFReader.readAsDataURL(oFile);
        })
        oFReader.onload = function (oFREvent) {
            var data = {};
            data.code = oFREvent.target.result;
            data.imgname = this.imgname;
            saveImg(data);
        };
        function saveImg(data)
        {
            $.ajax({
                url: 'site/uploadimg',
                type: 'POST',
                data: data,
                dataType: 'json',
                traditional: true,
                success: function(msg){
                    var result = eval(msg);
                    if(result['status']){
                        showImage();
                    }
                },
            });
        }
        function showImage()
        {
            $.ajax({
                url: 'site/getimage',
                type: 'GET',
                dataType: 'json',
                success: function(msg){
                    var result = eval(msg);
                    if(result['status']){
                        $('.popwrap-img-lists').empty();
                        result['material'].map(function(item){
                            var imgstyle = item['method'] + ':' + '124px';
                            $('.popwrap-img-lists').append('<li><label class="img-item-bd"><div class="jue_pic"><img style="'+imgstyle+';" class="img-list" src="'+item['imgurl']+'"></div><span class="jueimg_name" title="'+item['imgname']+'">'+item['imgname']+'</span><div class="selected_mask"><div class="selected_mask_inner"></div><div class="selected_mask-icon"></div></div></label></li>');
                        })
                    }
                },
            });
        }
        function updateSelectedStutus()
        {
            $('.popwrap-inner p .js-selected').text(selectedNum);
            if(selectedNum !== 2){
                if(!$('.btn-confirm').hasClass('btn-disabled')){
                    $('.btn-confirm').addClass('btn-disabled');
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
            $('.popwrap-header').append('<span class="check-img">选择图片</span><button class="jue-desktop-dialog btn-closed"><svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"><path d="M10.01 8.996l7.922-7.922c.086-.086.085-.21.008-.289l-.73-.73c-.075-.074-.208-.075-.29.007L9 7.984 1.077.062C.995-.02.863-.019.788.055l-.73.73c-.078.078-.079.203.007.29l7.922 7.92-7.922 7.922c-.086.086-.085.212-.007.29l.73.73c.075.074.207.074.29-.008l7.92-7.921 7.922 7.921c.082.082.215.082.29.008l.73-.73c.077-.078.078-.204-.008-.29l-7.921-7.921z"></path></svg></button>');
            $('.popwrap-inner').append('<div class="popwrap-inner-hd"><span class="popupload-img upload-btn">本地上传</span></div><ul class="popwrap-img-lists"></ul><p class="juepopwrap-ft-desc"></p>');
            showImage();
            $('.popwrap-inner p').append('已选<span class="js-selected">0</span>个，只能选择2个');
            $('.popwrap-fd').append('<span class="btn btn-input btn-confirm btn-primary btn-disabled"><button class="js-btn" disabled="disabled">确定</button></span><span class="btn btn-closed btn-default btn-input"><button class="js-btn">取消</button></span>');
        });
        $(document).on('click', '.btn-confirm', function(){
            if(selectedNum != 2){
                return;
            }else{
                $('.pop-bd').css('display','none');
                $('.pop-wrap').remove();

                selectedNum = 0;
            }
        })
        $(document).on('click', '.btn-closed', function(){
            $('.pop-bd').css('display','none');
            $('.pop-wrap').remove();
            selectedNum = 0;
        });
    }
</script>
