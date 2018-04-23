(function($) {
    $.fn.drags = function(opt) {

        opt = $.extend({handle:".titlelan",cursor:"move"}, opt);

        if(opt.handle === "") {
            var $el = this;
        } else {
            var $el = this.find(opt.handle);
        }

        return $el.css('cursor', opt.cursor).not('input').on("mousedown", function(e) {
            if(opt.handle === "") {
                var $drag = $(this).addClass('draggable');
            } else {
                var $drag = $(this).addClass('active-handle').parent().addClass('draggable');
            }
            var z_idx = $drag.css('z-index'),
                drg_h = $drag.outerHeight(),
                drg_w = $drag.outerWidth(),
                pos_y = $drag.offset().top + drg_h - e.pageY,
                pos_x = $drag.offset().left + drg_w - e.pageX;
            $drag.css('z-index', 1000).parents().on("mousemove", function(e) {
                $('.draggable').offset({
                    top:e.pageY + pos_y - drg_h,
                    left:e.pageX + pos_x - drg_w
                }).on("mouseup", function() {
                    $(this).removeClass('draggable').css('z-index', z_idx);
                });
            });
            e.preventDefault(); // disable selection
        }).on("mouseup", function() {
            if(opt.handle === "") {
                $(this).removeClass('draggable');
            } else {
                $(this).removeClass('active-handle').parent().removeClass('draggable');
            }
        });

    }
})(jQuery);

$(window).load(function(){
    $('ul#side-menu li a').hover(function(){
        $(this).find('.caption').animate({
            width:'toggle'
        }, 250);
    }, function(){
        $(this).find('.caption').animate({
            width:'toggle'
        }, 250);
    });
                
    $('ul#side-menu li a#open').click(function(e){
        e.preventDefault();
                    
                    
        $(this).parent().fadeOut('fast');
        $(this).parent().parent().find('li.lvl-1').not('#opening').animate({
            width:'toggle'
        }, 150);
    });
                
    $('ul#side-menu li a#close').click(function(e){
        e.preventDefault();
                    
                    
        $(this).parent().parent().find('li.lvl-1').fadeOut('fast', function(){
            $('ul#side-menu li a#open').parent().fadeIn('fast');
        });
    });
                
    $('html').click(function(){
        $('ul#side-menu li a').not('#open, #close').removeAttr('id');
        $('ul#side-menu li ul').fadeOut();
    });
                
    $('ul#side-menu li ul li label').click(function(e){
        e.stopPropagation();
    });
                
    $('ul#side-menu li a').not('#open, #close').click(function(e){
        e.preventDefault();
        e.stopPropagation();
                    
        if($(this).attr('id') == 'current'){
            $(this).removeAttr('id');
            $(this).parent().find('ul').fadeOut();
        }else if($(this).attr('class') == 'lightning' || $(this).attr('class') == 'lightning-sub'){
            $(this).addClass('nyala');
        }else if($(this).attr('class') == 'lightning nyala' || $(this).attr('class') == 'lightning-sub nyala'){
            $(this).removeClass('nyala');
        }else{
            $('ul#side-menu li a').not('#open, #close').removeAttr('id');
            $(this).attr('id', 'current');
            $('ul#side-menu li ul').fadeOut();
            $(this).parent().find('ul').animate({
                width:'toggle'
            }, 150);
        }
    });
                
    $('#open-side-right').click(function(e){
        e.preventDefault();
        
        if($('#side-right').is(':hidden')){
            $('.notif-center').animate({'marginRight': 262}, 200);
            $('.notif-expand').animate({'marginRight': 262}, 200);
        }else{
            $('.notif-center').animate({'marginRight': 10}, 200);
            $('.notif-expand').animate({'marginRight': 10}, 200);
        }
                    
        $('#side-right').animate({
            width:'toggle'
        }, 150);
        
        
    });
                
    $('#side-right a#close-right').click(function(e){
        e.preventDefault();
                    
        $('#side-right').animate({
            width:'toggle'
        }, 150);
        
        $('.notif-center').animate({'marginRight': 10}, 200);
        $('.notif-expand').animate({'marginRight': 10}, 200);
    });

    
// side-info baru per menu 
    $('#open-side-info-pesut').click(function(e){
        e.preventDefault();
        
        if($('#side-pesut').is(':hidden')){
            $('.notif-center').animate({'marginRight': 262}, 200);
            $('.notif-expand').animate({'marginRight': 262}, 200);
        }else{
            $('.notif-center').animate({'marginRight': 10}, 200);
            $('.notif-expand').animate({'marginRight': 10}, 200);
        }
                    
        $('#side-pesut').animate({
            width:'toggle'
        }, 150);
        
        
    });
                
    $('#side-pesut a#close-pesut').click(function(e){
        e.preventDefault();
                    
        $('#side-pesut').animate({
            width:'toggle'
        }, 150);
        
        $('.notif-center').animate({'marginRight': 10}, 200);
        $('.notif-expand').animate({'marginRight': 10}, 200);
    });
       

// side-info-KRI
  $('#open-side-info-KRI').click(function(e){
        e.preventDefault();
        
        if($('#side-KRI').is(':hidden')){
            $('.notif-center').animate({'marginRight': 262}, 200);
            $('.notif-expand').animate({'marginRight': 262}, 200);
        }else{
            $('.notif-center').animate({'marginRight': 10}, 200);
            $('.notif-expand').animate({'marginRight': 10}, 200);
        }
                    
        $('#side-KRI').animate({
            width:'toggle'
        }, 150);
        
        
    });
                
    $('#side-KRI a#close-KRI').click(function(e){
        e.preventDefault();
                    
        $('#side-KRI').animate({
            width:'toggle'
        }, 150);
        
        $('.notif-center').animate({'marginRight': 10}, 200);
        $('.notif-expand').animate({'marginRight': 10}, 200);
    });

    $('#open-video').click(function(e){
        e.preventDefault();
        
        $('.video-streaming').fadeIn('fast');
    });
    
    $('#open-chat').click(function(e){
        e.preventDefault();
                    
        $('.chat').fadeIn('fast');
    });
                
//    $('#close-video').click(function(e){
//        e.preventDefault();
//                    
//        $('#video-streaming').fadeOut('fast', function(){
//            $('#backlight').fadeOut('fast');
//        });
//    });
    
    $('.popup, .chat, .video-streaming').drags();
    
    $('#form-laporan').click(function(){
        $('.popup').fadeIn('fast');
    });
    
    $('.titlelan a.closing').click(function(e){
        e.preventDefault();
        
        $(this).parent().parent().fadeOut('fast');
    });
    
    $('.notif-center').click(function(event){
        event.preventDefault();
        
        $(this).find('span').fadeOut();
        
        if($('.notif-expand').is(':hidden')){
            $('.notif-expand').fadeIn();
        }else{
            $('.notif-expand').fadeOut();
        }
    });
});