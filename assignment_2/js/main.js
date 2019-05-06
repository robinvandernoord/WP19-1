const regexes = {
    'number': /^\d+$/,
    'text': /^[A-z ]+$/,
    'tel': /^[0-9 +]+$/,
    'email': /^[A-z.0-9!#$%&'*+\-/=?^_`{|}~]{1,65}@[A-z0-9.-]+\.\w+$/,
    // rules for email from https://en.wikipedia.org/wiki/Email_address#Syntax
};

function capitalize(s) {
    return s.charAt(0).toUpperCase() + s.slice(1)
}

function validateForm(values) {
    // `this` is now the button element
    // `e` is the event
    let errors = [];

    $('#mainform .form-group input').each(function (index, element) {
        // check each form item
        // look for the data-validate attribute, with 'text' as default
        let use_regex = regexes[$(element).data('validate') || 'text'];
        if (element.value) {
            // if the field is filled in
            if (!use_regex.test(element.value)) {
                // if the field does not match the right regular expression, give an error
                let fieldtip = $(element).data('tip');
                errors.push(`Field ${element.id}: ${fieldtip}`);
            } else {
                values[element.id] = element.value;
            }
        } else {
            // if the field is not filled in, give an error
            errors.push(`Field ${element.id} was not filled in!`);
        }
    });

    if (errors && errors.length) {
        // if the error array has anything in it, show the error(s)
        $('#form-alert')
            .show()
            .html(errors.join('<br>'));

        return false;
    } else {
        // otherwise continue
        return true;
    }
}

function writeFormData(values) {
    let tbody;
    $('#form-content tbody').remove(); // delete old table
    tbody = $('<tbody>');
    $.each(values, function (key, value) {
        let th, td, tr;
        th = $('<th>');
        th.attr('scope', 'row');
        th.text(capitalize(key));

        td = $('<td>');
        td.text(value);

        tr = $('<tr>');
        tr.append(th).append(td);
        tbody.append(tr);
    });
    $('#form-content table').append(tbody);
    $('#form-alert').hide();
    $('#form-content').show();
}

function change_tab() {
    /* todo: change if # in url */
    let self, other;
    // get whether it is contact or link
    self = this.id.split('-')[0];
    // other is whatever self isn't
    other = self === 'contact' ? 'link' : 'contact';
    // give the clicked menu item a white background and remove it from the other item:
    $(this).addClass('active');
    $(`#myTab #${other}-tab`).removeClass('active');
    // show the clicked content and hide the other content:
    // (`id^=` has to be used because it's `link[s]` and `content`)
    $(`#myTabContent div[id^=${self}]`).addClass('active');
    $(`#myTabContent div[id^=${other}]`).removeClass('active');
}


$(function () {
    $('#submit').on('click', function (e) {
        let values = {};
        if (validateForm(values)) {
            // values should be filled in now
            writeFormData(values);
        }
    });
    // `() =>` is shorthand for creating a nameless function
    // ( just passing `$('#form-content, #form-alert').hide` didnt work)
    $('#erase').on('click', () => $('#form-content, #form-alert').hide());

    $('#myTab a').on('click', change_tab);

});