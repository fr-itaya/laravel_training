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
        $apply = new ApplyInfo;
        $hobby = new Hobby;
        $validator = new UserValidator;

        Input::flash();
        if ($form_data = Input::all()) {
            $form_data_trimmed = $apply->trimSpaces($form_data);
        Input::merge($form_data_trimmed);
        Input::flash();

            $hobbies = array(
                1 => Input::get('hobby.1'),
                2 => Input::get('hobby.2'),
                3 => "その他：",
                4 => Input::get('hobby.4')
            );

            $hobby_checked = $hobby->hobbyAutoCheck($hobbies);
            if (!$hobby_checked) {
                Input::merge(array('hobby' => $hobbies));
                Input::flash();
            }

            $v = $validator->validate($apply_info);
            if ($v->fails()) {
                return Redirect::to('form')->withErrors($v);
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
