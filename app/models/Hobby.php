<?php

class Hobby {
    public function hobbyAutoCheck($hobbies) {
        //チェックボックスへの自動入力
        if (empty($hobbies[4]) || !empty($hobbies[3])) {
            return true;
        }
        return false;
    }
}
