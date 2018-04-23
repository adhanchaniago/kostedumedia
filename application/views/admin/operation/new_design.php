<script>
    $(document).ready(function(){
        $('.pilih-status').change(function(){
            if($(this).val() == 'sandar'){
                $('.tempat-sandar').slideDown('fast');
            }else{
                $('.tempat-sandar').slideUp('fast');
            }
        });
    });
</script>

<div id="main">
    <p class="tit-form">Posisi KRI</p>
    
    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</td>						
                <td class="header">No Lambung</td>
                <td class="header">Nama</td>
                <td class="header">Jenis</td>
                <td class="header">Komando</td>
                <td class="header">Kodal</td>
                <td class="header">Pembina</td>
                <td class="header">Latitude</td>
                <td class="header">Longitude</td>
                <td class="header">Status</td>
                <td class="header delete" style="width: 52px;">Aksi</td>
            </tr>
        </thead>
        <tbody>
            <tr class="row-one">
                <td>1</td>
                <td>0123456789</td>
                <td>KRI Krait (827)</td>
                <td>Kapal Operasi</td>
                <td>Ateng Alibasyah, MM.</td>
                <td>Laksamana Pertama Marsetio, MM.</td>
                <td>Ir. Soegeng Poerwadi P.S.</td>
                <td>48.89364</td>
                <td>2.33739</td>
                <td>Sandar (Kep. Seribu)</td>
                <td>
                    <a href="#">
                        <div class="tab-edit"></div>
                    </a>
                    <a class="delete" href="#">
                        <div class="tab-delete"></div>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
    
    <br /><br />
    
    <p class="tit-form">Tambah Posisi KRI</p>
    <ul class="form-admin">
        <li>
            <label>Nomor Lambung</label>
            <select name="station_id" class="form-admin pilih-status">
                <option value="" selected="selected">- Pilih Nomor Lambung -</option>
            </select>				
            <div class="clear"></div>
        </li>
        <li>
            <label>Latitude</label>
            <input class="form-admin" type="text" class="text-medium">					
            <div class="clear"></div>
        </li>
        <li>
            <label>Longitude</label>
            <input class="form-admin" type="text" class="text-medium">				
            <div class="clear"></div>
        </li>
        <li>
            <label>Status</label>
            <select name="station_id" class="form-admin pilih-status">
                <option value="" selected="selected">- Pilih Status -</option>
                <option value="sandar">Sandar</option>
                <option value="lego">Lego</option>
                <option value="layar">Layar</option>
            </select>				
            <div class="clear"></div>
        </li>
        <li class="tempat-sandar" style="display: none;">
            <label>Tempat Sandar</label>
            <input class="form-admin" type="text" class="text-medium">				
            <div class="clear"></div>
        </li>
        <li>
            <label>&nbsp;</label>
            <input class="button-form" type="submit" value="Simpan">
            <input class="button-form" type="reset" value="Cancel">
            <div class="clear"></div>
        </li>
    </ul>
</div>