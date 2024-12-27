<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .success-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .success-card {
            max-width: 500px;
            background-color: #ffffff;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        .success-icon {
            font-size: 60px;
            color: #28a745;
        }
        .success-btn {
            color: #ffffff;
            background-color: #28a745;
        }
    </style>
</head>
<body>

<div class="success-page">
    <div class="success-card p-4 rounded">
        <div class="success-icon mb-4">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h1 class="mb-3">Payment Successful!</h1>
        <p class="mb-4">Thank you for your payment. Your transaction has been completed, and a receipt has been emailed to you.</p>
        <a href="<?= base_url('/logout')?>" class="btn success-btn px-4">Logout</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
