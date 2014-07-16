@extends ('layouts.master')

@section('title')
  TOP
@stop

@section('body')
  <header>
    <h1>フォーム>TOPページ</h1>
  </header>

  <nav>
    {{ HTML::link('form', '入力画面へ') }}
  </nav>

  <footer>
    <p>Copyright 2014</p>
  </footer>
@stop
