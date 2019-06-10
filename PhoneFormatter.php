<?php

namespace common\helpers;

class PhoneFormatter extends \yii\i18n\Formatter
{

    const DEFAULT_MASK = '(000) 000-00-00';

    public function asPhone($number, $mask = self::DEFAULT_MASK)
    {
        $len = mb_strlen($number);
        $numMask = '/' . str_pad('', $len * 4, '(\d)') . '/';
        $regexMask = $this->fillRegexByParams($mask);
        $outputNumber = preg_replace($numMask, $regexMask, $number);

        return $outputNumber;

    }

    protected function fillRegexByParams($mask)
    {
        $maskLen = mb_strlen($mask);
        $outputMask = '';
        $current = 1;
        for ($i = 0; $i < $maskLen; $i++) {
            if ($mask[$i] === '0') {
                $outputMask .= '$' . $current;
                $current++;
            } else {
                $outputMask .= $mask[$i];
            }
        }

        return $outputMask;
    }
}