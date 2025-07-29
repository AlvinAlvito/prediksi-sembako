<nav>
    <div class="logo-name">
        <div class="logo-image">
            <img src="/images/logo.jpg"  alt="">
        </div>

        <span class="logo_name">Toko Gento</span>
    </div>

    <div class="menu-items">
        <ul class="nav-links">
            <li >
                <a href="/admin" class="{{ Request::is('/admin') ? 'active' : '' }}">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Beranda</span>
                </a>
            </li>
             <li >
                <a href="/admin/data-penjualan" class="{{ Request::is('/admin/data-penjualan') ? 'active' : '' }}">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Data Penjualan</span>
                </a>
            </li>
            <li >
                <a href="/admin/koefisien" class="{{ Request::is('/admin/koefisien') ? 'active' : '' }}">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Koefisien</span>
                </a>
            </li>
             <li >
                <a href="/admin/hasil-prediksi" class="{{ Request::is('/admin/hasil-prediksi') ? 'active' : '' }}">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Hasil Prediksi</span>
                </a>
            </li>
           
        </ul>
        

        <ul class="logout-mode">
            <li><a href="/">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

            <li class="mode">
                <a href="#">
                    <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                    <span class="switch"></span>
                </div>
            </li>
        </ul>
    </div>
</nav>
