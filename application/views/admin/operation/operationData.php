<?php
/**
 * @author Wira Sakti G
 * @added Aug 27, 2013
 */
?>
<script>
    $(document).ready(function(){
        var baseUrl = '<?php echo base_url() ?>';
        var htmlHeight = $('html').height();
        
        $('.list-data').delegate('a:not(#add-all, #remove-all)', 'click', function(e){
            e.preventDefault();
                    
            var banyakA = $(this).parent().find('a').length;
            var isiHtml = $(this).find('span').text();
            var idSide = $(this).parent().parent().attr('id');
            var valElement = $(this).find('span').attr('id');
                    
            $(this).slideUp('fast', function(){
                $(this).remove();
                        
                if(idSide == 'lefting'){
                    if($('.list-data#righting p.datkos').is(':visible')){
                        $('.list-data#righting p.datkos').slideUp('fast', function(){
                            $('p#first-righting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/cancel.png" /><span id="'+valElement+'">' + isiHtml + '</span><input type="hidden" name="new_element[]" value="'+valElement+'"/></a>');
                        });
                    }else{
                        $('p#first-righting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/cancel.png" /><span id="'+valElement+'">' + isiHtml + '</span><input type="hidden" name="new_element[]" value="'+valElement+'"/></a>');
                    }
                            
                    if($('a#remove-all').not(':visible')){
                        $('a#remove-all').fadeIn('fast');
                    }
                }else{
                    if($('.list-data#lefting p.datkos').is(':visible')){
                        $('.list-data#lefting p.datkos').slideUp('fast', function(){
                            $('p#first-lefting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/arrow-right.png" /><span id="'+valElement+'">' + isiHtml + '</span></a>');
                        });
                    }else{
                        $('p#first-lefting').parent().find('.scrolling').prepend('<a href="#"><img src="' + baseUrl + 'assets/html/img/back-end/arrow-right.png" /><span id="'+valElement+'">' + isiHtml + '</span></a>');
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
        
        //submit form
        $(function() {  
            $("#input_unsur").click(function() {  
                // validate and process form here
                var elementName = $('#elementName').val();
                var operationId = $('#operationId').val();
                var arrElement = new Array();
                
                $('input[name="new_element[]"]').each(function (){
                    arrElement.push($(this).val());
                });
                var dataString = {operationId: operationId, elementName: elementName,newElement:arrElement};  
                //alert (dataString);return false;  
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo base_url() ?>admin/operation_ctrl/OpsElement",  
                    data: dataString,  
                    success: function() {  
                        parent.close_page();
                    }  
                });  
                return false;  
            });  
        });  
    });
</script>
<div id="spotting-content">
    <div id="title-pop">
        <ul>
            <li><p>Armada Operasi (KRI)</p></li>
            <li><label>Nama Operasi</label>: <?php if (!empty($obj)) echo $obj->operation_name; ?></li>
            <li><label>Waktu</label>: <?php if (!empty($obj)) echo $obj->operation_start; ?> s/d <?php if (!empty($obj)) echo $obj->operation_end; ?></li>
        </ul>
    </div>
    <form action="" name="elementForm">
        <div class="list-data" id="lefting">
            <p style="border-bottom: 1px solid #DDD;" id="first-lefting"><a href="#" id="add-all">Masukan Semua</a> <?php echo $element[1] ?> yang tersedia</p>
            <!--<input type="text" placeholder="Masukan Kata Kunci" class="search-list" />-->
            <div class="scrolling">
                <?php foreach ($element_list as $el) { ?>
                    <a href="#">
                        <img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span id="<?php echo $el->id ?>"><?php echo $el->name ?></span>
                    </a>
                <?php } ?>
            </div>
            <p class="datkos" style="display: none;">Tidak ada data</p>
            <p><?php echo $element[1] ?> yang tersedia</p>
        </div>
        <div class="list-data" id="righting">
            <p style="border-bottom: 1px solid #DDD;" id="first-righting"><a href="#" id="remove-all" style="margin-left: 252px;">Hapus Semua</a>List armada yang sudah masuk</p>
            <!--<input type="text" placeholder="Masukan Kata Kunci" class="search-list" />-->
            <div class="scrolling">
                <?php foreach ($element_ops as $ops) { ?>
                    <a href="#">
                        <img src="<?php echo base_url() ?>assets/html/img/back-end/cancel.png" /><span id="<?php echo $ops->id ?>"><?php echo $ops->name ?></span>
                        <input type="hidden" name="new_element[]" value="<?php echo $ops->id ?>"/>
                    </a>
                <?php } ?>
            </div>
            <p class="datkos" style="display: none;">Tidak ada data</p>
            <p>List armada yang sudah masuk</p>
        </div>
        <input type="hidden" id="elementName" value="<?php echo $element[0] ?>"/>
        <input type="hidden" id="operationId" value="<?php echo $obj->operation_id ?>"/>

        <div class="clear"></div>
        <ul class="form-admin">
            <li>
                <input type="submit" value="<?php if (empty($obj)) echo 'Save'; else echo 'Edit'; ?> " class="button-form" id="input_unsur">
            </li>
        </ul>
    </form>
</div>
</div>