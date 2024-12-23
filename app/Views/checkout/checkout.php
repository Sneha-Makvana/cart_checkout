<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<?php if (!session()->get('is_logged_in')) : ?>
    <div class="alert alert-warning">You need to log in first to checkout. <a href="<?= base_url('/login'); ?>">Click here to log in</a></div>
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
                        <input type="hidden" id="order_total" name="order_total" value="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h2 class="h3 mb-3 text-black">Your Order</h2>
                            <div class="p-3 p-lg-5 border">

                                <div class="border p-3 mb-3">
                                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Direct Bank Transfer</a></h3>

                                    <div class="collapse" id="collapsebank">
                                        <div class="py-2">
                                            <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="border p-3 mb-3">
                                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsecheque" role="button" aria-expanded="false" aria-controls="collapsecheque">Cheque Payment</a></h3>

                                    <div class="collapse" id="collapsecheque">
                                        <div class="py-2">
                                            <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="border p-3 mb-5">
                                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsepaypal" role="button" aria-expanded="false" aria-controls="collapsepaypal">Paypal</a></h3>

                                    <div class="collapse" id="collapsepaypal">
                                        <div class="py-2">
                                            <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="button" id="submitCheckout">Place Order</button>
                                </div>
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

        $.ajax({
            url: '<?= base_url("checkout/process") ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#message').html('<p class="text-success">' + response.message + '</p>')
                    // alert('Order placed successfully!');
                    window.location.href = '<?= base_url("/thankyou") ?>';
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(field, error) {
                            $(`#${field}Error`).text(error);
                        });
                    } else {
                        alert(response.message);
                    }
                    // $('#message').html('<p class="text-success">' + response.message + '</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ', error);
                alert('An error occurred while processing your request.');
            }
        });
    });
</script>

<?= $this->endSection(); ?>