<?php

class ApplyInfo extends Eloquent {

    protected $table = 'user';

    public static function trimSpaces($form_data) {
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
        Input::merge($form_data_trimmed);
        Input::flash();
        return $form_data_trimmed;
    }

    public static function hobbyAutoCheck() {
        //チェックボックスへの自動入力
        $hobbies = array(
            1 => Input::get('hobby.1'),
            2 => Input::get('hobby.2'),
            3 => "その他：",
            4 => Input::get('hobby.4')
        );
        if (!empty(Input::get('hobby.4')) && empty(Input::get('hobby.3'))) {
            Input::merge(array('hobby' => $hobbies));
            Input::flash();
        }
    }


}
