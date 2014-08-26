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
        $csrf_token = csrf_token();
        $this->session(array(
            '_token' => $csrf_token
            )
        );
        //route fillter(for CSRF test)
        Route::enableFilters();
        $response = $this->client->request('POST', 'confirm');
        $this->assertResponseOk();
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
