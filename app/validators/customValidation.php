<?php

class CustomValidator
{
    public function regexFullWidthChars ($attribute, $value)
    {
        $pattern = "/(?:\xEF\xBD[\xA0-\xBF]|\xEF\xBE[\x80-\x9F])|[\x20-\x7E]/";
        if (preg_match($pattern, $value)) {
            return false;
        }
        return true;
    }

    public function pref_required ($attribute, $value)
    {
        $pattern = "/^[1-9]$|^[1-3][0-9]$|^4[0-7]$/";
        if (preg_match($pattern, $value)) {
            return true;
        }
        return false;
    }
}
