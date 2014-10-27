<?php

class FormTest extends TestCase {

    private $input_passes = array(
            'last_name'            => '秋山',
            'first_name'           => '好古',
            'sex'                  => '男性',
            'postalcode.zone'      => '123',
            'postalcode.district'  => '4567',
            'pref_id'              => '38',
            'email'                => 'clouds_over_the_slope@nxk.jp',
            'hobby'              => array(
                1              => '',
                2              => '',
                3              => 'その他：',
                4              => '読書'
            )
        );

    private $input_fails = array(
            'last_name'            => '',
            'first_name'           => '',
            'sex'                  => '',
            'postalcode.zone'      => '',
            'postalcode.district'  => '',
            'pref_id'              => '',
            'email'                => '',
            'hobby'              => array(
                1              => '',
                2              => '',
                3              => '',
                4              => ''
            )
        );

    public function setUp() {
        parent::setUp();
    }

    //routing
    public function testRoutingGetIndex() {
        $response = $this->call('GET', '/');
        $this->assertResponseOk();
    }

    public function testRoutingGetForm() {
        $response = $this->call('GET', 'form');
        $this->assertResponseOk();
    }

    public function testRoutingPostConfirm() {
        $response = $this->call('POST', 'confirm');
        $this->assertResponseOk();
    }

    public function testCsrfRouteFilter() {
        $csrf_token = csrf_token();
        $this->session(['_token' => $csrf_token]);
        Route::enableFilters();
        $response = $this->call('POST', 'confirm');
        $this->assertResponseOk();
    }

    public function testRoutingPostDone() {
        $response = $this->call('POST', 'done');
        $this->assertResponseOk();
    }

    public function testValidateRedirect() {
        $response = $this->call('POST', 'confirm');
        //$this->assertRedirectedTo('form');
    }

    //Controller
    public function testInputandSessionHasTrimedValues() {

    }

    //値を渡す必要があるControllerでViewに値を渡せてるか
    public function testFormReturnsView() {
        $this->action('GET', 'FormController@getForm');
        $this->assertViewHas('data');
    }

    public function testConfirmReturnsView() {
        $this->action('POST', 'FormController@postConfirm');
        $this->assertViewHas('hobby_view');
        $this->assertViewHas('pref_view');
    }

    //Validators
    public function testValidate_true() {
        // $validator = Validator::make($input, $rules);
        // $validator->
        // $this->assertTrue($validator->passes());
    }

    public function testValidate_false() {
        //$validator = new UserValidator;
        $this->action('POST', 'FormController@postConfirm');
        //$validator->validate();
        //$this->assertTrue($validator->fails());
        //$this->assertRedirectedTo('form');
        //$this->assertSessionHasErrors();
    }
}
