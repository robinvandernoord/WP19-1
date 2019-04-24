/* assignment 1 */

function make_title(page) {
    return `Webprogramming (LIX019P05) - ${page}`;
}

function capitalize(string) {
    if (typeof string !== "string") {
        /* make sure its a string */
        string = String(string);
    }
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function change_title() {
    // change the title of the page
    let page_name, current_page;
    /* use index as default for when you visit the folder: */
    page_name = window.location.href.split("/").slice(-1)[0].split(".")[0] || "index";
    current_page = capitalize(page_name);
    document.title = make_title(current_page);
    return current_page;
}

/* assignment 2 */
function add_article() {
    // add an article to the index page
    let new_article, new_heading, new_paragraph;

    new_article = document.createElement("article");

    new_heading = document.createElement("h1");
    new_heading.innerText = "Hello there";
    new_article.appendChild(new_heading);

    new_paragraph = document.createElement("p");
    new_paragraph.innerText = "De planning van de komende weken is als volgt:";
    new_article.appendChild(new_paragraph);

    document.getElementsByClassName("container")[0].appendChild(new_article);
    return new_article;
}

/* assignment 3 + 4 */
function change_footer() {
    // add a link to the footer and open it in a new tab
    let third_link = document.querySelectorAll("footer #myTabContent li a")[2];
    third_link.href = "https://google.com";
    third_link.target = "_blank";
}

/* assignment 5 */
function make_red() {
    // make the children of nav-item red
    /* nav-item doesn't make the text red, nav-link does */
    for (let element of document.getElementsByClassName("nav-link")) {
        element.style.color = "red";
    }
}

/* assignment 6 */
function make_object() {
    // create an object
    return {
        "Week 1": "Assignment 1",
        "Week 2": "No lecture",
        "Week 3": "Assignment 2",
        "Week 4": "-",
        "Week 5": "Assignment 3",
        "Week 6": "-",
        "Week 7": "Guest Lecture"
    };
}

function display_object(obj, element) {
    // show an object
    let newparagraph = document.createElement("p");
    let representation = "";
    for (let key in obj) {
        if (obj.hasOwnProperty(key)) {
            // make sure obj has this key with a value
            representation += `${key} | ${obj[key]} <br>`;
        }
    }
    newparagraph.innerHTML = representation;
    element.appendChild(newparagraph);
}

/* assignment 7 */
function wrap(el, wrapper) {
    // helper function to wrap an element in an other element
    // needed to create a 'row' around the columns for the sidebar
    el.parentNode.insertBefore(wrapper, el);
    wrapper.appendChild(el);
}

function add_sidebar() {
    // create a sidebar and wrap a row around the content and sidebar
    let container, new_sidebar, new_header, new_row, content, sidebar_article;
    container = document.querySelector(".container");
    content = container.querySelector(".col-md-12");
    /* change col-12 to col-8 */
    content.classList.replace("col-md-12", "col-md-8");

    /* new div element with col-md-4 */
    new_sidebar = document.createElement("div");
    new_sidebar.classList.add("col-md-4");
    /* add <article> for margin etc */
    sidebar_article = document.createElement("article");
    new_sidebar.append(sidebar_article);

    /* new heading */
    new_header = document.createElement("h1");
    new_header.innerText = "Sidebar";
    sidebar_article.appendChild(new_header);

    /* new row so the sidebar is actually next to the content */
    new_row = document.createElement("div");
    new_row.classList.add("row");
    wrap(content, new_row);
    new_row.appendChild(new_sidebar);
}

function main() {
    // main, execute all functions.
    let article_element, current_page, myobject;

    current_page = change_title();
    change_footer();
    make_red();
    myobject = make_object();
    if (current_page === "Index") {
        article_element = add_article();
        display_object(myobject, article_element);
    } else if (current_page === "Second") {
        add_sidebar();
    }
}

// start it all after the page has finished loading:
window.addEventListener("load", main);
