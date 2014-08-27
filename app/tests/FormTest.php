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
    public function testValidateFirstName()
    {

    }

    public function testValidateLastName()
    {

    }

    public function testValidateSex()
    {

    }

    public function testValidatePostalCode()
    {

    }

    public function testValidatePrefId_true()
    {

    }

    public function testValidatePrefId_false()
    {

    }

    public function testValidateEmail_true()
    {

    }

    public function testValidateEmail_false()
    {

    }

    public function testValidateHobbyDetail()
    {

    }

    //Model

}
