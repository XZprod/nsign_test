<?php

namespace common\models;

use Yii;
use yii\data\ArrayDataProvider;

class ProductSearch extends Product
{

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['price'], 'integer'],
            [['category'], 'string'],
            [['categoryName'], 'string'],
        ];
    }

    public static function search($params)
    {
        $models = Product::loadMultipleFromXML(Yii::getAlias('@rootdir') . '/xml/products.xml');
        $models = array_filter($models, function ($item) {
            return !$item->hidden;
        });

        if (isset($params['id']) && $params['id']) {
            $models = array_filter($models, function ($item) use ($params) {
                return $item->id === $params['id'];
            });
        }

        if (isset($params['price']) && $params['price']) {
            $models = array_filter($models, function ($item) use ($params) {
                return $item->price === $params['price'];
            });
        }

        if (isset($params['categoryName']) && $params['categoryName']) {
            $models = array_filter($models, function ($item) use ($params) {
                return strripos($item->category->name, $params['categoryName']) !== false;
            });
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'sort' => [
                'attributes' => ['id', 'price', 'categoryName'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $dataProvider;
    }
}
