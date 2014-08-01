<?php
class FormController extends BaseController {

    public function getIndex() {
        return View::make('index');
    }

    public function getForm() {
        $pref_none = array(0 => '--');
        $data['pref_data'] = Prefecture::get(['pref_name'])->toArray();
        $data['pref_data'] = array_merge($pref_none, $data['pref_data']);
        $data['pref_data'] = array_flatten($data['pref_data']);

        return View::make('form')->with('data', $data);
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
            Validator::extend('pref_required', 'CustomValidator@pref_required');

            $rules = array(
                'last_name'            => array('required', 'regex_full_width_chars', 'max:50'),
                'first_name'           => array('required', 'regex_full_width_chars', 'max:50'),
                'sex'                  => 'required',
                'postalcode'           => 'array',
                'postalcode.zone'      => 'required|regex:/^[0-9]+$/|size:3',
                'postalcode.district'  => 'required|regex:/^[0-9]+$/|size:4',
                'pref_id'              => 'pref_required',
                'email'                => 'required | email',
                'hobby.4'              => 'required_if:hobby.3,"その他："'
            );

            $error_messages = array(
                'required'               => ':attributeを入力してください',
                'pref_required'          => ':attributeを入力してください',
                'regex_full_width_chars' => ':attributeは全角で入力してください',
                'regex'                  => ':attributeを正しく入力してください',
                'max'                    => ':attributeを:max字以内で入力してください',
                'size'                   => ':attributeを正しく入力してください',
                'email'                  => ':attributeを正しく入力してください',
                'required_if'            => ':attributeを入力してください'
            );

            $names = array(
                'last_name'           => '姓',
                'first_name'          => '名',
                'sex'                 => '性別',
                'postalcode.zone'     => '郵便番号',
                'postalcode.district' => '郵便番号',
                'pref_id'             => '都道府県',
                'email'               => 'メールアドレス',
                'hobby.4'             => 'その他の詳細'
            );

            //チェックボックスへの自動入力
            $hobbies = array(
                1 => Input::get('hobby.1'),
                2 => Input::get('hobby.2'),
                3 => "その他：",
                4 => Input::get('hobby.4')
            );
            if (Input::has('hobby.4') && empty(Input::get('hobby.3'))) {
                Input::merge(array('hobby' => $hobbies));
                Input::flash();
            }

            $validator = Validator::make($form_data_trimmed, $rules,$error_messages);
            $validator->setAttributeNames($names);

            if ($validator->fails()) {
                return Redirect::to('form')->withErrors($validator);
            }
        }

        //確認画面表示用
        $hobby_view = implode(' ', Session::getOldInput('hobby'));
        return View::make('confirm')->with('hobby_view', $hobby_view);
    }

    public function postDone() {
        Session::reflash();
        if(Session::getOldInput()) {
          // $data['last_name'] = Session::getOldInput('family_name');
          // $data['first_name'] = Session::getOldInput('given_name');
          // $data['email'] = Session::getOldInput('email');
          // $data['pref_id'] = Session::getOldInput('prefecture');
          $data = array_only(Session::getOldInput(), array('last_name', 'first_name', 'email', 'pref_id'));
          $create = User::create($data);
        }
        return View::make('done');
    }
}
