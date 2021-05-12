$("#btn_search").on("click", function () {
  OnClickSearch();
});

$('#data_edit').click(function () {
  $('#img_edit').prop('disabled', false);
  $('#data_save').prop('disabled', false);
  $('#data_name').prop('disabled', false);
  $('#data_memo').prop('disabled', false);
});

$('#data_save').click(function () {
  $('#img_edit').prop('disabled', true);
  $('#data_save').prop('disabled', true);
  $('#data_name').prop('disabled', true);
  $('#data_memo').prop('disabled', true);
});

$(function () {
  $('#myfile').change(function (e) {
    //ファイルオブジェクトを取得する
    var file = e.target.files[0];
    var reader = new FileReader();

    //画像でない場合は処理終了
    if (file.type.indexOf("image") < 0) {
      alert("画像ファイルを指定してください。");
      return false;
    }

    //アップロードした画像を設定する
    reader.onload = (function (file) {
      return function (e) {
        $("#side_data_img").attr("src", e.target.result);
        $("#side_data_img").attr("title", file.name);
      };
    })(file);
    reader.readAsDataURL(file);

  });
});