$(function(){
  $("button#doInitialize").on("click", function(){
    console.log("clicked");
    $.ajax({
      url: "initialize.php",
      method: "POST"
    })
    .done(function(msg){
      $("div#initialize > a > dl > dd").append("初期化が実行されました。");
    })
    .fail(function(msg){
      $("#resultInitialize").append("初期化に失敗しました。");
    });
  });
});
