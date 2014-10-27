<?php

class HobbyTest extends TestCase {

    public $hobby;

    public function setUp() {
        parent::setUp();
        $this->hobby = new Hobby;
    }

    public function testHobbyAutoCheck_true_other_exists() {
        $hobbies_filled_all = array(
            1 => '音楽鑑賞',
            2 => '映画鑑賞',
            3 => 'その他：',
            4 => '読書'
        );
        $result = $this->hobby->hobbyAutoCheck($hobbies_filled_all);
        $this->assertTrue($result);
    }

    public function testHobbyAutoCheck_true_other_none() {
        $hobbies_other_none = array(
            1 => '音楽鑑賞',
            2 => '映画鑑賞',
            3 => '',
            4 => ''
        );
        $result = $this->hobby->hobbyAutoCheck($hobbies_other_none);
        $this->assertTrue($result);
    }

    public function testHobbyAutoCheck_false() {
        $hobbies_detail_exists = array(
            1 => '音楽鑑賞',
            2 => '映画鑑賞',
            3 => '',
            4 => '読書'
        );
        $result = $this->hobby->hobbyAutoCheck($hobbies_detail_exists);
        $this->assertFalse($result);
    }
}
