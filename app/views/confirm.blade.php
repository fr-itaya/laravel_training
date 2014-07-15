@extends('layouts.master')

@section('title')
確認画面
@stop



@section('body')
  <header>
    <h1>フォーム>確認</h1>
  </header>

  <section>
    <p>
      <table>

        <tr>
          <th>姓</th>
          <td>
            {{{ $_POST['family_name'] or '' }}}
          </td>
        </tr>

        <tr>
          <th>名</th>
          <td>
            {{{ $_POST['given_name'] or '' }}}
          </td>
        </tr>

        <tr>
          <th>性別</th>
          <td>
            {{{ $_POST['sex'] or '' }}}
          </td>
        </tr>

        <tr>
          <th>郵便番号</th>
          <td>
            {{{ $_POST['postalcode']['zone'] or '' }}}-{{{ $_POST['postalcode']['district'] or '' }}}
          </td>
        </tr>

        <tr>
          <th>都道府県</th>
          <td>
            <!--PENDING-->
          </td>
        </tr>

        <tr>
          <th>メールアドレス</th>
          <td>
            {{{ $_POST['email'] or '' }}}
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
            {{{ $_POST['comment'] }}}
          </td>
        </tr>
      </table>
    </p>
  </section>

  <nav>
    <form>
      <p><input type="submit" value="戻る" formaction="form" formmethod="get"></p>
      <p><input type="submit" value="送信" formaction="done" formmethod="post"></p>
    </form>
  </nav>

  <footer>
    <p>&copy; 2014</p>
  </footer>
@stop
