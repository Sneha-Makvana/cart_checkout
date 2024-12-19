<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="row g-0">
                    <div class="col">
                        <div class="card-body p-4">
                            <h3 class="mb-4 text-uppercase text-center text-dark">Registration</h3>
                            <form id="registerForm" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" id="username" name="username" class="form-control" />
                                        <span class="error-message text-danger small" id="error-username"></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" id="lname" name="lname" class="form-control" />
                                        <span class="error-message text-danger small" id="error-lname"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email ID <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" class="form-control" />
                                        <div class="error-message text-danger small" id="error-email"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password">
                                        <div class="error-message text-danger small" id="error-password"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Gender <span class="text-danger">*</span></label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male">
                                            <label class="form-check-label" for="genderMale">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female">
                                            <label class="form-check-label" for="genderFemale">Female</label>
                                        </div>
                                        <div class="error-message text-danger small" id="error-gender"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                        <select class="form-control" id="city" name="city">
                                            <option value="">Select City</option>
                                            <option value="India">India</option>
                                            <option value="USA">USA</option>
                                            <option value="UK">UK</option>
                                            <option value="London">London</option>
                                        </select>
                                        <div class="error-message text-danger small" id="error-city"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="mobile_number" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number">
                                        <div class="error-message text-danger small" id="error-mobile_number"></div>
                                    </div>
                                </div>
                                <div class="text-end pt-3">
                                    <button type="submit" id="submitBtn" class="btn btn-primary btn-lg">Submit</button>
                                </div>
                            </form>
                            <div id="message" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        $(".error-message").html("");
        var formData = new FormData(this);
        $.ajax({
            url: '<?= base_url('/register/create')?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === true) {
                    $('#message').html('<p class="text-success">' + response.message + '<a href="<?= base_url('/login')?>"> Login </a>' + '</p>');
                    $('#registerForm')[0].reset();
                } else if (response.status === 'error') {
                    let errors = response.errors;
                    for (let key in errors) {
                        $('#error-' + key).html(errors[key]);
                    }
                }
            },
            error: function() {
                $('#message').html('<p class="text-danger">An error occurred. Please try again.</p>');
            }
        });
    });
</script>
<?= $this->endSection(); ?>