<?php

namespace common\models;

class Product extends \yii\base\Model
{
    public $id;
    public $categoryId;
    public $price;
    public $hidden;
    public $category;
    public $categoryName;

    public static function loadMultipleFromXML($src)
    {
        $simple = file_get_contents($src);
        $modelArray = self::convertXmlToArray($simple);
        $models = [];
        foreach ($modelArray['item'] as $el) {
            $models[] = self::buildModel($el);
        }

        return $models;
    }

    protected static function convertXmlToArray($xml)
    {
        if (is_string($xml)) {
            $xml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
        $result = (array)$xml;
        foreach ($result as $key => $value) {
            if (!is_scalar($value)) {
                $result[$key] = self::convertXmlToArray($value);
            }
        }

        return $result;
    }

    protected static function buildModel($arrayAttributes)
    {
        $model = new self($arrayAttributes);
        $model->category = Category::getCategoryById($model->categoryId);
        $model->categoryName = $model->category->name;

        return $model;
    }

}