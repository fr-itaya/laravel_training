<?php
class FormController extends BaseController {

    public function getIndex() {
        return View::make('index');
    }

    public function getForm() {
        $pref_none = array(0 => '--');
        $pref_name = Prefecture::lists('pref_name', 'pref_id');
        $data['pref_data'] = $pref_none + $pref_name;

        return View::make('form')->with('data', $data);
    }

    public function postConfirm() {
        Input::flash();
        if ($form_data = Input::all()) {
            $form_data_trimmed = ApplyInfo::trimSpaces($form_data);
        Input::merge($form_data_trimmed);
        Input::flash();

            //入力値バリデート
            Validator::extend('regex_full_width_chars', 'CustomValidator@regexFullWidthChars');

            $rules = array(
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

            $error_messages = array(
                'required'               => ':attributeを入力してください',
                'exists'                 => ':attributeを入力してください',
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

            ApplyInfo::hobbyAutoCheck();

            $validator = Validator::make($form_data_trimmed, $rules, $error_messages);
            $validator->setAttributeNames($names);

            if ($validator->fails()) {
                return Redirect::to('form')->withErrors($validator);
            }
        }

        //確認画面表示用(趣味欄に記入あれば)
        $hobby_view = '';
        if (!empty(Input::get('hobby'))) {
            $hobby_view = implode(' ', Input::get('hobby'));
        }

        //確認画面表示用：都道府県(idを名前に変換)
        $pref_view  = Prefecture::where('pref_id', Session::getOldInput('pref_id'))->pluck('pref_name');

        return View::make('confirm')->with(array('hobby_view' => $hobby_view, 'pref_view' => $pref_view));
    }

    public function postDone() {
        Session::reflash();
        if (Session::getOldInput()) {
            $data = array_only(Session::getOldInput(), array('last_name', 'first_name', 'email', 'pref_id'));
            User::create($data);
        }
        return View::make('done');
    }
}
