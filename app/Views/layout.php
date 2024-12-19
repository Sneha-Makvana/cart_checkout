<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shopping</title>
    <?= $this->include('home/header_link'); ?>
</head>

<body>

    <div class="site-wrap">

        <?= $this->include('home/navbar'); ?>


        <div class="site-section">
            <?= $this->renderSection('content'); ?>
        </div>


        <?= $this->include('home/footer'); ?>

    </div>

    <?= $this->include('home/footer_link'); ?>

</body>

</html>