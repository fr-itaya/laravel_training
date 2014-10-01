<?php

class ApplyInfoTest extends TestCase {

    public $apply;

    public function setUp()
    {
        parent::setUp();
    }

    public function testTrimSpaces()
    {
        $input = array(
            "name"  => "名取　", //末尾全角
            "age"   => "25 ",    //末尾半角
            "hobby" => array(
                1 => " 音楽鑑賞",//先頭半角
                2 => "　読書"    //先頭全角
            )
        );

        $expected = array(
            "name"  => "名取",
            "age"   => "25",
            "hobby" => array(
                1 => "音楽鑑賞",
                2 => "読書"
            )
        );
        \Illuminate\Support\Facades\Request::setSession($this->app['session.store']);
        $apply = new ApplyInfo;
        $result = $apply->trimSpaces($input);
        $this->assertEquals($expected, $result);
    }

}
