<header>
        <!-- Header Start -->
        <div class="header-area header-transparent ">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="p-3 menu-wrapper d-flex align-items-center justify-content-between">
                        <!-- Logo -->
                        <div class="logo">
                            <h1>Blog Du Dev</h1>
                        </div>
                        <!-- Main-menu -->
                         
                        <!-- Header-btn -->
                        <div class="header-btns d-none d-lg-block f-right">
                           <a href="/form-article.php" class="btn <?= $_SERVER['REQUEST_URI'] === '/form-article.php' ? 'btn-active' : '' ?>">Ecrire un article</a>
                       </div>
                       <!-- Mobile Menu -->
                       <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>