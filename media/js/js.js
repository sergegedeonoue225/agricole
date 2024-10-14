jQuery(function($){
    $('.input').focus(function(){
        $(this).parent().find(".label-txt").addClass('label-active');
    });

    $('.input').each(function(){
        if($(this).val().length > 0) {
            $(this).parent().find(".label-txt").addClass('label-active');
        }
    });

    $(".input").focusout(function(){
        if ($(this).val() == '') {
            $(this).parent().find(".label-txt").removeClass('label-active');
        };
    });
})