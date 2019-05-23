// js that manages the loading of news items

function delete_item(edit_id) {
    // remove item from page with animation
    let changing_item = $(`#${edit_id}`);
    changing_item.slideUp(250, function () {
        // after sliding up, remove it
        $(this).remove();
    });
}

function handle_update(element, id) {
    // jquery load a news item from the read_latest_news php script
    element.load("scripts/read_latest_news.php?id=" + id);
}

function handle_add(id) {
    // create a new element and load the content
    let new_element = $("<div>")
        .addClass("async-loader col col col-lg-4 col-md-6 d-flex col-sm-12 d-flex")
        .attr("id", id);

    // add to page
    $("#articles .row").prepend(new_element);
    handle_update(new_element, id);
}


function handle_delta(data) {
    // do what needs to be done with the changes we got from the server
    $.each(data, function (id, meta_info) {
        if (meta_info["status"] === "removed") {
            delete_item(id);
        } else {
            let changing_item = $("#" + id);
            if (changing_item.length) {
                handle_update(changing_item, id);
            } else {
                handle_add(id);
            }
        }
    });
}

function do_request() {
    // get the changed ids from the server and make the handler process it
    $.ajax("scripts/read_latest_news.php?timestamp=" + window.latest_timestamp,
        {
            "success": function (result) {
                if (result["length"] > 0) {
                    window.latest_timestamp = result["last_timestamp"];
                    handle_delta(result["items"]);
                    return true;
                }
            },
            // 'error': function(e){console.error(e)}
        });
}

$(function () {
    // global settings
    window.latest_timestamp = 0;
    window.enable_autoreload = 1;

    // disable auto loading of posts
    $("#toggle_reload").on("click", function () {
        window.enable_autoreload = !window.enable_autoreload;
        return true;
    });

    // always do request first time
    do_request();

    setInterval(function () {
        if (window.enable_autoreload) {  // every 5 seconds, look for changes
            do_request();
        }
    }, 5000);
});