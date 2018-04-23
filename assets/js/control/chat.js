/**
    chat engine handler.
*/
function initChatEngine(){

    var selectedClients = null;

    socket.emit('reqClientList');
    socket.once('resClientList', function(clients){
        //console.log('CLIENT LISTS : '+JSON.stringify(clients));
        //console.log(clients);
		var onchat,client_text = null;
        $.each(clients, function(idx, client){
			if(idx==0){
				$('.chat_user').text(client.chatName);
			}
			onchat = (idx==0)?'onchat':'';
            client_text = 
                '<li>'+
                    '<a href="#" class="'+onchat+' list_user_chat"  id="user-'+client.chatId+'" onclick="select_user_chat(event,this.id)" rel="'+client.chatId+'">'+client.chatName+'</a>'+
                '</li>';

            $('.chat_user_list').append(client_text);
			onchat = null;client_text=null;
        });
    });

    //input text id : chat-input
    //submit button id : chat-submit

    socket.on('chat', function(data){
        //append to chat history
        
        data = JSON.parse(data);
		//console.log('chat-from');
        //console.log(data);
		var time,sender,content,chatComponent = null;
        $.each(data, function(i, item ){
            time = new Date(item.timestamp);
            
            sender = markerKRIdata[item.from]['kri'].name;
            content = item.content;
            chatComponent = 
                '<li class="from-other">'+
                    '<span>'+sender+'|'+month[time.getUTCMonth()]+' '+time.getDate()+','+time.getFullYear()+' '+time.getUTCHours()+':'+time.getMinutes()+':'+time.getSeconds()+'</span><br />'+
                    content+
                '</li>';
            $('.chat_content').append(chatComponent);
			
        });
        time=null;sender=null;content=null;chatComponent = null;

    });

    $('#chat-submit').click(function(){
        var msgToSend = $('#chat-input').val();
        
        //append to chat history
        var time = new Date();
        var time = month[time.getUTCMonth()]+' '+time.getDate()+','+time.getFullYear()+' '+time.getUTCHours()+':'+time.getMinutes()+':'+time.getSeconds();
        var sender = 'Puskodal';
        var content = msgToSend;

        socket.emit('sendMsg',{'from' : 'P', 'to': '1' , priority: 3, 'content' : content});

        var chatComponent = 
			 '<li class="from-you">'+
                    '<span>'+sender+'|'+time+'</span><br />'+
                    content+
			'</li>';
        $('.chat_content').append(chatComponent);

        $('#chat-input').val('');
		msgToSend=null;time=null;sender=null;content=null;chatComponent=null;
    });
    $('.search-button').click(function(event){
        event.preventDefault();
        $('.search-input').show().focus();
        $('.search-cancel').show();
        $(this).hide();
        // //console.log(array_search);
    });
    $('.search-cancel').click(function(event){
        event.preventDefault();
        $('.search-input').val('').hide();
        $('.search-tooltip').empty().hide();
        $(this).hide();
        $('.search-button').show();
    });
    $('.search-input').keyup(function(){
        var src_keyword = $(this).val();
        $('.search-tooltip').empty();
        var it_up = 0;
        $.each(array_search,function(i,item){
            var search = new RegExp(src_keyword.toLowerCase(), "gi");
            var item_search = item.name.toLowerCase();
            if(item_search.match(search) && src_keyword.length>0){
                if(item.type=="marines" && stat_view.marine==true){
                    $('.search-tooltip').append('<a class="search-tip" style="cursor:pointer;" onclick="setView('+item.lat+','+item.lon+',\''+item.type+'\',\''+item.name+'\')" >'+item.name+'</a>');
                    it_up++;
                }else if(item.type=="kri" && stat_view.kri==true){
                    $('.search-tooltip').append('<a class="search-tip" style="cursor:pointer;" onclick="setView('+item.lat+','+item.lon+',\''+item.type+'\',\''+item.name+'\')" >'+item.name+'</a>');
                    it_up++;
                }else if(item.type=="track" && stat_view.kri==true){
                    $('.search-tooltip').append('<a class="search-tip" style="cursor:pointer;" onclick="setView('+item.lat+','+item.lon+',\''+item.type+'\',\''+item.name+'\')" >'+item.name+'</a>');
                    it_up++;
                }
            }else if(src_keyword.length==0){
                $('.search-tooltip').empty().hide();
            }
        });
		
        if(it_up>0){
            $('.search-tooltip').show();
        }
		src_keyword = null;
		it_up = null;
    }).keydown(function(){
        var src_keyword = $(this).val();
        $('.search-tooltip').empty();
        var it_down = 0;
        $.each(array_search,function(i,item){
            var search = new RegExp(src_keyword.toLowerCase(), "gi");
            var item_search = item.name.toLowerCase();
            if(item_search.match(search) && src_keyword.length>0){
                if(item.type=="marines" && stat_view.marine==true){
                    $('.search-tooltip').append('<a class="search-tip" style="cursor:pointer;" onclick="setView('+item.lat+','+item.lon+',\''+item.type+'\',\''+item.name+'\')" >'+item.name+'</a>');
                    it_down++;
                }else if(item.type=="kri" && stat_view.kri==true){
                    $('.search-tooltip').append('<a class="search-tip" style="cursor:pointer;" onclick="setView('+item.lat+','+item.lon+',\''+item.type+'\',\''+item.name+'\')" >'+item.name+'</a>');
                    it_down++;
                }else if(item.type=="track" && stat_view.kri==true){
                    $('.search-tooltip').append('<a class="search-tip" style="cursor:pointer;" onclick="setView('+item.lat+','+item.lon+',\''+item.type+'\',\''+item.name+'\')" >'+item.name+'</a>');
                    it_down++;
                }
            }else if(src_keyword.length==0){
                $('.search-tooltip').empty().hide();
            }
        });
        if(it_down>0){
            $('.search-tooltip').show();
        }
		src_keyword = null;
		it_down = null;
    }).click(function(){
        $(this).focus();
    });
}

function select_user_chat(event,id){
	event.preventDefault();
	$('.list_user_chat').each(function(){
		if($(this).hasClass('onchat')){
			$(this).removeClass('onchat');
		}
	});
	$('#'+id).addClass('onchat');
	//console.log(id);
}

function setView(lat,lon,type,text){
    $('.search-tooltip').empty().hide();
    $('.search-input').val(text);
    map.panTo(new L.LatLng(parseFloat(lat), parseFloat(lon)),{animate:true,duration:1,easeLinearity:100});
    if(circleAnimation!=null){
        map.removeLayer(circleAnimation);
    }
    circleAnimation = new L.CircleMarker([parseFloat(lat), parseFloat(lon)],{
        radius: 10,
        weight: 3,
        color: '#e03',
        stroke: true,
        fill: false,
        title: '',
        //TODO add custom icon! 
        marker: false   //show icon optional, show only circleLoc
    }); 
    map.addLayer(circleAnimation);
}
//chat engine end.