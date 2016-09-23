<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('

        $(function(){
            //得到焦点
            $(":password").focus(function(){
                $("#left_hand").animate({
                    left: "150",
                    top: " -38"
                },{step: function(){
                    if(parseInt($("#left_hand").css("left"))>140){
                        $("#left_hand").attr("class","left_hand");
                    }
                }}, 2000);
                $("#right_hand").animate({
                    right: "-64",
                    top: "-38px"
                },{step: function(){
                    if(parseInt($("#right_hand").css("right"))> -70){
                        $("#right_hand").attr("class","right_hand");
                    }
                }}, 2000);
            });
            //失去焦点
            $(":password").blur(function(){
                $("#left_hand").attr("class","initial_left_hand");
                $("#left_hand").attr("style","left:100px;top:-12px;");
                $("#right_hand").attr("class","initial_right_hand");
                $("#right_hand").attr("style","right:-112px;top:-12px");
            });
        });
',$this::POS_END);
?>
<DIV class="top_div"></DIV>
<DIV style="background: rgb(255, 255, 255); margin: -100px auto auto; border: 1px solid rgb(231, 231, 231); border-image: none; width: 400px; height: auto; text-align: center;">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <DIV style="width: 165px; height: 96px; position: absolute;">
        <DIV class="tou"></DIV>
        <DIV class="initial_left_hand" id="left_hand"></DIV>
        <DIV class="initial_right_hand" id="right_hand"></DIV>
    </DIV>
    <div style="padding: 30px 0px 0px; position: relative;"><SPAN class="u_logo"></SPAN>
        <?= $form->field($model,'username')->textInput(['placeholder'=>'请输入用户名','class'=>'ipt'])->label(false);?>
    </div>
    <P style="position: relative;"><SPAN class="p_logo"></SPAN>
        <?=$form->field($model,'password')->passwordInput(['placeholder'=>'请输入密码','class'=>'ipt'])->label(false)?>
    </P>
    <DIV style="height: 50px; line-height: 50px; margin-top: 30px; border-top-color: rgb(231, 231, 231); border-top-width: 1px; border-top-style: solid;">
        <div style="margin: 0px 35px 20px 45px;"><SPAN style="float: left;">
                <A style="color:  #666;" href="#">忘记密码?</A></SPAN>
                <SPAN style="float: right;">
               <div class="form-group">
                   <?= Html::submitButton('登录', ['class'=>'btn btn-primary','style' => 'background: rgb(0, 142, 173); margin: 7px 18px; border-radius: 4px; border: 1px solid rgb(26, 117, 152); border-image: none; color: rgb(255, 255, 255); font-weight: bold;', 'name' => 'login-button']) ?>
               </div>

                </SPAN>
        </div>
    </DIV>
    <?php ActiveForm::end(); ?>
</DIV>
