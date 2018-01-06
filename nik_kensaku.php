<!doctype html>

<html>
  <head>
    <meta charset="utf-8">
    <title>雑誌データの検索結果（作成者：渕上）</title>
    <link rel="stylesheet" type="text/css" href="magindex.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

    <script type="text/javascript" src="magindex.js"></script>

  </head>

  <body>

    <h2 align="center">--雑誌データ検索結果一覧--</h2>
    <div align="right"><a href="nik_kensaku_top.php">検索トップ画面へ</a></div>
    <hr size="1" />

    <table border="1">
      <th width="30%">ジャンル</th>
      <th width="50%">論文名</th>
      <th width="10%">発行年</th>
      <th width="10%">発行月</th>

      <?php

      setlocale(LC_ALL, 'ja_JP.UTF-8');  //fgetcsvが日本語を正しく扱うため

      $genre_selected=@$_POST['genre'];   //フォームデータを取得

      $keyword =@$_POST['keyword'];   //セレクトボックスから選択されたジャンルを配列$genre_selectedに =@使用
      $year =@ $_POST['year'];  //年の選択
      $month =@ $_POST['month'];  //月の選択

      $keyword = mb_convert_kana($keyword, "s", "utf-8"); //全角スペースを半角に変換する =@使用

      $keywords = preg_split("/[\s,]+/",$keyword,-1,PREG_SPLIT_NO_EMPTY);  //全角または半角スペース、カンマまたはタブなどの文字でキーワードを配列に分割する

      $andor =@$_POST['andor'];  //選択オプション（キーワードをand連結かor連結か） =@を使用

      $home_dir = "/home/s1781063/my_www/mag_sys/";
      $zashi_file = "nikkei_science.txt";
      $genre_file = "genre.txt";
      $genre = array();
      $search_genre = array();

      //検索すべきジャンルの配列
      //ますジャンルファイルを連想配列に呼び込む
      //$genre["10"]="生物科学"

      $fp = fopen($home_dir . $genre_file, "r");
      while ($data = fgetcsv ($fp, 1000, ",")) {

	$genre[$data[0]] = $data[1];
	$search_genre[$data[0]] = 1;

      }

      fclose ($fp);
      if(!in_array('111', (array)$genre_selected) ){   //(array)を$前に追加し配列として処理しないように

	foreach(array_keys($search_genre)as $genre_key){
	  if(!in_array($genre_key, (array)$genre_selected)){
	    $search_genre[$genre_key] = 0;

	  }

	}

      }

      //検索するジャンルをキーとする配列$search_genreの要素値を1、
      //そうではなければ0をセット
      //全てのジャンルにおいて検索を行なう
      $fp = fopen($home_dir . $zashi_file, "r");
      $total = 0;
      $count = 0;

      if($keyword==null){
	$keyword="未入力";
      }

      if($count<1){
	print('<b><font size="4">入力されたキーワード：');
	print($keyword);
	print('　　検索オプション：');
	print($andor);
	print('</b><br>');
      }

      if($year!=0){
	print('<b>検索年：');
	print($year);
	print('年</b><br>');
	}

      if($month!=0){
	print('<b>検索月：');
	print($month);
	print('月</b><br><br>');
      }

      print('</font>');

      while ($data = fgetcsv ($fp, 1000, ",")) {   	//雑誌データを一見すつ検索処理する
	if($search_genre[$data[0]]==1){   //年参照
	  if($year != 0){
	    if($year != $data[2]){
	      continue;
	    }
	  }

	  if($month != 0){  //月参照
	    if($month != $data[3]){
	      continue;
	    }
	  }

	  switch($andor){
	    case 'and':  //and検索

	      $check = 1;
	      foreach($keywords as $key){

		if( $key && !stristr($data[1], $key) ){
		  $check = 0;
		  break;
		}
	      }

	      if($check == 1){
		print ("<tr><td>" . $genre[$data[0]] . "</td><td>" . $data[1] ."</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td></tr>\n");
		$total++;

	      }
	      break;

	    case 'or':  //or検索

	      foreach($keywords as $key){
		if( !$key || stristr($data[1],$key) ){
		  print ("<tr><td>" . $genre[$data[0]] . "</td><td>" . $data[1] ."</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td></tr>\n");

		  $total++;

		  break;

		}
	      }
	    case 'not':  //and検索

	      $check = 1;
	      foreach($keywords as $key){

		if( $key && stristr($data[1], $key) ){
		  $check = 0;
		  break;
		}
	      }

	      if($check == 1){
		print ("<tr><td>" . $genre[$data[0]] . "</td><td>" . $data[1] ."</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td></tr>\n");
		$total++;
	      }
	      break;
	  }
	}
      }

      if($total==0){
	print('<style type="text/css">'.'table{display: none;}'.'</style>');
	print('<b><font color="red" size="10">＼(＾o＾)／表示するものがねぇ！！！！！！</font></b>');
      }

      fclose ($fp);

      ?>

      <tr><td colspan="4" align="right">合計件数：<?php print $total; ?></td></tr>
    </table>
    <div align="right"><a href="nik_kensaku_top.php">検索トップ画面へ</a></div>
    <hr size="1" />


  </body>
</html>
