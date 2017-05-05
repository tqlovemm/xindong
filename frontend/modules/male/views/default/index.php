<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "十三平台入会申请表";
$this->registerCss('
    .container-fluid{padding:0;}
    label{margin-bottom:0;}
    .form-group{margin-bottom:0;}
    .help-block{margin:0 15px;}
    .weui_cell:first-child:before{display:block !important;}
    .demo{max-width:600px;margin:auto;}
    .demo_image .weui_cell:before{border-top:none;}
');
?>
<link rel="stylesheet" href="/weui/dist/style/weui.min.css"/>

<input type="hidden" id="domain" value="http://ooqyxp14h.bkt.clouddn.com/">
<input type="hidden" id="uptoken_url" value="male/default/up-token">
<div class="demo">
<div id="header" style="padding:10px;background-color: #2695D0;text-align: center;color:#fff;font-size: 20px;font-weight: bold;"><?=$this->title?></div>
<div id="main" style="padding:10px;background-color: #fbf9fe;">
<b>下面的一些问题可能会触及到你的隐私，但请放心我们会绝对保密，仅用于平台内部。填写的越详细越能吸引女生的注意哦！！</b>
<div id="up_status" style="display:none"><img src="/images/loader.gif" alt="uploading"/></div>
<div class="demo_image">
<div class="weui_cells weui_cells_form">
    <div class="weui_cell">
        <div class="weui_cell_bd weui_cell_primary">
            <div class="weui_uploader">
                <div class="weui_uploader_hd weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">档案照上传<small> （单张上传至少4张，第一张作为翻牌头像请选择优质图片，点击图片可删除）</small></div>
                    <div class="weui_cell_ft weui_cell_fts"><span><?php if(!empty($model->img)): echo count($model->img); else:?>0<?php endif;?></span>/6</div>
                </div>
                <div class="weui_uploader_bd">
                    <div class="weui_uploader_files">
                        <ul class="weui_uploader_files" id="fsUploadProgress">
                            <?php if(!empty($model->img)):?>
                                <?php foreach ($model->img as $img):?>
                                    <li id="<?=$img->clent_id?>" class="weui_uploader_file" onclick="deleteImg('<?=$img->clent_id?>',this)" style="opacity: 1; background-image: url('http://ooqyxp14h.bkt.clouddn.com/<?=$img->img?>?imageView2/1/w/100/h/100');"></li>
                                <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                    </div>

                    <div class="weui_uploader_input_wrp btn body" style="<?php if(count($model->img)>=6):?>display:none;<?php endif;?>" id="container2">
                        <a id="pickfiles2" href="#" style="display: block;height: 77px;width: 77px;"></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="weui_cells weui_cells_form">
    <div class="weui_cell">
        <div class="weui_cell_bd weui_cell_primary">
            <div class="weui_uploader">
                <div class="weui_uploader_hd weui_cell">
                    <div class="weui_cell_bd weui_cell_primary">微信名片二维码<small> （点击图片可删除）</small></div>
                    <div class="weui_cell_ft weui_cell_ftsw"><span><?php if(!empty($model->wm)):?>1<?php else:?>0<?php endif;?></span>/1</div>
                </div>
                <div class="weui_uploader_bd">
                    <div class="weui_uploader_files">
                        <ul class="weui_uploader_files" id="fsUploadProgresss">
                            <?php if(!empty($model->wm)):?>
                                <li id="<?=$model->wm->clent_id?>" class="weui_uploader_file" onclick="deleteImg('<?=$model->wm->clent_id?>',this)" style="opacity: 1; background-image: url('http://ooqyxp14h.bkt.clouddn.com/<?=$model->wm->img?>?imageView2/1/w/100/h/100');"></li>
                            <?php endif;?>
                        </ul>
                    </div>
                    <div class="weui_uploader_input_wrp btn body" style="<?php if(!empty($model->wm)):?>display:none;<?php endif;?>" id="container">
                        <a id="pickfiles" href="#" style="display: block;height: 77px;width: 77px;"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="/js/qiniu/plupload.full.min.js"></script>
<script src="/js/qiniu/qiniu.js"></script>
<script src="/js/qiniu/ui.js"></script>
<script src="http://cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<?php $form = ActiveForm::begin();
    $ages = [16=>'16岁',17=>'17岁',18=>'18岁',19=>'19岁',20=>'20岁',21=>'21岁',22=>'22岁',23=>'23岁',24=>'24岁',25=>'25岁',26=>'26岁',27=>'27岁',28=>'28岁',29=>'29岁',30=>'30岁',31=>'31岁',32=>'32岁',33=>'33岁',34=>'34岁',35=>'35岁',36=>'36岁',37=>'37岁',38=>'38岁',39=>'39岁',40=>'40岁',41=>'41岁',42=>'42岁',43=>'43岁',44=>'44岁',45=>'45岁',46=>'46岁',47=>'47岁',48=>'48岁',49=>'49岁',50=>'50岁',51=>'51岁',52=>'52岁',53=>'53岁',54=>'54岁',55=>'55岁',56=>'56岁',57=>'57岁',58=>'58岁',59=>'59岁',60=>'60岁',];
    $heights = [150=>'150cm',151=>'151cm',152=>'152cm',153=>'153cm',154=>'154cm',155=>'155cm',156=>'156cm',157=>'157cm',158=>'158cm',159=>'159cm',160=>'160cm',161=>'161cm',162=>'162cm',163=>'163cm',164=>'164cm',165=>'165cm',166=>'166cm',167=>'167cm',168=>'168cm',169=>'169cm',170=>'170cm',171=>'171cm',172=>'172cm',173=>'173cm',174=>'174cm',175=>'175cm',176=>'176cm',177=>'177cm',178=>'178cm',179=>'179cm',180=>'180cm',181=>'181cm',182=>'182cm',183=>'183cm',184=>'184cm',185=>'185cm',186=>'186cm',187=>'187cm',188=>'188cm',189=>'189cm',190=>'190cm',191=>'191cm',192=>'192cm',193=>'193cm',194=>'194cm',195=>'195cm',196=>'196cm',197=>'197cm',198=>'198cm',199=>'199cm',200=>'200cm',201=>'201cm',202=>'202cm',203=>'203cm',204=>'204cm',205=>'205cm',206=>'206cm',207=>'207cm',208=>'208cm',209=>'209cm',210=>'210cm',];
    $weights = [40=>'40kg',41=>'41kg',42=>'42kg',43=>'43kg',44=>'44kg',45=>'45kg',46=>'46kg',47=>'47kg',48=>'48kg',49=>'49kg',50=>'50kg',51=>'51kg',52=>'52kg',53=>'53kg',54=>'54kg',55=>'55kg',56=>'56kg',57=>'57kg',58=>'58kg',59=>'59kg',60=>'60kg',61=>'61kg',62=>'62kg',63=>'63kg',64=>'64kg',65=>'65kg',66=>'66kg',67=>'67kg',68=>'68kg',69=>'69kg',70=>'70kg',71=>'71kg',72=>'72kg',73=>'73kg',74=>'74kg',75=>'75kg',76=>'76kg',77=>'77kg',78=>'78kg',79=>'79kg',80=>'80kg',81=>'81kg',82=>'82kg',83=>'83kg',84=>'84kg',85=>'85kg',86=>'86kg',87=>'87kg',88=>'88kg',89=>'89kg',90=>'90kg',91=>'91kg',92=>'92kg',93=>'93kg',94=>'94kg',95=>'95kg',96=>'96kg',97=>'97kg',98=>'98kg',99=>'99kg',100=>'100kg',101=>'101kg',102=>'102kg',103=>'103kg',104=>'104kg',105=>'105kg',106=>'106kg',107=>'107kg',108=>'108kg',109=>'109kg',110=>'110kg',];
    $marries = [0=>"未婚",1=>"已婚",2=>"有女友"];
    $salaries = ['10-20万'=>'10-20万','20-50万'=>'20-50万','50-100万'=>'50-100万','100-300万'=>'100-300万','300-500万'=>'300-500万','500-1000万'=>'500-1000万','1000万以上'=>'1000万以上'];
    $cars = ['无' => '无', '奥迪' => '奥迪', '安驰' => '安驰', '阿尔法-罗密欧' => '阿尔法-罗密欧', '阿斯顿马丁' => '阿斯顿马丁', 'Alpina' => 'Alpina', '本田' => '本田', '别克' => '别克', '标致' => '标致', '比亚迪' => '比亚迪', '宝马' => '宝马', '奔驰' => '奔驰', '奔腾' => '奔腾', '宝骏' => '宝骏', '北汽' => '北汽', '保时捷' => '保时捷', '北京' => '北京', '宝龙' => '宝龙', '巴博斯' => '巴博斯', '宾利' => '宾利', '布加迪' => '布加迪', '保斐利' => '保斐利', '长安' => '长安', '长城' => '长城', '传祺' => '传祺', '长安商用' => '长安商用', '昌河' => '昌河', '大众' => '大众', '东南' => '东南', '大发' => '大发', '东风' => '东风', '道奇' => '道奇', 'DS' => 'DS', '东风风度' => '东风风度', '东风小康' => '东风小康', '大迪' => '大迪', '大通' => '大通', '大宇' => '大宇', '丰田' => '丰田', '福特' => '福特', '菲亚特' => '菲亚特', '福田' => '福田', '法拉利' => '法拉利', '风行' => '风行', '风神' => '风神', '福迪' => '福迪', '富奇' => '富奇', '光冈' => '光冈', '观致' => '观致', 'GMC' => 'GMC', '海马' => '海马', '哈弗' => '哈弗', '红旗' => '红旗', '哈飞' => '哈飞', '悍马' => '悍马', '华泰' => '华泰', '海格' => '海格', '黑豹' => '黑豹', '黄海' => '黄海', '恒天' => '恒天', '华北' => '华北', '华普' => '华普', '华颂' => '华颂', '华阳' => '华阳', '幻速' => '幻速', '汇众' => '汇众', '吉利' => '吉利', '江淮' => '江淮', 'Jeep' => 'Jeep', '金杯' => '金杯', '捷豹' => '捷豹', '江铃' => '江铃', '解放' => '解放', '江南' => '江南', '吉奥' => '吉奥', '佳星' => '佳星', '金程' => '金程', '九龙' => '九龙', '凯迪拉克' => '凯迪拉克', '克莱斯勒' => '克莱斯勒', '卡尔森' => '卡尔森', '卡威' => '卡威', '开瑞' => '开瑞', '凯翼' => '凯翼', '科尼赛克' => '科尼赛克', '铃木' => '铃木', '路虎' => '路虎', '雷诺' => '雷诺', '雷克萨斯' => '雷克萨斯', '猎豹' => '猎豹', '兰博基尼' => '兰博基尼', '劳斯莱斯' => '劳斯莱斯', '力帆' => '力帆', '罗孚' => '罗孚', '路特斯' => '路特斯', '理念' => '理念', '莲花' => '莲花', '林肯' => '林肯', '陆风' => '陆风', '劳伦士' => '劳伦士', '马自达' => '马自达', 'MINI' => 'MINI', '玛莎拉蒂' => '玛莎拉蒂', 'MG' => 'MG', '美亚' => '美亚', '迈巴赫' => '迈巴赫', '迈凯伦' => '迈凯伦', '纳智捷' => '纳智捷', '欧宝' => '欧宝', '讴歌' => '讴歌', '欧朗' => '欧朗', '庞蒂克' => '庞蒂克', '帕加尼' => '帕加尼', '起亚' => '起亚', '奇瑞' => '奇瑞', '启辰' => '启辰', '庆铃' => '庆铃', '启腾' => '启腾', '日产' => '日产', '荣威' => '荣威', '瑞麒' => '瑞麒', 'RUF' => 'RUF', '斯柯达' => '斯柯达', '绅宝' => '绅宝', '斯巴鲁' => '斯巴鲁', '三菱' => '三菱', '思铭' => '思铭', '双龙' => '双龙', 'Smart' => 'Smart', '世爵' => '世爵', '双环' => '双环', '萨博' => '萨博', '赛宝' => '赛宝', '陕汽通家' => '陕汽通家', 'SPRINGO' => 'SPRINGO', 'Scion' => 'Scion', '特斯拉' => '特斯拉', '通用' => '通用', '腾势' => '腾势', '天马' => '天马', '通田' => '通田', '沃尔沃' => '沃尔沃', '五十铃' => '五十铃', '五菱' => '五菱', '威麟' => '威麟', '万丰' => '万丰', '威旺' => '威旺', '威兹曼' => '威兹曼', '现代' => '现代', '雪佛兰' => '雪佛兰', '雪铁龙' => '雪铁龙', '夏利' => '夏利', '西雅特' => '西雅特', '西安奥拓' => '西安奥拓', '新凯' => '新凯', '新雅途' => '新雅途', '英菲尼迪' => '英菲尼迪', '依维柯' => '依维柯', '一汽' => '一汽', '扬子' => '扬子', '野马' => '野马', '英致' => '英致', '永源' => '永源', '云雀' => '云雀', '众泰' => '众泰', '中华' => '中华', '中兴' => '中兴', '中顺' => '中顺', '中欧' => '中欧'];
?>

<div class="weui_cells weui_cells_form">
    <?= $form->field($model, 'wechat', [
        'template' => '<div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">微信号</label></div>
        <div class="weui_cell_bd weui_cell_primary">{input}</div>
            </div>{error}',
        'inputOptions' => [
            'class'=>'weui_input',
            'placeholder'=>'请输入微信号',
        ],
    ])->label(false);?>

    <?= $form->field($model, 'status')->hiddenInput(['value'=>1])->label(false);?>
    <?= $form->field($model, 'email', [
        'template' => '<div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">邮箱号</label></div>
        <div class="weui_cell_bd weui_cell_primary">{input}</div>
            </div>{error}',
        'inputOptions' => [
            'class'=>'weui_input',
            'placeholder'=>'请输入邮箱',
        ],
    ])->label(false);?>
    <?= $form->field($model, 'cellphone', [
        'template' => '<div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">手机号</label></div>
        <div class="weui_cell_bd weui_cell_primary">{input}</div>
            </div>{error}',
        'inputOptions' => [
            'class'=>'weui_input',
            'placeholder'=>'请输入手机号',
        ],
    ])->label(false);?>

</div>
<div class="weui_cells weui_cells_form">
    <?= $form->field($model, 'age', [
        'template' => '<div class="weui_cell weui_cell_select weui_select_after">
            <div class="weui_cell_hd">
                <label for="" class="weui_label">年龄</label>
            </div>
            <div class="weui_cell_bd weui_cell_primary">{input}</div>
        </div>{error}',
        'inputOptions' => [
            'class'=>'weui_select',
        ],
    ])->dropDownList($ages,['prompt'=>'请选择'])->label(false);?>
    <?= $form->field($model, 'height', [
        'template' => '<div class="weui_cell weui_cell_select weui_select_after">
            <div class="weui_cell_hd">
                <label for="" class="weui_label">身高</label>
            </div>
            <div class="weui_cell_bd weui_cell_primary">{input}</div>
        </div>{error}',
        'inputOptions' => [
            'class'=>'weui_select',
        ],
    ])->dropDownList($heights,['prompt'=>'请选择'])->label(false);?>

    <?= $form->field($model, 'weight', [
        'template' => '<div class="weui_cell weui_cell_select weui_select_after">
            <div class="weui_cell_hd">
                <label for="" class="weui_label">体重</label>
            </div>
            <div class="weui_cell_bd weui_cell_primary">{input}</div>
        </div>{error}',
        'inputOptions' => [
            'class'=>'weui_select',
        ],
    ])->dropDownList($weights,['prompt'=>'请选择'])->label(false);?>
    </div>
<div class="weui_cells weui_cells_form">
        <?= $form->field($model, 'annual_salary', [
            'template' => '<div class="weui_cell weui_cell_select weui_select_after">
                <div class="weui_cell_hd">
                    <label for="" class="weui_label">年薪情况</label>
                </div>
                <div class="weui_cell_bd weui_cell_primary">{input}</div>
            </div>{error}',
            'inputOptions' => [
                'class'=>'weui_select',
            ],
        ])->dropDownList($salaries,['prompt'=>'请选择'])->label(false);?>
        <?= $form->field($model, 'marry', [
            'template' => '<div class="weui_cell weui_cell_select weui_select_after">
                <div class="weui_cell_hd">
                    <label for="" class="weui_label">婚姻情况</label>
                </div>
                <div class="weui_cell_bd weui_cell_primary">{input}</div>
            </div>{error}',
            'inputOptions' => [
                'class'=>'weui_select',
            ],
        ])->dropDownList($marries,['prompt'=>'请选择'])->label(false);?>
        <?= $form->field($model, 'car_type', [
            'template' => '<div class="weui_cell weui_cell_select weui_select_after">
                <div class="weui_cell_hd">
                    <label for="" class="weui_label">汽车型号</label>
                </div>
                <div class="weui_cell_bd weui_cell_primary">{input}</div>
            </div>{error}',
            'inputOptions' => [
                'class'=>'weui_select',
            ],
        ])->dropDownList($cars,['prompt'=>'请选择'])->label(false);?>

    </div>
<div class="weui_cells weui_cells_form">
    <?= $form->field($model, 'offten_go', [
        'template' => '<div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">常去地</label></div>
        <div class="weui_cell_bd weui_cell_primary">{input}</div>
            </div>{error}',
        'inputOptions' => [
            'class'=>'weui_input',
            'placeholder'=>'请输入常去地',
        ],
    ])->label(false);?>

    <?= $form->field($model, 'job', [
        'template' => '<div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">工作职业</label></div>
        <div class="weui_cell_bd weui_cell_primary">{input}</div>
            </div>{error}',
        'inputOptions' => [
            'class'=>'weui_input',
            'placeholder'=>'请输入工作职业',
        ],
    ])->label(false);?>
    <?= $form->field($model, 'province', [
        'template' => '<div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">入会地区</label></div>
        <div class="weui_cell_bd weui_cell_primary">{input}</div>
            </div>{error}',
        'inputOptions' => [
            'class'=>'weui_input',
            'placeholder'=>'请输入微信号',
            'disabled'=>true,
        ],
    ])->label(false);?>
</div>
<div class="weui_cells weui_cells_form">
    <?= $form->field($model, 'hobby', [
        'template' => '<div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">{input}<div class="weui_textarea_counter"><span>0</span>/200</div></div>
            </div>',
        'inputOptions' => [
            'class'=>'weui_textarea',
        ],
    ])->textarea(['placeholder'=>'兴趣爱好'])->label(false);?>
</div>
<div class="weui_cells weui_cells_form">
    <?= $form->field($model, 'like_type', [
        'template' => '<div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">{input}<div class="weui_textarea_counter"><span>0</span>/200</div></div>
            </div>',
        'inputOptions' => [
            'class'=>'weui_textarea',
        ],
    ])->textarea(['placeholder'=>'喜欢妹子类型'])->label(false);?>
</div>
<div class="weui_cells weui_cells_form">
    <?= $form->field($model, 'remarks', [
        'template' => '<div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">{input}<div class="weui_textarea_counter"><span>0</span>/200</div></div>
            </div>',
        'inputOptions' => [
            'class'=>'weui_textarea',
        ],
    ])->textarea(['placeholder'=>'备注'])->label(false);?>
</div>
<?php if($model->status==0):?>
<div class="weui_btn_area">
    <?= Html::submitButton('下一步', ['class' => 'weui_btn weui_btn_primary','id'=>'submit_signup','name' => 'login-button']) ?>
</div>
<div class="weui_cells_tips text-center" style="font-size: 12px;">确定即表示同意十三平台<a id="vRegShowPro" href="javascript:;" class="aTxt">注册服务条款及隐私政策</a></div>
<?php
$this->registerJs("
    var Q2 = new QiniuJsSDK();
    var uploader2 = Q2.uploader({
        runtimes: 'html5,flash,html4',
        browse_button: 'pickfiles',
        container: 'container',
        drop_element: 'container',
        max_file_size: '100mb',
        flash_swf_url: 'http://jssdk.demo.qiniu.io/js/plupload/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        uptoken_url: $('#uptoken_url').val(),
        domain: $('#domain').val(),
        auto_start: true,
        init: {
            'FilesAdded': function(up, files) {
                $('table').show();
                $('#success').hide();
                plupload.each(files, function(file) {
                    var progress = new FileProgress(file, 'fsUploadProgresss');
                    progress.setStatus('0%');
                });
                 
            },
            'BeforeUpload': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgresss');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                if (up.runtime === 'html5' && chunk_size) {
                    progress.setChunkProgess(chunk_size);
                }
            },
            'UploadProgress': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgresss');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                progress.setProgress(file.percent + '%', file.speed, chunk_size);
                $('#container').hide();
                
            },
            'UploadComplete': function() {
                $('.weui_cell_ftsw span').html(1);
            },
            'FileUploaded': function(up, file, info) {
                var progress = new FileProgress(file, 'fsUploadProgresss');
                progress.setComplete(up, info);
                saveWeima(info,file.id);
            },
            'Error': function(up, err, errTip) {
                $('table').show();
                var progress = new FileProgress(err.file, 'fsUploadProgresss');
                progress.setError();
                progress.setStatus(errTip);
            },
              'Key': function(up, file) {
                var hash = md5(file.id);
                var date = getDate();
                var key = date+hash+'.png';
                return key
            }
        }
    });
    Qiniu.uploader({
        runtimes: 'html5,flash,html4',
        browse_button: 'pickfiles2',
        container: 'container2',
        drop_element: 'container2',
        max_file_size: '100mb',
        flash_swf_url: 'http://jssdk.demo.qiniu.io/js/plupload/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        uptoken_url: $('#uptoken_url').val(),
        domain: $('#domain').val(),
        auto_start: true,
        init: {
            'FilesAdded': function(up, files) {
                $('table').show();
                $('#success').hide();
                plupload.each(files, function(file) {
                    var progress = new FileProgress(file, 'fsUploadProgress');
                    progress.setStatus('0%');
                });
            },
            'BeforeUpload': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                if (up.runtime === 'html5' && chunk_size) {
                    progress.setChunkProgess(chunk_size);
                }
                  if($('#fsUploadProgress').children('li').length>=6){
                    $('#container2').hide();
                }
            },
            'UploadProgress': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));

                progress.setProgress(file.percent + '%', file.speed, chunk_size);
            },
            'UploadComplete': function(up, file) {
                $('.weui_cell_fts span').html(parseInt($('.weui_cell_fts span').html())+1);
                 if($('#fsUploadProgress').children('li').length>=6){
                    $('#container2').hide();
                }
            },
            'FileUploaded': function(up, file, info) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                progress.setComplete(up, info);
                save(info,file.id);
            },
            'Error': function(up, err, errTip) {
                $('table').show();
                var progress = new FileProgress(err.file, 'fsUploadProgress');
                progress.setError();
                progress.setStatus(errTip);
            },
            'Key': function(up, file) {
                var hash = md5(file.id);
                var date = getDate();
                var key = date+hash+'.png';
                return key
            }
        }
    });

");
?>
<script>
        function getDate(){
            var mydate = new Date();
            var str = "" + mydate.getFullYear() + "/";
            str += (mydate.getMonth()+1) + "/";
            str += mydate.getDate() + "/";
            return str;
        }
        function deleteImg(id,content) {
            var con = $(content);
            if(confirm("确定删除当按照吗？")){
                $.get('male/default/delete-img?id='+id,function (data) {
                    var first = con.parent('ul').is('#fsUploadProgress');
                    con.remove();
                    if(!first){
                        $('#container').show();
                        $('.weui_cell_ftsw span').html(0);
                    }else {
                        $('.weui_cell_fts span').html(parseInt($('.weui_cell_fts span').html())-1);
                        if($('#fsUploadProgress').children('li').length<6){
                            $('#container2').fadeIn();
                        }
                    }
                });
            }
        }
        function saveWeima(parms,fileId) {
            $.get('male/default/save-weima?id=<?=$model->id?>&data='+parms+'&fileID='+fileId,function (data) {});
        }
        function save(parms,fileId) {
            $.get('male/default/save?id=<?=$model->id?>&data='+parms+'&fileID='+fileId,function (data) {});
        }

        $(function () {

            if($('.weui_cell_ftsw span').html()!=0){
                $('#container').hide();
            }
            $('.weui_textarea',this).keyup(function () {
                $(this).siblings('.weui_textarea_counter').children('span').html( $(this).val().length);
            });
        });
    </script>
<?php endif;?>
<?php ActiveForm::end(); ?>

