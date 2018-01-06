<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>雑誌記事データの削除</title>
    <link rel="stylesheet" type="text/css" href="magindex.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
      <script type="text/javascript" src="magindex.js"></script>
  </head>
  <body>
    <h2 align="center">-雑誌記事データの削除-</h2>
    <hr size="1" />
    <?php
    setlocale(LC_ALL, 'ja_JP.utf-8');
    $genre_file = "genre.txt";
    $zashi_file = "nikkei_science.txt";
    $home_dir = "/home/s1781060/my_www/mag_sys/";
    //まずジャンルファイルを連想破裂に読み込む
    //$genre["10"]="生物化学"
    $fp = fopen($home_dir . $genre_file, "r");
    while ($data = fgetcsv ($fp, 1000, ",")){
      $genre[$data[0]] = $data[1];
    }
    fclose ($fp);
    ?>
    <form method="post" action="zashidel.php">
      <table border="1">
	<caption>次の雑誌一覧表から<br />
	  削除するものを選択してください</caption>
	<th width="5%"</th><th width="25%">ジャンル</th><th width="50%">論文名</th><th width="10%">発行年</th><th width="10%">発行月</th></tr>
	<?php
	$kiji_data = array();
	$fp = fopen($home_dir . $zashi_file, "r");
	$kiji_cnt = 0;
	while ($data = fgetcsv ($fp, 1000, ",")){
	  $kiji_cnt++;
	  $kiji_data["" . $kiji_cnt] = implode(",", $data);
	}
	fclose ($fp);
	if($_SERVER['REQUEST_METHOD']=='POST'){
	  //フォームでチェックされたジャンルを配列として受け取る
	  $del_kijis = $_POST['dels'];
	  foreach($del_kijis as $del){
	    unset($kiji_data[$del]);
	    //削除をマークされたジャンルを配列＄genreから破棄する
	  }
	  $fp2 = fopen($home_dir . $zashi_file, "w");
	  foreach($kiji_data as $key => $data){
	    fputs($fp2, $data . "\n");
	  }
	  //nikkei_science.txtファイルに削除後のデータで上書き保存する
	  fclose($fp2);

	  print "<div>記事データ削除処理が行われた</div><br />\n";
	}
	$kiji_cnt = 0;
	foreach ($kiji_data as $key => $data_line){
	  //$kiji_data["12"] = "16,気配りできるコンピューター,2005,4"
	  $kiji_cnt++;
	  $data = preg_split("/,/",$data_line);
	  //$data[] =["16", "気配りできるコンピューター,2005,4"
	  print "<tr><td><input type=\"checkbox\" name=\"dels[]\" value=\"" . $kiji_cnt ."\"></td>\n";
	  print "<td>" . $genre[$data[0]] . "</td><td>" . $data[1] .
	        "</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td></tr>\n";
	  $kiji_data["" . $kiji_cnt] = implode(",", $data);
	}
	?>
	<tr><td colspan="5" align="right">合計件数:<?php print $kiji_cnt; ?></td></tr>
	<tr><td></td>
	  <td colspan="4">
	    <input type="submit" value="削除">
	    <input type="reset" value="クリア">
	  </td>
	</tr>
      </table>
    </form>
    <hr size="1" />
  </body>
</html>
