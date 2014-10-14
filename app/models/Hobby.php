<?php

class Hobby {
    public function hobbyAutoCheck($hobbies) {
        //チェックボックスへの自動入力
        if (empty($hobbies[4]))  return true;
        if (!empty($hobbies[3])) return true;
        return false;
    }
}
