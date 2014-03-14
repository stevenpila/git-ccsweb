$(document).ready(function(){
    $('.modal-options').hide();
    $('.modal-close').hide();
    $('.gallery-options').hide();
    $('.folder-options').hide();
    // $('.folder-caption').hide();
    $('#image-gallery-button').on('click', function (event) {
        event.preventDefault();
        blueimp.Gallery($('#links a'), $('#blueimp-gallery').data());
    });
//    $(document).on('click','.left.carousel-control.prev, .right.carousel-control.next',function(){
//        $('.modal-options').hide();
//        var index = $(this).parents('.slide').attr('data-index');
//        index ++;
//        $('strong').text(index).css({'font-weight':'normal'});
//        $('.modal-options-dropdown > .dropdown-menu').attr('data-value',$('#links div').eq(index).children('ul').attr('data-value'));
//        $('.modal-options-dropdown > .dropdown-menu').attr('data-album',$('#links div').eq(index).children('ul').attr('data-album'));
//    });
    $(document).on('mouseenter','#blueimp-gallery .modal-content',function(){
        var index = $(this).parents('.slide').attr('data-index');
        index ++;
        $('strong').text(index).css({'font-weight':'normal'});
//        $('.modal-options-dropdown > .dropdown-menu').attr('data-value',$('#links gallery-options-container[data-index="'+index+'"]').children('ul').attr('data-value'));
////        $('.modal-options-dropdown > .dropdown-menu').attr('data-album',$('#links div').eq(index).children('ul').attr('data-album'));
////        alert($('#links div').eq(index).children('ul').attr('data-value'));
//        alert($('#links div').eq(index).children('ul').attr('data-value'));
        if(!$('.modal-options-dropdown').hasClass('open')){
            $('.modal-options').show();
            $('.modal-close').show();
        }
        else{
            $('.modal-options').show();
            $('.modal-close').show();
        }
    });
    $(document).on('mouseleave','#blueimp-gallery .modal-content',function(){
        if($('.modal-options-dropdown').hasClass('open')){
            $('.modal-options').show();
            $('.modal-close').show();
        }
        else{
//            $('.modal-options').fadeOut();
//            $('.modal-close').fadeOut();
            $('.modal-options').hide();
            $('.modal-close').hide();
        }
//        $('.modal-options').slideDown();
    });
    $(document).on('mouseenter','.folder-options-container',function(){
        if(!$('.folder-options-dropdown',this).hasClass('open')){
            $('.folder-options',this).show();
            $('.folder-caption',this).show();
        }
        else{
            $('.folder-options',this).show();
            $('.folder-caption',this).show();
        }
    });
    $(document).on('mouseleave','.folder-options-container',function(){
        if($('.folder-options-dropdown',this).hasClass('open')){
            $('.folder-options',this).show();
            $('.folder-caption',this).show();
        }
        else{
            $('.folder-options',this).hide();
            $('.folder-caption',this).hide();
        }
    });
    
    $(document).on('mouseenter','#links .gallery-options-container',function(){
        if(!$('.gallery-options-dropdown',this).hasClass('open'))
            $('.gallery-options',this).show();
        else
            $('.gallery-options',this).show();
    });
    $(document).on('mouseleave','#links .gallery-options-container',function(){
        if($('.gallery-options-dropdown',this).hasClass('open'))
            $('.gallery-options',this).show();
        else
            $('.gallery-options',this).hide();
    });
    $(document).click(function(){
        $('.gallery-options').hide();
        $('.folder-options').hide();
        $('.folder-caption').hide();
    });
    $(document).on('click','.modal-close',function(){
        location.reload();
//        $('#blueimp-gallery .modal').removeClass('in');
    });
});
