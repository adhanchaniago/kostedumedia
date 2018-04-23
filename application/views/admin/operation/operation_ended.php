<script>
    function operationDetail(operation_id) {
        $.get('<?php echo base_url() ?>admin/operation_ctrl/operation_detail_occur/' + operation_id + '', function(data) {
            $('#detail-operation').html(data);
            $('#detail-operation').fadeIn(800);
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('.filter_param').keypress(function(event) {
            if (event.keyCode == '13') { //jquery normalizes the keycode 
                event.preventDefault(); //avoids default action
                $(this).parent().find('input[type=submit]').trigger('click');
                // or $(this).closest('form').submit();
            }
        });

    });
</script>
<div id="main">
    <p class="tit-form">Operasi yang Sudah Selesai
        <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" />
        </a>
    </p>
    <div class="filtering" style="display: none;">
        <form action="<?php echo base_url() . 'admin/ship_ctrl/position' ?>" method="post" id="form_search_filter" >
            <ul class="filter-form">
                <li>
                    <label>Tanggal Dislokasi Unsur KRI</label><br/>
                    <input type="text" class="filter_param" name="ship_timestamp_date" id='ship_timestamp_date' readonly value="<?php echo $this->input->get('ship_timestamp_date') ?>"/>
                </li>
            </ul>

            <div class="clear"></div>
            <div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>

            <input type="submit" value="Cari" name="search_filter" onclick="create_url();" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
            <input type="button" value="Bersihkan Pencarian" onclick="document.location = '<?php echo base_url() . 'admin/ship_ctrl/position' ?>';" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />

            <div class="clear"></div>
            <div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
        </form>
    </div>
    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</td>
                <td class="header">Nama</td>
                <td class="header">Jenis</td>
                <td class="header">Tanggal Mulai</td>
                <td class="header">Tanggal Selesai</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($operation as $ops) {
                ?>
                <tr class="<?php echo alternator("row-one", "row-two"); ?>">
                    <td><?php echo $i++; ?></td>
                    <td><a href="javascript:operationDetail('<?php echo $ops->operation_id ?>');" > <?php echo $ops->operation_name ?></a></td>
                    <td><?php echo $ops->jenis_ops ?></td>
                    <td><?php echo $ops->operation_start ?></td>
                    <td><?php echo $ops->operation_end ?></td>
                <?php } ?>
            </tr>
        </tbody>
    </table>

    <br /><br />

    <div id="detail-operation">

    </div>
</div>
