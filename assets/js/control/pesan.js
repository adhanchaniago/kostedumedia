
function getMessage(fn){

        socket.emit('reqMessage');
        socket.once('resMessage', function (data) {
            //console.log(dfta);
            fn(data);
        });
}
function getMessageinbox(fn){

        socket.emit('reqMessageinbox');
        socket.once('resMessageinbox', function (data) {
            //console.log(data);
            fn(data);
        });
}


function getMessageoutbox(fn){

        socket.emit('reqMessageoutbox');
        socket.once('resMessageoutbox', function (data) {
            // console.log(data);
            fn(data);
        });
}

function newMessage(fn){ // added by SKM17

        socket.emit('reqRTShipList');
        socket.once('resRTShipList', function (data) {
            //console.log(data);
            fn(data);
        });
}   



var ke = null;
function Showfrom(id,nama,fn, idMsgShow)
{ 
    // console.log("isi apa");
    // console.log(id);

    $('#mva'+id+'a').click(function(){
        console.log("df");
        $('#mva'+id+'a').empty();
        var r = '';
        r += '<input class="magic" type="radio" id="radio(\''+id+'\')" name="radios" value="noo" checked>';
        r += '<label class="lb" for="radio(\''+id+'\')">'+ id + ' - '+ nama + '';        
        r += '</label>';
        $('#mva'+id+'a').append(r); 
    });

    ke = id;    
   
    if(socket != null){ 
        // console.log("pas ngereload masuk sini ga yaa");
        if (id[3] != null) {  //pesan broadcast          
            socket.emit('reqMessageBroadcast', { ship_id: id });

            socket.once('resMessageBroadcast', function (data) {
            var data1hr = [];
            var data2hr = [];
            var data3hr = [];
            var data4hr = [];
            var data5hr = [];
            var data6hr = [];
            var data7hr = [];
            var filter='';
            var now = new Date();     
            // console.log("panjang = "+data.length); 
            
            //filtering dan assign data perhari
            for(var i=0; i<data.length; i++){                
                var d = new Date(data[i].created_time);
            
                if (d.getTime() > now.getTime() - 1*24*60*60*1000){ //kalo dari 1 hr yg lalu
                    // console.log("lebih kecil 1");  
                    data1hr.push(data[i]);
                    // console.log(data1hr);  
                } 
                if (d.getTime() > now.getTime() - 2*24*60*60*1000){ //kalo dari 2 hr yg lalu
                    // console.log("lebih kecil 2");  
                    data2hr.push(data[i]);
                    // console.log(data2hr);  
                }
                if (d.getTime() > now.getTime() - 3*24*60*60*1000){ //kalo dari 3 hr yg lalu
                    // console.log("lebih kecil 3");  
                    data3hr.push(data[i]);
                }
                if (d.getTime() > now.getTime() - 4*24*60*60*1000){ //kalo dari 4 hr yg lalu
                    // console.log("lebih kecil 4");  
                    data4hr.push(data[i]);
                    // console.log(data4hr);  
                }
                if (d.getTime() > now.getTime() - 5*24*60*60*1000){ //kalo dari 5 hr yg lalu
                    // console.log("lebih kecil 5");  
                    data5hr.push(data[i]);
                    // console.log(data5hr);  
                }
                if (d.getTime() > now.getTime() - 6*24*60*60*1000){ //kalo dari 6 hr yg lalu
                    // console.log("lebih kecil 6");  
                    data6hr.push(data[i]);
                    // console.log(data6hr);  
                }
                if (d.getTime() > now.getTime() - 7*24*60*60*1000){ //kalo dari 7 hr yg lalu
                    // console.log("lebih kecil 7");  
                    data7hr.push(data[i]);
                    // console.log(data7hr);  
                }                                
            }

            $("#filter").html(''); 
             var filter = '';
                 filter +='<select id="sel" style="color:black"  >';
                 filter +='<option value="99"> - </option>';
                 filter +='<option value="1">1hari (24)</option>';
                 filter +='<option value="2">2hari (48)</option>';
                 filter +='<option value="3">3hari (72)</option>';
                 filter +='<option value="4">4hari (96)</option>';
                 filter +='<option value="5">5hari (120)</option>';
                 filter +='<option value="6">6hari (144)</option>';
                 filter +='<option value="7">7hari (168)</option>';
                 filter +='</select> ';
                 filter += 'Jam yang Lalu';
            $("#filter").append(filter);

            var sumberdata = [];
            // console.log($("#sel").val());  
            $("#sel").change(function(){
                console.log($("#sel").val());  
                sumberdata = data;

                if ($("#sel").val() == "1"){
                    sumberdata = data1hr;
                } else if ($("#sel").val() == "2"){
                    sumberdata = data2hr;
                } else if ($("#sel").val() == "3"){
                    sumberdata = data3hr;
                } else if ($("#sel").val() == "4"){
                    sumberdata = data4hr;
                } else if ($("#sel").val() == "5"){
                    sumberdata = data5hr;
                } else if ($("#sel").val() == "6"){
                    sumberdata = data6hr;
                } else if ($("#sel").val() == "7"){
                    sumberdata = data7hr;
                } else if ($("#sel").val() == "99"){
                    sumberdata = data;
                }

                         $("#ship-id2").html('');   
             var Ipesan = '';
             
                 Ipesan += '<div  class="tranding-pesan">';
            $.each(sumberdata,function(i,item){ 
                
          
                if (item.id_from!='1') {
                Ipesan +='<div class="bubble">';
                Ipesan +='<li>';
                Ipesan +='<div class="dari"><font style="margin-top:5px;"><strong>Dari </strong>:'+item.id_from+'&nbsp;</font>';    
                Ipesan += '<label class="content_timestamp" style="float:right; margin-right:130px;">'+item.created_time + ' '; // +'</label>'; 
                Ipesan += '<div id="isistate' + item.msg_id + '"';
                if (item.state > 1 && item.state < 5)
                Ipesan += ' style="color:red"';
                Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                Ipesan += '</div>';
                //Ipesan += '<hr>';
                    if ( item.msg_type==1) {
                    Ipesan +=' <p style="margin-right:20px;"> '+ item.msg +'</p>';
               
                    }
                    if (item.msg_type==2) {
                     Ipesan +='<img class="pic" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' " width="120px" height="100px"; alt="kpl">' 
                     Ipesan +='<div class="big">';
                     Ipesan +='<center><img class="picbig" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' "height="125" width="215" alt="kpl"></center>';
                     Ipesan +='</div>';
                 
                    };
                Ipesan +='</li>'
                Ipesan +='</div>';
                }

                  else  {
                Ipesan +='<div class="bubble bubble--alt">'
                Ipesan +='<li>';            
                if (item.msg_type==3){
                     Ipesan +='<div><strong>Ke </strong>:<img src="' + conf.url + 'assets/html/img/bc.png" height="23" width="22" > &nbsp;';
                } else {
                    Ipesan +='<div><strong>Ke </strong>:'+item.id_to+'&nbsp;';
                }
                Ipesan += '<label class="content_timestamp" style="float:right; text-align:left;" >'+item.created_time + ' '; // +'</label>'; 
                Ipesan += '<div id="isistate' + item.msg_id + '"';
                if (item.state > 1 && item.state < 5)
                Ipesan += ' style="color:red"';
                Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                Ipesan += '</div>';
                // Ipesan += '<hr>';
                Ipesan +=' <p> '+ item.msg +'</p>';
                Ipesan +='</li>'
                Ipesan +='</div>';
                }
                

               
            });  

                Ipesan +'</div>';

            $("#ship-id2").append(Ipesan);  
              $( ".tranding-pesan" ).scrollTop( 10000000 );
            //end sel change
            });        

            sumberdata = data;

            $("#ship-id2").html('');   
             var Ipesan = '';
             
                 Ipesan += '<div  class="tranding-pesan">';
            $.each(sumberdata,function(i,item){ 
                
          
                if (item.id_from!='1') {
                Ipesan +='<div class="bubble">';
                Ipesan +='<li>';
                Ipesan +='<div class="dari"><font style="margin-top:5px;"><strong>Dari </strong>:'+item.id_from+'&nbsp;</font>';    
                Ipesan += '<label class="content_timestamp" style="float:right; margin-right:130px;">'+item.created_time + ' '; // +'</label>'; 
                Ipesan += '<div id="isistate' + item.msg_id + '"';
                if (item.state > 1 && item.state < 5)
                Ipesan += ' style="color:red"';
                Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                Ipesan += '</div>';
                //Ipesan += '<hr>';
	                if ( item.msg_type==1) {
	                Ipesan +=' <p style="margin-right:20px;"> '+ item.msg +'</p>';
	           
	                }
	                if (item.msg_type==2) {
	                 Ipesan +='<img class="pic" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' " width="120px" height="100px"; alt="kpl">' 
	                 Ipesan +='<div class="big">';
	                 Ipesan +='<center><img class="picbig" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' "height="125" width="215" alt="kpl"></center>';
	                 Ipesan +='</div>';
	             
	                };
                Ipesan +='</li>'
                Ipesan +='</div>';
                }

                  else  {
                Ipesan +='<div class="bubble bubble--alt">'
                Ipesan +='<li>';            
                if (item.msg_type==3){
                     Ipesan +='<div><strong>Ke </strong>:<img src="' + conf.url + 'assets/html/img/bc.png" height="23" width="22" > &nbsp;';
                } else {
                    Ipesan +='<div><strong>Ke </strong>:'+item.id_to+'&nbsp;';
                }
                Ipesan += '<label class="content_timestamp" style="float:right; text-align:left;" >'+item.created_time + ' '; // +'</label>'; 
                Ipesan += '<div id="isistate' + item.msg_id + '"';
                if (item.state > 1 && item.state < 5)
                Ipesan += ' style="color:red"';
                Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                Ipesan += '</div>';
                // Ipesan += '<hr>';
                Ipesan +=' <p> '+ item.msg +'</p>';
                Ipesan +='</li>'
                Ipesan +='</div>';
                }
                

               
            });  

                Ipesan +'</div>';

            $("#ship-id2").append(Ipesan);  
              $( ".tranding-pesan" ).scrollTop( 10000000 );      
              
               
              
            });
            
        } else  if (id == 'XX') {  //pesan KRI TO KRI        
          
            socket.emit('reqMessageKriToKri', { ship_id: id });

            socket.once('resMessageKriToKri', function (data) {
            var data1hr = [];
            var data2hr = [];
            var data3hr = [];
            var data4hr = [];
            var data5hr = [];
            var data6hr = [];
            var data7hr = [];
            var filter='';
            var now = new Date();     
            // console.log("panjang = "+data.length); 
            
            //filtering dan assign data perhari
            for(var i=0; i<data.length; i++){                
                var d = new Date(data[i].created_time);
            
                if (d.getTime() > now.getTime() - 1*24*60*60*1000){ //kalo dari 1 hr yg lalu
                    // console.log("lebih kecil 1");  
                    data1hr.push(data[i]);
                    // console.log(data1hr);  
                } 
                if (d.getTime() > now.getTime() - 2*24*60*60*1000){ //kalo dari 2 hr yg lalu
                    // console.log("lebih kecil 2");  
                    data2hr.push(data[i]);
                    // console.log(data2hr);  
                }
                if (d.getTime() > now.getTime() - 3*24*60*60*1000){ //kalo dari 3 hr yg lalu
                    // console.log("lebih kecil 3");  
                    data3hr.push(data[i]);
                }
                if (d.getTime() > now.getTime() - 4*24*60*60*1000){ //kalo dari 4 hr yg lalu
                    // console.log("lebih kecil 4");  
                    data4hr.push(data[i]);
                    // console.log(data4hr);  
                }
                if (d.getTime() > now.getTime() - 5*24*60*60*1000){ //kalo dari 5 hr yg lalu
                    // console.log("lebih kecil 5");  
                    data5hr.push(data[i]);
                    // console.log(data5hr);  
                }
                if (d.getTime() > now.getTime() - 6*24*60*60*1000){ //kalo dari 6 hr yg lalu
                    // console.log("lebih kecil 6");  
                    data6hr.push(data[i]);
                    // console.log(data6hr);  
                }
                if (d.getTime() > now.getTime() - 7*24*60*60*1000){ //kalo dari 7 hr yg lalu
                    // console.log("lebih kecil 7");  
                    data7hr.push(data[i]);
                    // console.log(data7hr);  
                }                                
            }

            $("#filter").html(''); 
             var filter = '';
                 filter +='<select id="sel" style="color:black"  >';
                 filter +='<option value="99">-</option>';
                 filter +='<option value="1">1hari (24)</option>';
                 filter +='<option value="2">2hari (48)</option>';
                 filter +='<option value="3">3hari (72)</option>';
                 filter +='<option value="4">4hari (96)</option>';
                 filter +='<option value="5">5hari (120)</option>';
                 filter +='<option value="6">6hari (144)</option>';
                 filter +='<option value="7">7hari (168)</option>';
                 filter +='</select> ';
                 filter += 'Jam yang Lalu';
            $("#filter").append(filter);

            var sumberdata = [];
            // console.log($("#sel").val());  
            $("#sel").change(function(){
                console.log($("#sel").val());  
                sumberdata = data;

                if ($("#sel").val() == "1"){
                    sumberdata = data1hr;
                } else if ($("#sel").val() == "2"){
                    sumberdata = data2hr;
                } else if ($("#sel").val() == "3"){
                    sumberdata = data3hr;
                } else if ($("#sel").val() == "4"){
                    sumberdata = data4hr;
                } else if ($("#sel").val() == "5"){
                    sumberdata = data5hr;
                } else if ($("#sel").val() == "6"){
                    sumberdata = data6hr;
                } else if ($("#sel").val() == "7"){
                    sumberdata = data7hr;
                } else if ($("#sel").val() == "99"){
                    sumberdata = data;
                }

             $("#ship-id2").html('');   
             var Ipesan = '';
                 Ipesan += '<div  class="tranding-pesan">';
            $.each(sumberdata,function(i,item){ 
                
          
                if (item.id_from!='1') {
                Ipesan +='<div class="bubble bubble--alt">';
                Ipesan +='<li>';
                Ipesan +='<div class="dari"><font style="margin-top:0px;">'+item.id_to+'</font><img src="' + conf.url + 'assets/html/img/ye.png" height="14" width="20" ><font>'+item.id_from+' </font>';    
                Ipesan += '<label class="content_timestamp" style="float:right; margin-right:5px;">'+item.created_time + ' '; // +'</label>'; 
                Ipesan += '<div id="isistate' + item.msg_id + '"';
                if (item.state > 1 && item.state < 5)
                Ipesan += ' style="color:red"';
                Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                Ipesan += '</div>';
                //Ipesan += '<hr>';
                    if ( item.msg_type==1) {
                    Ipesan +=' <p style="margin-right:20px;"> '+ item.msg +'</p>';
               
                    }
                    if (item.msg_type==2) {
                     Ipesan +='<img class="pic" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' " width="120px" height="100px"; alt="kpl">' 
                     Ipesan +='<div class="big">';
                     Ipesan +='<center><img class="picbig" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' "height="125" width="215" alt="kpl"></center>';
                     Ipesan +='</div>';
                 
                    };
                Ipesan +='</li>'
                Ipesan +='</div>';
                }   
            });  

                Ipesan +'</div>';

            $("#ship-id2").append(Ipesan);  
              $( ".tranding-pesan" ).scrollTop( 10000000 );      
              
            //end sel change
            });        

            sumberdata = data;

            $("#ship-id2").html('');   
             var Ipesan = '';
                 Ipesan += '<div  class="tranding-pesan">';
            $.each(sumberdata,function(i,item){ 
                
          
                if (item.id_from!='1') {
                Ipesan +='<div class="bubble bubble--alt">';
                Ipesan +='<li>';
                Ipesan +='<div class="dari"><font style="margin-top:0px;">'+item.id_to+'</font><img src="' + conf.url + 'assets/html/img/ye.png" height="14" width="20" ><font>'+item.id_from+' </font>';    
                Ipesan += '<label class="content_timestamp" style="float:right; margin-right:5px;">'+item.created_time + ' '; // +'</label>'; 
                Ipesan += '<div id="isistate' + item.msg_id + '"';
                if (item.state > 1 && item.state < 5)
                Ipesan += ' style="color:red"';
                Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                Ipesan += '</div>';
                //Ipesan += '<hr>';
	                if ( item.msg_type==1) {
	                Ipesan +=' <p style="margin-right:20px;"> '+ item.msg +'</p>';
	           
	                }
	                if (item.msg_type==2) {
	                 Ipesan +='<img class="pic" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' " width="120px" height="100px"; alt="kpl">' 
	                 Ipesan +='<div class="big">';
	                 Ipesan +='<center><img class="picbig" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' "height="125" width="215" alt="kpl"></center>';
	                 Ipesan +='</div>';
	             
	                };
                Ipesan +='</li>'
                Ipesan +='</div>';
                }   
            });  

                Ipesan +'</div>';

            $("#ship-id2").append(Ipesan);  
              $( ".tranding-pesan" ).scrollTop( 10000000 );      
              
               
              
            });
            
        } else if (id[2]!=null) { //pesan selain broadcast
            socket.emit('reqMessagefrom', { ship_id: id });
            socket.once('resMessagefrom', function (data) {

            var data1hr = [];
            var data2hr = [];
            var data3hr = [];
            var data4hr = [];
            var data5hr = [];
            var data6hr = [];
            var data7hr = [];
            var filter='';
            var now = new Date();     
            // console.log("panjang = "+data.length); 
            
            //filtering dan assign data perhari
            for(var i=0; i<data.length; i++){                
                var d = new Date(data[i].created_time);
            
                if (d.getTime() > now.getTime() - 1*24*60*60*1000){ //kalo dari 1 hr yg lalu
                    // console.log("lebih kecil 1");  
                    data1hr.push(data[i]);
                    // console.log(data1hr);  
                } 
                if (d.getTime() > now.getTime() - 2*24*60*60*1000){ //kalo dari 2 hr yg lalu
                    // console.log("lebih kecil 2");  
                    data2hr.push(data[i]);
                    // console.log(data2hr);  
                }
                if (d.getTime() > now.getTime() - 3*24*60*60*1000){ //kalo dari 3 hr yg lalu
                    // console.log("lebih kecil 3");  
                    data3hr.push(data[i]);
                }
                if (d.getTime() > now.getTime() - 4*24*60*60*1000){ //kalo dari 4 hr yg lalu
                    // console.log("lebih kecil 4");  
                    data4hr.push(data[i]);
                    // console.log(data4hr);  
                }
                if (d.getTime() > now.getTime() - 5*24*60*60*1000){ //kalo dari 5 hr yg lalu
                    // console.log("lebih kecil 5");  
                    data5hr.push(data[i]);
                    // console.log(data5hr);  
                }
                if (d.getTime() > now.getTime() - 6*24*60*60*1000){ //kalo dari 6 hr yg lalu
                    // console.log("lebih kecil 6");  
                    data6hr.push(data[i]);
                    // console.log(data6hr);  
                }
                if (d.getTime() > now.getTime() - 7*24*60*60*1000){ //kalo dari 7 hr yg lalu
                    // console.log("lebih kecil 7");  
                    data7hr.push(data[i]);
                    // console.log(data7hr);  
                }                                
            }

            $("#filter").html(''); 
             var filter = '';
                 filter +='<select id="sel" style="color:black"  >';
                 filter +='<option value="99">-</option>';
                 filter +='<option value="1">1hari (24)</option>';
                 filter +='<option value="2">2hari (48)</option>';
                 filter +='<option value="3">3hari (72)</option>';
                 filter +='<option value="4">4hari (96)</option>';
                 filter +='<option value="5">5hari (120)</option>';
                 filter +='<option value="6">6hari (144)</option>';
                 filter +='<option value="7">7hari (168)</option>';
                 filter +='</select> ';
                 filter += 'Jam yang Lalu';
            $("#filter").append(filter);

            var sumberdata = [];
            // console.log($("#sel").val());  
            $("#sel").change(function(){
                console.log($("#sel").val());  
                sumberdata = data;

                if ($("#sel").val() == "1"){
                    sumberdata = data1hr;
                } else if ($("#sel").val() == "2"){
                    sumberdata = data2hr;
                } else if ($("#sel").val() == "3"){
                    sumberdata = data3hr;
                } else if ($("#sel").val() == "4"){
                    sumberdata = data4hr;
                } else if ($("#sel").val() == "5"){
                    sumberdata = data5hr;
                } else if ($("#sel").val() == "6"){
                    sumberdata = data6hr;
                } else if ($("#sel").val() == "7"){
                    sumberdata = data7hr;
                } else if ($("#sel").val() == "99"){
                    sumberdata = data;
                }

                        $("#ship-id2").html('');   
                
                     var Ipesan = '';
                         Ipesan += '<div class="tranding-pesan">';

                    $.each(sumberdata,function(i,item){ 
                        // console.log("huiii",item); 
                        
                        if (item.id_from!='1') {
                            Ipesan +='<div class="bubble">';
                            Ipesan +='<li>';
                            Ipesan +='<div class="dari"><font style="margin-top:5px;"><strong>Dari </strong>:'+item.id_from+'&nbsp;</font>'; 
                            Ipesan += '<label class="content_timestamp" style="float:right; margin-right:130px;">'+item.created_time + ' '; // +'</label>'; 
                            Ipesan += '<div id="isistate' + item.msg_id + '"';
                        if (item.state > 1 && item.state < 5)
                            Ipesan += ' style="color:red"';
                            Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                            Ipesan += '</div>';
                        // Ipesan += '<hr>';
                        if ( item.msg_type==1) {
                             Ipesan +=' <p style="margin-right:20px;"> '+ item.msg +'</p>';
                             }
                         else  if (item.msg_type==2) {
                             Ipesan +='<img class="pic" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' " width="120px" height="100px"; alt="kpl">' 
                             Ipesan +='<div class="big">';
                             Ipesan +='<center><img class="picbig" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' "height="125" width="215" alt="kpl"></center>';
                             Ipesan +='</div>';
                             };
                             Ipesan +='</li>'
                             Ipesan +='</div>';
                                }
                          else if (item.msg_type=='3') {
                            Ipesan +='<div class="bubble">';
                            Ipesan +='<li>';            
                            Ipesan +='<div class="dari"><strong>Dari </strong>:<img src="' + conf.url + 'assets/html/img/bc.png" height="23" width="22" > &nbsp;';
                            Ipesan += '<label class="content_timestamp" style="float:right; margin-right:130px; margin-top:5px;">'+item.created_time + ' '; // +'</label>'; 
                            Ipesan += '<div id="isistate' + item.msg_id + '"';
                            if (item.state > 1 && item.state < 5)
                            Ipesan += ' style="color:red"';
                            Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                            Ipesan += '</div>';
                            // Ipesan += '<hr>';
                            Ipesan +=' <p> '+ item.msg +'</p>';
                            Ipesan +='</li>'
                            Ipesan +='</div>';
                        }else {
                            Ipesan +='<div class="bubble bubble--alt">';
                            Ipesan +='<li>'; 
                            Ipesan +='<div><strong>Ke </strong>:'+item.id_to+'&nbsp;';

                            Ipesan += '<label class="content_timestamp" style="float:right; text-align:left;" >'+item.created_time + ' '; // +'</label>'; 
                            Ipesan += '<div id="isistate' + item.msg_id + '"';
                            if (item.state > 1 && item.state < 5)
                            Ipesan += ' style="color:red"';
                            Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                            Ipesan += '</div>';
                            // Ipesan += '<hr>';
                            Ipesan +=' <p> '+ item.msg +'</p>'; 
                            Ipesan +='</li>';
                            Ipesan +='</div>';
                        };
                        
                        // $("span").removeClass("blt-not");
                        // $("label").removeAttr("style");
                        // $("span").remove();  
                        });  
                            Ipesan +'</div>';
                   

                        $("#ship-id2").append(Ipesan);  
                        $( ".tranding-pesan" ).scrollTop( 10000000 );

            //end sel change
            });        

            sumberdata = data;
            // console.log(sumberdata);  
            // console.log(data);

            $("#ship-id2").html('');   
        
             var Ipesan = '';
                 Ipesan += '<div class="tranding-pesan">';

            $.each(sumberdata,function(i,item){ 
                // console.log("huiii",item); 
                
                if (item.id_from!='1') {
                    Ipesan +='<div class="bubble">';
                    Ipesan +='<li>';
                    Ipesan +='<div class="dari"><font style="margin-top:5px;"><strong>Dari </strong>:'+item.id_from+'&nbsp;</font>'; 
                    Ipesan += '<label class="content_timestamp" style="float:right; margin-right:130px;">'+item.created_time + ' '; // +'</label>'; 
                    Ipesan += '<div id="isistate' + item.msg_id + '"';
                if (item.state > 1 && item.state < 5)
                    Ipesan += ' style="color:red"';
                    Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                    Ipesan += '</div>';
                // Ipesan += '<hr>';
                if ( item.msg_type==1) {
                     Ipesan +=' <p style="margin-right:20px;"> '+ item.msg +'</p>';
                     }
                 else  if (item.msg_type==2) {
                     Ipesan +='<img class="pic" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' " width="120px" height="100px"; alt="kpl">' 
                     Ipesan +='<div class="big">';
                     Ipesan +='<center><img class="picbig" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' "height="125" width="215" alt="kpl"></center>';
                     Ipesan +='</div>';
                     };
                     Ipesan +='</li>'
                     Ipesan +='</div>';
                        }
                  else if (item.msg_type=='3') {
                    Ipesan +='<div class="bubble">';
                    Ipesan +='<li>';            
                    Ipesan +='<div class="dari"><strong>Dari </strong>:<img src="' + conf.url + 'assets/html/img/bc.png" height="23" width="22" > &nbsp;';
                    Ipesan += '<label class="content_timestamp" style="float:right; margin-right:130px; margin-top:5px;">'+item.created_time + ' '; // +'</label>'; 
                    Ipesan += '<div id="isistate' + item.msg_id + '"';
                    if (item.state > 1 && item.state < 5)
                    Ipesan += ' style="color:red"';
                    Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                    Ipesan += '</div>';
                    // Ipesan += '<hr>';
                    Ipesan +=' <p> '+ item.msg +'</p>';
                    Ipesan +='</li>'
                    Ipesan +='</div>';
                }else {
                    Ipesan +='<div class="bubble bubble--alt">';
                    Ipesan +='<li>'; 
                    Ipesan +='<div><strong>Ke </strong>:'+item.id_to+'&nbsp;';

                    Ipesan += '<label class="content_timestamp" style="float:right; text-align:left;" >'+item.created_time + ' '; // +'</label>'; 
                    Ipesan += '<div id="isistate' + item.msg_id + '"';
                    if (item.state > 1 && item.state < 5)
                    Ipesan += ' style="color:red"';
                    Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
                    Ipesan += '</div>';
                    // Ipesan += '<hr>';
                    Ipesan +=' <p> '+ item.msg +'</p>'; 
                    Ipesan +='</li>';
                    Ipesan +='</div>';
                };
                
                });  
                    Ipesan +'</div>';
           

                $("#ship-id2").append(Ipesan);  
                $( ".tranding-pesan" ).scrollTop( 10000000 ); 
               
                return false;

            });

        }

    }
  
}
         

var clear = null;

function showtulis(stat){
    newMessage(function(data) {
    $("#ship-ado2").html('');
    var allShip = [];
    var sentid =[];
    var Kritokri='XX';
    var result = '';
  
    result +='<div class="clear"></div>';
    result +='<div class="content-user">';
        $.each(data,function(i,item){
           allShip.push(item.ship_id);
        if (item.n_unread>0) {
           result += '<ul>';
           result += '<li style="list-style:none" >';
           result += '<div  id="mv\a'+item.ship_id+'\a" onclick="Showfrom(\''+item.ship_id+'\', \''+item.ship_abbr+'\')"  >';
           result += '<input class="magic" type="radio" id="radio(\''+item.ship_id+'\')" name="radios" value="noo">';
           result += '<label class="lb" style="font-weight: bold;" for="radio(\''+item.ship_id+'\')">'+ item.ship_id + ' - '+ item.ship_abbr + '';
           result += '<span id="hu" class="blt-not">'+ item.n_unread +'</span>';
           result += '</label>';
           result += '</div>'; 
           result += '</li>';
           result += '</ul>';     
        }else {
           result += '<ul>';
           result += '<li style="list-style:none" >';
           result += '<div  onclick="Showfrom(\''+item.ship_id+'\', \''+item.ship_abbr+'\')"  >';
           result += '<input class=".wo" type="radio" id="radio(\''+item.ship_id+'\')" name="radios"  >';
           result += '<label  for="radio(\''+item.ship_id+'\')">'+ item.ship_id + ' - '+ item.ship_abbr + '</label>';
           result += '</div>'; 
           result += '</li>';
           result += '</ul>';
           $(".wo").attr("background-image","none");
       };

        });
         //add broadcast
        result += '<ul>';
        result += '<li style="list-style:none" >';
        result += '<div onclick="Showfrom(\''+allShip+'\')" class="pesan-scroll">';
        result +=' <input  type="radio" id="radio1(\''+allShip+'\')" class="rdio" name="radios" >';
        result += ' <label for="radio1(\''+allShip+'\')">Broadcast</label>';
        result += '</div>';
         // result +='<br />';
        result += '</li>';
        result += '</ul>';
          //add KRI to KRI
        result += '<ul>';
        result += '<li style="list-style:none" >';
        result += '<div onclick="Showfrom(\''+Kritokri+'\')" class="pesan-scroll">';
        result +=' <input  type="radio" id="radio1(\''+Kritokri+'\')" name="radios" >';
        result += ' <label for="radio1(\''+Kritokri+'\')">Kri To Kri</label>';
        result += '</div>';
        result += '</li>';
        result += '</ul>';
        result += '</div>';
        result +='<div class="clear"></div>';
        result += '<div id="tranding-pesan2">';
        result += '</div>';
        result +='<div class="content-action">';
        result += ' <form >';
        result +='<div style="float:left"> <textarea  id="isipesanbaru" maxlength="500" placeholder="Tulis Pesan"></textarea>';
        result +='</div>';
        result +='<div  style="float:left" > <div id="btkirim"  class="btn_kirim" style="margin-left:2px;" > Kirim </div> </div>';
        result +='<div id="the-count">';
        result +='<span id="current" >0</span>';
        result +='<span id="maximum">/ 500</span>';
        result +='</div>';
        result += '</form>';        
     
        result +='<div class="clear"></div>'; 
        $("#ship-ado2").append(result); 
        $("#btkirim").click(function () {
           
            // if(ke.length >> 4 ){
            if (ke[5] != null) {
                    var pesan = {
                        "id_to" : null,
                        "msg" : $("#isipesanbaru").val()                        
                    }
                    socket.emit('sendMessageBroadcast', pesan);
                console.log(ke[5]);
                clear = ke;            
                ke = null;
                setTimeout(function() {
                    $("#ship-id2").empty();  
                    Showfrom(clear);
                }, 6000);            
            } else {
                var pesan = {
                    "id_to" : ke,
                    "msg" : $("#isipesanbaru").val()
                }                

                socket.emit('sendMessage', pesan);
                console.log(pesan);
                clear = ke;
                ke = null;

               setTimeout(function() {
                    $("#ship-id2").empty();  
                    Showfrom(clear);
                }, 1000);           
                               
            }   

          

            var n = noty({
                layout:'topCenter',
                text: "Pesan dalam proses pengiriman.", 
                type : "info"
            });  



          
   
            $("#id_to").val("");
            $("#isipesanbaru").val("");  
        });
$('#btkirim').prop('disabled', true);

// Do stuff when there is textarea activity
$('#isipesanbaru').on("propertychange input textInput", function() {
    var charLimit = 500;
    var remaining = charLimit - $(this).val().length;
  // alert("COUNTER " + remaining);
     $('#current').addClass("over-char-limit").text(remaining);
    if (remaining === charLimit) {
       // No characters entered so disable the button
        $('#btkirim').prop('disabled', true);
  
    } else if (remaining < 0) {
        
        // remaining = 0; // Prevents the counter going into negative numbers
       
        $('#btkirim').prop('disabled', true);
    } else {
        $('#btkirim').removeAttr('disabled');
        $('#current').removeClass("over-char-limit").text(remaining);
    }
});


 

  });
 
   
   

 getMessageinbox(function(data){ 
  
        $("#ship-info2").html('');  
          var Ipesan = '';
        $.each(data,function(i,item){   
             Ipesan += '<div class="I-pesan" id="msg'+item.msg_id+'" style="display: none;" >';

             
             Ipesan += '<label >Penerima : '+item.id_from+'</label>';
             Ipesan += '<button onclick="myscan()" style="margin-left:30px;">save</button>'
             Ipesan += '<label class="content_timestamp" style="float:right;">'+item.waktu + ' '; // +'</label>'; 
             Ipesan += '<div id="isistate' + item.msg_id + '"';
            if (item.state > 1 && item.state < 5)
             Ipesan += ' style="color:red"';
             Ipesan += '>' + getIsiStatus(item.state) + '</div></label>';
             // Ipesan += '<hr>';
             if ( item.msg_type==1) {
            Ipesan += '<label >' + item.msg +'</label>';
            } 
            else if (item.msg_type==2) {
            // Ipesan += '<center><img class="picbig" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' "height="125" width="215" alt=""></center>';
             Ipesan +='<img class="pic" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' " width="120px" height="100px"; alt="kpl">' 
             Ipesan +='<div class="big">';
             Ipesan +='<center><img class="picbig" src="' + conf.url + 'assets/img/upload/pengiriman/' + item.id_from + '/' + item.msg + ' "height="125" width="215" alt="kpl"></center>';
             Ipesan +='</div>';
            };
             Ipesan += '</div>';       
        });    
         var result = '<div class="scoll-info" >';
        $.each(data,function(i,item){ 
            result += '<div onclick="Show(\''+item.msg_id+'\')" class="pesan-scroll" >';
            // result += '<hr>';
            result += '<label>  '+item.id_from+'</label>';
            result += '<br>';
            result += '<label class="content_timestamp"> '+item.waktu + ' '; // +'</label>'; 
            result += '<div id="isistate' + item.msg_id + '"';
            if (item.state > 1 && item.state < 5)
            result += ' style="color:red"';
            result += '>' + getIsiStatus(item.state) + '</div></label>'; 
            result += '<input type="hidden" id="state' + item.msg_id + '" value="' + item.state + '">';
            result += '</div>';      
      });
            $("#ship-info2").append(result);       
          $("#ship-info2").append(Ipesan);  
        });
  



getMessageoutbox(function(data){
        $("#ship-personnel2").html(''); 
         var Ipesan = '';
        $.each(data,function(i,item){ 
            
            Ipesan += '<div class="I-pesan" id="msg'+item.msg_id+'" style="display:none;" name="pesan_keluar"><label>Penerima: '+ item.id_to +' <br> <hr> '+ item.msg +'</label></div>';   
        
        });    
        var result = '<div class="scoll-info2">';
           $.each(data,function(i,item){  
            result += '<div onclick="Show(\''+item.msg_id+'\')" class="pesan-scroll">';
           //   result += '<div class="scoll-isi" id="msg'+item.msg_id+'" style="visibility: hidden;" name="pesan_keluar"><label>Pesan : '+item.msg+'</label></div></ul>';
            // result += '<hr>';
            result += '<label> '+item.id_to+'</label>';
            result += '<br>';
            result += '<label class="content_timestamp"> '+item.waktu; //+'</label>';
            result += '<div id="isistate' + item.msg_id + '"';
            if (item.state > 1 && item.state < 5)
                result += ' style="color:red"';
            result += '>' + getIsiStatus(item.state) + '</div></label>'; 
            result += '<input type="hidden" id="state' + item.msg_id + '" value="' + item.state + '">';
            result += '</div>'; 
            });
  
        
        
        $("#ship-personnel2").append(result);
        $("#ship-personnel2").append(Ipesan);
      
    });   
        
    
   $('#side-tengah').fadeIn ('fast');

    
}


function showinbox(stat){
    // newMessage(function(data) {
    //     $("").html('');       
    
    // var result = '';
    
   
    // result += '<label>Penerima : <select id="id_to"></label>';
    //     result += '<option value="" selected>-Pilih Posisi Penerima-</option>';
    //     $.each(data,function(i,item){
    //         result += '<option value="' + item.ship_id + '">' + item.ship_id + ' - ' + item.ship_name + '</option>';
    //     });
    //     result += '</select>';
    //     result += '<br>';
    //     result += '<textarea id="isipesanbaru" class="css-isi-pesan" cols="1" rows="1"></textarea>';
        
    //     result += '<a href="#" class="btnpesan" id="btkirim">Kirim</a>';

    //     result += '<a href="#" class="btnpesan2" id="btkirim">Kirim Semua</a>';
        
    
           
    //     $("#ship-ado2").append(result);   
    //     $("#btkirim").click(function() {
    //         var pesan = {
    //             "id_to" : $("#id_to").val(),
    //             "msg" : $("#isipesanbaru").val()
    //         }
    //         socket.emit('sendMessage', pesan);
    //         var n = noty({
    //             layout:'topCenter',
    //             text: "Pesan dalam proses pengiriman.", 
    //             type : "info"
    //         });
    //         $("#id_to").val("");
    //         $("#isipesanbaru").val("");
    //     });
    // });
     
  
    $('#side-tengah2').fadeIn ('fast');
}
function showoutbox(stat){
    // newMessage(function(data) {
    //     $("#ship-ado2").html('');       
    
    // var result = '';
    
   
    // result += '<label>Penerima : <select id="id_to"></label>';
    //     result += '<option value="" selected>-Pilih Posisi Penerima-</option>';
    //     $.each(data,function(i,item){
    //         result += '<option value="' + item.ship_id + '">' + item.ship_id + ' - ' + item.ship_name + '</option>';
    //     });
    //     result += '</select>';
    //     result += '<br>';
    //     result += '<textarea id="isipesanbaru" class="css-isi-pesan" cols="1" rows="1"></textarea>';
        
    //     result += '<a href="#" class="btnpesan" id="btkirim">Kirim</a>';

    //     result += '<a href="#" class="btnpesan2" id="btkirim">Kirim Semua</a>';
        
    
           
    //     $("#ship-ado2").append(result);   
    //     $("#btkirim").click(function() {
    //         var pesan = {
    //             "id_to" : $("#id_to").val(),
    //             "msg" : $("#isipesanbaru").val()
    //         }
    //         socket.emit('sendMessage', pesan);
    //         var n = noty({
    //             layout:'topCenter',
    //             text: "Pesan dalam proses pengiriman.", 
    //             type : "info"
    //         });
    //         $("#id_to").val("");
    //         $("#isipesanbaru").val("");
    //     });
    // });
     
  
    $('#side-tengah3').fadeIn ('fast'); 

}
function Show(idMsg)
{
    // versi lama
            var idFolder = idMsg;
            var elm = document.getElementById("msg"+idFolder);
            var elmState = document.getElementById("state"+idFolder);
            var state = parseInt(elmState.value);
            //var elmIsiState = document.getElementById("isistate"+idFolder);
            
         elm.style.visibility="visible"; 
         if(elm.style.display == "" ) {
             elm.style.display = "none";
         }
         else {
            elm.style.display = "";
         }
         
         // update state
         console.log('state ' + state);
         if (state == 5)
             socket.emit('changeMsgState', { 'msg_id' : idFolder, 'new_state' : 1 });
          else if (state == 6)
             socket.emit('changeMsgState', { 'msg_id' : idFolder, 'new_state' : 7 });
             
          socket.once('resChangeMsgState', function (data) {
    
          console.log('resChangeMsgState ' + data);
             if (data) {
                console.log('if true');
                
                   if (state == 5)
                       elmState.value = 1;
                    else if (state == 6)
                       elmState.value = 7;
                       
                    if (elmIsiState) {
                    elmIsiState.style = '';
                    elmIsiState.innerHTML = 'sudah dibaca';
                }
             }
         });
}


function messageInbox(argId)
{
    // versi lama
            var idFolder = argId.substr(7);
            Show(idFolder);
            /*
            var elm = document.getElementById("msg"+idFolder);
            var elmState = document.getElementById("state"+idFolder);
            var state = parseInt(elmState.value);
            var elmIsiState = document.getElementById("isistate"+idFolder);
            
         elm.style.visibility="visible"; 
         if(elm.style.display == "" ) {
             elm.style.display = "none";
         }
         else {
            elm.style.display = "";
         }
         
         // update state
         console.log('state ' + state);
         if (state == 5)
             socket.emit('changeMsgState', { 'msg_id' : idFolder, 'new_state' : 1 });
          else if (state == 6)
             socket.emit('changeMsgState', { 'msg_id' : idFolder, 'new_state' : 7 });
             
          socket.once('resChangeMsgState', function (data) {
          console.log('resChangeMsgState ' + data);
             if (data) {
                console.log('if true');
                
                   if (state == 5)
                       elmState.value = 1;
                    else if (state == 6)
                       elmState.value = 7;
                       
                elmIsiState.style = '';
                elmIsiState.innerHTML = 'sudah dibaca';
             }
         });
         */

/* versi SKM17
         var idFolder = argId.substr(7);
         var msg_content;
         var elm = document.getElementById("msgInbox"+idFolder);
            
        
         elm.style.visibility="visible"; 
        if (elm.innerHTML == '') {
            socket.emit('reqMessageContent', { 'msg_id' : idFolder });
            socket.once('resMessageContent', function (data) {
                 msg_content = data[0].msg;
                 elm.innerHTML = '<label>Pesan : ' + msg_content + '</label>';
             });
        }.
        
         if (elm.style.display == "" ) {
             elm.style.display = "none";
         }
         else {
            elm.style.display = "";
            
         }
*/
}

function messageOutbox(argId)
{
         var idFolder = argId.substr(7);
         document.getElementById("msgOutbox"+idFolder).style.visibility="visible"; 
         if(document.getElementById("msgOutbox"+idFolder).style.display == "" ) {
             document.getElementById("msgOutbox"+idFolder).style.display = "none";
         }
         else {
            document.getElementById("msgOutbox"+idFolder).style.display = "";
         }
}
function konsep(argId)
{
         var idFolder = argId.substr(7);
         document.getElementById("konsep"+idFolder).style.visibility="visible"; 
         if(document.getElementById("konsep"+idFolder).style.display == "" ) {
             document.getElementById("konsep"+idFolder).style.display = "none";
         }
         else {
            document.getElementById("konsep"+idFolder).style.display = "";
         }
}

function getIsiStatus (state) {
    var isistatus;
    switch (state) {
        case 1:
            isistatus = 'Terkirim';
            break;
        case 2:
            isistatus = 'Sedang dikirim';
            break;
        case 3:
            isistatus = 'gagal';
            break;
        case 4:
            isistatus = 'belum dibaca';
            break;
        case 5:
            isistatus = 'sudah dibaca';
            break;
        // case :
        //     isistatus = 'belum dibaca';
        //     break;
        // case 6:
        //     isistatus = 'belum dibaca';
        //     break;
        // case 7:
        //     isistatus = 'sudah dibaca';
        //     break;
    }
    return isistatus;
}


