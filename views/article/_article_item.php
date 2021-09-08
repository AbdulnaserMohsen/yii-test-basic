<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/*@var $model \app\models\Article */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div>
    <a href="<?= Url::to(['article/view','id'=> $model->id]) ?>">
        <h3> <?= Html::encode($model->title)   ?> </h3>
    </a>
    <div>
        <?= StringHelper::truncateWords(Html::encode($model->body),40) ?>
    </div>
    <hr>
</div>