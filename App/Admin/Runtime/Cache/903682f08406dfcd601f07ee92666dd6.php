<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<script type="text/javascript">
    function doc_upload_success(file, data) {
        var json = $.parseJSON(data)

        $(this).bjuiajax('ajaxDone', json)
        if (json[BJUI.keys.statusCode] == BJUI.statusCode.ok) {
            $('#doc_pic').val(json.filename)
            $('#doc_span_pic').html('已上传图片：<img src="'+ json.filename +'" width="100">')
        }
    }


</script>
<div style="display:inline-block; vertical-align:middle;">
    <div id="doc_pic_up" data-toggle="upload" data-uploader="doc/form/ajaxPic.html"
         data-file-size-limit="1024000000"
         data-file-type-exts="*.jpg;*.png;*.gif;*.mpg"
         data-multi="true"
         data-on-upload-success="doc_upload_success"
         data-icon="cloud-upload"></div>
    <input type="hidden" name="doc.pic" value="" id="doc_pic">
</div>
<span id="doc_span_pic"></span>

</body>
</html>