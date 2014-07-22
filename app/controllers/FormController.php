<?php
class FormController extends BaseController {

    public function getIndex() {
        return View::make('index');
    }

    public function getForm() {
        return View::make('form');
    }

    public function postConfirm() {
        Input::flash();
        if ($form_data = Input::all()) {
            $form_data_trimmed = array();
            foreach ($form_data as $key => $val) {
                if (is_array($val)) {
                    //配列の場合
                    foreach ($val as $key_array => $val_array) {
                        $form_data_trimmed[$key][$key_array] = trim(mb_convert_kana($val[$key_array], 's', 'utf-8'));
                    }
                } else {
                    //変数の場合
                    $form_data_trimmed[$key] = trim(mb_convert_kana($val, 's', 'utf-8'));
                }
            }
            
            Validator::extend('regex_full_width_chars', 'CustomValidator@regexFullWidthChars');
            
            $rules = array(
                'family_name'          => array('required', 'regex_full_width_chars', 'max:50'),
                'given_name'           => array('required', 'regex_full_width_chars', 'max:50'),
                'sex'                  => 'required',
                'postalcode'           => 'array',
                'postalcode.zone'      => 'required|regex:/^[0-9]+$/|size:3',
                'postalcode.district'  => 'required|regex:/^[0-9]+$/|size:4',
                //prefecture
                'email'                => 'required | email'
            );

            $error_messages = array(
                'required'                  => ':attributeを入力してください',
                'regex_full_width_chars'    => ':attributeは全角で入力してください',
                'max'                       => ':attributeを:max字以内で入力してください',
                'numeric'                   => ':attributeは数字で入力してください',
                'size'                      => ':attributeは:size桁で入力してください',
                'email'                     => ':attributeを正しく入力してください'
            );

            $names = array(
                'family_name'=> '姓',
                'given_name' => '名',
                'sex' => '性別',
                'postalcode.zone' => '郵便番号上3桁',
                'postalcode.district' => '郵便番号下4桁',
                'email' => 'メールアドレス' 
            );


            $validator = Validator::make($form_data_trimmed, $rules,$error_messages);
            $validator->setAttributeNames($names);

            if ($validator->fails()) {
                return Redirect::to('form')->withErrors($validator);
            }
        }
        $hobby_view = implode(' ', Session::getOldInput('hobby'));
        return View::make('confirm')->with('hobby_view', $hobby_view);
    }

    public function postDone() {
        Session::reflash();
        return View::make('done');
    }
}
