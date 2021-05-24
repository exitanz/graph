<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">

$(function() {
  $("#btn3").click(function() {
    $("#txt2").prop("disabled", true);
  });

  $("#btn4").on("click", function(e) {
    $("#txt2").prop("disabled", false);
  });
});

</script>

<div style="background-color:#CCC; padding:20px;">
  <input type="button" id="btn3" value="無効">
  <input type="button" id="btn4" value="リセット">
　<input type="text" id="txt2">
</div>