<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .product-image {
        height: 250px;
        object-fit: cover;
    }

    .btn-outline-success:hover,
    .btn-outline-primary:hover {
        color: #fff !important;
    }
</style>

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
                <img src="<?= base_url('public/assets/images/model_3.png') ?>" alt="Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="title-section mb-5 col-12 text-center">
            <h2 class="text-uppercase">Popular Products</h2>
        </div>
    </div>
    <div class="row">
        <?php if (!empty($products) && is_array($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm product-card">
                        <a href="<?= base_url('product/display/' . $product['id']) ?>" class="product-link">
                            <img src="<?= base_url('public/uploads/' . $product['image']) ?>" alt="<?= esc($product['product_name']) ?>" class="card-img-top img-fluid product-image">
                        </a>
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <a href="<?= base_url('product/display/' . $product['id']) ?>" class="text-dark text-decoration-none">
                                    <?= esc($product['product_name']) ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted mb-2">
                                <strong>$<?= esc($product['price']) ?></strong>
                            </p>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-outline-success btn-sm mx-1 add-to-cart-btn" data-id="<?= $product['id'] ?>" data-name="<?= esc($product['product_name']) ?>" data-price="<?= esc($product['price']) ?>">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                                <a href="<?= base_url('product/display/' . $product['id']) ?>" class="btn btn-outline-primary btn-sm mx-1">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12">
                <p class="text-center">No products available at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    $(document).on('click', '.add-to-cart-btn', function() {
        const productId = $(this).data('id');
        const productName = $(this).data('name');
        const productPrice = $(this).data('price');

        $.ajax({
            url: '<?= base_url('cart/add') ?>',
            type: 'POST',
            data: {
                product_id: productId,
                quantity: 1
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(`"${productName}" added to your cart.`);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error adding product to the cart.');
            }
        });
    });
</script>


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
                <img src="<?= base_url('public/assets/images/model_6.png') ?>" alt="Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>