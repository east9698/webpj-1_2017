<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ジャンルの追加画面</title>
    <link rel="stylesheet" type="text/css" href="magindex.css">
    <link rel="stylesheet" href="search.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="magindex.js"></script>
    <script type="text/javascript" src="magformCheck.js"></script>
  </head>
  <body>
    <table class="list">
      <caption>現在のジャンル一覧</caption>
      <thead>
        <tr>
          <th scope="col">ジャンル番号</th>
          <th scope="col">ジャンル名</th>
        </tr>
      </thead>
      <tbody>
        <?php
        setlocale(LC_ALL, 'ja.UTF-8');
        $genre_file = "genre.txt";
        $home_dir = "/home/www/proj2017/";
        $genre = array();
        //まずジャンルファイルから連想配列に読み込む
        //$genre["10"]="生物科学"
        $fp = fopen($home_dir . $genre_file, "r");
        while ($data = fgetcsv ($fp, 1000, ",")){
          $genre[$data[0]] = $data[1];
        }
        fclose ($fp);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $new_genre_no = $_POST['genre_no'];
          $new_genre_name = $_POST['genre_name'];
          if($new_genre_no == ""){
            print "<div>ジャンル番号が入力されていません</div><br />\n";
          }else if(!is_finite($new_genre_no)){
            print "<div>ジャンル番号が数字ではありません</div><br />\n";
          }else if(array_key_exists($new_genre_no, $genre)){
            print "<div>追加しようとするジャンル番号はすでに存在している</div><br />\n";
          }else{
            $genre[$new_genre_no] = $new_genre_name;
            $fp = fopen($home_dir . $genre_file, "w");
            ksort($genre);
            //連想配列$genreをキーでソートする
            foreach($genre as $key => $name){
              fputs($fp, $key . "," . $name . "\n");
            }
            //連想配列$genreからキーと値のペアを最後まで一つずつ取り出す
            fclose($fp);
            print "<div>追加処理が行われた</div><br />\n";
          }

        }
        foreach($genre as $no => $name){
          print "<tr><th scope='row'>" . $no . "</th><td>" . $name . "</td></tr>\n";
        }
        ?>

      </tbody>
    </table>

    <form action="genreadd.php" method="post" name="MyForm" id="checkForm">
      <table class="form">
        <tbody>
          <tr>
            <th>新規ジャンル番号</th>
            <td  class="contents">
              <input type="text" name="genre_no" class="validate[required.custom[onlyNumberSp]] text-input textbox short">
            </td>
          </tr>

          <tr>
            <td class="bar" colspan="2"></td>
          </tr>

          <tr>
            <th>新規ジャンル名</th>
            <td class="contents">
              <input type="text" name="genre_name" class="validate[required] text-input textbox">
            </td>
          </tr>

          <tr>
            <td class="bar" colspan="2"></td>
          </tr>

          <tr>
            <td colspan="2" class="contents">
              <input type="submit" value="追加" class="btn">
              <input type="reset" value="クリア" class="btn">
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </body>
</html>
