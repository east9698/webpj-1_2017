<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ジャンル削除</title>
  <link rel="stylesheet" type="text/css" href="magindex.css">
  <link rel="stylesheet" href="validationEngine.jquery.css" type="text/css"/>
  <link rel="stylesheet" href="search.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="jquery.validationEngine-ja.js" type="text/javascript" charset="utf-8"></script>
  <script src="jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
  <script>
  $(document).ready(function() {
    jQuery("#checkform").validationEngine();
  });
  </script>
</head>
<body>
  <h2 class="funcTitle">ジャンルの削除</h2>
  <hr size="1" />

  <form method="post" action="genredel.php">

    <table class="list" border="1">
      <caption>次の現ジャンル一覧表から<br>削除するジャンルを選択してください</caption>
      <thead>
        <tr>
          <th scope="col" width="10%"></th>
          <th scope="col" width="30%">ジャンル番号</th>
          <th scope="col" width="60%">ジャンル名</th>
        </tr>
      </thead>

      <tbody>
        <?php
        setlocale(LC_ALL, 'ja_JP.utf-8');
        $genre_file = "genre.txt";
        $home_dir = "/home/www/proj2017/";

        $genre = array();
        //まずジャンルファイルを連想配列に呼び込む
        //$genre["10"]="生物科学"

        $fp = fopen($home_dir . $genre_file, "r");
        while ($data = fgetcsv ($fp, 1000, ",")) {
          $genre[$data[0]] = $data[1];
        }
        fclose ($fp);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          //フオームでチェックされたジャンルを配列として受け取る
          $del_genres = $_POST['dels'];

          foreach($del_genres as $del){
            unset($genre[$del]);
            //削除をマークされたジャンルを配列$genreから破棄する
          }
          print "<p>";

          ksort($genre);
          //$genre配列をキーでソートする

          $fp = fopen($home_dir . $genre_file, "w");
          foreach($genre as $key => $name) {
            fputs($fp, $key . "," . $name . "\n");
          }
          fclose ($fp);
          print "<div>ジャンル削除処理が行なわれました。</div><br/>\n";
        }


        foreach($genre as $no => $name){
          print "<tr><td><input type=\"checkbox\" style=\"font-size:1.8em;\" name=\"dels[]\" value=\"" . "" . $no .
          "\"></td>\n";
          print "<td>" . $no . "</td><td>" . $name . "</td></tr>\n";
        }

        ?>

        <tr>
          <td colspan="3">
            <input type="submit" value="削除" class="btn" onClick="return confirm('削除してもよろしいでしょうか？')">
            <input type="reset" value="クリア" class="btn">
          </td>
        </tr>
      </tbody>

    </table>
  </form>
  <hr size="1" />
</body>
</html>
