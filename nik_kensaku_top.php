<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>日経サイエンス バックナンバーの検索</title>
    <link rel="stylesheet" type="text/css" href="magindex.css">
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="magindex.js"></script>

  </head>
  <body>
    <form method="post" action="nik_kensaku.php" id="search">
      <table border="1" align="center">
        <tbody class="form">
          <tr>
            <th>ジャンル(分野)</th>
            <td class="contents">
              <select name="genre[]" multiple>
                <option value="111" selected>全分野</option>
                <?php
                setlocale(LC_ALL, 'ja_JP.UTF-8');
                $genre_file = "genre.txt";
                $home_dir = "/home/www/proj2017/";

                //まずジャンルファイルから現在のジャンルを読み込む

                $fp = fopen($home_dir . $genre_file, "r");
                while ($data = fgetcsv($fp, 1000, ",")){
                  print "<option value=\"" . $data[0] . "\">" . $data[1] . "</option>";
                }
                fclose($fp);
                ?>
              </select>
            </td>
          </tr>

          <tr>
            <td class="bar" colspan="2"></td>
          </tr>

          <tr>
            <th>発行年月</th>
            <td class="contents">
              <?php
              setlocale(LC_ALL,'ja_JP.UTF-8');
              $zashi_file = "nikkei_science.txt";
              $year = array();
              $month = array();

              $fp2 = fopen($home_dir . $zashi_file,"r");

              while($data = fgetcsv($fp2,1000,",")){
                if(!in_array($data[2],$year)){      //既に存在するデータは配列に加えない
                  array_push($year,$data[2]);        //配列の末尾に追加
                }

                if(!in_array($data[3],$month)){
                  array_push($month,$data[3]);
                }
              }

              rsort($year);                            //配列を降順にソート
              sort($month);                            //配列を昇順にソート

              print('<select name="year">' . "\n");  //年
              print('<option value="0" selected>-</option>' . "\n");
              for($i=0;$i<count($year);$i++) {
                print "<option value=\"". $year[$i] . "\">". $year[$i] . "</option>";
              }
              print("</select>年\n");

              print('<select name="month">' . "\n");  //月
              print('<option value="0" selected>-</option>' . "\n");
              for($i=0;$i<count($month);$i++) {
                print "<option value=\"". $month[$i] . "\">". $month[$i] . "</option>";
              }
              print("</select>月\n");

              fclose($fp2);
              ?>
            </td>
          </tr>

          <tr>
            <td class="bar" colspan="2"></td>
          </tr>

          <tr>
            <th>キーワード入力</th>
            <td class="contents">
              <input type="text" name="keyword" class="textbox">
            </td>
          </tr>

          <tr>
            <td class="bar" colspan="2"></td>
          </tr>

          <tr>
            <th>検索オプション</th>
            <td class="contents">

              <div class="pretty p-default p-round p-smooth p-bigger p-pulse">
                <input type="radio" name="andor" value="and" checked />
                <div class="state p-primary">
                  <label>AND(すべて含む)</label>
                </div>
              </div>

              <div class="pretty p-default p-round p-smooth p-bigger p-pulse">
                <input type="radio" name="andor" value="or">
                <div class="state p-primary">
                  <label>OR(いずれかを含む)</label>
                </div>
              </div>

              <div class="pretty p-default p-round p-smooth p-bigger p-pulse">
                <input type="radio" name="andor" value="not">
                <div class="state p-primary">
                  <label>NOT(すべて含まない)</label>
                </div>
              </div>

            </td>
          </tr>

          <tr>
            <td class="bar" colspan="2"></td>
          </tr>

          <tr>
            <td colspan="2" class="contents">
              <input type="submit" value="検索" class="btn">
              <input type="reset" value="クリア" class="btn">
            </td>
          </tr>
        </tbody>
      </table>

<!--

           <dl>
             <dt>ジャンルの選択</dt>
             <dd>検索ジャンルを選択可能。Shiftキーを押しながら連続した複数個のジャンルを選択できる。また、Ctrlキーを押しながら選択すると不連続の複数ジャンル選択ができる。</dd>

             <dt>キーワード</dt>
             <dd>複数のキーワードをスペース(コンマ、全角スペース、タブなどでも可)で区切って与える</dd>

             <dt>検索オプション</dt>
             <dd>複数のキーワードが与えられたとき、検索方式を決める。すべてのキーワードを雑誌名に含むように検索するとき、andを選択する。キーワードの一つでも雑誌名に含む項目を検索のとき、orを選択する。</dd>
           </dl>
-->
     </from>
   </body>
</html>
