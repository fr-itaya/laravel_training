<?php

class CustomValidator
{
    public function regexFullWidthChars ($attribute, $value, $param = null)
    {
        if (preg_match("/(?:\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F])|[\x20-\x7E]/", $value)) {
            return false;
        } else {
            return true;
        }
    } 
}
