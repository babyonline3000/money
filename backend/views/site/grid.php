<?php
/**
 * Created by PhpStorm.
 * User: Cosmos
 * Date: 02.08.20
 * Time: 18:31
 */
use common\models\User;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var \common\models\User $webUser */
$webUser = Yii::$app->user->identity;
?>
<h3><?= $this->title ?></h3>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => 0.00],
//        'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => ['width' => '5%'],
        ],
        [
            'attribute' => 'username',
            'headerOptions' => ['width' => '66%'],
        ],
        [
            'attribute' => 'sum',
            'label' => 'Сумма',
            'headerOptions' => ['width' => '28%'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => $webUser->role == User::ROLE_ADMIN ?  'Добавить денег' : '',
            'headerOptions' => ['width' => '1%'],
            'template' => '{add}',
            'buttons' => [
                'add' => function ($url,\common\models\User $model, $key) use ($webUser){
                        return $webUser->role == User::ROLE_ADMIN ? Html::button('Добавить денег', [
                            'class' => 'btn btn-default',
                            'data' => [
                                'toggle' => 'modal',
                                'target' => '#myModalCash',
                                'user_id' => $model->id
                            ],
                        ]) : '';
                    },
            ],
        ],
    ],
]); ?>

    <!--модальное окно пополнение средств-->
<?php
$model = new \common\models\Balance();
Modal::begin([
    'id' => 'myModalCash',
    'header' => '<h4 style="padding-left: 10px">Пополнение средств</h4>',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
    'size' => Modal::SIZE_DEFAULT,
    'footer' => '<button type="submit" class="btn btn-success btn-md" id="but_save_cash">Пополнить</button>',
]);?>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'id' => 'form_cash',
    'method' => 'POST',
    'action' => ['site/add'],
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-lg-4',
            'offset' => 'col-lg-offset-0',
            'wrapper' => 'col-lg-8',
        ],
    ],
]); ?>

<?= $form->field($model, 'user_id')->hiddenInput([
    'id' => 'user_id_hidden',
])->label(false) ?>

<?= $form->field($model, 'value')->textInput([
    'id' => 'id_form_balans_cash',
    'type' => 'number',
    'min' => 1,
    'max' => 1000000,
    'placeholder' => 'Внесите средства',
]) ?>


<?php ActiveForm::end(); ?>
<?php Modal::end();?>

<?php
$script = <<<JS
    $(function(){
        $('button[data-target="#myModalCash"]').on('click',function(){
            var r = $(this).data('user_id');
            $('#user_id_hidden').val(r);
        });

        $('#but_save_cash').on('click',function(){
            if(($('#id_form_balans_cash').val()) === ''){
                alert('Внесите сумму !');
            }else{
                $('#myModalCash').modal('hide');
                var form = $('#form_cash').serializeArray();
                var arr = $('#form_cash');
                console.log(form);//return;
                $.post({
                    type : arr.attr('method'),
                    url : arr.attr('action'),
                    data : form
                }).done(function(response) {
                        if(response == 444){
                            alert('Пополнение не возможно! Пользователь не зарегистрирован или заблокирован! Обратитесь в службу поддержки.');
                        }else{
//                            $('.site-index').html(response);
                            $('#id_form_balans_cash').val(null);
                            $('#user_id_hidden').val(null);
                            $('#myModalCash').modal('hide');
                        }
                    }).fail(function() {
                        console.log('error');
                    });
                return false;
            }
        });
    })
JS;
$this->registerJs($script,yii\web\View::POS_END);
?>