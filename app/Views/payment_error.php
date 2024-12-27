<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Error</title>
</head>
<body>
    <h1>Payment Error</h1>
    <p><?= isset($message) ? esc($message) : 'An unknown error occurred during payment processing.' ?></p>
    <a href="<?= base_url('/cart') ?>">Return to Cart</a>
</body>
</html>
