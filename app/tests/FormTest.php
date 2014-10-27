<?php

class FormTest extends TestCase {

    private $validator;

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
        $validator = new UserValidator;
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

    //Controller
    //値を渡す必要があるControllerでViewに値を渡せてるか
    public function testFormReturnsView() {
        $response = $this->action('GET', 'FormController@getForm');
        $this->assertEquals('form', $response->original->getName());
        $this->assertViewHas('data');
    }

    public function testConfirmReturnsView() {
        $this->action('POST', 'FormController@postConfirm');
        $this->assertViewHas('hobby_view');
        $this->assertViewHas('pref_view');
    }

    //Validators
    public function testValidate_true() {
        $response = $this->action('POST', 'FormController@postConfirm', array(), $this->input_passes);
        $this->assertEquals('confirm', $response->original->getName());
        $this->assertViewHas('hobby_view', 'その他： 読書');
        $this->assertViewHas('pref_view', '愛媛県');
    }

    public function testPostDoneWithRightinput() {
        $response = $this->action('POST', 'FormController@postDone', array(), $this->input_passes);
        $this->assertEquals('done', $response->original->getName());
        $data = array_only($this->input_passes,
            array('last_name', 'first_name', 'email', 'pref_id'));
        $db_column = User::orderBy('user_id', 'DESC')->first()
            //->pluck('last_name', 'first_name', 'email', 'pref_id')
            ->toArray();
        //$this->assertEquals($data, $db_column);
    }

    public function testValidate_false() {
        $this->action('POST', 'FormController@postConfirm', $this->input_fails);
        $this->assertRedirectedTo('form');
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }
}
