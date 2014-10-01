<?php

class HobbyTest extends TestCase {

    public $hobby;

    public function setUp()
    {
        parent::setUp();
    }

    public function testHobbyAutoCheck_true()
    {
        $hobbies_detail_none = array(
            1 => '音楽鑑賞',
            2 => '映画鑑賞',
            3 => 'その他：',
            4 => ''
        );
        $hobby = new Hobby;
        $result = $hobby->hobbyAutoCheck($hobbies_detail_none);
        $this->assertTrue($result);
    }

    public function testHobbyAutoCheck_false()
    {
        $hobbies_detail_exists = array(
            1 => '音楽鑑賞',
            2 => '映画鑑賞',
            3 => '',
            4 => '読書'
        );
        $hobby = new Hobby;
        $result = $hobby->hobbyAutoCheck($hobbies_detail_exists);
        $this->assertFalse($result);
    }

}
