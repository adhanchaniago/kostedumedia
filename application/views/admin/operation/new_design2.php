<div id="main">
    <p class="tit-form">Rencana</p>
    
    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</td>
                <td class="header">Nama</td>
                <td class="header">Jenis</td>
                <td class="header">Komando</td>
                <td class="header">Kodal</td>
                <td class="header">Pembina</td>
                <td class="header">Tanggal Mulai</td>
                <td class="header">Tanggal Selesai</td>
                <td class="header">Status</td>
                <td class="header">Keterangan</td>
                <td class="header delete" style="width: 52px;">Aksi</td>
            </tr>
        </thead>
        <tbody>
            <tr class="row-one" style="cursor: pointer;">
                <td>1</td>
                <td><a href="#" class="open-tab2">Nama Operasinya</a></td>
                <td>Kapal Operasi</td>
                <td>Laksamana Pertama Marsetio, MM.</td>
                <td>Ir. Soegeng Poerwadi P.S.</td>
                <td>Ateng Alibasyah, MM.</td>
                <td>12/03/2014</td>
                <td>18/03/2014</td>
                <td>Belum Berlangsung</td>
                <td>Tugas patroli keamanan laut kapal ini juga bisa digunakan sebagai kapal SAR</td>
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
    
    <div class="komponen" style="display: none;">
    <p class="tit-form">Komponen Nama Operasinya</p>
    
    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</td>						
                <td class="header" style="width: 150px;">Jenis Unsur</td>
                <td class="header" style="width: 150px;">Nomor</td>
                <td class="header">Nama</td>
            </tr>
        </thead>
        <tbody>
            <tr class="row-one">
                <td>1</td>
                <td>KRI Krait (827)</td>
                <td>Kapal Operasi</td>
                <td>Tugas patroli keamanan laut kapal ini juga bisa digunakan sebagai kapal SAR</td>
            </tr>
        </tbody>
    </table>
    
    <br /><br />
    </div>
    
    <p class="tit-form">Tambah Rencana</p>
    <ul class="form-admin">
        <li>
            <label>Nama</label>
            <input class="form-admin" type="text" class="text-medium">			
            <div class="clear"></div>
        </li>
        <li>
            <label style="height: 120px;">Jenis</label>
            <select name="station_id" class="form-admin pilih-status">
                <option value="" selected="selected">- Pilih Jenis 1 -</option>
            </select><br /><br /><br />
            <select name="station_id" class="form-admin pilih-status">
                <option value="" selected="selected">- Pilih Jenis 2 -</option>
            </select><br /><br /><br />
            <select name="station_id" class="form-admin pilih-status">
                <option value="" selected="selected">- Pilih Jenis 3 -</option>
            </select><br /><br /><br />
            <select name="station_id" class="form-admin pilih-status">
                <option value="" selected="selected">- Pilih Jenis 4 -</option>
            </select>	
            <div class="clear"></div>
        </li>
        <li>
            <label>Komando</label>
            <select name="station_id" class="form-admin pilih-status">
                <option value="" selected="selected">- Pilih Komando -</option>
            </select>		
            <div class="clear"></div>
        </li>
        <li>
            <label>Kodal</label>
            <select name="station_id" class="form-admin pilih-status">
                <option value="" selected="selected">- Pilih Kodal -</option>
            </select>			
            <div class="clear"></div>
        </li>
        <li>
            <label>Pembina</label>
            <select name="station_id" class="form-admin pilih-status">
                <option value="" selected="selected">- Pilih Pembina -</option>
            </select>			
            <div class="clear"></div>
        </li>
        <li>
            <label>Tanggal Mulai</label>
            <input class="form-admin" type="text" class="text-medium">			
            <div class="clear"></div>
        </li>
        <li>
            <label>Tanggal Selesai</label>
            <input class="form-admin" type="text" class="text-medium">			
            <div class="clear"></div>
        </li>
        <li>
            <label>Status</label>
            <select name="station_id" class="form-admin pilih-status">
                <option value="" selected="selected">- Pilih Status -</option>
            </select>			
            <div class="clear"></div>
        </li>
        <li>
            <label>Keterangan</label>
            <textarea rows="1" cols="1" class="form-admin"></textarea>			
            <div class="clear"></div>
        </li>
        <li>
            <br />
            <p class="sub-tit-form">Komponen Operasi KRI</p>
        </li>
        <li>
            <div class="form-admin-check" style="margin: 0 0 0 30px;">
                <label><input type="checkbox"> KRI 1</label>
                <label><input type="checkbox"> KRI 2</label>
                <label><input type="checkbox"> KRI 3</label>
                <label><input type="checkbox"> KRI 1</label>
                <label><input type="checkbox"> KRI 2</label>
                <label><input type="checkbox"> KRI 3</label>
                <label><input type="checkbox"> KRI 1</label>
                <label><input type="checkbox"> KRI 2</label>
                <label><input type="checkbox"> KRI 3</label>
                <label><input type="checkbox"> KRI 1</label>
                <label><input type="checkbox"> KRI 2</label>
                <label><input type="checkbox"> KRI 3</label>
            </div>		
            <div class="clear"></div>
        </li>
        <li>
            <br />
            <p class="sub-tit-form">Komponen Operasi Pesud</p>
        </li>
        <li>
            <div class="form-admin-check" style="margin: 0 0 0 30px;">
                <label><input type="checkbox"> Pesud 1</label>
                <label><input type="checkbox"> Pesud 2</label>
                <label><input type="checkbox"> Pesud 3</label>
                <label><input type="checkbox"> Pesud 1</label>
                <label><input type="checkbox"> Pesud 2</label>
                <label><input type="checkbox"> Pesud 3</label>
                <label><input type="checkbox"> Pesud 1</label>
                <label><input type="checkbox"> Pesud 2</label>
                <label><input type="checkbox"> Pesud 3</label>
                <label><input type="checkbox"> Pesud 1</label>
                <label><input type="checkbox"> Pesud 2</label>
                <label><input type="checkbox"> Pesud 3</label>
            </div>		
            <div class="clear"></div>
        </li>
        <li>
            <br />
            <p class="sub-tit-form">Komponen Operasi Marinir</p>
        </li>
        <li>
            <div class="form-admin-check" style="margin: 0 0 0 30px;">
                <label><input type="checkbox"> Marinir 1</label>
                <label><input type="checkbox"> Marinir 2</label>
                <label><input type="checkbox"> Marinir 3</label>
                <label><input type="checkbox"> Marinir 1</label>
                <label><input type="checkbox"> Marinir 2</label>
                <label><input type="checkbox"> Marinir 3</label>
                <label><input type="checkbox"> Marinir 1</label>
                <label><input type="checkbox"> Marinir 2</label>
                <label><input type="checkbox"> Marinir 3</label>
                <label><input type="checkbox"> Marinir 1</label>
                <label><input type="checkbox"> Marinir 2</label>
                <label><input type="checkbox"> Marinir 3</label>
            </div>		
            <div class="clear"></div>
        </li>
        <li>
            <br />
            <p class="sub-tit-form">Komponen Operasi Pangkalan</p>
        </li>
        <li>
            <div class="form-admin-check" style="margin: 0 0 0 30px;">
                <label><input type="checkbox"> Pangkalan 1</label>
                <label><input type="checkbox"> Pangkalan 2</label>
                <label><input type="checkbox"> Pangkalan 3</label>
                <label><input type="checkbox"> Pangkalan 1</label>
                <label><input type="checkbox"> Pangkalan 2</label>
                <label><input type="checkbox"> Pangkalan 3</label>
                <label><input type="checkbox"> Pangkalan 1</label>
                <label><input type="checkbox"> Pangkalan 2</label>
                <label><input type="checkbox"> Pangkalan 3</label>
                <label><input type="checkbox"> Pangkalan 1</label>
                <label><input type="checkbox"> Pangkalan 2</label>
                <label><input type="checkbox"> Pangkalan 3</label>
            </div>		
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

<script>
    $('a.open-tab2').click(function(event){
        event.preventDefault();
        $('.komponen').slideDown();
    });
</script>