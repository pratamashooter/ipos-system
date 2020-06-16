(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));

$(".number-input").inputFilter(function(value) {
  return /^-?\d*$/.test(value); 
});

$(document).on('input propertychange paste', '.input-notzero', function(e){
  var val = $(this).val()
  var reg = /^0/gi;
  if (val.match(reg)) {
      $(this).val(val.replace(reg, ''));
  }
});

$(document).on('keydown', '.dis-backspace', function(e){
  if (e.which === 8){
    e.preventDefault();
  }
});

function responsiveBtn(){
	var width = $(window).width();
    if(width < 710){
        $(".btn-search-lg").prop('hidden', true);
        $(".btn-search-sm").prop('hidden', false);
    }else if(width < 768){
    	$(".btn-search-lg").prop('hidden', false);
        $(".btn-search-sm").prop('hidden', true);
    }else if(width < 1350){
		$(".btn-search-lg").prop('hidden', true);
        $(".btn-search-sm").prop('hidden', false);
    }else{
    	$(".btn-search-lg").prop('hidden', false);
        $(".btn-search-sm").prop('hidden', true);
    }
}

function percentate(){
	$('.percent-status').each(function(){
	  var harga_awal = parseInt($(this).prev().children().first().val());
	  var harga_akhir = parseInt($(this).parent().prev().children().eq(2).children().first().val());
	  if(harga_awal == 0 || harga_akhir == harga_awal){
	    $(this).parent().prev().children().eq(3).html('<i class="mdi mdi-trending-neutral"></i> 0%');
	    $(this).parent().prev().children().eq(3).addClass('text-primary');
	    $(this).parent().prev().children().eq(4).children().first().attr('data-content', '0');
	  }else if(harga_akhir < harga_awal){
	    var penurunan = Math.round((harga_awal - harga_akhir) / harga_awal * 100);
	    var harga_turun = harga_awal - harga_akhir;
	    $(this).parent().prev().children().eq(3).html('<i class="mdi mdi-trending-down"></i> '+ penurunan +'%');
	    $(this).parent().prev().children().eq(3).addClass('text-success');
	    $(this).parent().prev().children().eq(4).children().first().attr('data-content', '+ ' + harga_turun);
	  }else if(harga_akhir > harga_awal){
	    var kenaikan = Math.round((harga_akhir - harga_awal) / harga_awal * 100);
	    var harga_naik = harga_akhir - harga_awal;
	    $(this).parent().prev().children().eq(3).html('<i class="mdi mdi-trending-up"></i> '+ kenaikan +'%');
	    $(this).parent().prev().children().eq(3).addClass('text-danger');
	    $(this).parent().prev().children().eq(4).children().first().attr('data-content', '- ' + harga_naik);
	  }
	});
}

$(function () {
	$('.info-btn').popover({
	  container: 'body'
	});
});

$(document).ready(function () {
    responsiveBtn();
    percentate();
});

$(window).on('resize', function(){
	responsiveBtn();
});

$(document).on('click', '.info-btn', function(e){
	e.preventDefault();
});

$(document).on('click', '.btn-search', function(){
	$('.info-btn').popover('hide');
});

$('.date').dateDropper({
  format: 'd-m-Y'
});

var check_laporan = 0;
$(document).on('click', 'input[value=period]', function(){
  check_laporan = 0;
  $('.period-form').prop('hidden', false);
  $('.manual-form').prop('hidden', true);
});

$(document).on('click', 'input[value=manual]', function(){
  check_laporan = 1;
  $('.manual-form').prop('hidden', false);
  $('.period-form').prop('hidden', true);
});

$(document).on('change', '.period-select', function(){
  if($(this).val() == 'minggu'){
    $('.time-input').val(1);
    $('.time-input').attr('max', 4);
  }else if($(this).val() == 'bulan'){
    $('.time-input').val(1);
    $('.time-input').attr('max', 11);
  }else if($(this).val() == 'tahun'){
    $('.time-input').val(1);
    $('.time-input').attr('max', 5);
  }
});

$(document).on('click', '.btn-export', function(){
  if(check_laporan == 1){
    var tgl_awal = $('input[name=tgl_awal_export]').val();
    var tgl_akhir = $('input[name=tgl_akhir_export]').val();
    if(tgl_awal == '' && tgl_akhir == ''){
      swal(
          "",
          "Tanggal awal dan akhir tidak boleh kosong",
          "error"
      );
    }else if(tgl_awal == ''){
      swal(
          "",
          "Tanggal awal tidak boleh kosong",
          "error"
      );
    }else if(tgl_akhir == ''){
      swal(
          "",
          "Tanggal akhir tidak boleh kosong",
          "error"
      );
    }else{
      var sArray = tgl_awal.split('-');
      var sDate = new Date(sArray[2], sArray[1], sArray[0]);
      var eArray = tgl_akhir.split('-');
      var eDate = new Date(eArray[2], eArray[1], eArray[0]);
      if(eDate < sDate){
        swal(
            "",
            "Tanggal akhir tidak boleh kurang dari tanggal awal",
            "error"
        );
      }else{
        $('form[name=export_form]').submit();
      }
    }
  }else{
    $('form[name=export_form]').submit();
  }
});

$(document).ready(function(){
  $('input[name=search]').on('keyup', function(){
    var searchTerm = $(this).val().toLowerCase();
    $(".product-list li").each(function(){
      var lineStr = $(this).text().toLowerCase();
      console.log(lineStr);
      if(lineStr.indexOf(searchTerm) == -1){
        $(this).addClass('non-active-list');
        $(this).removeClass('active-list');
      }else{
        $(this).addClass('active-list');
        $(this).removeClass('non-active-list');
      }
    });
  });
});