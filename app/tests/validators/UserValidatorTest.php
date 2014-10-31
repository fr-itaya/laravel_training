<?php

class UserValidatorTest extends TestCase {

    private $validator;

    public function setUp() {
        parent::setUp();
        $this->validator = new UserValidator;
    }

    public function testValidatePasses() {
        $input_data_passes = array(
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
        $v = $this->validator->validate($input_data_passes);
        $this->assertTrue($v->passes());
    }

    /**
     * @dataProvider provider
     */
    public function testValidateFails($input_data) {
        $v = $this->validator->validate($input_data);
        $this->assertTrue($v->fails());
    }

    public function provider() {
        return array(
            //未入力
            array(
                array(
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
                )
            ),
            //全項目引っかかる
            array(
                array(
                    'last_name'            => 'test',
                    'first_name'           => 'test',
                    'sex'                  => '',
                    'postalcode.zone'      => '12345',
                    'postalcode.district'  => '45678',
                    'pref_id'              => '48',
                    'email'                => 'clouds_over_the_slope_nxk.jp',
                    'hobby'              => array(
                        1              => '',
                        2              => '',
                        3              => 'その他：',
                        4              => ''
                    )
                )
            ),
            //名前が全角でない
            array(
                array(
                    'last_name'            => '秋山',
                    'first_name'           => 'Yoshifuru',
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
                )
            ),
            //名前が51字以上
            array(
                array(
                    'last_name'            => '秋山',
                    'first_name'           => '○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○',
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
                )
            ),
            //性別未入力
            array(
                array(
                    'last_name'            => '秋山',
                    'first_name'           => '好古',
                    'sex'                  => '',
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
                )
            ),
            //郵便番号が1桁多い
            array(
                array(
                    'last_name'            => '秋山',
                    'first_name'           => '好古',
                    'sex'                  => '男性',
                    'postalcode.zone'      => '1234',
                    'postalcode.district'  => '4567',
                    'pref_id'              => '38',
                    'email'                => 'clouds_over_the_slope@nxk.jp',
                    'hobby'              => array(
                        1              => '',
                        2              => '',
                        3              => 'その他：',
                        4              => '読書'
                    )
                )
            ),
            //郵便番号が数字でない
            array(
                array(
                    'last_name'            => '秋山',
                    'first_name'           => '好古',
                    'sex'                  => '男性',
                    'postalcode.zone'      => 'test',
                    'postalcode.district'  => '4567',
                    'pref_id'              => '38',
                    'email'                => 'clouds_over_the_slope@nxk.jp',
                    'hobby'              => array(
                        1              => '',
                        2              => '',
                        3              => 'その他：',
                        4              => '読書'
                    )
                )
            ),
            //郵便番号が1桁足りない
            array(
                array(
                    'last_name'            => '秋山',
                    'first_name'           => '好古',
                    'sex'                  => '男性',
                    'postalcode.zone'      => '12',
                    'postalcode.district'  => '4567',
                    'pref_id'              => '38',
                    'email'                => 'clouds_over_the_slope@nxk.jp',
                    'hobby'              => array(
                        1              => '',
                        2              => '',
                        3              => 'その他：',
                        4              => '読書'
                    )
                )
            ),
            //存在しない都道府県ID
            array(
                array(
                    'last_name'            => '秋山',
                    'first_name'           => '好古',
                    'sex'                  => '男性',
                    'postalcode.zone'      => '123',
                    'postalcode.district'  => '4567',
                    'pref_id'              => '48',
                    'email'                => 'clouds_over_the_slope@nxk.jp',
                    'hobby'              => array(
                        1              => '',
                        2              => '',
                        3              => 'その他：',
                        4              => '読書'
                    )
                )
            ),
            //emailの書式に沿っていない
            array(
                array(
                    'last_name'            => '秋山',
                    'first_name'           => '好古',
                    'sex'                  => '男性',
                    'postalcode.zone'      => '123',
                    'postalcode.district'  => '4567',
                    'pref_id'              => '38',
                    'email'                => 'clouds_over_the_slope_nxk.jp',
                    'hobby'              => array(
                        1              => '',
                        2              => '',
                        3              => 'その他：',
                        4              => '読書'
                    )
                )
            ),
            //その他の詳細が入力されていない
            array(
                array(
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
                        4              => ''
                    )
                )
            )
        );
    }
}
