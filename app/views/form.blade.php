<!DOCTYPE html>
<html lang="ja">
<head>
  <title>フォーム</title>
  <meta charset="utf-8">
  <link href="style.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>
  <header>
    <h1>フォーム>入力</h1>
  </header>

  <section>
    <form action="confirm" method="post">
      <fieldset name="form">
        <legend>フォーム</legend>
  
        <p>
          <label>姓：</label><input type="text" name="family_name" size="20" value=''>
          <label>名：</label><input type="text" name="given_name" size="20" value=''>
        </p>

        <p>
          <label>性別：</label>
          <ul class="gender">
            <li><input type="radio" name="sex" value='男性'>男性</li>
            <li><input type="radio" name="sex" value='女性'>女性</li>
          </ul>
        </p>

        <p><label>郵便番号：</label><input type="text" name="postalcode[zone]" size="10" maxlength="3" value=''>-<input type="text" name="postalcode[district]" size="10" maxlength="4" value=''></p>

        <p>
          <label>都道府県：</label>
         <!--PENDING--> 
        </p>

        <p><label>メールアドレス：</label><input type="email" name="email" size="30" maxlength="40" value=''></p>

        <p>
          <label>趣味はなんですか：</label>
          <input type="hidden" name="hobby[1]" value=''>
          <input type="checkbox" name="hobby[1]" value='音楽鑑賞'>音楽鑑賞
          <input type="hidden" name="hobby[2]" value=''>
          <input type="checkbox" name="hobby[2]" value='映画鑑賞'>映画鑑賞
          <input type="hidden" name="hobby[3]" value=''>
          <input type="checkbox" name="hobby[3]" value='その他：'>その他
          <input type="text" name="hobby[4]" size="10" maxlength="15" value=''>
        </p>

        <p><label>ご意見：</label><textarea name="comment" cols="20" rows="2" maxlength="40"></textarea></p>

        <p><input type="submit" value="確認" formaction="confirm"></p>
      </fieldset>
    </form>
  </section>

  <footer>
     <p>&copy; 2014</p>
  </footer>
</body>
</html>
