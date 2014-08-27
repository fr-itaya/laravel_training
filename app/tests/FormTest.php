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
        $response = $this->call('POST', 'confirm');
        Route::enableFilters();
        $this->assertNotEquals($csrf_token, $response);

    }

    public function testRoutingPostDone()
    {
        $response = $this->call('POST', 'done');
        $this->assertResponseOk();
    }

    //Controller
    //Model

    public function testViewHasPrefValue()
    {
        $this->action('GET', 'FormController@getForm');
        $this->assertViewHas('data');
    }
}
