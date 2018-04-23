<!DOCTYPE html>
<html>
    <head>
        <title>Puskodal Side Menu</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/html/css/reset.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/html/css/back-end.puskodal.css" />
        
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript">
            var baseUrl = '<?php echo base_url() ?>';
        </script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/back-end.puskodal.js"></script>
    </head>
    <body>
        <img src="<?php echo base_url() ?>assets/html/img/loading.gif" id="loading" style="display: none;" />
        <div id="spotting-holder" style="display: none;">
            <div id="spotting-content">
                <div id="title-pop">
                    <ul>
                        <li><p>Armada Operasi (KRI)</p></li>
                        <li><label>Nama Operasi</label>: Ambalat Sakti</li>
                        <li><label>Waktu</label>: X Juni 2013 s/d Y April 2014</li>
                    </ul>
                </div>
                
                <div class="list-data" id="lefting">
                    <p style="border-bottom: 1px solid #DDD;" id="first-lefting"><a href="#" id="add-all">Masukan Semua</a> KRI yang tersedia</p>
                    <input type="text" placeholder="Masukan Kata Kunci" class="search-list" />
                    <div class="scrolling">
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 1</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 2</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 3</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 4</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 5</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 6</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 7</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 8</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 9</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 10</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 11</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 12</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 13</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 14</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 15</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 16</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 17</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 18</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 19</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 20</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 21</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 22</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 23</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 24</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 25</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 26</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/arrow-right.png" /><span>KRI 27</span></a>
                    </div>
                    <p class="datkos" style="display: none;">Tidak ada data</p>
                    <p>KRI yang tersedia</p>
                </div>
                <div class="list-data" id="righting">
                    <p style="border-bottom: 1px solid #DDD;" id="first-righting"><a href="#" id="remove-all" style="margin-left: 245px;">Hapus Semua</a>List armada yang sudah masuk</p>
                    <input type="text" placeholder="Masukan Kata Kunci" class="search-list" />
                    <div class="scrolling">
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/cancel.png" /><span>KRI 28</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/cancel.png" /><span>KRI 29</span></a>
                        <a href="#"><img src="<?php echo base_url() ?>assets/html/img/back-end/cancel.png" /><span>KRI 30</span></a>
                    </div>
                    <p class="datkos" style="display: none;">Tidak ada data</p>
                    <p>List armada yang sudah masuk</p>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div id="backlight" style="display: none;"></div>
        <div id="container">
            <ul id="side-menu">
                <li id="logo"><img src="<?php echo base_url() ?>assets/html/img/logo-new-liting.png" /></li>
                <li><a href="#" class="current"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Kesatuan</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Operasi</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Personel</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Kapal</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Pangkalan</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Skuadron</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />PESUD</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Kapal Selam</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />RANPUR</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Marinir</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Corps</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Pilots</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Skuadron</a></li>
                <li><a href="#"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" />Pilot</a></li>
                <li class="category">Reference</li>
                <li class="sub-category"><a href="#"><span>Pengguna</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a></li>
                <li class="Pengguna" style="display: none;"><a href="#">Pengguna</a></li>
                <li class="Pengguna" style="display: none;"><a href="#">Role Pengguna</a></li>
                <li class="Pengguna" style="display: none;"><a href="#">Role</a></li>
                <li class="sub-category"><a href="#"><span>Kapal</span> <img src="<?php echo base_url() ?>assets/html/img/arrow-down.png" /></a></li>
                <li class="Kapal" style="display: none;"><a href="#">Logistik Kapal</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Akses Kapal</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Operasi Kapal</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Personel</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Status Kapal</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Ship Logistic</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Ship Viewable</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Ship Operation</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Ship Type</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Ship Status</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Status Operasi</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Akses Operasi</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Tipe Pangkalan</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Logistik Pangkalan</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Tipe Personel</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Tipe Kapal</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Pangkat Pilot</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Tipe Pesawat</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Logistik Pesawat</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Logistik Marinir</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Operation Status</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Operation View Ability</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Station Type</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Station Logistic</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Personnel Type</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Pilot Grade</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Aeroplane Type</a></li>
                <li class="Kapal" style="display: none;"><a href="#">Item Logistik</a></li>
            </ul>
            <div id="content">
                <div id="title-up">
                    Kesatuan <a href="#" class="red">Log Out</a> <a href="#" class="blue">Maps</a>
                </div>
                
                <div class="clear"></div>
                <br />
                
                <p class="notif attention"><strong>Attention notification</strong>. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
                <p class="notif information"><strong>Information notofication</strong>. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
                <p class="notif success"><strong>Success notification</strong>. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
                <p class="notif error"><strong>Error notification</strong>. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
                
                <div class="clear"></div>
                <br />
                
                <p class="tit-form">
                    Table Bro! <a href="#" id="filtering-form">Table Filter <img src="<?php echo base_url() ?>assets/html/img/arrow-down-black.png" /></a>
                </p>
                
                <div class="filtering" style="display: none;">
                    <ul class="filter-form">
                        <li>
                            <label>Input Text</label><br />
                            <input type="text" placeholder="Text Input" />
                        </li>
                        <li>
                            <label>Select</label><br />
                            <select>
                                <option>Select Your select</option>
                            </select>
                        </li>
                        <li>
                            <label>Input Text</label><br />
                            <input type="text" placeholder="Text Input" />
                        </li>
                        <li>
                            <label>Select</label><br />
                            <select>
                                <option>Select Your select</option>
                            </select>
                        </li>
                        <li>
                            <label>Select</label><br />
                            <select>
                                <option>Select Your select</option>
                            </select>
                        </li>
                        <li>
                            <label>Input Text</label><br />
                            <input type="text" placeholder="Text Input" />
                        </li>
                        <li>
                            <label>Select</label><br />
                            <select>
                                <option>Select Your select</option>
                            </select>
                        </li>
                        <li>
                            <label>Input Text</label><br />
                            <input type="text" placeholder="Text Input" />
                        </li>
                    </ul>

                    <div class="clear"></div>
                    <div style="border-bottom: 1px dotted #DDD; margin: 15px 0 17px 0;"></div>
                    
                    <input type="submit" value="Filter" class="button-form" style="float: right; margin-right: 15px; border: 1px solid #CCC;" />
                    
                    <div class="clear"></div>
                    <div style="border-bottom: 1px solid #DDD; margin: 15px 0 0 0;"></div>
                </div>
                
                <table class="tab-admin">
                    <tr class="tittab">
                        <td style="width: 20px;">No.</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td style="width: 52px;">Action</td>
                    </tr>
                    <tr class="row-one">
                        <td>1</td>
                        <td>Abcdefghij</td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</td>
                        <td><a href="#" class="edit"><div class="tab-edit"></div></a> <a href="#"><div class="tab-delete"></div></a></td>
                    </tr>
                    <tr class="row-two">
                        <td>2</td>
                        <td>Klmnopqrstu</td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</td>
                        <td><a href="#" class="edit"><div class="tab-edit"></div></a> <a href="#"><div class="tab-delete"></div></a></td>
                    </tr>
                    <tr class="row-one">
                        <td>4</td>
                        <td>Abcdefghij</td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</td>
                        <td><a href="#" class="edit"><div class="tab-edit"></div></a> <a href="#"><div class="tab-delete"></div></a></td>
                    </tr>
                    <tr class="row-two">
                        <td>5</td>
                        <td>Klmnopqrstu</td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</td>
                        <td><a href="#" class="edit"><div class="tab-edit"></div></a> <a href="#"><div class="tab-delete"></div></a></td>
                    </tr>
                </table>
                
                <p class="sub-tit-form">Table Notes</p>
                <p style="margin: 0 20px 10px 20px;">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
                
                <div class="clear"></div>
                <br />
                
                <p class="tit-form">Input Bro!</p>
                
                <ul class="form-admin">
                    <li>
                        <p class="sub-tit-form">InputText, PasswordInput, TextArea and Select</p>
                    </li>
                    <li>
                        <label>Text Input</label>
                        <input type="text" placeholder="Text Input" class="form-admin" />
                        <p class="notif-input error"><span>&lt;</span><strong>Error notification</strong></p>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <label>Text Input Disable</label>
                        <input type="text" value="This input is disable" placeholder="Text Input" class="form-admin" disabled="disabled" />
                        <p class="notif-input attention"><span>&lt;</span><strong>Attention notification</strong></p>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <label>Password Input</label>
                        <input type="password" placeholder="Password Input" class="form-admin" />
                        <p class="notif-input success"><span>&lt;</span><strong>Success notification</strong></p>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <label>Textarea</label>
                        <textarea class="form-admin" placeholder="Textarea"></textarea>
                        <p class="notif-input attention"><span>&lt;</span><strong>Attention notification</strong></p>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <label>Select</label>
                        <select class="form-admin">
                            <option>Select your select</option>
                        </select>
                        <p class="notif-input information"><span>&lt;</span><strong>Information notification</strong></p>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <p class="sub-tit-form">RadioButton and CheckBox</p>
                    </li>
                    <li>
                        <label>Radio</label>
                        <div class="form-admin-radio">
                            <label><input type="radio" name="radio" /> Radio 1</label>
                            <div class="clear"></div>
                            <label><input type="radio" name="radio" /> Radio 2</label>
                            <div class="clear"></div>
                            <label><input type="radio" name="radio" /> Radio 3</label>
                        </div>
                        <p class="notif-input information"><span>&lt;</span><strong>Information notification</strong></p>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <label>Checkbox</label>
                        <div class="form-admin-check">
                            <label><input type="checkbox" /> Checkbox 1</label>
                            <div class="clear"></div>
                            <label><input type="checkbox" /> Checkbox 2</label>
                            <div class="clear"></div>
                            <label><input type="checkbox" /> Checkbox 3</label>
                        </div>
                        <p class="notif-input attention"><span>&lt;</span><strong>Attention notification</strong></p>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <label>&nbsp;</label>
                        <input type="submit" value="Add" class="button-form blue" />
                        <input type="submit" value="Reset" class="button-form green" />
                        <input type="submit" value="Cancel" class="button-form red" />
                        <div class="clear"></div>
                    </li>
                </ul>
                
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            
            <p id="copyrights">Copyrights &copy; 2015 Pusat Komando dan Pengendalian Tentara Nasional Indonesia Angkatan Laut. Semua Hak Cipta Dilindungi.</p>
        </div>
    </body>
</html>