$(function(){
  $("a.open").each(function(){

    var id = $(this).attr("href");
    var floatWindow = $("div.floatingwindow" + id);
    var btnOpen = $(this);
    var btnClose = floatWindow.find(".close");
    var windowHeader = floatWindow.find("dt");

    btnOpen.click(function(){
      floatWindow.fadeIn("fast");
      return false;
    });

    btnClose.click(function(){
      floatWindow.fadeOut("fast");
      return false;
    });

    floatWindow.resizable();

    windowHeader.mousedown(function(event){

      var clickPointX = event.offsetX;
      var clickPointY = event.offsetY;

      $(document).mousemove(function(event){
        floatWindow.css({
          left: event.pageX - clickPointX + "px",
          top: event.pageY - clickPointY + "px"
        });
        var pageCoords = "( " + event.pageX + ", " + event.pageY + " )";
        var clickPoint = "( " + clickPointX + ", " + clickPointY + " )";
        $("div#test1").text( "( event.pageX, event.pageY ) : " + pageCoords );
        $("div#test2").text( "( clickPointX, clickPointY ) : " + clickPoint );
      });

    }).mouseup(function(){
      $(document).unbind("mousemove");

    });
  });


  $("div.floatingwindow").focusin(function(){


    var numOfWindows = $('div.floatingwindow[style*="display: block;"]').length;
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
