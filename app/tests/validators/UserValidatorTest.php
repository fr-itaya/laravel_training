<?php

class UserValidatorTest extends TestCase {

    private $validator;

    public function setUp()
    {
        parent::setUp();
        $this->validator = new UserValidator;
    }

    public function testValidatePasses()
    {
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
    public function testValidateFails($input_data)
    {
        $v = $this->validator->validate($input_data);
        $this->assertTrue($v->fails());
    }

    public function provider()
    {
        return array(
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
            array(
                array(
                    'last_name'            => 'test',
                    'first_name'           => 'test',
                    'sex'                  => 'その他',
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
            )
        );
    }

}
