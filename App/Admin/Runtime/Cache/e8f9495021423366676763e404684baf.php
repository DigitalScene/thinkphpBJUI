<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--webuploader的css包和js包-->
    <link rel="stylesheet" type="text/css" href="<?php echo C('STATIC_PATH');?>Plugins/webuploader/css/syntax.css">
    <link rel="stylesheet" type="text/css" href="<?php echo C('STATIC_PATH');?>Plugins/webuploader/css/demo.css">
    <link rel="stylesheet" type="text/css" href="<?php echo C('STATIC_PATH');?>Plugins/webuploader/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo C('STATIC_PATH');?>Plugins/webuploader/css/webuploader.css">

</head>
<body>

<div class="bjui-pageContent">
    <h3 id="demo">场景图片上传</h3>
                    <p class="text-info">您可以尝试文件拖拽，使用QQ截屏工具，然后激活窗口后粘贴，或者点击添加图片按钮.</p>

                    <div id="uploader" class="wu-example">
                        <div class="queueList">
                            <div id="dndArea" class="placeholder">
                                <div id="filePicker"></div>
                                <p>或将照片拖到这里，单次最多可选300张</p>
                            </div>
                        </div>
                        <div class="statusBar" style="display:none;">
                            <div class="progress">
                                <span class="text">0%</span>
                                <span class="percentage"></span>
                            </div><div class="info"></div>
                            <div class="btns ">
                                <div id="filePicker2"></div>
                                <div class="uploadBtn btn btn-primary" style="line-height:22px;">开始上传</div>
                            </div>
                        </div>
                    </div>

</div>

<script type="text/javascript">
    // 添加全局站点信息
    var BASE_URL = '<?php echo C('STATIC_PATH');?>Plugins/webuploader';
</script>
<script type="text/javascript" src="<?php echo C('STATIC_PATH');?>Plugins/webuploader/js/demo.js"></script>
</body>
</html>