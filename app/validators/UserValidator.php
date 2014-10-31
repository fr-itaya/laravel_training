<?php

class UserValidator
{
    private $rules = array(
        'last_name'            => array('required', 'regex_full_width_chars', 'max:50'),
        'first_name'           => array('required', 'regex_full_width_chars', 'max:50'),
        'sex'                  => 'required',
        'postalcode'           => 'array',
        'postalcode.zone'      => 'required|regex:/^[0-9]+$/|size:3',
        'postalcode.district'  => 'required|regex:/^[0-9]+$/|size:4',
        'pref_id'              => 'exists:prefectures,pref_id',
        'email'                => 'required | email',
        'hobby.4'              => 'required_if:hobby.3,"その他："'
    );

    private $error_messages = array(
        'required'               => ':attributeを入力してください',
        'exists'                 => ':attributeを入力してください',
        'regex_full_width_chars' => ':attributeは全角で入力してください',
        'regex'                  => ':attributeを正しく入力してください',
        'max'                    => ':attributeを:max字以内で入力してください',
        'size'                   => ':attributeを正しく入力してください',
        'email'                  => ':attributeを正しく入力してください',
        'required_if'            => ':attributeを入力してください'
    );

    private $names = array(
        'last_name'           => '姓',
        'first_name'          => '名',
        'sex'                 => '性別',
        'postalcode.zone'     => '郵便番号',
        'postalcode.district' => '郵便番号',
        'pref_id'             => '都道府県',
        'email'               => 'メールアドレス',
        'hobby.4'             => 'その他の詳細'
    );

    public function validate($input_data) {
        Validator::extend('regex_full_width_chars', 'CustomValidator@regexFullWidthChars');
        $validator = Validator::make($input_data, $this->rules, $this->error_messages);
        $validator->setAttributeNames($this->names);
        return $validator;
    }
}
