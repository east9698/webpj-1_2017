<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>雑誌記事データの追加</title>
    <link rel="stylesheet" type="text/css" href="magindex.css">
    <link rel="stylesheet" href="search.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="magindex.js"></script>
    <script type="text/javascript" src="magformCheck.js"></script>
  </head>
  <body>
    <form method="post" action="zashiadd.php"  id="checkForm">
      <table>
        <tbody class="form">
          <tr>
            <th>ジャンル(分野)</th>
            <td class="contents">
              <select name="genre">
                <?php
                setlocale(LC_ALL, 'ja_JP.UTF-8');
                $genre_file = "genre.txt";
                $zashi_file = "nikkei_science.txt";
                $home_dir = "/home/www/proj2017/";
                //まずジャンルファイルから現在のジャンルを読み込む
                $fp = fopen($home_dir . $genre_file, "r");
                while ($data = fgetcsv ($fp, 1000, ",")){
                  print "<option value=\"" . $data[0] . "\">" . $data[1];
                }
                fclose ($fp);
                ?>
              </select>
            </td>
          </tr>

          <tr>
            <td class="bar" colspan="2"></td>
          </tr>

          <tr>
            <th>論文名</th>
            <td class="contents">
              <input type="text" name="name" class="validate[required] text-input textbox wide" size="60">
            </td>
          </tr>

          <tr>
            <td class="bar" colspan="2"></td>
          </tr>

          <tr>
            <th>発行年</th>
            <td class="contents">
              <input type="text" name="year" class="validate[required,custom[onlyNumberSp]] text-input textbox short" size="35">
            </td>
          </tr>

          <tr>
            <td class="bar" colspan="2"></td>
          </tr>

          <tr>
            <th>発行月</th>
            <td class="contents">
              <input type="text" name="month" class="validate[required] validata[custom[onlyNumber]] text-input textbox short" size="35">
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
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $new_kiji_genre = $_POST['genre'];
      $new_kiji_name = $_POST['name'];
      $new_kiji_year = $_POST['year'];
      $new_kiji_month = $_POST['month'];
      $fp = fopen($home_dir . $zashi_file, "a");
        //ファイルを追加用にオープン。ファイルポインタはファイルの末尾に
        fputs($fp, $new_kiji_genre . "," .$new_kiji_name . "," . $new_kiji_year . "," . $new_kiji_month . "\n");
        //新たな記事データをデータファイルの末尾に書き出す
        fclose($fp);
        print "<div>追加処理が行われた</div><br />\n";
      }
      ?>
  </body>
</html>

<!--
<td width="30%">説明：どのジャンルにデータを追加するか、ジャンルを一つ選択する</td>
<td>説明：追加する記事データの記事のタイトルを入力</td>
<td>説明：記事データの発行年度を西暦で入力</td>
<td>説明：追加する記事データの発行月を入力</td>
-->
