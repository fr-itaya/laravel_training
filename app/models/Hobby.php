<?php

class Hobby {
    public function hobbyAutoCheck($hobbies) {
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
