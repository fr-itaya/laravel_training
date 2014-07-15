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
        {{ Form::label('family_name', '姓：') }}{{ Form::text('family_name', Input::old('family_name', '')) }}
        {{ Form::label('given_name', '名：') }}{{ Form::text('given_name', Input::old('given_name', '')) }}
        </p>

        <p>
        {{ Form::label('sex', '性別：') }}
          <ul class="gender">
            <li>{{ Form::radio('sex[male]', '男性', Input::old('sex[male]', false)) }}男性</li>
            <li>{{ Form::radio('sex[female]', '女性', Input::old('sex[female]', false)) }}女性</li>
          </ul>
        </p>

        <p>{{ Form::label('postalcode', '郵便番号：') }}{{ Form::text('postalcode[zone]', Input::old('postalcode[zone]', '')) }}-{{ Form::text('postalcode[district]', Input::old('postalcode[district]', '')) }}</p>

        <p>
        {{ Form::label('prefecture', '都道府県：') }}
          <!--PENDING--> 
        </p>

        <p>{{ Form::label('email', 'メールアドレス：') }}{{ Form::email('email', Input::old('email', '')) }}</p>

        <p>
          {{ Form::label('hobby', '趣味はなんですか：') }}
          {{ Form::hidden('hobby[1]', '') }}
          {{ Form::checkbox('hobby[1]', '音楽鑑賞', !empty(Input::old('hobby[1]') ? true : false)) }}音楽鑑賞
          {{ Form::hidden('hobby[2]', '') }}
          {{ Form::checkbox('hobby[2]', '映画鑑賞', !empty(Input::old('hobby[2]') ? true : false)) }}映画鑑賞
          {{ Form::hidden('hobby[3]', '')}}
          {{ Form::checkbox('hobby[3]', 'その他：', !empty(Input::old('hobby[3]') ? true : false)) }}その他
          {{ Form::text('hobby[4]', Input::old('hobby[4]', '')) }}
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
