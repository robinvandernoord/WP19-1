function add_item(title, text, changetime, edit_id) {
    let using_row = $('#articles .row')[0];

    // everything in the same 'row' so things can be removed

    // if (using_row.children.length > 2) {
    //     // make new row
    //     let new_row = $('<div class="row justify-content-end">');
    //     using_row = new_row;
    //     $('#articles').prepend(new_row);
    // }

    // build the card:
    let new_card = $(
        `<div class="col col-4 bubble d-flex" id="newsitem-${edit_id}">
                <div class="card d-flex flex-grow-1">
                    <div class="card-body">
                        <h5 class="card-title">${title}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">${changetime}</h6>
                        <p class="card-text">${nl2br(text)}</p>
                        <a href="news_edit.php?id=${edit_id}" class="card-link">edit news</a>
                    </div>
                </div>
            </div>`);
    using_row.prepend(new_card[0]);

}

function nl2br(str, replaceMode, isXhtml) {
    let breakTag = (isXhtml) ? '<br />' : '<br>';
    let replaceStr = (replaceMode) ? '$1' + breakTag : '$1' + breakTag + '$2';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
}


function change_item(title, text, changetime, edit_id) {
    let changing_item = $(`#newsitem-${edit_id}`);
    changing_item.find('.card-title').text(title);
    changing_item.find('.card-subtitle').text(changetime);
    changing_item.find('.card-text').html(nl2br(text));
    return changing_item;
}

function delete_item(edit_id) {
    let changing_item = $(`#newsitem-${edit_id}`);
    changing_item.slideUp(250, function () {
        // after sliding up, remove it
        $(this).remove();
    });
}


function do_request() {
    $.ajax('scripts/read_latest_news.php?timestamp=' + window.latest_timestamp,
        {
            'success': function (result) {
                if (result['length'] > 0) {
                    window.latest_timestamp = result['last_timestamp'];
                    handle_delta(result['items']);
                    return true
                }
            },
            // 'error': function(e){console.error(e)}
        })
}

function get_delta_dummy() {
    // get all changed items from the server
    return [
        {'status': 'removed', 'id': '666'},
        {
            'status': 'new',
            'title': 'Nieuw',
            'text': 'some content met woorden en such',
            'changetime': '23:03',
            'id': '420'
        },
        {
            'status': 'changed',
            'title': 'Sport, dit zijn de regels',
            'text': 'Sport heeft geen regels',
            'changetime': '23:03',
            'id': '79e235e5-cccc-4864-99a0-4043237ff591'
        },
        {
            'status': 'new',
            'title': 'Nieuw 2: electric boogaloo',
            'text': 'some more content',
            'changetime': '23:03',
            'id': '66'
        },
    ]
}

function handle_remove(id) {
    delete_item(id);
}

function handle_add(data) {
    add_item(data['title'], data['text'], data['changetime'], data['id'])
}

function handle_update(data) {
    change_item(data['title'], data['text'], data['changetime'], data['id'])
}


function handle_delta(data) {
    $.each(data, function (index, item) {
        if (item['status'] === 'removed') {
            handle_remove(item['id']);
        } else {
            let changing_item = $(`#newsitem-${item['id']}`);
            if (changing_item.length) {
                handle_update(item);
            } else {
                handle_add(item);
            }
        }
    });
}

$(function () {
    window.latest_timestamp = 0;
    window.enable_autoreload = 1;

    $('#toggle_reload').on('click', function () {
        window.enable_autoreload = !window.enable_autoreload;
        return true;
    });

    setInterval(function () {
        if (window.enable_autoreload) {
            do_request();
        }
    }, 5000)
});