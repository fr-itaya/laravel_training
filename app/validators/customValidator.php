<?php

class CustomValidator {
    public function regexFullWidthChars ($attribute, $value) {
        $pattern = "/(?:\xEF\xBD[\xA0-\xBF]|\xEF\xBE[\x80-\x9F])|[\x20-\x7E]/";
        if (preg_match($pattern, $value)) return false;
        return true;
    }
}
