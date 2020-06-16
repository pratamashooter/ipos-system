$(document).ready(function(){
    $(document).on('focus', ':input', function(){
    	$(this).attr('autocomplete', 'off');
    });
});

$(function() {
  $("form[name='create_form']").validate({
    rules: {
      nama: "required",
      email: {
      	required: true,
      	email: true
      },
      username_2: {
        required: true,
        minlength: 4
      },
      password_2: {
        required: true,
        minlength: 5
      }
    },
    messages: {
      nama: "<i class='mdi mdi-close-circle-outline'></i>",
      email: "<i class='mdi mdi-close-circle-outline'></i>",
      username_2: "<i class='mdi mdi-close-circle-outline'></i>",
      password_2: "<i class='mdi mdi-close-circle-outline'></i>"
    },
    success: function(element) {
    	$(element).html("<i class='mdi mdi-check-circle-outline'></i>");
    	$(element).children().css({'margin-bottom' : '0px', 'color' : '#52fd5e'});
    },
    errorPlacement: function(error, element) {
        var name = element.attr("name");
        $("#" + name + "_error").html(error);
        $("#" + name + "_error").children().css({'margin-bottom' : '0px', 'color' : 'red'});
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});

$(function() {
  $("form[name='login_form']").validate({
    rules: {
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
      username: "<i class='mdi mdi-close-circle-outline'></i>",
      password: "<i class='mdi mdi-close-circle-outline'></i>"
    },
    success: function(element) {
    	$(element).html("<i class='mdi mdi-check-circle-outline'></i>");
    	$(element).children().css({'margin-bottom' : '0px', 'color' : '#52fd5e'});
    },
    errorPlacement: function ($error, $element) {
        var name = $element.attr("name");
        $("#" + name + "_error").append($error);
        $("#" + name + "_error").children().css({'margin-bottom' : '0px', 'color' : 'red'});
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});