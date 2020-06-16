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

$('.date').dateDropper({
  format: 'd-m-Y'
});

function responsiveBtn(){
	var width = $(window).width();
    if(width < 455){
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

function searchFunction(){
  $('input[name=search]').on('input', function(){
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
}

$(document).ready(function(){
    responsiveBtn();
    searchFunction();
    $('.total-field').each(function(){
      var harga = $(this).prev().children().first().val();
      var jumlah = $(this).prev().prev().text();
      var total = parseInt(harga) * parseInt(jumlah);
      $(this).text("- Rp. " + parseInt(total).toLocaleString() + ',00');
    });
});

$(document).on('click', '.pasok-btn', function(){
    $(this).addClass('btn-active');
    $('.transaksi-btn').removeClass('btn-active');
    $('#list-date-pasok').prop('hidden', false);
    $('#list-date-transaksi').prop('hidden', true);
    $('input[name=search]').val('');
    $('.list-date table').show();
    $('.list-date table').parent().prev().show();
});

$(document).on('click', '.transaksi-btn', function(){
    $(this).addClass('btn-active');
    $('.pasok-btn').removeClass('btn-active');
    $('#list-date-pasok').prop('hidden', true);
    $('#list-date-transaksi').prop('hidden', false);
    $('input[name=search]').val('');
    $('.list-date table').show();
    $('.list-date table').parent().prev().show();
});

$(document).on('click', '.btn-selengkapnya', function(){
  var target = $(this).attr('data-target');
  var status = $(target).attr('data-status');
  if(status == 0){
    $(target).fadeIn(200);
    $(this).children().first().removeClass('mdi-chevron-down');
    $(this).children().first().addClass('mdi-chevron-up');
    $(target).attr('data-status', 1);
  }else{
    $(target).fadeOut(200);
    $(this).children().first().addClass('mdi-chevron-down');
    $(this).children().first().removeClass('mdi-chevron-up');
    $(target).attr('data-status', 0);
  }
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

var check_checkbox = 0;
$(document).on('click', '.checkbox_laporan', function(){
  if($(this).attr('data-check') == 0){
    $(this).attr('data-check', 1);
    check_checkbox += 1;
  }else{
    $(this).attr('data-check', 0);
    check_checkbox -= 1;
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
        if(check_checkbox >= 1){
          $('form[name=export_form]').submit();
        }else{
          swal(
                "",
                "Silakan pilih laporan",
                "error"
            );
        }
      }
    }
  }else{
    if(check_checkbox >= 1){
      $('form[name=export_form]').submit();
    }else{
      swal(
            "",
            "Silakan pilih laporan",
            "error"
        );
    }
  }
});

$('.small-search').on('hide.bs.dropdown', function () {
  $('input[name=search]').val('');
  $('.list-date table').show();
  $('.list-date table').parent().prev().show();
});