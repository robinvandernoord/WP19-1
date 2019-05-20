function delete_item(edit_id) {
    let changing_item = $(`#${edit_id}`);
    changing_item.slideUp(250, function () {
        // after sliding up, remove it
        $(this).remove();
    });
}

function handle_update(element, id) {
    element.load("scripts/read_latest_news.php?id=" + id);
}

function handle_add(id) {
    let new_element = $("<div>")
        .addClass("async-loader col col col-lg-4 col-md-6 d-flex col-sm-12 d-flex")
        .attr("id", id);

    // add to page
    $("#articles .row").prepend(new_element);
    handle_update(new_element, id);
}


function handle_delta(data) {
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
    window.latest_timestamp = 0;
    window.enable_autoreload = 1;


    $("#toggle_reload").on("click", function () {
        window.enable_autoreload = !window.enable_autoreload;
        return true;
    });

    // always do request first time
    do_request();

    setInterval(function () {
        if (window.enable_autoreload) {
            do_request();
        }
    }, 5000);
});