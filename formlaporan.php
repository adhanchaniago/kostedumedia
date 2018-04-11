          <!-- FORM INPUT LAPORAN -->
          <div class="right-panel-heading">
            <a data-toggle="collapse" href="#formlaporan">
              <h3 class="panel-title">
                <button type="button" class="btn btn-xs btn-default pull-right" id="tutupR"><i class="fa fa-chevron-right"></i></button>
                <!-- <button type="button" class="btn btn-xs btn-default pull-right" data-toggle="collapse" data-target="#formlaporan"><i class="fa fa-sort"></i></button> -->
                <i class="fa fa-sort"></i>&nbsp;&nbsp;Form Input Laporan
              </h3>
            </a>
          </div>

          <div class="right-panel-body collapse" id="formlaporan" >
          <form style="font-size:12px;">
            <div class="form-group">
              <div class="row">
                <div class="col-md-2" style="vertical-align: middle;"><i>Judul : </i></div>
                <div class="col-md-10"><input id="formjudul" class="form-control" type="text" placeholder="Judul Laporan"></div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-2" style="vertical-align: middle;"><i>Kategori : </i></div>
                <div class="col-md-7"><select id="formkategori" class="form-group" name="kategori">
                  <option value="rompak">Perompakan (Robbery)</option>
                  <option value="bajak">Pembajakan (Piracy)</option>
                  <option value="teror">Terrorisme</option>
                  <option value="sabotase">Sabotase</option>
                  <option value="curiikan">Pencurian Ikan (Illegal Fishing)</option>
                  <option value="curikayu">Penyelundupan Kayu (Illegal Logging)</option>
                  <option value="curitambang">Penyelundupan Hasil Tambang (Illegal Mining)</option>
                  <option value="curibarang">Penyelundupan Komoditi (Illegal Trading)</option>
                </select></div>
                <div class="col-md-3"><select id="formtingkat" class="form-group">
                  <option value="low">Low</option>
                  <option value="med">Medium</option>
                  <option value="high">High</option>
                </select></div>
              </div>
              <div class="row">
                <div class="col-md-2" style="vertical-align: middle;"><i>Tanggal : </i></div>
                <div class="col-md-10">
                  <!-- <input type="date" placeholder="tanggal"> -->
                  <input id="formtanggal" type="datetime-local" placeholder="jam & tgl">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-2" style="vertical-align: middle;"><i>Lokasi : </i></div>
                <div class="col-md-1" style="vertical-align: middle;"><button style="vertical-align: middle;" id="formselectloc"><i class="fa fa-map-marker"></i></button></div>
                <div class="col-md-3"><input id="formlat" class="form-control" type="text" placeholder="Lat"></div>
                <div class="col-md-3"><input id="formlon" class="form-control" type="text" placeholder="Lon"></div>
                <div class="col-md-3"><input id="formlokasi" class="form-control type="text" placeholder="Ket Lokasi"></div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-2" style="vertical-align: middle;"><i>Penjelasan Laporan : </i></div>
                <div class="col-md-10">
                  <textarea id="formisi" class="form-control" placeholder="Isi laporan"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-2" style="vertical-align: middle;"><i>Foto : </i></div>
                <div class="col-md-5">
                  <input type="file" id="formfotokjadian1">
                </div>
                <div class="col-md-5">
                  <input type="file" id="formfotokjadian2">
                </div>
              </div>
            </div> 

            <i class="fa fa-user"></i>&nbsp;ORANG TERLIBAT :
            <a data-toggle="modal" href="#nambahorang"><i class="fa fa-user-plus pull-right"> &nbsp;ORANG</i></a>
            
            <!-- Modal -->
            <div class="modal fade" id="nambahorang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ORANG TERLIBAT</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group"><div class="row">
                    <div class="col-md-4"><input id="formorgnama" class="form-control" type="text" placeholder="nama org terlibat"></div>
                    <div class="col-md-3"><input id="formorgumur" class="form-control" type="text" placeholder="umur"></div>
                    <div class="col-md-3"><input id="formorgsuku" class="form-control" type="text" placeholder="suku"></div>
                    <div class="col-md-2"><select id="formorgsebagai" class="form-group" name="sebgai">
                      <option value="Pelaku">Pelaku</option>
                      <option value="Kurir">Kurir</option>
                      <option value="Pengedar">Pengedar</option>
                      <option value="Bandar">Bandar</option>
                      <option value="Saksi">Saksi</option>
                    </select></div>
                    </div></div>
                    <div class="form-group"><div class="row">
                      <div class="col-md-3"><input id="formorgagama" class="form-control" type="text" placeholder="agama"></div>
                      <div class="col-md-9"><input id="formorgalamat" class="form-control" type="text" placeholder="alamat"></div>
                    </div></div>
                    FOTO 1 : <div class="form-group"><input id="formorgfoto1" type="file"></br></div>
                    FOTO 2 : <div class="form-group"><input id="formorgfoto2" type="file"></br></div>
                    FOTO 3 : <div class="form-group"><input id="formorgfoto3" type="file"></br></div>
                  </div>
                  <div class="modal-footer">
                    <button id="formorgbersih" type="button" class="btn btn-default" data-dismiss="modal">Reset</button>
                    <button id="formorgkirim" type="button" class="btn btn-primary">Tambah</button>
                  </div>
                </div>
              </div>
            </div>

            <table class="table table-hover table-striped table-condensed" style="font-size:11px;" id="formtabelorg">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Umur</th>
                  <th>Sebagai</th>
                  <th>Suku</th>
                  <th>Agama</th>
                  <th>Alamat</th>
                  <th>Foto</th>
                <tr>
              </thead>
              <tbody class="list">
                <!-- <tr>
                  <td>Gopal</td>
                  <td>17</td>
                  <td>Saksi</td>
                  <td>Sunda</td>
                  <td>Islam</td>
                  <td>Jl kemanaja no1</td>
                  <td><a href><i class="fa fa-file"></i></a></td>
                </tr>
                <tr>
                  <td>Sesdika</td>
                  <td>37</td>
                  <td>Saksi</td>
                  <td>Batak</td>
                  <td>Islam</td>
                  <td>Jl hahaha no1</td>
                  <td><a href><i class="fa fa-file"></i></a></td>
                </tr> -->
              </tbody>
            </table>
            </br>
            <button type="submit" id="formkirim" class="btn btn-success"><i class="fa fa-send-o"></i>&nbsp;&nbsp;Submit</button>
            <button type="reset" id="formbersih" class="btn btn-warning"><i class="fa fa-undo"></i>&nbsp;&nbsp;Reset Form</button>
          </form>                        
          </div> <!-- tutup id formlaporan -->