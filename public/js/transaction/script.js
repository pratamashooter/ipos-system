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
  $("form[name='transaction_form']").validate({
    rules: {
      diskon: "required",
      bayar: "required"
    },
    errorPlacement: function(error, element) {
        var name = element.attr("name");
        $('input[name='+ name +']').addClass('is-invalid');
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});

function subtotalBarang() {
  var subtotal_barang = 0;
  $('.total_barang').each(function(){
    subtotal_barang += parseInt($(this).val());
  });
  $('.nilai-subtotal1-td').html('Rp. ' + parseInt(subtotal_barang).toLocaleString());
  $('.nilai-subtotal2-td').val(subtotal_barang);
}

function diskonBarang() {
  var subtotal = parseInt($('input[name=subtotal]').val());
  var diskon = parseInt($('input[name=diskon]').val());
  var total = subtotal - (subtotal * diskon / 100);
  $('.nilai-total1-td').html('Rp. ' + parseInt(total).toLocaleString());
  $('.nilai-total2-td').val(total);
}

function jumlahBarang(){
  var jumlah_barang = 0;
  $('.jumlah_barang_text').each(function(){
    jumlah_barang += parseInt($(this).text());
  });
  $('.jml-barang-td').html(jumlah_barang + ' Barang');
}

function tambahData(kode, nama, harga, stok, status) {
  var tambah_data = '<tr><td><input type="text" name="kode_barang[]" hidden="" value="'+ kode +'"><span class="nama-barang-td">'+ nama +'</span><span class="kode-barang-td">'+ kode +'</span></td><td><input type="text" name="harga_barang[]" hidden="" value="'+ harga +'"><span>Rp. '+ parseInt(harga).toLocaleString() +'</span></td><td><div class="d-flex justify-content-start align-items-center"><input type="text" name="jumlah_barang[]" hidden="" value="1"><a href="#" class="btn-operate mr-2 btn-tambah"><i class="mdi mdi-plus"></i></a><span class="ammount-product mr-2" unselectable="on" onselectstart="return false;" onmousedown="return false;"><p class="jumlah_barang_text">1</p></span><a href="#" class="btn-operate btn-kurang"><i class="mdi mdi-minus"></i></a></div></td><td><input type="text" class="total_barang" name="total_barang[]" hidden="" value="'+ harga +'"><span>Rp. '+ parseInt(harga).toLocaleString() +'</span></td><td><a href="#" class="btn btn-icons btn-rounded btn-secondary ml-1 btn-hapus"><i class="mdi mdi-close"></i></a></td><td hidden=""><span>'+ stok +'</span><span>'+ status +'</span></td></tr>';
  $('.table-checkout').append(tambah_data);
  subtotalBarang();
  diskonBarang();
  jumlahBarang();
  $('.close-btn').click();
}

$(document).on('click', '.btn-tambah', function(e){
  e.preventDefault();
  var stok = parseInt($(this).parent().parent().next().next().next().children().first().text());
  var status = parseInt($(this).parent().parent().next().next().next().children().eq(1).text());
  var jumlah_barang = parseInt($(this).prev().val());
  if((stok > jumlah_barang && status == 1) || status == 0){
    var tambah_barang = jumlah_barang + 1;
    $(this).prev().val(tambah_barang);
    $(this).next().children().first().html(tambah_barang);
    var harga = parseInt($(this).parent().parent().prev().children().first().val());
    var total_barang = harga * tambah_barang;
    $(this).parent().parent().next().children().first().val(total_barang);
    $(this).parent().parent().next().children().eq(1).html('Rp. ' + parseInt(total_barang).toLocaleString());
    subtotalBarang();
    diskonBarang();
    jumlahBarang();
  }
});

$(document).on('click', '.btn-kurang', function(e){
  e.preventDefault();
  var jumlah_barang = parseInt($(this).prev().prev().prev().val());
  if(jumlah_barang > 1){
    var kurang_barang = jumlah_barang - 1;
    $(this).prev().prev().prev().val(kurang_barang);
    $(this).prev().children().first().html(kurang_barang);
    var harga = parseInt($(this).parent().parent().prev().children().first().val());
    var total_barang = harga * kurang_barang;
    $(this).parent().parent().next().children().first().val(total_barang);
    $(this).parent().parent().next().children().eq(1).html('Rp. ' + parseInt(total_barang).toLocaleString());
    subtotalBarang();
    diskonBarang();
    jumlahBarang();
  }
});

$(document).on('click', '.btn-hapus', function(e){
  e.preventDefault();
  $(this).parent().parent().remove();
  subtotalBarang();
  diskonBarang();
  jumlahBarang();
});

$(document).on('click', '.ubah-diskon-td', function(e){
  e.preventDefault();
  $('.diskon-input').prop('hidden', false);
  $('.nilai-diskon-td').prop('hidden', true);
  $('.simpan-diskon-td').prop('hidden', false);
  $(this).prop('hidden', true);
});

$(document).on('click', '.simpan-diskon-td', function(e){
  e.preventDefault();
  $('.diskon-input').prop('hidden', true);
  $('.nilai-diskon-td').prop('hidden', false);
  $('.ubah-diskon-td').prop('hidden', false);
  $(this).prop('hidden', true);
  diskonBarang();
});

$(document).on('input', '.diskon-input', function(){
  $('.nilai-diskon-td').html($(this).val());
  if($(this).val().length > 0){
    $(this).removeClass('is-invalid');
  }else{
    $(this).addClass('is-invalid');
  }
});

$(document).on('input', '.bayar-input', function(){
  if($(this).val().length > 0){
    $(this).removeClass('is-invalid');
    $('.nominal-error').prop('hidden', true);
  }else{
    $(this).addClass('is-invalid');
  }
});

function stopScan(){
  Quagga.stop();
}

$('#scanModal').on('hidden.bs.modal', function(e) {
  $('#area-scan').prop('hidden', true);
  $('#btn-scan-action').prop('hidden', true);
  $('.barcode-result').prop('hidden', true);
  $('.barcode-result-text').html('');
  $('.kode_barang_error').prop('hidden', true);
  stopScan();
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