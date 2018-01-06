<!doctype html>
<html>
  <head>
  <meta charset="utf-8">
  <title>ジャンルの削除画面（作成者：萩原　和人）</title>
  <link rel="stylesheet" type="text/css" href="magindex.css">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script type="text/javascript" src="magindex.js"></script>

  </head>
  <body>
    <h2 align="center">ージャンルデータの削除ー</h2>
    <hr size="1" />

    <form method="post" action="genredel.php">

      <table border="1" align="center">
	<caption>次の現ジャンル一覧表から<br>削除するジャンルを選択してください</caption>
	<tr><th width="10%">&nbsp;</th><th width="30%">ジャンル番号</th><th width="60%">ジャンル名</th></tr>

<?php
setlocale(LC_ALL, 'ja_JP.utf-8');
$genre_file = "genre.txt";
$home_dir = "/home/s1781060/my_www/mag_sys/";

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
    print "<div>ジャンル削除処理が行なわれました。</div><br />\n";
  }


  foreach($genre as $no => $name){
    print "<tr><td><input type=\"checkbox\" name=\"dels[]\" value=\"" . "" . $no .
	  "\"></td>\n";
    print "<td>" . $no . "</td><td>" . $name . "</td></tr>\n";
  }

?>

	<tr><td colspan="3">
	  <input type="submit" value="削除">
	  <input type="reset" value="クリア">
	</td></tr>
      </table>
    </form>
    <hr size="1" />
  </body>
</html>
