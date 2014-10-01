<?php

class FormTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
    }

    //routing
    public function testRoutingGetIndex()
    {
        $response = $this->call('GET', '/');
        $this->assertResponseOk();
    }

    public function testRoutingGetForm()
    {
        $response = $this->call('GET', 'form');
        $this->assertResponseOk();

    }

    public function testRoutingPostConfirm()
    {
        $response = $this->call('POST', 'confirm');
        $this->assertResponseOk();
    }

    public function testCsrfRouteFilter()
    {
        $csrf_token = csrf_token();
        $this->session(['_token' => $csrf_token]);
        Route::enableFilters();
        $response = $this->call('POST', 'confirm');
        $this->assertResponseOk();

    }

    public function testRoutingPostDone()
    {
        $response = $this->call('POST', 'done');
        $this->assertResponseOk();
    }

    public function testValidateRedirect()
    {
        $response = $this->call('POST', 'confirm');
        //$this->assertRedirectedTo('form');
    }

    //Controller
    //空白トリム
    public function testTrimSpaces()
    {
        $input = array(
            "name"  => "名取　",
            "age"   => "25 ",
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
        $result = $this->FormController->trimSpaces($input);//undefined property
        $this->assertEquals($expected, $result);
        $this->assertSessionHas($expected);
    }
    //値を渡す必要があるControllerでViewに値を渡せてるか

    public function testFormReturnsView()
    {
        $this->action('GET', 'FormController@getForm');
        $this->assertViewHas('data');
    }

    public function testConfirmReturnsView()
    {
        $this->action('POST', 'FormController@postConfirm');
        $this->assertViewHas('hobby_view');
        $this->assertViewHas('pref_view');

    }

    //Validators
    public function testValidate_true()
    {
        // $validator = Validator::make($input, $rules);
        // $validator->
        // $this->assertTrue($validator->passes());
    }

    public function testValidate_false()
    {
        $this->action('POST', 'FormController@postConfirm');
        // $this->assertRedirectedTo('form');
        // $this->assertSessionHasErrors();
    }

}
