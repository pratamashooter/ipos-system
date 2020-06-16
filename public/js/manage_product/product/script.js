$(document).ready(function(){
  $('input[name=search]').on('keyup', function(){
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
    $('.barcode-result').prop('hidden', false);
    $('#scan-modal-footer').prop('hidden', false);
    $('.barcode-result-text').html(data.codeResult.code);
    stopScan();
  });
}

$(document).on('click', '.btn-scan', function(){
  $('#edit-modal-body').prop('hidden', true);
  $('#scan-modal-body').prop('hidden', false);
  $('#edit-modal-footer').prop('hidden', true);
  $('#scan-modal-footer').prop('hidden', true);
  $('#area-scan').prop('hidden', false);
  $('.barcode-result').prop('hidden', true);
  $('.barcode-result-text').html('');
  startScan();
});

$(document).on('click', '.btn-continue', function(){
  $('input[name=kode_barang]').val($('.barcode-result-text').text());
  $('#edit-modal-body').prop('hidden', false);
  $('#scan-modal-body').prop('hidden', true);
  $('#edit-modal-footer').prop('hidden', false);
  $('#scan-modal-footer').prop('hidden', true);
  $('#area-scan').prop('hidden', true);
  $('.barcode-result').prop('hidden', true);
  stopScan();
});

$(document).on('click', '.btn-repeat', function(){
  $('#area-scan').prop('hidden', false);
  $('.barcode-result').prop('hidden', true);
  $('#scan-modal-footer').prop('hidden', true);
  $('.barcode-result-text').html('');
  startScan();
});

$('#editModal').on('hidden.bs.modal', function (e) {
  $('#edit-modal-body').prop('hidden', false);
  $('#scan-modal-body').prop('hidden', true);
  $('#edit-modal-footer').prop('hidden', false);
  $('#scan-modal-footer').prop('hidden', true);
  $('#area-scan').prop('hidden', true);
  $('.barcode-result').prop('hidden', true);
  $('.barcode-result-text').html('');
  stopScan();
});

$(function() {
  $("form[name='update_form']").validate({
    rules: {
      kode_barang: "required",
      nama_barang: "required",
      jenis_barang: "required",
      stok: "required",
      harga: "required"
    },
    messages: {
      kode_barang: "Kode barang tidak boleh kosong",
      nama_barang: "Nama barang tidak boleh kosong",
      jenis_barang: "Silakan pilih jenis barang",
      stok: "Stok barang tidak boleh kosong",
      harga: "Harga barang tidak boleh kosong"
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

var validator = $("form[name='update_form']").validate({
  rules: {
    kode_barang: "required",
    nama_barang: "required",
    jenis_barang: "required",
    stok: "required",
    harga: "required"
  },
  messages: {
    kode_barang: "Kode barang tidak boleh kosong",
    nama_barang: "Nama barang tidak boleh kosong",
    jenis_barang: "Silakan pilih jenis barang",
    stok: "Stok barang tidak boleh kosong",
    harga: "Harga barang tidak boleh kosong"
  },
  errorPlacement: function(error, element) {
      var name = element.attr("name");
      $("#" + name + "_error").html(error);
  },
  submitHandler: function(form) {
    form.submit();
  }
});

$('.dropdown-search').on('hide.bs.dropdown', function () {
  $('tbody tr').show();
  $('input[name=search]').val('');
});