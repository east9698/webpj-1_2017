<!doctype html>
<html>

  <head>

    <meta charset="utf-8">
    <title>雑誌データの一覧表示（作成者：東 昭太朗）</title>


    <link rel="stylesheet" type="text/css" href="magindex.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="magindex.js"></script>

  </head>

  <body>


    <h2>- 操作メインメニュー -</h2>

    <hr size="1" />

    <?php
    setlocale(LC_ALL, 'ja_JP.UTF-8');
    $home_dir = "/home/s1781061/my_www/mag_sys/";
    $zashi_file = "nikkei_science.txt";
    $genre_file = "genre.txt";

    $genre = array();

    $genre["10"] = "生物化学";

    $fp = fopen($home_dir . $genre_file, "r");

    while ($data = fgetcsv ($fp, 1000, ",")) {
    $genre[$data[0]] = $data[1];
    }

    fclose ($fp);

    ?>

    <table border="1">

      <tr>
	<th wifth="30%">ジャンル</th>
	<th wifth="50%">論文名</th>
	<th wifth="10%">発行年</th>
	<th wifth="10%">発行月</th>
      </tr>

      <?php
      $fp1 = fopen($home_dir . $zashi_file, "r");
      $total = 0;
      while ($data = fgetcsv ($fp1, 1000, ",")) {

      print "<tr><td>" . $genre[$data[0]] . "</td><td>" . $data[1] . "</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td></tr>\n";

      $total++;

      }

      fclose ($fp1);


      ?>
      <tr><td colspan="4" align="right"合計件数：<?php print $total; ?>></tr></td>

    </table>

  </body>

  </html>
