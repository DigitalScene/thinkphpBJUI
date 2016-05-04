<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="<?php echo U($Think.ACTION_NAME);?>" id="addForm" class="pageForm" data-toggle="validate" data-reload-navtab="true">
        <input type="hidden" id="del" name="info[isDel]"   value="0">
        <input type="hidden" id="pk" name="info[id]" value="<?php echo ($info["id"]); ?>">
        <input type="hidden"  name="info[dataUploadID]" value="<?php echo ($info["dataUploadID"]); ?>">
        <table class="table table-condensed table-hover" width="100%">
            <tbody>
            <tr>
                <td colspan="2">
                    <label class="control-label x100">场景名：</label>
                    <input id="name" type="text" name="info[name]" value="<?php echo ($info["name"]); ?>" size="60">
                    <a href="javascript:void(0)" id="checkNewsName">检测是否重复</a>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <label class="control-label x100">创建日期：</label>
                    <input id="creatingDate" type="text"  name="info[creatingDate]" <?php if($info["creatingDate"] == '' || $info["creatingDate"] == null): ?>value="<?php import('ORG.Util.Date'); echo new Date(); ?>"<?php elseif($info["creatingDate"] != '' || $info["creatingDate"] != null): ?>value="<?php echo ($info["creatingDate"]); ?>"<?php endif; ?>   size="60">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="control-label x100">创建人：</label>
                    <input id="creatingPer" type="text" name="info[creatingPer]" value="<?php echo ($info["creatingPer"]); ?>" size="60">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <label class="control-label x100">场景描述：</label>
                    <textarea name="info[desc]" style="width:600px;height: 50px" data-toggle="autoheight"><?php echo ($info["desc"]); ?></textarea>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
        <li><button type="submit" class="btn-default" data-icon="save">保存</button></li>
    </ul>
</div>

<script type="text/javascript">
    //检测标题是否重复
    $("#checkNewsName").click(function(){
        $.getJSON("__URL__/checkDisceneName",
                {
                    name:$("#name").val(),
                    id:"<?php echo ($info["id"]); ?>"
                },function(json){
                    $("#checkNewsName").css('color',json.statusCode==200 ? "#0f0" :"#f00").html(json.message);
                });
    });
</script>