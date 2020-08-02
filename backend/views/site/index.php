<?php

/* @var $this yii\web\View */
/* @var $model common\models\Balance */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <?= $this->render('grid',[
        'dataProvider' => $dataProvider
    ]) ?>

</div>

