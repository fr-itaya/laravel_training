<?php

class ApplyInfo {

    public function trimSpaces($form_data) {
        $form_data_trimmed = array();
        foreach ($form_data as $key => $val) {
            if (is_array($val)) {
                //配列の場合
                foreach ($val as $key_array => $val_array) {
                    $form_data_trimmed[$key][$key_array] = trim(mb_convert_kana($val[$key_array], 's', 'utf-8'));
                }
            } else {
                //変数の場合
                $form_data_trimmed[$key] = trim(mb_convert_kana($val, 's', 'utf-8'));
            }
        }
        return $form_data_trimmed;
    }
}
