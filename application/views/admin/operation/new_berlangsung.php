<div id="main">
    <p class="tit-form">Operasi yang Sedang Berlangsung</p>
    
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
    <p class="tit-form">Keterangan Operasi</p>
    <div class="keterangan-ops">
        <ul>
            <li><strong>Operasi X</strong></li>
            <li><label>Jenis Operasi</label>: BlaBlaBla</li>
            <li><label>Komando</label>: BlaBlaBla</li>
            <li><label>Kodal</label>: BlaBlaBla</li>
            <li><label>Pembina</label>: BlaBlaBla</li>
        </ul>
    </div>
    
    <br /><br />
    
    <p class="tit-form">Komponen Nama Operasinya</p>
    
    <table class="tab-admin">
        <thead>
            <tr class="tittab">
                <td class="header" style="width: 30px;">No</td>						
                <td class="header" style="width: 150px;">Jenis Unsur</td>
                <td class="header" style="width: 150px;">Nomor</td>
                <td class="header">Nama</td>
                <td class="header">Lintang</td>
                <td class="header">Bujur</td>
                <td class="header">Status</td>
            </tr>
        </thead>
        <tbody>
            <tr class="row-one">
                <td>1</td>
                <td>KRI Krait (827)</td>
                <td>Kapal Operasi</td>
                <td>Tugas patroli keamanan laut kapal ini juga bisa digunakan sebagai kapal SAR</td>
                <td><input /></td>
                <td><input /></td>
                <td>
                    <select>
                        <option>- Pilih Status -</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    
    <br /><br />
    </div>
</div>

<script>
    $('a.open-tab2').click(function(event){
        event.preventDefault();
        $('.komponen').slideDown();
    });
</script>