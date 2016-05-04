<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="<?php echo U($Think.ACTION_NAME);?>" id="addForm" class="pageForm" data-toggle="validate" data-reload-navtab="true">
        <input type="hidden" id="del" name="info[isDel]"   value="0">
        <input type="hidden" id="pk" name="info[id]" value="<?php echo ($info["id"]); ?>">
        <table class="table table-condensed table-hover" width="100%">
            <tbody>
               <tr>
                   <td colspan="2">
                       <label class="control-label x100">项目名：</label>
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
                       <label class="control-label x100">项目状态：</label>
                       <input type="radio" name="info[status]" data-toggle="icheck" value="0" data-rule="checked" data-label="项目尚未启动&nbsp;&nbsp;" <?php if($info["status"] == 0): ?>checked<?php endif; ?>>
                       <input type="radio" name="info[status]" data-toggle="icheck"  value="1" data-label="项目正在启动中" <?php if($info["status"] == 1): ?>checked<?php endif; ?>>
                       <input type="radio" name="info[status]" data-toggle="icheck"  value="2" data-label="用户数据上传中" <?php if($info["status"] == 2): ?>checked<?php endif; ?>>
                       <input type="radio" name="info[status]" data-toggle="icheck"  value="3" data-label="原始图片编辑中" <?php if($info["status"] == 3): ?>checked<?php endif; ?>>
                       <input type="radio" name="info[status]" data-toggle="icheck"  value="4" data-label="球形图制作中" <?php if($info["status"] == 4): ?>checked<?php endif; ?>>
                       <input type="radio" name="info[status]" data-toggle="icheck"  value="5" data-label="场景构建中" <?php if($info["status"] == 5): ?>checked<?php endif; ?>>
                       <input type="radio" name="info[status]" data-toggle="icheck"  value="6" data-label="数据整合中" <?php if($info["status"] == 6): ?>checked<?php endif; ?>>
                       <input type="radio" name="info[status]" data-toggle="icheck"  value="7" data-label="已完成" <?php if($info["status"] == 7): ?>checked<?php endif; ?>>
                   </td>
               </tr>
               <tr>
                   <td colspan="2">
                       <label class="control-label x100">项目模块：</label>
                       <span>用户数据上传模块</span>　<span>原始图片编辑模块(线下编辑)</span>　<span>球形图制作模块(线下编辑)</span>　<span>场景构建模块</span>　<span>数据整合模块</span>
                   </td>
               </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label x100">项目描述：</label>
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
        $.getJSON("__URL__/checkProjectName",
                {
                    name:$("#name").val(),
                    id:"<?php echo ($info["id"]); ?>"
                },function(json){
                   $("#checkNewsName").css('color',json.statusCode==200 ? "#0f0" :"#f00").html(json.message);
                });
    });
</script>