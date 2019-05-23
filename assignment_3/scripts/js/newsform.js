// js for the forms on 'add news' and 'edit news'.
// Makes the image upload fancy and enables the deletion of news items

$(function () {
    $("#delete-entry").on("click", function () {
        if (confirm("Are you sure you want to remove this news item?")) {
            $.ajax("scripts/news_remove.php?id=" + $("#id").val(), {
                "success": function () {
                    window.location.href = "index.php";
                },
            });
        }
    });

    $("#picupload").change(function () {
        let fileName = this.files[0].name;
        $("#picuploadlabel").text(fileName);
    });
});