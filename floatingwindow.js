$(function(){
  $("a.open").each(function(){ // "open"クラスが付与された<a>タグ

    var id = $(this).attr("href");  // 対象要素のhref属性の値を取得
    var floatWindow = $("div.floatingwindow" + id);  // 便宜のため変数でjqueryセレクタを設定
    var btnOpen = $(this);  // windowを開くボタン
    var btnClose = floatWindow.find(".close");  // windowを閉じるボタン
    var windowHeader = floatWindow.find("dt");  // windowのヘッダー部

    btnOpen.click(function(){  // windowを開くボタンがクリックされた時
      floatWindow.fadeIn("fast");  // ポップアップ時のアニメーション付与
      return false;
    });

    btnClose.click(function(){
      floatWindow.fadeOut("fast");  // 終了時のアニメーション付与
      return false;
    });

    floatWindow.resizable();

    windowHeader.mousedown(function(event){  // windowのヘッダーがドラッグされている間

      var clickPointX = event.offsetX;
      var clickPointY = event.offsetY;

      $(document).mousemove(function(event){  // windowの位置を移動する
        floatWindow.css({
          left: event.pageX - clickPointX + "px",
          top: event.pageY - clickPointY + "px"
        });
        // 以下テストコード
        var pageCoords = "( " + event.pageX + ", " + event.pageY + " )";
        var clickPoint = "( " + clickPointX + ", " + clickPointY + " )";
        $("div#test1").text( "( event.pageX, event.pageY ) : " + pageCoords );
        $("div#test2").text( "( clickPointX, clickPointY ) : " + clickPoint );
        // ここまで
      });

    }).mouseup(function(){  // ドロップしたら
      $(document).unbind("mousemove");  // windowの移動をやめる

    });
  });


  $("div.floatingwindow").focusin(function(){  // windowが複数ある場合、フォーカスが当たると最前面に表示する


    var numOfWindows = $('div.floatingwindow[style*="display: block;"]').length;  // windowの数を取得
    console.log(numOfWindows);

    $(this).css("z-index", numOfWindows * 100 );
    console.log(numOfWindows * 100);

    $(this).focusout(function(){
      var zindex = $(this).css("z-index");
      $(this).css("z-index", zindex - 1);
    });

  });

  /*
  $("div.floatingwindow").resizable({
  autoHide : true
  ghost : true
  handler : n, ne, e, se, s, sw, w, nw
  });
  */
});
