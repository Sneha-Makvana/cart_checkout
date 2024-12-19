<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
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
                    <a href="#" class="product-item md-height bg-gray d-block">
                        <img src="<?= base_url('public/uploads/' . $product['image']) ?>" alt="<?= esc($product['product_name']) ?>" class="img-fluid">
                    </a>
                    <div class="d-flex">
                        <h2 class="item-title">
                            <a href="#" class="text-dark"><?= esc($product['product_name']) ?></a>
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
<?= $this->endSection(); ?>
