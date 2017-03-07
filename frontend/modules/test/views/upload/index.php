<?php

$this->registerJs("");
?>

<div>
    <form action="" method="post" id="uploadImage" enctype="multipart/form-data">
        <input type="file" name="file" value="" class="file"><br>
        <input type="text" name="word" value="" class="word"><br>
        <input type="submit" value="提交" >
    </form>
</div>
<script src="/js/jquery-1.11.3.js"></script>
<script>

    //function sub(){
        $("#uploadImage").submit(function(){
            var file = $("input[type=file]").val();
            if(file == ''){
                alert('上传文件为空');
            }else{
                alert(file);
            }

            $.ajax({
                type:'post',
                url:'https://a1.easemob.com/easemob-demo/chatdemoui/chatfiles',//https://a1.easemob.com/easemob-demo/chatdemoui/chatfiless
                data:{file:file},
                contentType:'multipart/form-data',
                dataType:'json',
               // beforeSend:function(){
                    headers:{
                     "Authorization":'Bearer YWMt4Gmi4tuAEeaBXw1KRTvDxAAAAVrZnnTFdfSCCrwky01kkZb2rHruB7Tt8Gk',
                     "restrict-access":true
                     },
                //},

                success:function(data,status){
                    alert(status);
                    alert(data);
                    document.write(data);
                },

                error:function(err){
                    console.log(err);die();
                }
            });
        });
    //}


</script>
