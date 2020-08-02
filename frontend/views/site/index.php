<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Balance */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <h3><?= $this->title ?></h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'user_id',
                'label' => 'Имя пользователя',
                'headerOptions' => ['width' => '70%'],
                'value' => function ($model) {
                        return $model->user->username;
                    },
            ],
            [
                'attribute' => 'value',
                'headerOptions' => ['width' => '30%'],
            ],


        ],
    ]); ?>

</div>
