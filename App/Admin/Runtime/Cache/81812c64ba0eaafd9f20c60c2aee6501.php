<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch"  action="<?php echo U($Think.ACTION_NAME);?>" method="post">
        <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
        <div class="bjui-searchBar">
            <label>项目ID：</label><input type="text" name="search[projectID]" value="<?php echo ($search["projectID"]); ?>"/>　　
            <label>项目名：</label><input type="text" name="search[projectName]" value="<?php echo ($search["projectName"]); ?>"/>
            <button type="submit" class="btn-default" data-icon="search">查询</button>
            <!--<div class="pull-right">-->
                <!--<div class="btn-group">-->
                    <!--<button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy">功能操作<span class="caret"></span> </button>-->
                    <!--<ul class="dropdown-menu right" role="menu">-->
                        <!--<li><a href="<?php echo U('add');?>" data-toggle="dialog" data-width="950" data-height="300" data-id="dialog-mask" data-mask="true"><i class="fa fa-plus "></i>新增项目 </a> </li>-->
                    <!--</ul>-->
                <!--</div>-->
            <!--</div>-->
        </div>
    </form>
</div>

<div class="bjui-pageContent">
    <!--内容区-->
    <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
        <thead>
        <tr>
            <?php if(is_array($tableFields)): $i = 0; $__LIST__ = $tableFields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tvo): $mod = ($i % 2 );++$i;?><th <?php if($tvo["order"] == 1): ?>data-order-field="<?php echo ($key); ?>"<?php endif; ?>><?php echo ($tvo["name"]); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>

        </tr>
        </thead>

        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <?php if(is_array($tableFields)): $i = 0; $__LIST__ = $tableFields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tvo): $mod = ($i % 2 );++$i;?><td><?php echo ($vo["$key"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                <!--<td>-->
                    <!--<a href="<?php echo U('edit?id='.$vo[id]);?>" class="btn btn-default"data-toggle="dialog" data-width="850" data-height="300" data-id="dialog-mask" data-mask="true">编辑</a>-->
                    <!--<a href="<?php echo U('remove?id='.$vo[id].'&status='.$vo[status]);?>" class="btn btn-red" data-toggle="doajax" data-confirm-msg="确定要删除该行信息吗？">删除</a>-->
                    <!--<?php if($vo[status] == '项目尚未启动'): ?>-->
                        <!--<a href="<?php echo U('startUp?id='.$vo[id]);?>" class="btn btn-green" data-toggle="doajax" data-confirm-msg="你确定启动项目么？">启动项目</a>-->
                        <!--<?php elseif($vo[status] != '项目尚未启动'): ?><a href="#" class="btn btn-green" disabled>已启动项目</a>-->
                    <!--<?php endif; ?>-->
                    <!--&lt;!&ndash;下面的写法是创建navTab&ndash;&gt;-->
                    <!--&lt;!&ndash;<a href="<?php echo U('process?id='.$vo[id]);?>" class="btn btn-green" data-toggle="navtab" data-id="mynavtab" data-title="项目进度">项目进度</a>&ndash;&gt;-->
                <!--</td>-->
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
</div>

<div class="bjui-pageFooter">
    <div class="pages">
        <span>每页</span>
        <div class="selectPagesize">
            <select data-toggle="selectpicker" data-toggle-change="changepagesize">
                <option value="20" <?php if($_SESSION['pageSize']== 20): ?>selected="selected"<?php endif; ?>>20</option>
                <option value="40" <?php if($_SESSION['pageSize']== 40): ?>selected="selected"<?php endif; ?>>40</option>
                <option value="60" <?php if($_SESSION['pageSize']== 60): ?>selected="selected"<?php endif; ?>>60</option>
                <option value="120" <?php if($_SESSION['pageSize']== 120): ?>selected="selected"<?php endif; ?>>120</option>
                <option value="150" <?php if($_SESSION['pageSize']== 150): ?>selected="selected"<?php endif; ?>>150</option>
            </select>
        </div>
        <span>条，共{total}条</span>
    </div>
    <div class="pagination-box" data-toggle="pagination" data-total="<?php echo ($total); ?>" data-page-size="<?php echo (session('pageSize')); ?>" data-page-current="<?php echo (session('pageCurrent')); ?>">
    </div>
</div>

<script>
    /* zxc优化开始*/

    //解决多个列表间的字段排序冲突问题
    // 解决多个列表间的字段排序冲突问题
    $(".page.unitBox.fade.in > .bjui-pageHeader > #pagerForm > [name='orderField']").val("");
    $(".page.unitBox.fade.in > .bjui-pageHeader > #pagerForm > [name='orderDirection']").val("");

    // 解决多个列表间的分页大小冲突问题
    var selectedPagesize = $(".page.unitBox.fade.in > .bjui-pageFooter > .pages > .selectPagesize > select").val();
    $(".page.unitBox.fade.in > .bjui-pageHeader > #pagerForm > [name='pageSize']").val(selectedPagesize);
    $(".page.unitBox.fade.in > .bjui-pageFooter > .pagination-box").attr('data-page-size',selectedPagesize);

</script>