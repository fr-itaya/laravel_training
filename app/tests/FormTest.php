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
        'hobby'                => array(
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
        'hobby'                => array(
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

    //Controller
    //値を渡す必要があるControllerでViewに値を渡せてるか
    public function testFormReturnsView() {
        $response = $this->action('GET', 'FormController@getForm');
        $this->assertEquals('form', $response->original->getName());
    }

    public function testFormReturnsViewWithValue() {
        $response = $this->action('GET', 'FormController@getForm');
        $this->assertViewHas('data');
    }

    public function testConfirmReturnsViewWithValues_hobbies() {
        $this->action('POST', 'FormController@postConfirm');
        $this->assertViewHas('hobby_view');
    }

    public function testConfirmReturnsViewWithValues_prefName() {
        $this->action('POST', 'FormController@postConfirm');
        $this->assertViewHas('pref_view');
    }

    //バリデータが通った後の挙動
    public function testConfirmReturnsView_rightInput() {
        $response = $this->action('POST', 'FormController@postConfirm', array(), $this->input_passes);
        $this->assertEquals('confirm', $response->original->getName());
    }

    public function testConfirmViewWithRightValues_rightInput_hobbies() {
        $response = $this->action('POST', 'FormController@postConfirm', array(), $this->input_passes);
        $this->assertViewHas('hobby_view', 'その他： 読書');
    }

    public function testViewWithRightValues_rightInput_prefName() {
        $response = $this->action('POST', 'FormController@postConfirm', array(), $this->input_passes);
        $this->assertViewHas('pref_view', '愛媛県');
    }

    public function testDoneReturnsView_rightInput() {
        $response = $this->action('POST', 'FormController@postDone', array(), $this->input_passes);
        $this->assertEquals('done', $response->original->getName());
    }

    public function testDoneCreatesUser_rightInput() {
        // Controller呼び出し
        // Session::getoldInput()のデータを基にクエリを組み立てるので,
        // 先に確認画面のコントローラに入力値を渡して呼び出す
        $this->action('POST', 'FormController@postConfirm', array(), $this->input_passes);
        $this->action('POST', 'FormController@postDone');

        // 追加したテスト用データとDBの最新レコード1件を比較
        $db_column = array('last_name', 'first_name', 'email', 'pref_id');
        $test_user = array_only($this->input_passes, $db_column);
        $latest_record = User::orderBy('user_id', 'DESC')
                             ->first()
                             ->toArray();
        $latest_user = array_only($latest_record, $db_column);

        $this->assertEquals($test_user, $latest_user);

        // assertionが終ったらテスト内で追加したレコードを削除
        $latest_user_id = User::max('user_id');
        User::where('user_id', '=', $latest_user_id)
            ->delete();
    }

    // バリデータを通らない入力パターンだった場合の挙動についてのみ見ている
    public function testConfirmRedirectToForm_falseInput() {
        $this->action('POST', 'FormController@postConfirm', $this->input_fails);
        $this->assertRedirectedTo('form');
    }

    public function testRedirectHasOlsInput_falseInput() {
        $this->action('POST', 'FormController@postConfirm', $this->input_fails);
        $this->assertHasOldInput();
    }

    public function testRedirectHasErrors_falseInput() {
        $this->action('POST', 'FormController@postConfirm', $this->input_fails);
        $this->assertSessionHasErrors();
    }
}
