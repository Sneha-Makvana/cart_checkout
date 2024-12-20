<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="site-section mt-5 mb-5">
    <div class="container">
        <div class="row mb-5">
            <form class="col-md-12" method="post">
                <div class="site-blocks-table">
                    <table class="table table-bordered" id="cart-table">
                        <thead>
                            <tr>
                                <th class="product-thumbnail">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cartItems)) : ?>
                                <?php foreach ($cartItems as $productId => $item) : ?>
                                    <tr data-id="<?= $productId ?>">
                                        <td class="product-thumbnail">
                                            <img src="<?= base_url('public/uploads/' . $item['image']) ?>" alt="<?= esc($item['product_name']) ?>" class="img-fluid" style="width: 75px; height: auto;">
                                        </td>
                                        <td class="product-name"><?= esc($item['product_name']) ?></td>
                                        <td class="product-price">$<?= esc($item['price']) ?></td>
                                        <td>
                                            <input type="number" class="form-control text-center qty-input" value="<?= esc($item['quantity']) ?>" min="1">
                                        </td>
                                        <td class="product-total">$<?= esc($item['total_price']) ?></td>
                                        <td>
                                            <button class="btn btn-danger btn-sm remove-btn" data-id="<?= $productId ?>">X</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center">Your cart is empty.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>

        <!-- Totals and checkout buttons -->
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-6">
                        <button class="btn btn-outline-primary btn-sm btn-block"><a href="<?= base_url('/main'); ?>">Continue Shopping</a></button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pl-5">
                <div class="row justify-content-end">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12 text-right border-bottom mb-5">
                                <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <span class="text-black">Subtotal</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black cart-subtotal">$</strong>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <span class="text-black">Total</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black cart-total">$</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-lg btn-block" onclick="window.location='<?= base_url('/checkout') ?>'">Proceed To Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateCartTotals() {
        $.ajax({
            url: '<?= base_url('cart/totals') ?>',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('.cart-subtotal').text(`$${response.subtotal.toFixed(2)}`);
                    $('.cart-total').text(`$${response.total.toFixed(2)}`);
                }
            },
            error: function() {
                console.error('Error fetching cart totals.');
            }
        });
    }

    $(document).on('input', '.qty-input', function() {
        const cartId = $(this).closest('tr').data('id');
        const newQty = $(this).val();

        if (newQty < 1) {
            alert('Quantity must be at least 1.');
            return;
        }
        $.ajax({
            url: '<?= base_url('cart/update') ?>',
            type: 'POST',
            data: {
                cart_id: cartId,
                quantity: newQty
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $(`tr[data-id="${cartId}"] .product-total`).text(`$${response.newTotalPrice.toFixed(2)}`);
                    updateCartTotals();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error updating cart item.');
            }
        });
    });

    $(document).on('click', '.remove-btn', function(e) {
        e.preventDefault();
        const cartId = $(this).data('id');

        $.ajax({
            url: '<?= base_url('cart/remove') ?>',
            type: 'POST',
            data: {
                cart_id: cartId
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $(`tr[data-id="${cartId}"]`).remove();
                    updateCartTotals();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error removing item from cart.');
            }
        });
    });

    $(document).ready(function() {
        updateCartTotals();
    });
</script>
<?= $this->endSection(); ?>