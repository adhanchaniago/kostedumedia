/***********************************************
Puskodal
URL: -
AUTHOR: Nabil Amer Thabit (nbilz//lab//dsign | @nbilz)
EMAIL: nbilz@live.com
DATE: Aug 26, 2013
REVISION: 1
NAME: back-end.puskodal.js
TYPE: JavaScript
DESCRIPTION: Pusat Komando dan Pengendalian Tentara Nasional Indonesia Angkatan Laut
************************************************/

$(window).load(function(){
    var widthTable = $('table.tab-admin').width();
    var htmlHeight = $('html').height();
    
    $('table.tab-admin').width(widthTable - 38);
    
    $(window).resize(function(){
        $('table.tab-admin').css('width', '100%').css('width', '-=38px');
    });
    
    $('#backlight').height(htmlHeight);
    
    $(window).resize(function(){
        $('#backlight').height(htmlHeight);
    });
    
    $('ul#side-menu li.sub-category a').click(function(e){
        e.preventDefault();
        
        var whoOpen = $(this).find('span').html();
        
        if($(this).hasClass('expand')){
            $(this).removeClass('expand');
            $('ul#side-menu li.' + whoOpen).slideUp('fast');
            $(this).find('img').attr('src', baseUrl + 'assets/html/img/arrow-down.png');
        }else{
            $(this).addClass('expand');
            $('ul#side-menu li.' + whoOpen).slideDown('fast');
            $(this).find('img').attr('src', baseUrl + 'assets/html/img/arrow-up.png');
        }
    });
    
    $('#filtering-form').click(function(e){
        e.preventDefault();
        
        if($('.filtering').is(':hidden')){
            $('.filtering').slideDown('fast');
            $(this).addClass('opens');
            $(this).find('img').attr('src', baseUrl + 'assets/html/img/arrow-up.png');
        }else{
            $('.filtering').slideUp('fast');
            $(this).removeClass('opens');
            $(this).find('img').attr('src', baseUrl + 'assets/html/img/arrow-down-black.png');
        }
    });
                
    $('a.edit').click(function(e){
        e.preventDefault();
        
        $('#backlight').fadeIn('fast', function(){
            $('#spotting-holder').fadeIn('fast');
        });
    });
                
    $('#backlight').click(function(e){
        e.preventDefault();
                    
        $('#spotting-holder').fadeOut('fast', function(){
            $('#backlight').fadeOut('fast');
        });
    });
                
    $('.list-data').delegate('a:not(#add-all, #remove-all)', 'click', function(e){
        e.preventDefault();
                    
        var banyakA = $(this).parent().find('a').length;
        var isiHtml = $(this).find('span').text();
        var idSide = $(this).parent().parent().attr('id');
                    
        $(this).slideUp('fast', function(){
            $(this).remove();
                        
            if(idSide == 'lefting'){
                if($('.list-data#righting p.datkos').is(':visible')){
                    $('.list-data#righting p.datkos').slideUp('fast', function(){
                        $('p#first-righting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/cancel.png" /><span>' + isiHtml + '</span></a>');
                    });
                }else{
                    $('p#first-righting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/cancel.png" /><span>' + isiHtml + '</span></a>');
                }
                            
                if($('a#remove-all').not(':visible')){
                    $('a#remove-all').fadeIn('fast');
                }
            }else{
                if($('.list-data#lefting p.datkos').is(':visible')){
                    $('.list-data#lefting p.datkos').slideUp('fast', function(){
                        $('p#first-lefting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/arrow-right.png" /><span>' + isiHtml + '</span></a>');
                    });
                }else{
                    $('p#first-lefting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/arrow-right.png" /><span>' + isiHtml + '</span></a>');
                }
                            
                if($('a#add-all').not(':visible')){
                    $('a#add-all').fadeIn('fast');
                }
            }
        });
                    
        if(banyakA == 1){
            $(this).parent().parent().find('p.datkos').slideDown();
                        
            if(idSide == 'lefting'){
                $('a#add-all').fadeOut('fast');
            }else{
                $('a#remove-all').fadeOut('fast');
            }
        }
    });
                
    $('a#add-all').click(function(e){
        e.preventDefault();
                    
        $(this).parent().parent().find('.scrolling a span').each(function(){

            var isiHtml = $(this).text();
                        
            $(this).parent().slideUp('fast', function(){
                $(this).remove();
                $('p#first-righting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/cancel.png" /><span>' + isiHtml + '</span></a>');
            });
        });
                    
        if($('.list-data#righting p.datkos').is(':visible')){
            $('.list-data#righting p.datkos').slideUp('fast');
        }
                    
        if($('a#remove-all').not(':visible')){
            $('a#remove-all').fadeIn('fast');
        }
                    
        $(this).fadeOut('fast', function(){
            $(this).parent().parent().find('p.datkos').slideDown('fast');
        });
                    
    });
                
    $('a#remove-all').click(function(e){
        e.preventDefault();
                    
        $(this).parent().parent().find('.scrolling a span').each(function(){

            var isiHtml = $(this).text();
                        
            $(this).parent().slideUp('fast', function(){
                $(this).remove();
                $('p#first-lefting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/arrow-right.png" /><span>' + isiHtml + '</span></a>');
            });
        });
                    
        if($('.list-data#lefting p.datkos').is(':visible')){
            $('.list-data#lefting p.datkos').slideUp('fast');
        }
                    
        if($('a#add-all').not(':visible')){
            $('a#add-all').fadeIn('fast');
        }
                    
        $(this).fadeOut('fast', function(){
            $(this).parent().parent().find('p.datkos').slideDown('fast');
        });
    });
});