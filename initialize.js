$(function(){
  $("button#doInitialize").on("click", function(){
    console.log("clicked");
    $.ajax({
      url: "initialize.php",
      method: "POST"
    })
    .done(function(msg){
      alert(msg);
      $("#resultInitialize").append(msg);
    })
    .fail(function(msg){
      $("#resultInitialize").append("初期化に失敗しました。");
    });
  });
  console.log("done");
});
