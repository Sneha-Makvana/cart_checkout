<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php if (!session()->get('is_logged_in')) : ?>
    <div class="alert alert-warning">You need to log in first to checkout. <a href="<?= base_url('/login'); ?>">Click here
            to log in</a></div>
<?php endif; ?>

<form action="" id="checkOutForm" method="POST" class="mt-5 mb-5 py-5">
    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-5 mb-md-0">
                    <h2 class="h3 mb-3 text-black">Billing Details</h2>
                    <div class="p-3 p-lg-5 border">
                        <div class="form-group">
                            <label for="city" class="text-black">City <span class="text-danger">*</span></label>
                            <select id="city" name="city" class="form-control">
                                <option selected disabled>Select a city</option>
                                <option value="Dubai">Dubai</option>
                                <option value="Japan">Japan</option>
                                <option value="UK">UK</option>
                                <option value="USA">USA</option>
                                <option value="India">India</option>
                            </select>
                            <div class="error text-danger" id="cityError"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="fname" class="text-black">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fname" name="fname">
                                <div class="error text-danger" id="fnameError"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="lname" class="text-black">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lname" name="lname">
                                <div class="error text-danger" id="lnameError"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="address" class="text-black">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Street address">
                                <div class="error text-danger" id="addressError"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="email" class="text-black">Email Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email" name="email">
                                <div class="error text-danger" id="emailError"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="text-black">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
                                <div class="error text-danger" id="phoneError"></div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="notes" class="text-black">Order Notes</label>
                            <textarea name="notes" id="notes" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."></textarea>
                            <div class="error text-danger" id="notesError"></div>
                        </div>
                        <input type="hidden" id="order_total" name="order_total" value="<?= $orderTotal ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h2 class="h3 mb-3 text-black">Your Order</h2>
                            <div class="p-3 p-lg-5 border">
                                <table class="table site-block-order-table mb-5">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cartItems as $item) : ?>
                                            <tr data-id="<?= $item['id'] ?>">
                                                <td class="product-name"><?= $item['product_name'] ?></td>
                                                <td class="product-total">
                                                    $<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                                <!-- Display the total amount per item -->
                                            </tr>

                                        <?php endforeach; ?>

                                        <tr>
                                            <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                                            <td class="text-black">$<?= number_format($subtotal, 2) ?></td>
                                        </tr>

                                        <tr>
                                            <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                                            <td class="text-black font-weight-bold total_amt">
                                                <strong>$<?= number_format($orderTotal, 2) ?></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="border p-3 mb-2">
                                    <h3 class="h6 mb-0">
                                        <label class="text-danger">
                                            <input type="radio" name="payment_method" value="stripe" id="stripe-button" class="mx-2"> Stripe
                                        </label>
                                    </h3>
                                </div>

                                <div class="border p-3 mb-2">
                                    <h3 class="h6 mb-0">
                                        <label class="text-danger">
                                            <input type="radio" name="payment_method" value="GooglePay" id="GooglePay-button" class="mx-2"> GooglePay
                                        </label>
                                    </h3>
                                </div>

                                <div class="border p-3 mb-2">
                                    <h3 class="h6 mb-0">
                                        <label class="text-danger">
                                            <input type="radio" name="payment_method" value="Paytm" id="Paytm-button" class="mx-2"> Bank Transfer
                                        </label>
                                    </h3>
                                </div>

                                <div class="border p-3 mb-2">
                                    <h3 class="h6 mb-0">
                                        <label class="text-danger">
                                            <input type="radio" name="payment_method" value="PhonePay" id="PhonePay-button" class="mx-2"> Credit/Debit Cards
                                        </label>
                                    </h3>
                                </div>

                                <div class="border p-3 mb-5">
                                    <h3 class="h6 mb-0">
                                        <label class="text-danger">
                                            <input type="radio" name="payment_method" value="paypal" id="paypal-button" class="mx-2"> PayPal
                                        </label>
                                    </h3>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="button" id="submitCheckout">Place Order</button>
                                </div>
                                <button type="button" id="stripeCheckoutButton" class="btn btn-primary btn-lg btn-block" style="display:none;">Pay with Stripe</button>
                                <div id="message"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#submitCheckout').on('click', function() {
        const formData = $('#checkOutForm').serialize();
        const paymentMethod = $('input[name="payment_method"]:checked').val(); // Get selected payment method

        if (!paymentMethod) {
            alert('Please select a payment method.');
            return;
        }

        let paymentUrl = '';
        if (paymentMethod === 'stripe') {
            paymentUrl = '<?= base_url("stripe/createCheckoutSession") ?>';
        } else if (paymentMethod === 'paypal') {
            paymentUrl = '<?= base_url("paypal/create-payment") ?>';
        } else {
            paymentUrl = '<?= base_url("checkout/process") ?>';
        }

        $.ajax({
            url: paymentUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    if (paymentMethod === 'stripe' || paymentMethod === 'paypal') {
                        window.location.href = response.redirect_url;
                    } else {
                        $('#message').html('<p class="text-success">' + response.message + '</p>');
                        setTimeout(function() {
                            window.location.href = '<?= base_url("/thankyou") ?>';
                        }, 1000); // Redirect after 2 seconds
                    }
                } else if (response.status === 'error' && response.errors) {
                    $.each(response.errors, function(field, error) {
                        $(`#${field}Error`).text(error);
                    });
                } else {
                    alert(response.message || 'An unexpected error occurred.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('An error occurred while processing your request.');
            }
        });
    });
</script>

<?= $this->endSection(); ?>