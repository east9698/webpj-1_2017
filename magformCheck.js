$(document).ready(dunction()) {

  $("head").append("<link>");
  css = $("head").children(":last");
  css.attr({
    rel: "stylesheet",
    type: "text/css",
    href: "http://anshun9.jc.fit.ac.jp/~zeng/mag_sys/lib/validationEngine.jquery.css"
  )};

  $.ajax.({
    type: "get",
    url: "http://anshun9.jc.fit.ac.jp/~zeng/mag_sys/lib/jquery.validationEngine-ja.js",
    data: null,
    dataType: "script"
  });

  $.ajax.({
    type: "get",
    url: "http://anshun9.jc.fit.ac.jp/~zeng/mag_sys/lib/jquery.validationEngine-ja.js",
    data: null,
    dataType: "script",
    success: function(){
      if($("#checkform").length > 0){
	$("#checkform").validationEngine();
      }
    }
  });

});
