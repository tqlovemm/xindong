<?php

    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

$this->registerCss("

    .user-info-box{padding:20px;background:red;}

");
?>
<?php $form=ActiveForm::begin();?>
<?=$form->field($model,'type')->dropDownList([0=>'按会员ID查询',1=>'按会员名查询',2=>'按会员编号查询',3=>'按手机号查询'])->label('查询类型')?>
<?=$form->field($model,'content')->textInput()->label('输入编号、id、会员名、手机号码')?>
<div class="form-group">
    <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end();?>
    <?php if(!empty($user_info)):

        switch ($user_info['groupid']){

            case 1:$grade = "网站会员";break;
            case 2:$grade = "普通会员";break;
            case 3:$grade = "高端会员";break;
            case 4:$grade = "至尊会员";break;
            case 5:$grade = "私人订制";break;
            default :$grade = "其他或管理员";
        }

        ?>

        <div class="user-info">
            <table class="table table-bordered table-striped table-hover">

                <tr>
                    <td width="200">添加付款截图</td><td><a class="btn btn-primary" href="upload?id=<?=$user_info['id']?>" target="_blank">添加</a></td>
                    <td width="200">查看所有上传截图</td><td><a class="btn btn-success" href="show-payment?id=<?=$user_info['id']?>" target="_blank">查看</a></td>
                </tr>
                <tr>
                    <td width="200">会员ID</td><td><?=$user_info['id']?></td>
                    <td width="200">会员编号</td><td><?=$user_info['number']?></td>
                </tr>
                <tr>
                    <td width="200">会员名</td><td><?=$user_info['username']?></td>
                    <td width="200">会员等级</td><td><?=$grade?></td>
                </tr>
                <tr>
                    <td width="200">会员地址1</td><td><?=$user_info['address_1']?></td>
                    <td width="200">会员地址2</td><td><?=$user_info['address_2']?></td>
                </tr>
                <tr>
                    <td width="200">会员地址3</td><td><?=$user_info['address_3']?></td>
                    <td width="200">会员创建时间</td><td><?=date('Y-m-d H:i:s',$user_info['created_at'])?></td>
                </tr>
                <tr>
                    <td width="200">会员节操币数量</td><td><?=$user_info['jiecao_coin']?></td>
                    <td width="200">会员节冻结节操币</td><td><?=$user_info['frozen_jiecao_coin']?></td>
                </tr>
                <tr>
                    <td width="200">会员手机号码</td><td><?=$user_info['cellphone']?></td>
                    <td width="200">会员手机邮箱</td><td><?=$user_info['email']?></td></tr>
                <tr>
                    <td width="200">会员性别</td><td><?=$user_info['sex']?>&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:red;">(1为girl 0为boy)</span></td>
                    <td width="200">会员创生日</td><td><?=$user_info['birthdate']?></td>
                </tr>
                <tr><td width="200">会员体重</td><td><?=$user_info['weight']?>kg</td>
                    <td width="200">会员身高</td><td><?=$user_info['height']?>cm</td>
                </tr>
                <tr>
                    <td width="200">会员头像</td><td><img class="img-responsive" style="width: 100px;" src="<?=$user_info['avatar']?>"></td>
                    <td width="200">会员档案照</td><td><img class="img-responsive" style="width: 100px;" src=""></td>
                </tr>
                <tr><td width="200">会员标签</td><td><?=var_dump(json_decode($user_info['mark']))?></td>
                    <td width="200">会员交友要求</td><td><?=var_dump(json_decode($user_info['make_friend']))?></td>
                </tr>
                <tr>
                    <td width="200">会员兴趣爱好</td><td><?=var_dump(json_decode($user_info['hobby']))?></td>
                    <td width="200">会员昵称</td><td><?=$user_info['nickname']?></td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
<?php if(Yii::$app->session->hasFlash('nobody')):?>
    <div class="alert alert-danger"><?=Yii::$app->session->getFlash('nobody')?></div>
<?php endif;?>
