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
        'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '5%'],
            ],
            [
                'attribute' => 'user_id',
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->andWhere(['role' => \common\models\User::ROLE_USER])->asArray()->all(), 'id', 'username'),
                'label' => 'Имя пользователя',
                'headerOptions' => ['width' => '45%'],
                'value' => function (\common\models\Balance $model) {
                        return $model->user->username;
                    },
                'footer' => 'Итого'
            ],
            [
                'attribute' => 'value',
                'headerOptions' => ['width' => '25%'],
                'footer' => sprintf('%0.2f', round((\common\models\Balance::getTotalBalance($dataProvider->models)), 2))
            ],
            [
                'attribute' => 'created_at',
                'headerOptions' => ['width' => '25%'],
            ],
        ],
    ]); ?>

</div>

