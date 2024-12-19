<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="site-blocks-cover mb-5" data-aos="fade">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ml-auto order-md-2 align-self-start">
                <div class="site-block-cover-content">
                    <h2 class="sub-title">#New Summer Collection 2019</h2>
                    <h1>Arrivals Sales</h1>
                    <p><a href="#" class="btn btn-black rounded-0">Shop Now</a></p>
                </div>
            </div>
            <div class="col-md-6 order-1 align-self-end">
                <img src="<?= base_url('public/assets/images/model_3.png')?>" alt="Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="title-section mb-5 col-12">
            <h2 class="text-uppercase">Popular Products</h2>
        </div>
    </div>
    <div class="row">
        <?php if (!empty($products) && is_array($products)): ?>
        <?php foreach ($products as $product): ?>
        <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="<?= base_url('product/display/' . $product['id']) ?>"
                class="product-item md-height bg-gray d-block">
                <img src="<?= base_url('public/uploads/' . $product['image']) ?>"
                    alt="<?= esc($product['product_name']) ?>" class="img-fluid">
            </a>
            <div class="d-flex">
                <h2 class="item-title">
                    <a href="<?= base_url('product/display/' . $product['id']) ?>"
                        class="text-dark"><?= esc($product['product_name']) ?></a>
                </h2>
                <strong class="item-price">$<?= esc($product['price']) ?></strong>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="col-12">
            <p>No products available.</p>
        </div>
        <?php endif; ?>


    </div>
</div>

<div class="site-blocks-cover inner-page py-5 mb-5" data-aos="fade">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ml-auto order-md-2 align-self-start">
                <div class="site-block-cover-content">
                    <h2 class="sub-title">#New Summer Collection 2019</h2>
                    <h1>New Shoes</h1>
                    <p><a href="#" class="btn btn-black rounded-0">Shop Now</a></p>
                </div>
            </div>
            <div class="col-md-6 order-1 align-self-end">
                <img src="<?= base_url('public/assets/images/model_6.png')?>" alt="Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>