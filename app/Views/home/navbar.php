<div class="site-navbar bg-white py-2">

    <div class="search-wrap">
        <div class="container">
            <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
            <form action="#" method="post">
                <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
            </form>
        </div>
    </div>

    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <div class="logo">
                <div class="site-logo">
                    <a href="<?= base_url('/main'); ?>" class="js-logo-clone">ShopMax</a>
                </div>
            </div>
            <div class="main-nav d-none d-lg-block">
                <nav class="site-navigation text-right text-md-center" role="navigation">
                    <ul class="site-menu js-clone-nav d-none d-lg-block">
                        <li class="">
                            <a href="<?= base_url('/main'); ?>">Home</a>
                        </li>
                        <li class="">
                            <a href="">Products</a>
                        </li>
                        <li>
                            <a href="">Add Product</a>
                        </li>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="icons d-flex">
                <a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a>
                <a href="#" class="icons-btn d-inline-block"><span class="icon-heart-o"></span></a>

                <a href="cart.php" class="icons-btn d-inline-block bag">
                    <span class="icon-shopping-bag"></span>
                    <span class="number" id="cart-count"> </span>
                </a>

                <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span class="icon-menu"></span></a>

                <a href="<?= base_url('/register'); ?>" class="icons-btn d-inline-block"><span class="icon-user-plus"></a>

                <a href="<?= base_url('/login'); ?>" class="icons-btn d-inline-block"><span class="icon-user"></a>

                <a href="<?= base_url('/logout'); ?>" class="icons-btn d-inline-block"><span class="icon-power-off"></span></a>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
</script>