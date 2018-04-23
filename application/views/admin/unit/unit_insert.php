<?php
if ($edit == true) {
    if (isset($unit)) {
?>
<div class="span12 block">          
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>                  
        <h2>unit</h2>
    </div>      <!-- .block_head ends -->       
    <div class="block_content">
        <?php echo $link_back; ?>
                <form action="<?php echo base_url().$current_context.'edit/'.$unit->unit_id; ?>" method="post">
                    <p>
						<label>unit_id</label><br/>
						<input name="unit_id" type="text" value="<?php echo isset($unit->unit_id) ? $unit->unit_id : '' ; ?>">
						<span class="note">This field is required</span>
					</p>
					<p>
						<label>unit_name</label><br/>
						<input name="unit_name" type="text" value="<?php echo isset($unit->unit_name) ? $unit->unit_name : '' ; ?>">
						<span class="note">This field is required</span>
					</p>
					<p>
						<label>unitcat_id</label><br/>
						<input name="unitcat_id" type="text" value="<?php echo isset($unit->unitcat_id) ? $unit->unitcat_id : '' ; ?>">
						<span class="note">This field is required</span>
					</p>
					
                    <p>
                        <input type="submit" class="submit small" value="Save">
                        <input type="reset" class="submit small" value="Cancel">
                    </p>

                </form>                 
    </div>      <!-- .block_content ends -->                
    <div class="bendl"></div>
    <div class="bendr"></div>                   
</div>
<?php
    }
} else {
?>
<div class="span12 block">          
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>                  
        <h2>unit</h2>
    </div>      <!-- .block_head ends -->       
    <div class="block_content">
        <?php echo $link_back; ?>
                <form action="<?php echo base_url().$current_context.'save/'; ?>" method="post">
                    <p>
						<label>unit_id</label><br/>
						<input name="unit_id" type="text" value="">
						<span class="note">This field is required</span>
					</p>
					<p>
						<label>unit_name</label><br/>
						<input name="unit_name" type="text" value="">
						<span class="note">This field is required</span>
					</p>
					<p>
						<label>unitcat_id</label><br/>
						<input name="unitcat_id" type="text" value="">
						<span class="note">This field is required</span>
					</p>
					
                    <p>
                        <input type="submit" class="submit small" value="Save">
                        <input type="reset" class="submit small" value="Cancel">
                    </p>

                </form>                 
    </div>      <!-- .block_content ends -->                
    <div class="bendl"></div>
    <div class="bendr"></div>                   
</div>
<?php
}
echo validation_errors();
?>
        
        