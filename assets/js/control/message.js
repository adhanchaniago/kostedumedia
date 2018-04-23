
function getRealTimeShipList(fn)
{
	socket.emit('reqRTShipList');
	socket.once('resRTShipList', function (data) {
		fn(data);
	});
}

function getKRIMsgContent(idKRI, fn) {
	socket.emit('reqKRIMsgContent', idKRI);
	socket.once('resKRIMsgContent', function (data) {
		fn(data);
	});
}

function showMessage(stat)
{    
	getRealTimeShipList(function(data) {        
		$('#side-right').hide();
		cleanInfoPanel();
		
		var content = '<li>Daftar Kapal</li>';
		$.each(data, function(i,item) {           
			content += '<li id = "' + item.ship_id + '" onclick="showMsgContent(' + item.ship_id + ')">' + item.ship_id + ' - ' + item.ship_name + '</li>'; 
		});
		
		$("#ship-info").html(content);
		
		$('#side-right').animate({width:'toggle'}, 150);

	});
}

function showMsgContent(idKRI)
{
	getKRIMsgContent(idKRI, function(data) {
		$('#ship-personnel').empty();
		
		var content = '<li>KRI ' + idKRI + '</li>';
		content += '<div class="msg-content">';
		
		$.each(data, function(i,item) {
			if (item.id_to == idKRI) {
				content += '<ul class="left-msg">';
			} else if (item.id_from == idKRI) {
				content += '<ul class="right-msg">';
			}
			content += '<label>' + item.msg + '</label>';
			content += '<label><small>' + item.waktu + '</small></label>';
			content += '</ul>'; 
		});
		content += '</div>';
		
		$("#ship-personnel").html(content);
	});
}

