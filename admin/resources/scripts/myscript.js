$(document).ready(function() {
    // Validation
    $('span.success').hide();
    $('span.error').hide();
    $('#name').on('blur', validateText);
    $('#add-category').on('blur', validateText);
    $('#add-tag').on('blur', validateText);
    $('#mrp').on('blur', validateNumber);
    $('#price').on('blur', validateNumber);
    $('#quantity').on('blur', validateNumber);
    $('#color').on('blur', validateText);
    $('#short_desc').on('blur', validateText);
    $('#description').on('blur', validateText);
    $('#category').on('blur change', validateNumber);
    $('#tag').on('blur change', validateNumber);
    $('#image').bind('change', validateImage);
});


function validateText() {
    let namePattern = /^[a-zA-Z\s]*$/;
    let nameValue = $(this).val();
    if (namePattern.test(nameValue) && nameValue !== '') {
        $(this).next('span.success').show();
        $(this).next().next('span.error').hide();
        return true;
    } else {
        $(this).next().next('span.error').show();
        $(this).next('span.success').hide();
        return false;
    }
}

function validateNumber() {
    let value = $(this).val();
    if ($.isNumeric(value) && value !== '') {
        $(this).next('span.success').show();
        $(this).next().next('span.error').hide();
        return true;
    } else {
        $(this).next().next('span.error').show();
        $(this).next('span.success').hide();
        return false;
    }
}

function validateImage() {
    let ext = $(this).val().split('.').pop().toLowerCase();
    console.log($.inArray(ext, ['jpg', 'jpeg', 'png']));
    if ($.inArray(ext, ['jpg', 'jpeg', 'png']) !== -1) {
        $(this).next('span.success').show();
        $(this).next().next('span.error').hide();
        return true;
    } else {
        $(this).next().next('span.error').show();
        $(this).next('span.success').hide();
        return false;
    }

}