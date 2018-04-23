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
			$drag = null;
			e.preventDefault(); // disable selection
		}).on("mouseup", function() {
			if(opt.handle === "") {
				$(this).removeClass('draggable');
			} else {
				$(this).removeClass('active-handle').parent().removeClass('draggable');
			}
		});
		$el = null;
	}
})(jQuery);


$(window).load(function(){
	$('.popup, .chat,.video-streaming ').drags();
	$('ul#side-menu li a').hover(function(){
		$(this).find('.caption').animate({width:'toggle'}, 250);
	}, function(){
		$(this).find('.caption').animate({width:'toggle'}, 250);
	});

	$('ul#side-menu li a#open').click(function(e){
		e.preventDefault();

		$(this).parent().fadeOut('fast');
		$(this).parent().parent().find('li.lvl-1').not('#opening').animate({width:'toggle'}, 150);
	});

	$('ul#side-menu li a#close').click(function(e){
		e.preventDefault();

		$(this).parent().parent().find('li.lvl-1').fadeOut('fast', function(){
			$('ul#side-menu li a#open').parent().fadeIn('fast');
		});
	});
    
	$('ul#side-menu li a').not('#open, #close').click(function(e){
		e.preventDefault();
		// console.log("ulsidemenu");
		if($(this).attr('id') == 'current'){
			$(this).removeAttr('id');
			$(this).parent().find('ul').fadeOut();
		}else if($(this).attr('class') == 'lightning'){
			$(this).addClass('nyala');
		}else if($(this).attr('class') == 'lightning nyala'){
			$(this).removeClass('nyala');
		}else{
			$('ul#side-menu li a').not('#open, #close').removeAttr('id');
			$(this).attr('id', 'current');
			$('ul#side-menu li ul').fadeOut();
			$(this).parent().find('ul').animate({width:'toggle'}, 150);
		}
	});

	//side-KRI
	$('div#side-KRI a').not('#open, #close').click(function(e){
		e.preventDefault();
		// console.log("masuk diveside");
		if($(this).attr('class') == 'showHist'){
			$(this).addClass('nyala');
			// console.log("2");
		}else if($(this).attr('class') == 'showHist nyala'){
			$(this).removeClass('nyala');
			// console.log("3");
		}
	});

//side-POI
	$('div#side-POI a').not('#open, #close').click(function(e){
		e.preventDefault();
		
	});
$('#side-POI a#close-POI').click(function(e){
		e.preventDefault();

		

		$('#side-POI').animate({width:'toggle'}, 150);
	});

// side-Fletmoon
	$('div#side-Fletmoon a').not('#open, #close').click(function(e){
		e.preventDefault();
		
	});
$('#side-Fletmoon a#close-Fletmoon').click(function(e){
		e.preventDefault();

		$("#ship-info-Fletmoon").empty();	

		$('#side-Fletmoon').animate({width:'toggle'}, 150);
	});

	//side-pesud
	$('div#side-pesud a').not('#open, #close').click(function(e){
		e.preventDefault();
		// console.log("masuk diveside");
		if($(this).attr('class') == 'showHist'){
			$(this).addClass('nyala');
			// console.log("2");
		}else if($(this).attr('class') == 'showHist nyala'){
			$(this).removeClass('nyala');
			// console.log("3");
		}
	});


	// $('ul#side-menu li a').not('#open, #close').click(function(e){
	// 	e.preventDefault();

	// 	if($(this).attr('id') == 'current'){
	// 		$(this).removeAttr('id');
	// 		$(this).parent().find('ul').fadeOut();
	// 	}else if($(this).attr('class') == 'lightning'){
	// 		$(this).addClass('nyala');
	// 	}else if($(this).attr('class') == 'lightning nyala'){
	// 		$(this).removeClass('nyala');
	// 	}else{
	// 		$('ul#side-menu li a').not('#open, #close').removeAttr('id');
	// 		$(this).attr('id', 'current');
	// 		$('ul#side-menu li ul').fadeOut();
	// 		$(this).parent().find('ul').animate({width:'toggle'}, 150);
	// 	}
	// });
    
	$('#open-side-right').click(function(e){
		e.preventDefault();

		$('#side-right').animate({width:'toggle'}, 150);
	});
    
	$('#side-right a#close-right').click(function(e){
		e.preventDefault();

		$('#side-right').animate({width:'toggle'}, 150);
	});
// js toogle info pangkalan
    $('#open-side-info-pangkalan').click(function(e){
		e.preventDefault();

		$('#side-pangkalan').animate({width:'toggle'}, 150);
	});
    
	$('#side-pangkalan a#close-pangkalan').click(function(e){
		e.preventDefault();

		$('#side-pangkalan').animate({width:'toggle'}, 150);
	});


// AIS
$('#open-side-info-ais').click(function(e){
		e.preventDefault();

		$('#side-ais').animate({width:'toggle'}, 150);
	});
    
	$('#side-ais a#close-ais').click(function(e){
		e.preventDefault();

		$('#side-ais').animate({width:'toggle'}, 150);
	});

// 

// ARPA RADAR
$('#open-side-info-arpa').click(function(e){
		e.preventDefault();

		$('#side-arpa').animate({width:'toggle'}, 150);
	});
    
	$('#side-arpa a#close-arpa').click(function(e){
		e.preventDefault();

		$('#side-arpa').animate({width:'toggle'}, 150);
	});

// 

// js toogle info marinir
    $('#open-side-info-marinir').click(function(e){
		e.preventDefault();

		$('#side-marinir').animate({width:'toggle'}, 150);
	});
    
	$('#side-marinir a#close-marinir').click(function(e){
		e.preventDefault();

		$('#side-marinir').animate({width:'toggle'}, 150);
	});

	// js toogle info pesud
    $('#open-side-info-pesud').click(function(e){
		e.preventDefault();

		$('#side-pesud').animate({width:'toggle'}, 150);
	});
    
	$('#side-pesud a#close-pesud').click(function(e){
		e.preventDefault();
		showHistoryPesud(false);
		$('#side-pesud').animate({width:'toggle'}, 150);
	});

		// js toogle info marinir
    $('#open-side-info-satgas').click(function(e){
		e.preventDefault();

		$('#side-satgas').animate({width:'toggle'}, 150);
	});
    
	$('#side-satgas a#close-satgas').click(function(e){
		e.preventDefault();

		$('#side-satgas').animate({width:'toggle'}, 150);
	});

// toogle info KRI
 $('#open-side-info-lawan').click(function(e){
		e.preventDefault();

		$('#side-lawan').animate({width:'toggle'}, 150);
	});
    
	$('#side-lawan a#close-lawan').click(function(e){
		e.preventDefault();

		$('#side-lawan').animate({width:'toggle'}, 150);
	});

// toogle pesan baru
$('#new-pesan a#new-pesan').click(function(e){
        e.preventDefault();
        
        $('#new-pesan').animate({width:'toggle'}, 150);
    });


    $("#show-tulis").click(function(){
        $(".chat").slideToggle();
          $('#ship-id2').empty();
    		$('#filter').empty();
    });

    $('.titlelan a.closing').click(function(e){
        $(this).parent().parent().slideToggle();
        $('#show-tulis').removeClass('nyala');
         $('#ship-id2').empty();
          $('#filter').empty();
    });

// toogle info kri 
 $('#open-side-info-KRI').click(function(e){
		e.preventDefault();

		$('#side-KRI').animate({width:'toggle'}, 150);
	});
    
	$('#side-KRI a#close-KRI').click(function(e){
		e.preventDefault();

		// console.log("tututututuppp base.js");
		showHistory(false);
		// + tutup yg asalnya nyala
		if($('#showhist').attr('class') == 'showHist nyala'){
			// $('#showhist').removeClass('nyala');
			// console.log("remove nyala");
			console.log("kedetek nyala");
		}

		$('#side-KRI').animate({width:'toggle'}, 150);
	});

	
	// $('#get-camera').click(function(e){
        // e.preventDefault();
		
        // if($(this).hasClass('nyala')){
			// $('#backlight').fadeIn('fast', function(){
				// $('#video-streaming').fadeIn('fast');
			// });
		// }else{
			// $('#video-streaming').fadeOut('fast', function(){
				// $('#backlight').fadeOut('fast');
			// });
		// }
        
    // });
    
	$('#close-video').click(function(e){
		e.preventDefault(); 
		$('#video-streaming').fadeOut('fast', function(){
			$('#backlight').fadeOut('fast');
		});
	});
    
    // ukur jarak
	// $('#show-measure-tools').click(function(){
	// 	if($(this).hasClass('nyala')){
	// 		stat_ukur_jarak = true;
	// 	}else{
	// 		stat_ukur_jarak = false;
	// 		hapus_jarak();
	// 	}
	// });
	
	$('#show-chat').click(function(e){
		e.preventDefault();
		if($(this).hasClass('nyala')){
			$('.chat').fadeIn('fast');
		}else{
			$('.chat').fadeOut('fast');
		}
	});
	
	// $('#chat_close').click(function(e){
	// 	e.preventDefault();
	// 	$('.chat').fadeOut('fast');
	// 	$('#show-chat').removeClass('nyala');
	// });
	// $('.chat').drags();
	/*$('ul#contact-list li a').click(function(e){
		e.preventDefault();
		$('ul#contact-list li a').removeClass('activate');
		$(this).addClass('activate');
		console.log($(this).val());
	});*/
});
