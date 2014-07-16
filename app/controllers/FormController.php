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
        $hobby_view = implode(' ', Session::getOldInput('hobby'));
        return View::make('confirm')->with('hobby_view', $hobby_view);
    }

    public function postDone() {
        Session::reflash();
        return View::make('done');
    }


}
