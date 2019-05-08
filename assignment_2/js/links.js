function add_li(title, url, ul) {
    let li = $("<li>").on("click", function (e) {
        if ($("#mylinks").hasClass("deletemode")) {
            e.preventDefault(); // don't follow the link
            $(this).remove();
        }
    });
    let a = $("<a>")
        .text(title)
        .attr("href", url)
        .attr("target", "_blank");
    li.append(a);
    ul.append(li);
}

function create_ul() {
    // Create an unorderedlist with links to external websites
    const links = {
        "Google": "https://google.com",
        "Facebook": "https://facebook.com",
        "Nestor": "https://nestor.rug.nl",
    };

    let ul = $("<ul>");

    // for each link, create a new li item for the ul
    $.each(links, (key, value) => add_li(key, value, ul));

    $("#mylinks").append(ul);
}

function create_btn() {
    // Add a button to the page. If the button is pressed, the unordered list should fade out.
    // If it is pressed again, it should fade in.
    let btn = $("<button>")
        .text("toggle")
        .addClass("btn")
        .addClass("btn-primary")
        .addClass("dynamic")
        .on("click", function () {
            $("#mylinks ul").fadeToggle();
        });
    // place the button before the list
    $("#mylinks").prepend(btn);
}

function validate_link_form() {
    let title, url, ul;
    let success = true;
    let feedback = $("#feedback").text("");
    let feedbackText = "";
    ul = $("#mylinks ul");
    title = $("#myform input#input-name");
    url = $("#myform input#input-url");
    if (!title.val()) {
        title.addClass("form-control-danger");
        success = false;
        feedbackText += "Please fill in a title <br />";
    }
    if (!url.val()) {
        url.addClass("form-control-danger");
        success = false;
        feedbackText += "Please fill in an URL <br />";
    }
    if (success) {
        add_li(title.val(), url.val(), ul);
    } else {
        feedback.html(feedbackText);
    }
}


function create_input() {
    // Add two input fields and a button to the page.
    // One input field in which the user is able to enter a link name.
    // Another in which th euser is able to enter a URL.
    // If the user presses the button, the link should be added to the unordered list.
    // Make sure you’ll validate the user’s input: both fields should be filled in.
    let input_name, input_url, send_button, name_group, url_group;
    name_group = $("<div>");
    url_group = $("<div>");
    input_name = $("<input>")
        .attr("placeholder", "Link title")
        .attr("id", "input-name")
        .addClass("form-control");
    input_url = $("<input>")
        .attr("placeholder", "Link URL")
        .attr("id", "input-url")
        .addClass("form-control");
    send_button = $("<button>")
        .text("save")
        .addClass("btn")
        .addClass("btn-primary")
        .on("click", function () {
            validate_link_form();
        });
    name_group.append(input_name);
    url_group.append(input_url);
    $("#myform").append(name_group, url_group, send_button);
}


function create_delete_btn() {
    // Add another button to the page.
    // If this button is clicked, a delete mode should be activated.
    // This mode enhances that when an element in the DOM is clicked,
    // this element should be removed. If the user again presses the button,
    // the delete mode should be deactivated.
    const delete_on = "delete mode";
    const delete_off = "link mode";
    let btn = $("<button>")
        .text(delete_on)
        .addClass("btn")
        .addClass("btn-danger")
        .on("click", function () {
            $("#mylinks").toggleClass("deletemode");
            // toggle 'delete on' and 'delete off'
            let newtext = $(this).text() === delete_off ? delete_on : delete_off;
            $(this).text(newtext)
                .toggleClass("btn-danger")
                .toggleClass("btn-success");
        });
    // place the button before the list
    $("#mylinks").prepend(btn);


}


$(function () {
    create_delete_btn();
    create_ul();
    create_btn();
    create_input();
});