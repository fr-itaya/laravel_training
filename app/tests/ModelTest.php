<?php

class ModelTest extends TestCase {

    public $apply;

    public function setUp()
    {
        parent::setUp();
    }

    //空白トリム
    public function testTrimSpaces()
    {
        $data = array(
            "name"  => "名取　",
            "age"   => " 25",
            "hobby" => array(
                1 => " 音楽鑑賞",
                2 => "　読書"
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
        $result = ApplyInfo::trimSpaces($data);
        $this->assertEquals($expected, $result);
    }
}
