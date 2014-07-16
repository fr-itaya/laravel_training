@extends('layouts.master')

@section('title') 
  フォーム
@stop

@section('body')
  <header>
    <h1>フォーム>入力</h1>
  </header>

  <section>
    {{ Form::open(array('url'=>'confirm', 'method'=>'post')) }}
      <fieldset name="form">
        <legend>フォーム</legend>
  
        <p>
        {{ Form::label('family_name', '姓：') }}{{ Form::text('family_name', Session::getOldInput('family_name', '')) }}
        {{ Form::label('given_name', '名：') }}{{ Form::text('given_name', Session::getOldInput('given_name', '')) }}
        </p>

        <p>
        {{ Form::label('sex', '性別：') }}
          <ul class="gender">
            <li>{{ Form::radio('sex', '男性', Session::getOldInput('sex', false)) }}男性</li>
            <li>{{ Form::radio('sex', '女性', Session::getOldInput('sex', false)) }}女性</li>
          </ul>
        </p>

        <p>{{ Form::label('postalcode', '郵便番号：') }}{{ Form::text('postalcode[zone]', Session::getOldInput('postalcode[zone]', '')) }}-{{ Form::text('postalcode[district]', Session::getOldInput('postalcode[district]', '')) }}</p>

        <p>
        {{ Form::label('prefecture', '都道府県：') }}
          <!--PENDING--> 
        </p>

        <p>{{ Form::label('email', 'メールアドレス：') }}{{ Form::email('email', Session::getOldInput('email', '')) }}</p>

        <p>
          {{ Form::label('hobby', '趣味はなんですか：') }}
          {{ Form::hidden('hobby[1]', '') }}
          {{ Form::checkbox('hobby[1]', '音楽鑑賞', !empty(Session::getOldInput('hobby[1]') ? true : false)) }}音楽鑑賞
          {{ Form::hidden('hobby[2]', '') }}
          {{ Form::checkbox('hobby[2]', '映画鑑賞', !empty(Session::getOldInput('hobby[2]') ? true : false)) }}映画鑑賞
          {{ Form::hidden('hobby[3]', '')}}
          {{ Form::checkbox('hobby[3]', 'その他：', !empty(Session::getOldInput('hobby[3]') ? true : false)) }}その他
          {{ Form::text('hobby[4]', Session::getOldInput('hobby[4]', '')) }}
        </p>

        <p>{{ Form::label('comment', 'ご意見：') }}{{ Form::textarea('comment') }}</p>

        <p>{{ Form::submit('確認') }}</p>
      </fieldset>
    {{ Form::close() }}
  </section>

  <footer>
     <p>&copy; 2014</p>
  </footer>
@stop
