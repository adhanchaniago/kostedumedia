<!DOCTYPE html>
<html>
    <head>
        <title>Puskodal Side Menu</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/html/css/style-new.css" />
        
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/html/js/jquery-puskodal.js"></script>
    </head>
    <body>
        <div class="video-streaming" style="display: none;">
            <p class="titlelan">
                Video Streaming <a href="#" class="closing"><img src="<?php echo base_url() ?>assets/html/img/close.png" /></a>
            </p>
<!--            <a id="close-video">
                <img src="<?php echo base_url() ?>assets/html/img/close.png" />
            </a>-->
            <div class="the-video"></div>
        </div>
        <div class="chat" style="display: none;">
            <p class="titlelan">
                Chatting <a href="#" class="closing"><img src="<?php echo base_url() ?>assets/html/img/close.png" /></a>
            </p>
            <div class="title-user">
                User
            </div>
            <div class="title-chat">
                Chat with Yos Sudarso-12
            </div>
            <div class="clear"></div>
            <div class="content-user">
                <ul>
                    <li>
                        <a href="#" class="onchat">Yos Sudarso-12</a>
                    </li>
                    <li>
                        <a href="#">Yos Sudarso-13</a>
                    </li>
                    <li>
                        <a href="#">Yos Sudarso-14</a>
                    </li>
                    <li>
                        <a href="#">Yos Sudarso-123</a>
                    </li>
                    <li>
                        <a href="#">Yos Sudarso-34</a>
                    </li>
                    <li>
                        <a href="#">Yos Sudarso-65</a>
                    </li>
                    <li>
                        <a href="#">Yos Sudarso-45</a>
                    </li>
                    <li>
                        <a href="#">Yos Sudarso-23</a>
                    </li>
                    <li>
                        <a href="#">Yos Sudarso-56</a>
                    </li>
                </ul>
            </div>
            <div class="content-chat">
                <ul>
                    <li class="from-you">
                        <span>You | 13:23:02 - 3 September 2013</span><br />
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                    </li>
                    <li class="from-other">
                        <span>Yos Sudarso-12 | 13:23:45 - 3 September 2013</span><br />
                        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.
                    </li>
                    <li class="from-you">
                        <span>You | 13:23:02 - 3 September 2013</span><br />
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                    </li>
                    <li class="from-other">
                        <span>Yos Sudarso-12 | 13:23:45 - 3 September 2013</span><br />
                        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.
                    </li>
                    <li class="from-you">
                        <span>You | 13:23:02 - 3 September 2013</span><br />
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                    </li>
                    <li class="from-other">
                        <span>Yos Sudarso-12 | 13:23:45 - 3 September 2013</span><br />
                        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.
                    </li>
                    <li class="from-you">
                        <span>You | 13:23:02 - 3 September 2013</span><br />
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                    </li>
                    <li class="from-other">
                        <span>Yos Sudarso-12 | 13:23:45 - 3 September 2013</span><br />
                        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="content-action">
                <textarea></textarea>
                <input type="submit" value="Send" />
            </div>
            <div class="clear"></div>
        </div>
        <div class="popup" style="display: none;">
            <p class="titlelan">
                Form Prototype <a href="#" class="closing"><img src="<?php echo base_url() ?>assets/html/img/close.png" /></a>
            </p>
            <div class="content">
                <ul class="form-pop">
                    <li>
                        <label>Judul</label><br />
                        <input type="text" />
                    </li>
                    <li class="field-set">
                        Titik 1
                    </li>
                    <li>
                        <label>Latitude</label><br />
                        <input type="text" class="lite" /><label>°</label>
                        <input type="text" class="lite" /><label>'</label>
                        <input type="text" class="lite" /><label>"</label>
                        <select class="lite">
                            <option>U</option>
                            <option>S</option>
                        </select>
                    </li>
                    <li>
                        <label>Longitude</label><br />
                        <input type="text" class="lite" /><label>°</label>
                        <input type="text" class="lite" /><label>'</label>
                        <input type="text" class="lite" /><label>"</label>
                        <select class="lite">
                            <option>B</option>
                            <option>T</option>
                        </select>
                    </li>
                    <li class="field-set">
                        Titik 2
                    </li>
                    <li>
                        <label>Latitude</label><br />
                        <input type="text" class="lite" /><label>°</label>
                        <input type="text" class="lite" /><label>'</label>
                        <input type="text" class="lite" /><label>"</label>
                        <select class="lite">
                            <option>U</option>
                            <option>S</option>
                        </select>
                    </li>
                    <li>
                        <label>Longitude</label><br />
                        <input type="text" class="lite" /><label>°</label>
                        <input type="text" class="lite" /><label>'</label>
                        <input type="text" class="lite" /><label>"</label>
                        <select class="lite">
                            <option>B</option>
                            <option>T</option>
                        </select>
                    </li>
                    <li>
                        <label>Tipe Pelanggaran</label><br />
                        <select>
                            <option>-</option>
                            <option>-</option>
                        </select>
                    </li>
                    <li>
                        <label>Tipe Laporan</label><br />
                        <select>
                            <option>-</option>
                            <option>-</option>
                        </select>
                    </li>
                    <li>
                        <label>Detail</label><br />
                        <textarea></textarea>
                    </li>
                    <li>
                        <input type="submit" value="Simpan" class="submiting" />
                        <input type="submit" value="Batal"  class="submiting" />
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <ul id="side-menu">
            <li class="lvl-1" id="opening">
                <a href="#" id="open">
                    <img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#" id="close">
                    <img src="<?php echo base_url() ?>assets/html/img/arrow-left.png" />
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#" class="lightning">
                    <div class="caption">Kapal KRI</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/kapal.png" /></div>
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#" class="lightning">
                    <div class="caption">Kapal Target</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/kapal-target.png" /></div>
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#" class="lightning">
                    <div class="caption">Pos dan Pangkalan</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/pos.png" /></div>
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#" class="lightning">
                    <div class="caption">Marinir</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/marinir.png" /></div>
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#" class="lightning">
                    <div class="caption">Kapal Selam</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/selam.png" /></div>
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#" class="lightning">
                    <div class="caption">Pesawat Udara</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/pesawat-udara.png" /></div>
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#" class="lightning">
                    <div class="caption">Kendaraan Tempur</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/kendaraan.png" /></div>
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#">
                    <div class="caption">Informasi dan Laporan</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/info.png" /></div>
                </a>
                <ul style="display: none;">
                    <li>
                        Informasi dan Laporan
                    </li>
                    <li>
                        <a href="#" id="form-laporan">Form Laporan</a>
                    </li>
                    <li>
                        <a href="#" class="lightning-sub">Lapsithar</a>
                    </li>
                    <li>
                        <a href="#" class="lightning-sub">Laporan Intelejen</a>
                    </li>
                </ul>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#" class="lightning">
                    <div class="caption">Ukur Jarak</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/ukur-jarak.png" /></div>
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#" class="lightning">
                    <div class="caption">Video</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/video.png" /></div>
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#" class="lightning">
                    <div class="caption">Chatting</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/chating.png" /></div>
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#">
                    <div class="caption">Data Back-End</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/data-backend.png" /></div>
                </a>
            </li>
            <li class="lvl-1" style="display: none;">
                <a href="#">
                    <div class="caption">Log Out</div>
                    <div class="default"><img src="<?php echo base_url() ?>assets/html/img/icon-menu/logout.png" /></div>
                </a>
            </li>
        </ul>
        <div id="side-right" style="display: none;">
            <a href="#" id="close-right">
                <img src="<?php echo base_url() ?>assets/html/img/arrow-right.png" />
            </a>
            <a href="#" id="tombol-chat">
                Chat
            </a>
            <ul class="info">
                <li>Yos Sudarso-12</li>
                <li><label>Posisi:</label><br />05°00′03.5460″U , 107°35′03.5460″T</li>
                <li><label>Halu:</label><br />120.9</li>
                <li><label>Cpt:</label><br />280.6 Knott</li>
                <li><label>Pemilik:</label><br />Armabar</li>
                <li><label>Nama Operasi:</label><br />Harimau Sumatera</li>
                <li><label>Deskripsi Operasi:</label><br />Pengamanan pantai utara sumatra</li>
            </ul>
            <ul class="info">
                <li>Informasi Personil</li>
                <li><label>DAN KRI:</label><br />(87653/P)Iwa Sukoco</li>
                <li><label>Jumlah other:</label><br />Bad</li>
                <li><label>Jumlah This is description of personnel type 2:</label><br />Good testing metric 2</li>
                <li><label>Jumlah TAMTAMA:</label><br />13 ORANG</li>
                <li><label>Jumlah BINTARA:</label><br />9 ORANG</li>
                <li><label>Jumlah PAMA:</label><br />5 ORANG</li>
                <li><label>Jumlah PAMEN:</label><br />2 ORANG</li>
            </ul>
            <ul class="info">
                <li>Informasi Logistik</li>
                <li><label>BADAN KAPAL:</label><br />S</li>
                <li><label>PENDORONGAN:</label><br />ST</li>
                <li><label>SENJATA:</label><br />ST</li>
                <li><label>KOMUNIKASI:</label><br />S</li>
                <li><label>BBM:</label><br />4 TON</li>
                <li><label>AIR TAWAR:</label><br />11 TON</li>
            </ul>
            <ul class="info">
                <li>ADO</li>
                <li><label>19 Jul 2013</label><br />Mendung</li>
                <li><label>23 Jul 2013</label><br />Mendung</li>
                <li><label>27 Jul 2013</label><br />Mendung</li>
            </ul>
        </div>
        <div style="text-align: center; padding-top: 350px;">
            <a href="#" id="open-side-right">Click Me For Side Right</a><br />
            <a href="#" id="open-video">Click Me For Video</a><br />
            <a href="#" id="open-chat">Click Me For Chat</a>
        </div>
    </body>
</html>