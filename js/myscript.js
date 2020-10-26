$(document).ready(function() {
    // Validate Registration Form
    $('#reg-name').on('blur', validateText);
    $('#reg-email').on('blur', validateEmail);
    $('#reg-mobile').on('blur', validateMobile);
    $('#reg-password').on('blur', validatePassword);
    $('#reg-form').on('submit', function(e) {
        $(this).find('input').each(function() {
            if ($(this).hasClass('has-error')) {
                $('#reg-message').addClass('success-message');
                $('#reg-message').removeClass('error-message');
                $('#reg-message').html('');
                e.preventDefault();
            } else {
                $('#reg-message').removeClass('success-message');
                $('#reg-message').addClass('error-message');
                $('#reg-message').html('All fields required !!!.');
            }
        });
    });
    $('#login-modal-form').on('submit', loginModal);
    $('#checkout-login-btn').on('click', userLogin);
});

function userLogin() {
    let email_id = $('#email_id').val();
    let login_password = $('#login_password').val();
    $.ajax({
        url: "login.php",
        method: "POST",
        data: { email_id: email_id, login_password: login_password },
        success: function(res) {
            if (res == 1) {
                window.location.href = window.location.href;
            } else {
                $('#checkout-login-msg').html('Email ID or Password is Incorrect !!!.');
            }
        },
    });
}

function loginModal(e) {
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        url: "login.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(res) {
            if (res == 1) {
                window.location.href = window.location.href;
            } else {
                $('#login-modal-error-message').html('Email Id or Password is Incorrect !!!.');
            }
        },
    });
}

function update_cart(ids) {
    let qty = 1;

    $.each(ids, function(index, item) {
        qty = $(`#${item}qty`).val();
        $.ajax({
            url: "manage_cart.php",
            method: "POST",
            data: { id: item, qty: qty, type: "update" },
            success: function(res) {
                $('.aa-cart-notify').html(res);
            },
        });
    });
    window.location.reload();

}

function manage_cart(id, type) {
    let qty = 1;
    if (type == 'update') {
        qty = $(`#${id}qty`).val();
    } else {
        qty = $('#qty').val();
    }
    $.ajax({
        url: "manage_cart.php",
        method: "POST",
        data: { id: id, qty: qty, type: type },
        success: function(res) {
            window.location.reload();
            $('.aa-cart-notify').html(res);
        },
    });
}

function validateText() {
    let value = $(this).val();
    if (value == '') {
        $(this).next().html('Please fill this field !!!.');
    } else if (value.length < 3 || value.length > 20) {
        $(this).next().html('Length Should be between 3 to 20 charecter !!!.');
    } else if (!isNaN(value)) {
        $(this).next().html('Number not allowed !!!.');
    } else {
        $(this).next().html('');
        $(this).removeClass('has-error');
    }
}

function validateEmail() {
    let value = $(this).val();
    let emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;
    if (value == '') {
        $(this).next().html('Please fill this field !!!.');
    } else if (!emailPattern.test(value)) {
        $(this).next().html('Please Enter a Valid Email !!!.');
    } else {
        $(this).next().html('');
        $(this).removeClass('has-error');
    }
}

function validateMobile() {
    let value = $(this).val();
    let mobilePattern = /^([+]\d{2})?\d{10}$/;
    if (value == '') {
        $(this).next().html('Please fill this field !!!.');
    } else if (!mobilePattern.test(value)) {
        $(this).next().html('Please Enter Valid Mobile Number !!!.');
    } else {
        $(this).next().html('');
        $(this).removeClass('has-error');
    }
}

function validatePassword() {
    let value = $(this).val();
    if (value == '') {
        $(this).next().html('Please fill this field !!!.');
    } else if (value.length < 8) {
        $(this).next().html('Password length must be minimum 8 !!!.');
    } else {
        $(this).next().html('');
        $(this).removeClass('has-error');
    }
}