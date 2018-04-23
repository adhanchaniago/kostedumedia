<div class="span12 block">          
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>                  
        <h2>unit</h2>
    </div>      <!-- .block_head ends -->       
    <div class="block_content">
        <?php echo $link_back; ?>
                    <p>
						<label>unit_id</label><br/>
						<?php echo $unit->unit_id;?></p>
					<p>
						<label>unit_name</label><br/>
						<?php echo $unit->unit_name;?></p>
					<p>
						<label>unitcat_id</label><br/>
						<?php echo $unit->unitcat_id;?></p>
					   
                    <?php echo anchor($current_context.'edit/'.$unit->unit_id,'edit',array('class'=>'edit')); ?>            
    </div>      <!-- .block_content ends -->                
    <div class="bendl"></div>
    <div class="bendr"></div>                   
</div>