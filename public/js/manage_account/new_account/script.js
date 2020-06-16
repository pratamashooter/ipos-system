$(document).on('click', '.upload-btn', function(){
	$('#foto').click();
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview-foto').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#foto").change(function(){
    readURL(this);
});

$(function() {
  $("form[name='create_form']").validate({
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
      },
      role: "required"
    },
    messages: {
      nama: "Nama tidak boleh kosong",
      email: "Email tidak boleh kosong",
      username: "Username tidak boleh kosong",
      password: "Password tidak boleh kosong",
      role: "Silakan pilih posisi"
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