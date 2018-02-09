<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>雑誌記事データの追加</title>
    <link rel="stylesheet" type="text/css" href="magindex.css">
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="validationEngine.jquery.css" type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="jquery.validationEngine-ja.js" type="text/javascript" charset="utf-8"></script>
    <script src="jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script>
	   $(document).ready(function() {
	      jQuery("#checkForm").validationEngine();
	     });
     </script>
  </head>

  <body>
    <h2 class="funcTitle">雑誌記事データの追加</h2>
    <form method="post" action="zashiadd.php"  id="checkForm">
      <table class="form">
        <tbody>
          <tr>
            <th>ジャンル(分野)</th>
            <td class="contents">
              <select name="genre" style="font-size:1.3em;">
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
