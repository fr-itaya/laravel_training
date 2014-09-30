<?php
//use Mockery as m;
//use Illuminate\Http\Request;

class ModelTest extends TestCase {

    public $apply;

    public function setUp()
    {
        parent::setUp();
        //$request = Request::create('foo');
        //$session = m::mock('Symfony\Component\HttpFoundation\Session\SessionInterface');
        //$request = Request::setSession($session);
    }

    public function tearDown()
    {
        //m::close();
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

        //Request::setSession($this->app['session.store']);
        $result = ApplyInfo::trimSpaces($data);
        $this->assertEquals($expected, $result);
    }
}
