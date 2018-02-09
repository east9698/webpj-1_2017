<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>雑誌データの一覧表示</title>
    <link rel="stylesheet" type="text/css" href="nikilist.css">
    <link rel="stylesheet" href="magindex.css">
    <link rel="stylesheet" href="search.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="nikilist.js"> </script>
  </head>

  <body>

    <?php

    setlocale(LC_ALL, 'ja_JP.UTF-8');
    $home_dir = "/home/www/proj2017/";
    $zashi_file = "nikkei_science.txt";
    $genre_file = "genre.txt";
    $year_file = "year.txt";

    $genre = array();
    $year = array();
    //ますジャンルファイルを連想配列に呼び込む
    //$genre["10"]="生物科学"

    $fp = fopen($home_dir . $genre_file, "r");

    while ($data = fgetcsv ($fp, 1000, ",")) {
      $genre[$data[0]] = $data[1];
    }

    fclose ($fp);

    ?>

    <?php
    $fp1 = fopen($home_dir . $zashi_file, "r");
    $total = 0;
    $mode = $_GET['mode'];
    $sort = $_GET['sort'];

    $all_data_line = file($home_dir . $zashi_file);
    $all_data = array();//[[10,tile,2017,9],....]
    foreach($all_data_line as $line){
      array_push($all_data, preg_split("/,/", $line));
    }
    $total = count($all_data);
    //var_dump($all_data);
    //10,title,2015,7
    //一気にファイルを行ごとに配列に読み込む
    ?>
    <h2 class="funcTitle">雑誌データの一覧</h2>
    <marquee scrollamount="10" truespeed>記事の総数は<?php print $total;?>件です。</marquee>

    <table align="center" border="1" style="width:90%;">
      <caption>ページ毎表示オプション</caption>
      <tr style="text-align:center;">
	<td><a href="nikilist.php?mode=bypage&sort=year&n=5">ジャンル順</a></td>
	<td><a href="nikilist.php?mode=bypage&sort=year&n=1">発行年昇順＆発行月昇順</a></td>

	<td><a href="nikilist.php?mode=bypage&sort=year&n=3">発行年降順＆発行月昇順</a></td>
	<td><a href="nikilist.php?mode=bypage&sort=year&n=2">発行年降順＆発行月昇順</a></td>
	<td><a href="nikilist.php?mode=bypage&sort=year&n=4">発行年降順＆発行月降順</a></td>
      </tr>
    </table>
    <hr size="1">
    <table class="list" style="width:90%;" border="1">
      <thead>
        <tr>
          <th scope="col" width="30%">ジャンル</th>
          <th scope="col" width="50%">論文名</th>
          <th scope="col" width="10%">発行年</th>
          <th scope="col" width="10%">発行月</th>
        </tr>
      </thead>

      <tbody>
        <?php
        switch($mode){
    case 'bypage':
      require_once 'vendor/autoload.php';
      //pagerというライブラリを読み込む


      if($sort == "genre"){
        //ジャンルにソートする
        sort($all_data);//並べ替え
      }
      if($sort == "year"){
        //yearにソートする
        foreach ($all_data as $v) $v0[] = $v['0']; // ジャンルの列（ジャンルの”列”配列作成
        foreach ($all_data as $v) $v1[] = $v['1']; // タイトルの列（タイトルの”列”配列作成
        foreach ($all_data as $v) $v2[] = $v['2']; // 年の列（年の”列”配列作成
        foreach ($all_data as $v) $v3[] = $v['3']; // 月の列（月の”月”配列作成
        $n = $_GET['n'];
        switch($n){
          case 1;
      print "<center><strong>発行年昇順＆発行月昇順表示</strong></center>\n<br />";
      array_multisort($v2, SORT_ASC, SORT_NUMERIC, $v3, SORT_ASC, SORT_NUMERIC, $all_data);
      //年昇順、月昇順
      break;

          case 2;
      print "<center><strong>発行年降順＆発行月昇順表示</strong></center>\n<br />";
      array_multisort($v2, SORT_ASC, SORT_NUMERIC, $v3, SORT_DESC, SORT_NUMERIC, $all_data);
      //年昇順、月降順
      break;

          case 3;
      print "<center><strong>発行年降順＆発行月昇順表示</strong></center>\n<br />";
      array_multisort($v2, SORT_DESC, SORT_NUMERIC, $v3, SORT_ASC, SORT_NUMERIC, $all_data);
      //年降順、月昇順
      break;

          case 4;
      print "<center><strong>発行年降順＆発行月降順表示</strong></center>\n<br />";
      array_multisort($v2, SORT_DESC, SORT_NUMERIC, $v3, SORT_DESC, SORT_NUMERIC, $all_data);
      //年降順、月降順
      break;

          case 5;
      print "<center><strong>ジャンル順表示</strong></center>\n<br />";
      array_multisort($v0, SORT_ASC, SORT_NUMERIC, $v2, SORT_ASC, SORT_NUMERIC, $all_data);
      //ジャンル昇順、タイトル昇順
      break;
  }

      }


      $options = array(
        "itemData" => $all_data, //表示するデータ配列
        "perPage" => 13, // 1ページにいくつ表示するか
        "delta" => 4, // number of page numbers to display
        "curPageSpanPre" => "<span><strong>",
        "curPageSpanPost" => "</strong></span>",
        "prevImg" => "<<前のページへ",
        "nextImg" => "次のページへ>>",
        "spacesBeforeSeparator" => 2,
        //"spacesAfterSeparator" => 2,
        //"mode" => "Jumping" // paging mode
        "mode" => "Sliding" // paging mode
      );       // initialize object
      $pager = &Pager::factory($options);
      // get items for this page as array
      $items = $pager->getPageData();
      //var_dump($items);
      // get page numbers and links for this page
      $links = $pager->getLinks();
      // get total number of pages
      $totalPages = $pager->numPages();

      // get current page number
      $currentPage = $pager->getCurrentPageID();
      // print page number links

      print "<tr bgcolor=\"#87CEEB\"><td colspan=\"4\" align=\"center\">" . $links['all'] . "</td></tr>";

      // print items on this page
      //var_dump($items);
      foreach ($items as $item) {
        //print("hhhhh" . $item);
        print "<tr bgcolor=\"#f0f8ff\"><td>" . $genre[$item[0]]."</td><td>" . $item[1] .
        "</td><td>" . $item[2] . "</td><td>" . $item[3] . "</td></tr>\n";
      }
      print "<tr><td colspan=\"4\" align=\"center\" bgcolor=\"#87CEEB\">" . $links['all'] . "</td></tr>\n";
      //print "<tr><td colspan=\"4\" align=\"right\">" . $currentPage . "/" . $totalPages . "</td></tr>";

      break;

    default:
      print "<center><strong>デフォルトで表示しています。</strong></center>\n<br />";
      while($data = fgetcsv ($fp1, 1000, ",")){
        print "<tr bgcolor=\"#f0f8ff\"><td>" . $genre[$data[0]] . "</td><td>" . $data[1] .
        "</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td></tr>\n";

      }
        }


        fclose ($fp1);

        ?>

        <tr>
          <td colspan="4" align="right">合計件数：<?php print $total; ?></td>
        </tr>
      </tbody>


    </table>
    <p id="topbutton">
      <a href="#top" onclick="$('html,body').animate({ scrollTop: 0 }); return false;">ページ上部へ</a>
    </p>
  </body>

</html>
