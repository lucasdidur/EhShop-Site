var count = 1;

function addCommand() {
    var clone = $("#package-command-template").clone();

    clone.attr("id", "");
    clone.find(".advanced").hide();
    clone.find(".command").attr("command_id", "");
    clone.find(".command").attr("placeholder", "");
    clone.find(':text').attr("value", "");

    clone.find('[name]').each(function () {
        this.name = this.name.replace('new_command[]', 'new_command[' + count + ']');
    });

    $(".package-commands li:last").after(clone);
    count++;
}

$("#add-package-command").click(function (e) {
    addCommand();
    e.preventDefault();
});

$(".package-commands").on("click", "li .delete-package-command", function (e) {
    var rowCount = $(".package-commands li").length;
    if (rowCount > 1) {
        var id_command = $(this).closest(".command").attr('command_id');
        $('#package_form').append('<input type="hidden" name="delete_command[]" value="' + id_command + '" />');
        $(this).closest(".command").remove();
    }
    e.preventDefault();
});

$(".package-commands").on("click", "li .edit-package-command", function (e) {
    var advancedBox = $(this).parents(".command").children(".advanced");
    if (advancedBox.is(":visible")) {
        advancedBox.hide();
    }
    else {
        //$(".package-commands .advanced").hide();
        advancedBox.show();
    }
    e.preventDefault();
});
