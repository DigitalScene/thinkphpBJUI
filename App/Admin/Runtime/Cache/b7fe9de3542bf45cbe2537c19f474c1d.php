<?php if (!defined('THINK_PATH')) exit();?>
<div class="bjui-pageContent">
    <!--内容区-->
    <form action="<?php echo U($Think.ACTION_NAME);?>" id="addForm" class="pageForm" data-toggle="validate" data-reload-navtab="true">

    <h3 style="margin-left: 8px;">图片下载</h3>
        <div>选择保存的目录：
        <select name="pan">
        <option value="C:/">C:/</option>
        <option value="D:/" selected>D:/</option>
        <option value="E:/">E:/</option>
        <option value="F:/">F:/</option>
        <option value="G:/">G:/</option>
        <option value="H:/">H:/</option>
        </select>
        <input id="path" type="text" name="path" value="" size="30"></div><br/>

    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div style="display: inline-block;width: 130px;">

            <img class="small_img"   src='<?php echo ($vo["picsrc"]); ?>' style='height: 110px;width: 110px;margin-left: 8px;'/>
            　 <label ><input name="pictures[]" value="<?php echo ($vo["picsrc"]); ?>" class="chooseAll" type="checkbox" />下载</label>
            <!--<span style="font-size: medium;">下载</span>-->
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </form>
</div>
<div class="bjui-pageFooter">
    <div class="pull-left">
            <ul >
                <li><label><input name="" class="chooseAll" type="checkbox" onclick="selectAll(this)" />全选</label></li>
            </ul>
    </div>
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
        <li><button type="submit" class="btn-blue" data-icon="save">下载</button></li>
    </ul>
</div>

<script>
    function selectAll(o){
        var a=$(".chooseAll");
        for (var i=0;i< a.length;i++){
            a[i].checked= o.checked;
        }
    }


</script>