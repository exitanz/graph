$("#btn_search").on("click", function () {
  OnClickSearch();
});

$('#data_edit').click(function() {
    $('#data_save').prop('disabled', false);
    $('#data_name').prop('disabled', false);
    $('#data_memo').prop('disabled', false);
});

$('#data_save').click(function() {
    $('#data_save').prop('disabled', true);
    $('#data_name').prop('disabled', true);
    $('#data_memo').prop('disabled', true);
});