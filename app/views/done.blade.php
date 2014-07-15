@extends('layouts.master')

@section('title')
  ご応募ありがとうございました
@stop

@section('body')
  <header>
    <h1>フォーム>完了</h1>
  </header>

  <section>
    <p>応募しました</p>
    {{ HTML::link('/', 'TOPへ') }} 
  </section>

  <footer>
    <p>Copyright 2014</p>
  </footer>
@stop
