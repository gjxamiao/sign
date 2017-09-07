<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<button id="btn">签到</button>
</body>
<script src="/Public/js/jquery-3.2.0.min.js"></script>
<script>
    $(function(){
        $("#btn").click(function(){
            $.ajax({
                type:'post',
                url:'/Home/Index/doAjax',
                dataType:'json',
                success:function (data) {
                    if(data['status'] === 1){
                        alert('签到成功');
                    }else{
                        alert(data.msg);
                    }
                }
            });
        })
    })
</script>
</html>