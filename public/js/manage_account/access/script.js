function responsiveBtn(){
	var width = $(window).width();
    if(width < 575){
        $('.big-search').prop('hidden', true);
        $('.small-search').prop('hidden', false);
    }else{
    	$('.big-search').prop('hidden', false);
        $('.small-search').prop('hidden', true);
    }
}

$(window).on('resize', function(){
    responsiveBtn();
});

$(document).ready(function(){
	responsiveBtn();
	$('input[name=search]').on('input', function(){
	    var searchTerm = $(this).val().toLowerCase();
	    $("tbody tr").each(function(){
	      var lineStr = $(this).text().toLowerCase();
	      if(lineStr.indexOf(searchTerm) == -1){
	        $(this).hide();
	      }else{
	        $(this).show();
	      }
	    });
	  });
});

$('.small-search').on('hide.bs.dropdown', function () {
  $('tbody tr').show();
  $('input[name=search]').val('');
});