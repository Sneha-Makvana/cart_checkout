<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row justify-content-center px-xl-5">
        <div class="col-lg-4 col-md-6 col-sm-8">
            <div class="card border-0 shadow-lg p-4">
                <h3 class="text-center mb-4 text-dark">Login</h3>
                <form id="loginForm">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email">
                        <div class="text-danger" id="error-email"></div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
                        <div class="text-danger" id="error-password"></div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="">Register here</a></p>
                </div>
                <div id="message"></div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            $(".text-danger").html("");

            let formData = new FormData(this);

            $.ajax({
                url: '<?= base_url('/login')?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status === true) {
                        $('#message').html('<p class="text-success">' + response.message + '</p>');
                        // window.location.href = "<?= base_url('/main'); ?>";
                    } else if (response.status === 'error') {
                        let errors = response.errors;
                        for (let key in errors) {
                            $('#error-' + key).html(errors[key]);
                        }
                    } else {
                        $('#message').html('<p class="text-danger">' + response.message + '</p>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#message').html('<p class="text-danger">An unexpected error occurred. Please try again.</p>');
                },
            });
        });
    });
</script>
<?= $this->endSection(); ?>