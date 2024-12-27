<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="site-section mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 text-center">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <span class="icon-check_circle display-3 text-success mb-3"></span>
                        <h2 class="display-4 text-black">Thank You!</h2>
                        <p class="lead mb-4">Your order was successfully completed. We appreciate your business!</p>
                        <a href="<?= base_url('/logout');?>" class="btn btn-primary btn-lg px-5 py-3">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
