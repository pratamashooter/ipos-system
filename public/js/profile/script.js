$(document).ready(function(){
  $('input[name=search]').on('keyup', function(){
    var searchTerm = $(this).val().toLowerCase();
    $(".activity-list div").each(function(){
      var lineStr = $(this).text().toLowerCase();
      console.log(lineStr);
      if(lineStr.indexOf(searchTerm) == -1){
        $(this).hide();
      }else{
        $(this).show();
      }
    });
  });
});

$(document).on('click', '.data_diri_tab_btn', function(){
  $(this).addClass('btn-tab-active');
  $('.password_tab_btn').removeClass('btn-tab-active');
  $('form[name=change_profile_form]').prop('hidden', false);
  $('form[name=change_password_form]').prop('hidden', true);
});

$(document).on('click', '.password_tab_btn', function(){
  $(this).addClass('btn-tab-active');
  $('.data_diri_tab_btn').removeClass('btn-tab-active');
  $('form[name=change_profile_form]').prop('hidden', true);
  $('form[name=change_password_form]').prop('hidden', false);
});

function responsiveCard(){
  var width = $(window).width();
    if(width < 576){
      $('.account-detail').addClass('order-first');
    }else{
      $('.account-detail').removeClass('order-first');
    }
}

$(window).on('resize', function(){
    responsiveCard();
});

$(document).ready(function(){
    responsiveCard();
});

$(document).on('click', '.btn-edit-img', function(){
  $('#foto').click();
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.foto-profil').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#foto").change(function(){
    readURL(this);
    $('.btn-update-img').prop('hidden', false);
    $('.btn-edit-img').prop('hidden', true);
});

$(function() {
  $("form[name='change_profile_form']").validate({
    rules: {
      nama: "required",
      email: {
        required: true,
        email: true
      },
      username: {
        required: true,
        minlength: 4
      }
    },
    messages: {
      nama: "Nama tidak boleh kosong",
      email: "Email tidak boleh kosong",
      username: "Username tidak boleh kosong"
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

$(function() {
  $("form[name='change_password_form']").validate({
    rules: {
      old_password: "required",
      new_password: "required"
    },
    messages: {
      old_password: "Password lama tidak boleh kosong",
      new_password: "Password baru tidak boleh kosong"
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