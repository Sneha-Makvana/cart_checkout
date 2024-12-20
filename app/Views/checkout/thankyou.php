<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="site-section mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <span class="icon-check_circle display-3 text-success"></span>
                <h2 class="display-3 text-black">Thank you!</h2>
                <p class="lead mb-5">You order was successfuly completed.</p>
                <p><a href="<?= base_url('/logout');?>" class="btn btn-sm height-auto px-4 py-3 btn-primary">Logout</a></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>