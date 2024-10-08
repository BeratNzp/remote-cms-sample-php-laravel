<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li>
                <a href="{{ route('homepage') }}">
                    <i class="fa fa-home"></i> Anasayfa
                </a>
            </li>
            <li>
                <a>
                    <i class="fa fa-edit"></i> İçerik İşlemleri <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a href="{{ route("category.list") }}">
                            <i class="fa fa-ellipsis-h"></i> Kategoriler
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-list"></i> Ürünler
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-list-ol"></i> Varyantlar
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-file"></i> Dosyalar
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-file-text"></i> Bloglar
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-sticky-note-o"></i> Sayfalar
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-comment"></i> Yorumlar
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-modx"></i> Modüller <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a>
                            <i class="fa fa-edit"></i> Randevu <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="#">
                                    <i class="fa fa-calendar"></i> Randevular
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-id-card"></i> Danışanlar
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-user"></i> Danışmanlar
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-suitcase"></i> Tatil Günleri
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-envelope-o"></i> eMail
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-phone"></i> İletişim Formu
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-image"></i> Slider
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-building"></i> Şirket İşlemleri <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a href="{{ route("company.list") }}">
                            <i class="fa fa-building"></i> Şirketler
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("department.list") }}">
                            <i class="fa fa-sitemap"></i> Departmanlar
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("user.list") }}">
                            <i class="fa fa-user-secret"></i> Kullanıcılar
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("service.list") }}">
                            <i class="fa fa-server"></i> Servisler
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("database.list") }}">
                            <i class="fa fa-cog"></i> Veritabanları
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-user"></i> Müşteriler
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-life-ring"></i> Destek <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a href="#">
                            <i class="fa fa-life-ring"></i> Ticket
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-cogs"></i> Ayarlar <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a href="#">
                            <i class="fa fa-tv"></i> Site Ayarları
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-hashtag"></i> Sosyal Ağ Ayarları
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-envelope-o"></i> eMail Ayarları
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-plug"></i> API Ayarları
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-database"></i> Veritabanı Ayarları
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-cogs"></i> Geliştirici <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li>
                        <a href="#">
                            Veritabanı
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            cPanel
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->
<!-- sidebar bottom buttons -->
<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="Site ayarları">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Siteyi görüntüle">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Siteye erişimi kilitle">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Çıkış Yap" href="{{ route('user.logout_action') }}">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>
<!-- .sidebar bottom buttons -->
