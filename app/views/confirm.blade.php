@extends('layouts.master')

@section('title')
  確認画面
@stop

@section('body')
  <header>
    <h1>フォーム>確認</h1>
  </header>
  ▼POST
  <pre><?php var_dump($_POST) ?></pre>
  ▼SESSION
  <pre><?php var_dump(Session::getOldInput()); ?></pre>
  <section>
    <p>
      <table>

        <tr>
          <th>姓</th>
          <td>
            {{{ Input::get('last_name') }}}
          </td>
        </tr>

        <tr>
          <th>名</th>
          <td>
            {{{ Input::get('first_name') }}}
          </td>
        </tr>

        <tr>
          <th>性別</th>
          <td>
            {{{ Input::get('sex') }}}
          </td>
        </tr>

        <tr>
          <th>郵便番号</th>
          <td>
            {{{ Input::get('postalcode.zone') }}}-{{{ Input::get('postalcode.district') }}}
          </td>
        </tr>

        <tr>
          <th>都道府県</th>
          <td>
            {{{ $pref_view }}}
          </td>
        </tr>

        <tr>
          <th>メールアドレス</th>
          <td>
            {{{ Input::get('email') }}}
          </td>
        </tr>

        <tr>
          <th>趣味</th>
          <td>
            {{{ $hobby_view }}}
          </td>
        </tr>

        <tr>
          <th>ご意見</th>
          <td>
            {{{ Input::get('comment') }}}
          </td>
        </tr>
      </table>
    </p>
  </section>

  <nav>
    {{ Form::open() }}
      <p>{{ Form::submit('戻る', array('formaction'=>'form', 'formmethod'=>'get')) }}</p>
      <p>{{ Form::submit('送信', array('formaction'=>'done', 'formmethod'=>'post')) }}</p>
    {{ Form::close() }}
  </nav>

  <footer>
    <p>&copy; 2014</p>
  </footer>
@stop
