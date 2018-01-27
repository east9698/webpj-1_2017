<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="magindex.css">
    <link rel="stylesheet" href="floatingwindow.css">
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="validationEngine.jquery.css" type="text/css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
    crossorigin="anonymous">
    <style media="screen">
      table {max-width: 650px;}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="floatingwindow.js"></script>
    <script src="initialize.js"></script>
    <script src="jquery.validationEngine-ja.js" type="text/javascript" charset="utf-8"></script>
    <script src="jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script>
     $(document).ready(function() {
        jQuery(".checkForm").validationEngine();
       });
     </script>
    <title>編集 - 日経サイエンス雑誌記事Web管理システム</title>
  </head>
  <body>
    <nav id="floating_menu">
      <a href="#genre_list" class="open">ジャンル一覧</a>
      <a href="#genre_add" class="open">ジャンル追加</a>
      <a href="#genre_del" class="open">ジャンル削除</a>
      <a href="#zashi_add" class="open">雑誌データ追加</a>
      <a href="#zashi_del" class="open">雑誌データ削除</a>
      <a href="#initialize" class="open">ファイルの初期化</a>
      <div id="test1"></div>
      <div id="test2"></div>
    </nav>

    <div id="genre_list" class="floatingwindow" tabindex="0">
      <a href="edit.php" class="close fa fa-close fa-2x fa-fw"></a>
      <dl>
        <dt>現在のジャンル一覧</dt>
        <dd>
          <table class="list">
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
              /*if($_SERVER['REQUEST_METHOD'] == 'POST'){
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

              }*/
              foreach($genre as $no => $name){
                print "<tr><th scope='row'>" . $no . "</th><td>" . $name . "</td></tr>\n";
              }
              ?>

            </tbody>
          </table>
        </dd>
      </dl>
    </div>

    <div id="genre_add" class="floatingwindow" tabindex="0">
      <a href="edit.php" class="close fa fa-close fa-2x fa-fw"></a>
      <dl>
        <dt>新規ジャンルの追加</dt>
        <dd>
          <form action="genreadd.php" method="post" name="MyForm" class="checkForm">
            <table class="form">
              <tbody>
                <tr>
                  <th>新規ジャンル番号</th>
                  <td  class="contents">
                    <input type="text" name="genre_no" class="validate[required, custom[onlyNumberSp]] text-input textbox short">
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
        </dd>
      </dl>
    </div>

    <div id="genre_del" class="floatingwindow" tabindex="0">
      <a href="edit.php" class="close fa fa-close fa-2x fa-fw"></a>
      <dl>
        <dt>ジャンルの削除</dt>
        <dd>
          <form action="genredel.php" method="post" name="MyForm" class="checkForm">
            <table class="list">
              <caption>次の一覧表から削除するジャンルを選択してください</caption>
              <thead>
              	<tr>
                  <th scope="col"></th>
                  <th scope="col">ジャンル番号</th>
                  <th scope="col">ジャンル名</th>
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
                  print "<tr>";
                  print "<td><input type=\"checkbox\" name=\"dels[]\" value=\"" . "" . $no . "\"></td>\n";
                  print "<td>" . $no . "</td>";
                  print "<td>" . $name . "</td>";
                  print "</tr>\n";
                }

              ?>

              <tr>
                <td colspan="3">
                  <input type="submit" value="削除" class="btn">
                  <input type="reset" value="クリア" class="btn">
                </td>
              </tr>

              </tbody>
            </table>
          </form>
        </dd>
      </dl>
    </div>


    <div id="zashi_add" class="floatingwindow"  tabindex="0">
      <a href="edit.php" class="close fa fa-close fa-2x fa-fw"></a>
      <dl>
        <dt>新規雑誌データ追加</dt>
        <dd>
          <form method="post" action="zashiadd.php"  class="checkForm">
            <table class="form">
              <tbody>
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
                  <th>タイトル</th>
                  <td class="contents">
                    <input type="text" name="name" class="validate[required] text-input textbox wide">
                  </td>
                </tr>

                <tr>
                  <td class="bar" colspan="2"></td>
                </tr>

                <tr>
                  <th>発行年</th>
                  <td class="contents">
                    <input type="text" name="year" class="validate[required,custom[onlyNumberSp]] text-input textbox short">
                  </td>
                </tr>

                <tr>
                  <td class="bar" colspan="2"></td>
                </tr>

                <tr>
                  <th>発行月</th>
                  <td class="contents">
                    <input type="text" name="month" class="validate[required] validata[custom[onlyNumber]] text-input textbox short">
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
        </dd>
      </dl>
    </div>

    <div id="zashi_del" class="floatingwindow"  tabindex="0">
      <a href="edit.php" class="close fa fa-close fa-2x fa-fw"></a>
      <dl>
        <dt>新規雑誌データ削除</dt>
        <dd>
          <?php
          setlocale(LC_ALL, 'ja_JP.utf-8');
          $genre_file = "genre.txt";
          $zashi_file = "nikkei_science.txt";
          $home_dir = "/home/www/proj2017/";
          //まずジャンルファイルを連想破裂に読み込む
          //$genre["10"]="生物化学"
          $fp = fopen($home_dir . $genre_file, "r");
          while ($data = fgetcsv ($fp, 1000, ",")){
            $genre[$data[0]] = $data[1];
          }
          fclose ($fp);
          ?>

          <form method="post" action="zashiadd.php"  class="checkForm">
            <table class="list">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">ジャンル</th>
                  <th scope="col">タイトル</th>
                  <th scope="col">年</th>
                  <th scope="col">月</th>
                </tr>
              </thead>

              <tbody>

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
                  print "<tr>";
                  print "<td><input type=\"checkbox\" name=\"dels[]\" value=\"" . $kiji_cnt ."\"></td>\n";
                  print "<td>" . $genre[$data[0]] . "</td>";
                  print "<td>" . $data[1] . "</td>";
                  print "<td>" . $data[2] . "</td>";
                  print "<td>" . $data[3] . "</td>";
                  print "</tr>\n";
                  $kiji_data["" . $kiji_cnt] = implode(",", $data);
                }
                ?>

                  <tr>
                    <td colspan="5">合計件数：<?php print "$kiji_cnt" ?></td>
                  </tr>

                  <tr>
                    <td colspan="5" class="contents">
                      <input type="submit" value="追加" class="btn">
                      <input type="reset" value="クリア" class="btn">
                    </td>
                  </tr>
              </tbody>
            </table>
          </form>
        </dd>
      </dl>
    </div>

    <div id="initialize" class="floatingwindow"  tabindex="0">
      <a href="edit.php" class="close fa fa-close fa-2x fa-fw"></a>
      <dl>
        <dt>データベースファイルの初期化</dt>
        <dd>
          <p>
            本アプリケーションはデモ用のため、初期データを用意しています。
            <br>
            必要に応じて以下のボタンをクリックして実行してください。
          </p>
          <button type="button" name="doInitialize" id="doInitialize">初期化を実行</button>
          <div id="resultInitialize">結果：</div>
        </dd>
      </dl>
    </div>

  </body>
</html>
