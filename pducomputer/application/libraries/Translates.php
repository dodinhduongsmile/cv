<?php
use \Statickidz\GoogleTranslate;
class Translates extends CI_Model
{
    public function trans($text){
        $source = 'en';
        $target = 'vi';
        $trans = new \Statickidz\GoogleTranslate();
        $result = $trans->translate($source, $target, $text);
        return $result;
    }
}