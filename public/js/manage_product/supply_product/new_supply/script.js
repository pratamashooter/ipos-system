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

$(function() {
  $("form[name='manual_form']").validate({
    rules: {
      kode_barang: "required",
      jumlah: "required",
      harga_beli: "required"
    },
    messages: {
      kode_barang: "Kode barang tidak boleh kosong",
      jumlah: "Jumlah tidak boleh kosong",
      harga_beli: "Harga satuan tidak boleh kosong"
    },
    errorPlacement: function(error, element) {
        var name = element.attr("name");
        $("#" + name + "_error").html(error);
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});

var validator = $("form[name='manual_form']").validate({
    rules: {
      kode_barang: "required",
      jumlah: "required",
      harga_beli: "required"
    },
    messages: {
      kode_barang: "Kode barang tidak boleh kosong",
      jumlah: "Jumlah tidak boleh kosong",
      harga_beli: "Harga satuan tidak boleh kosong"
    },
    errorPlacement: function(error, element) {
        var name = element.attr("name");
        $("#" + name + "_error").html(error);
    },
    submitHandler: function(form) {
      form.submit();
    }
});

function stopScan(){
  Quagga.stop();
}

function startScan() {
  Quagga.init({
    inputStream : {
      name : "Live",
      type : "LiveStream",
      target: document.querySelector('#area-scan')
    },
    decoder : {
      readers : ["ean_reader"],
      multiple: false
    },
    locate: false
  }, function(err) {
      if (err) {
          console.log(err);
          return
      }
      console.log("Initialization finished. Ready to start");
      Quagga.start();
  });

  Quagga.onDetected(function(data){
    $('#area-scan').prop('hidden', true);
    $('#btn-scan-action').prop('hidden', false);
    $('.barcode-result').prop('hidden', false);
    $('.barcode-result-text').html(data.codeResult.code);
    stopScan();
  });
}

$(document).on('click', '.btn-scan', function(){
  $('#btn-scan-action').prop('hidden', true);
  $('#area-scan').prop('hidden', false);
  $('.barcode-result').prop('hidden', true);
  $('.barcode-result-text').html('');
  startScan();
});

$(document).on('click', '.btn-repeat', function(){
  $('#area-scan').prop('hidden', false);
  $('#btn-scan-action').prop('hidden', true);
  $('.barcode-result').prop('hidden', true);
  $('.barcode-result-text').html('');
  startScan();
});

$('#scanModal').on('hidden.bs.modal', function (e) {
  $('#btn-scan-action').prop('hidden', true);
  $('#area-scan').prop('hidden', true);
  $('.barcode-result').prop('hidden', true);
  $('.barcode-result-text').html('');
  stopScan();
});

$(document).on('click', '.btn-tab', function(){
	$('.btn-tab').toggleClass('btn-tab-active');
});

$(document).on('click', '.btn-pilih', function(e){
  e.preventDefault();
	var kode_barang = $(this).prev().prev().children().first().text();
	$('input[name=kode_barang]').val(kode_barang);
	$('.close-btn').click();
	$('input[name=kode_barang]').valid();
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

$(document).on('click', '.btn-delete', function(){
	$(this).parents().eq(1).remove();
	var check = $('.kd-barang-field').length;
	if(check != 0){
		$('.btn-simpan').prop('hidden', false);
	}else{
		$('.btn-simpan').prop('hidden', true);
	}
});

$(document).on('click', '.manual_form_btn', function(){
  $('form[name=manual_form]').prop('hidden', false);
  $('form[name=import_form]').prop('hidden', true);
  $('input[name=excel_file]').val('');
  $('.excel-name').html('Pilih File');
  $('.btn-upload').prop('hidden', true);
});

$(document).on('click', '.import_form_btn', function(){
  $('form[name=manual_form]').prop('hidden', true);
  $('form[name=import_form]').prop('hidden', false);
  $('input[name=kode_barang]').val('');
  $('input[name=jumlah]').val('');
  $('input[name=harga_beli]').val('');
});

$(document).on('click', '.excel-file', function(e){
  e.preventDefault();
  $('input[name=excel_file]').click();
});

$('input[name=excel_file]').change(function(){
    var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
    $('.excel-name').html(filename);
    $('.btn-upload').prop('hidden', false);
});