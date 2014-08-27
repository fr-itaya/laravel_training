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

    //Controller
    //View渡せてるか
    public function testTopReturnsView()
    {
        //Laravel4のヘルパーで行けたはず

    }

    public function testFormReturnsView()
    {

    }

    public function testConfirmReturnsView()
    {

    }

    public function testDoneReturnsView()
    {

    }

    public function testViewHasPrefValue()
    {
        $this->action('GET', 'FormController@getForm');
        $this->assertViewHas('data');
    }

    //Model

}
