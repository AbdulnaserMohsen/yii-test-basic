<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="articles-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <small class="text-muted center-block"><?= Html::encode( Yii::$app->formatter->asDatetime($model->created_at) ) ?></small>
    <small class="text-muted center-block"><?= Html::encode( Yii::$app->formatter->asRelativetime($model->created_at) ) ?></small>

    <div>
        <?php if(!Yii::$app->user->isGuest): ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>
    </div>
    
    <blockquote>
        <p> <?= Html::encode($model->body) ?> </p>
        <footer> <?= Html::encode($model->createdBy->user_name) ?> </footer>
    </blockquote>

</div>
