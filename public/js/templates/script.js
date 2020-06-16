$(document).ready(function(){
    $(document).on('focus', ':input', function(){
    	$(this).attr('autocomplete', 'off');
    });
});