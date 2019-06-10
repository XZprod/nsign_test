<?php

namespace common\models;

use Yii;

class Category extends \yii\base\Model
{
    const DEFAULT_SRC = '@rootdir/xml/categories.xml';
    public $id;
    public $name;

    public static function loadMultipleFromXML($src = self::DEFAULT_SRC)
    {
        $simple = file_get_contents(Yii::getAlias($src));
        $modelArray = self::convertXmlToArray($simple);
        $models = [];
        foreach ($modelArray['item'] as $el) {
            $models[] = new self($el);
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

    public static function getCategoryById($id)
    {
        $categories = self::loadMultipleFromXML();
        foreach ($categories as $category) {
            if ($category->id === $id) return $category;
        }

        return false;
    }
}