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
            $regex = "/(?:\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F])|[\x20-\x7E]/u";
            $rules = array(
                'family_name'=>array('required','regex:{{$regex}}', 'max:50'),
                'given_name'=>array('required','regex:{{$regex}}', 'max:50'),
                'sex' => 'required',
                'postalcode' => 'array',
                'postalcode[zone]'     =>'required|numeric|size:3',
                'postalcode[district]' =>'required|numeric|size:4',
                //prefecture
                'email'      =>'required | email'
            );

            $error_messages = array(
                'required' => ':attributeを入力してください',
                'regex'    => ':attributeは全角で入力してください',
                'max'      => ':attributeを:max字以内で入力してください',
                'numeric'  => ':attributeは数字で入力してください',
                'size'   => ':attributeは:size桁で入力してください',
                'email'    => ':attributeを正しく入力してください'
            );

            $names = array(
                'family_name'=> '姓',
                'given_name' => '名',
                'sex' => '性別',
                'postalcode[zone]' => '郵便番号上3桁',
                'postalcode[district]' => '郵便番号下4桁',
                'email' => 'メールアドレス' 
            );


            $validator = Validator::make($form_data, $rules,$error_messages);
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
