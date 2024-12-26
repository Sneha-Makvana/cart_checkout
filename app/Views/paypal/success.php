<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<title>Payment Successful</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Container for the page content -->
    <div class="container mt-5 py-5 mb-5">
        <!-- Success message -->
        <div class="alert alert-success" role="alert">
            <h1>Payment Successful!</h1>
            <p>Your order has been successfully placed.</p>
        </div>
        <!-- Button for logout -->
        <a href="<?= base_url('/logout')?>" class="btn btn-danger">Logout</a>
    </div>
    <!-- Bootstrap JS (Optional for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <?= $this->endSection(); ?>