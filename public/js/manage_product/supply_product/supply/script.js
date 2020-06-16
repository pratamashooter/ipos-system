$(document).ready(function(){
	$('.total-field').each(function(){
	  var harga = $(this).prev().children().first().val();
	  var jumlah = $(this).prev().prev().text();
	  var total = parseInt(harga) * parseInt(jumlah);
	  $(this).text("- Rp. " + parseInt(total).toLocaleString() + ',00');
	});
});

$(document).ready(function(){
  $('input[name=search]').on('keyup', function(){
    var searchTerm = $(this).val().toLowerCase();
    $(".list-date table").each(function(){
      var lineStr = $(this).text().toLowerCase();
      if(lineStr.indexOf(searchTerm) == -1){
        $(this).hide();
        $(this).parent().prev().hide();
      }else{
        $(this).show();
        $(this).parent().prev().show();
      }
    });
  });
});

$('.dropdown-search').on('hide.bs.dropdown', function () {
  $('.list-date table').show();
  $('.list-date table').parent().prev().show();
  $('input[name=search]').val('');
});