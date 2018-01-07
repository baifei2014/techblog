<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '技术沙龙-爱阅技术团队';
echo Html::cssFile('@web/frontend/web/statics/css/salon.css');
echo Html::cssFile('@web/frontend/web/statics/css/tomorrow-night.css');
echo Html::jsFile('@web/frontend/web/statics/js/highlight.pack.js');
?>
<script>hljs.initHighlightingOnLoad();</script>
<style type="text/css">
    .php{
        font-size: 15px;
        font-family: 'Consolas';
    }
    code.php{
        padding-top: 20px;
    }
</style>
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
            </ul>
            <div class="jue-checktech">
                <span class="juestart-testimg test-btn">开始比对</span>
            </div>
            <pre>
                <code class="php"></code>
            </pre>
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
        var testImg = new Array();
        var rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
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
                            $('.popwrap-img-lists').append('<li><label class="img-item-bd"><div class="jue_pic"><img title="' + item.imgname +'" style="'+imgstyle+';" class="img-list" src="'+item['imgurl']+'"></div><span class="jueimg_name" title="'+item['imgname']+'">'+item['imgname']+'</span><div class="selected_mask"><div class="selected_mask_inner"></div><div class="selected_mask-icon"></div></div></label></li>');
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
            console.log('开始检测00');
            if(selectedNum != 2){
                return;
            }else{
                $('code').empty();
                $('.jue-imglist').empty();
                $('.jue-imglist').css('display', 'flex');
                testImg = [];
                $('label.selected img').map(function(){
                    testImg.push(this.src);
                    var imgstyle = this.style[0] + ':' + '326px';
                    $('.jue-imglist').append('<li><img style="' + imgstyle +'" src="' + this.src +'"><div class="hover-mask"><p>' + this.title +'</p></div></li>');
                })
                $('.pop-bd').css('display','none');
                $('.pop-wrap').remove();
                selectedNum = 0;
                var str = new Array(
                    '第一张图片加载...[success]',
                    '第二张图片加载...[success]',
                );
                setTimeConsole(str,'load');
            }
        })
        $(document).on('mouseover', '.jue-imglist > li', function(){
            $(this).find('.hover-mask').css('display', 'flex');
        })
        $(document).on('mouseout', '.jue-imglist > li', function(){
            $(this).find('.hover-mask').css('display', 'none');
        })
        $(document).on('click', '.btn-closed', function(){
            $('.pop-bd').css('display','none');
            $('.pop-wrap').remove();
            selectedNum = 0;
        });

        $(document).on('click', '.test-btn', function(){
            $('.juestart-testimg').css('display', 'none');
            var str = new Array(
                '正在检测图片属性...[waiting]',
            );
            setTimeConsole(str);
            var data = {};
            data.imgurl1 = testImg[0];
            data.imgurl2 = testImg[1];
            $.ajax({
                url: 'site/porntest',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(msg){
                    var result = eval(msg);
                    if(result['porndata'] != null && result['simidata'] != null){
                        var str = new Array(
                            '检测完成...[finish]',
                            '第一张图片涉黄度：' + result['porndata'][0]['porn_score'] + '%',
                            '第二张图片涉黄度：' + result['porndata'][1]['porn_score'] + '%',
                            '第一张图片性感度：' + result['porndata'][0]['hot_score'] + '%',
                            '第二张图片性感度：' + result['porndata'][1]['hot_score'] + '%',
                            '图片合法...[前测成功]',
                            '正在打印相似度检测结果...[writing]',
                            'result：',
                            '       人脸相似度：' + result['simidata'] + '%',
                        );
                        setTimeConsole(str, 'result');
                    }
                },
            });
        })
        function setTimeConsole(str,type = null){
            var time_num = 0;
            for (var i = 0; i < str.length; i++) {
                if(i > 0){
                    time_num += 90*str[i-1].length;
                }
                var time1 = setTimeout(function(item){
                    $('code').append('<p></p>');
                    console.log(item);
                    var str_item = item.split("");
                    for (var j = 0; j < str_item.length; j++) {
                        var time2 = setTimeout(function(item){
                            var text = $('code p:last-child').text();
                            $('code p:last-child').text(text + item);
                        }, 50*j, str_item[j]);
                        hljs.initHighlightingOnLoad();
                    }
                }, time_num, str[i]);
            }
            if(type == 'load' || type == 'result'){
                setTimeout(function(){
                    $('.juestart-testimg').css('display', 'block');
                }, time_num+90*str[str.length-1].length);
            }
        }
    }
</script>
