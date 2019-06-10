<?php

use common\models\ProductSearch;
use yii\grid\GridView;

/**
 * @var $this yii\web\View
 * @var $dataProvider \yii\data\ArrayDataProvider
 * @var $filterModel ProductSearch
 */

$this->title = 'Test';
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,
    'columns' => [
        'id',
        'price',
        'categoryName',
    ],
]) ?>