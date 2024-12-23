<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="site-section mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= base_url('public/uploads/' . $product['image']) ?>" alt="<?= esc($product['product_name']) ?>" class="img-fluid" style="height:300px ;">
            </div>
            <div class="col-md-6">
                <h2 class="text-black"><?= esc($product['product_name']) ?></h2>
                <p><?= esc($product['description']) ?></p>
                <p><strong class="text-primary h4">$<?= esc($product['price']) ?></strong></p>

                <div class="mb-5">
                    <div class="input-group mb-3" style="max-width: 120px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                        </div>
                        <input type="text" class="form-control text-center" value="1" placeholder="" aria-label="Quantity">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                        </div>
                    </div>
                </div>
                <p>
                    <button class="add-to-cart-btn btn btn-sm height-auto px-4 py-3 btn-primary" data-id="<?= $product['id'] ?>" data-price="<?= $product['price'] ?>" onclick="addToCart(<?= $product['id'] ?>)">
                        Add To Cart
                    </button>
                </p>
                <div id="error-message" class="text-danger" style="display: none;"></div>
                <div id="success-message" class="text-success" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function addToCart(productId) {
        let quantity = $('.form-control.text-center').val();

        $.ajax({
            url: '<?= base_url('cart/add') ?>',
            type: 'POST',
            data: {
                product_id: productId,
                quantity: quantity
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {    
                    // $('#success-message').text(response.message).show();
                    $("#success-message").html('<p class="text-success">' + response.message + ' <a href="<?= base_url('/cart'); ?>">View</a></p>').show();
                    $('#error-message').hide();
                } else {
                    $('#error-message').text(response.message).show();
                    $('#success-message').hide();
                }
            },
            error: function() {
                $('#error-message').text('Something went wrong. Please try again.').show();
                $('#success-message').hide();
            }
        });
    }
</script>

<?= $this->endSection(); ?>