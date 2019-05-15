const regexes = {
    'name': /^[A-z \-]+$/,
    'age': /^[0-9]{1,3}$/,
    'email': /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/,
    'place': /^[A-z \-]+$/,
    // rules for email from https://www.w3schools.com/tags/att_input_pattern.asp
};

function validate_me(e) {
    let that = e.target || e;  // the variable 'this' does not work if we use a functions, because it will be 'window'
    // using on.keyup e will have a target, using .each e will be the target.
    let valid = $(that).siblings('.valid-feedback');
    let invalid = $(that).siblings('.invalid-feedback');
    if (regexes[that.name].test(that.value)) {
        $(that).addClass('is-valid');
        $(that).removeClass('is-invalid');
        valid.show();
        invalid.hide();
        return true;
    } else {
        $(that).removeClass('is-valid');
        $(that).addClass('is-invalid');
        valid.hide();
        invalid.removeClass('mark');
        invalid.show();
        return false;
    }
}

$(function () {
    $('form input').on('keyup', validate_me);

    $('#do_submit').on('click', function () {
        let attention = $('.invalid-feedback').removeClass('mark');
        let all_valid = true;
        $('form input').each(function (i, e) {
            let is_valid = validate_me(e);
            if(all_valid){
                all_valid = is_valid;
            }
            return true;
            // return false will act as break so we can use is_valid to see if it's all true.
            // however, if we want to validate all fields (so we can se feedback on all), we don't want to return/break.
        });
        if (all_valid) {
            $('form').submit();
        } else {
            // if the submit button is pressed, give extra stress to the incorrect fields
            attention.addClass('mark');
        }
    })
});