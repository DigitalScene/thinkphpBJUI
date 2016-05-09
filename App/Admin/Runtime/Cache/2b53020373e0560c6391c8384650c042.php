<?php if (!defined('THINK_PATH')) exit();?>

<script type="text/javascript">

//    //检测标题是否重复
//    $("#show").click(function(){
//        var big_div=$("#big_div");//大图弹出层
//
//            big_div.show();
//            big_div.css({
//                'position':'fixed',
//                'left':'200px',
//                'top':'200px',
//                'background':'#eee'
//            });
//
//    });
//
//
//    $("#close").click(function(){
//        $("#big_div").hide();
//    });


</script>

<div class="bjui-pageContent">
    <!--内容区-->

       <h3 style="margin-left: 8px;">缩略图预览</h3>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div style="display: inline-block;width: 130px;">
                <img class="small_img" src='<?php echo ($vo["picsrc"]); ?>' style='height: 110px;width: 110px;margin-left: 8px;'/>
               　<a href="javascript:void(0)" id="show"  ><span style="font-size: medium;">大图</span></a>
            </div>
            <div id="big_div" style="display: none;">
                <p id="close">X</p>
                <p><img src="<?php echo ($vo["picsrc"]); ?>"/></p>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>

</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
    </ul>
</div>