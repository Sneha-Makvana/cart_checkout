<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="main.php">Home</a> <span class="mx-2 mb-0">/</span>
                <strong class="text-black">  </strong>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src=" " alt=" " class="img-fluid">
            </div>
            <div class="col-md-6">
                <h2 class="text-black"> </h2>
                <p>  </p>
                <p><strong class="text-primary h4">$ </strong></p>

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
                    <a href="#" class="add-to-cart-btn btn btn-sm height-auto px-4 py-3 btn-primary" data-id=" ">Add To Cart</a>
                </p>
                <div id="error-message" class="text-danger" style="display: none;"></div>
                <div id="success-message" class="text-success" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>