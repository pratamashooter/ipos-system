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

$(document).on('click', '.btn-upload', function(e){
	e.preventDefault();
	$('input[name=foto]').click();
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.img-edit').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("input[name=foto]").change(function(){
    readURL(this);
    var file = $(this).val();
    file = file.substring(file.lastIndexOf("\\") + 1, file.length);
    $('input[name=nama_foto]').val(file);
});

$(function() {
  $("form[name='update_form']").validate({
    rules: {
      nama: "required",
      email: {
      	required: true,
      	email: true
      },
      username: {
        required: true,
        minlength: 4
      },
      password: {
        required: true,
        minlength: 5
      }
    },
    messages: {
      nama: "Nama tidak boleh kosong",
      email: "Email tidak boleh kosong",
      username: "Username tidak boleh kosong",
      password: "Password tidak boleh kosong"
    },
    errorPlacement: function(error, element) {
        var name = element.attr("name");
        $("#" + name + "_error").html(error);
        $("#" + name + "_error").children().addClass('col-form-label');
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});

var validator = $("form[name='update_form']").validate({
    rules: {
      nama: "required",
      email: {
      	required: true,
      	email: true
      },
      username: {
        required: true,
        minlength: 4
      },
      password: {
        required: true,
        minlength: 5
      }
    },
    messages: {
      nama: "Nama tidak boleh kosong",
      email: "Email tidak boleh kosong",
      username: "Username tidak boleh kosong",
      password: "Password tidak boleh kosong"
    },
    errorPlacement: function(error, element) {
        var name = element.attr("name");
        $("#" + name + "_error").html(error);
        $("#" + name + "_error").children().addClass('col-form-label');
    },
    submitHandler: function(form) {
      form.submit();
    }
  });

$('.dropdown-search').on('hide.bs.dropdown', function () {
  $('tbody tr').show();
  $('input[name=search]').val('');
});