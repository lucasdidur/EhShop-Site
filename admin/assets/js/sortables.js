$(document).ready(function () {
    $(".categories").sortable({
        items: "> li[data-category-id]", axis: "y", handle: ".move", update: function (event, ui) {
            $.ajax({url: $(ui.item).data("url"), type: "POST", data: {orders: $(this).sortable("toArray", {attribute: "data-category-id"})}});
        }
    });
    $(".subcategories").sortable({
        items: "> li[data-category-id]", connectWith: ".subcategories", axis: "y", handle: ".move", update: function (event, ui) {
            var categoryID = $(ui.item).data("category-id");
            var parentCategoryID = $(ui.item).parents("li").data("category-id");
            if (ui.item.parent()[0] === this) {
                var orders = new Array();
                $(".subcategory").each(function () {
                    orders.push($(this).parent("li").data("category-id"));
                });
                $.ajax({url: $(ui.item).data("url"), type: "POST", data: {orders: orders, category: categoryID, parent: parentCategoryID}});
            }
        }
    });
    $(".packages").sortable({
        items: "> tr[data-package-id]", connectWith: ".packages", axis: "y", handle: ".move", update: function (event, ui) {
            if (ui.item.parent()[0] === this) {
                var packageID = $(ui.item).data("package-id");
                var categoryID = $(ui.item).closest("[data-category-id]").data("category-id");
                var placeholder = $(ui.item).siblings(':first');
                if (placeholder.data('package-id') == undefined) {
                    placeholder.remove();
                }
                var orders = new Array();
                $(".package").each(function () {
                    orders.push($(this).data("package-id"));
                });
                $.ajax({url: $(ui.item).data("url"), type: "POST", data: {orders: orders, package: packageID, category: categoryID}});
            }
            else {
                if ($(event.target).children('.package').length == 0) {
                    var categoryID = $(event.target).closest("[data-category-id]").data("category-id");
                    $(event.target).html('<tr><td colspan="2" class="empty">Drag a package here or <a href="/packages/add/0/' + categoryID + '">create one</a>.</td></tr>');
                }
            }
        }, helper: function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        }
    });
    $(".package-commands").sortable({items: "li", handle: ".command-move", axis: "y"});
    $(".variable-options").sortable({items: "tr", handle: ".options-move", axis: "y"})
    $(".modules").sortable({
        items: ".module", axis: "y", handle: ".move", update: function (event, ui) {
            $.ajax({url: $(ui.item).data("url"), type: "POST", data: {orders: $(".modules").sortable("toArray", {attribute: "data-id"})}});
        }
    });
    $(".gateways").sortable({
        items: ".gateway", axis: "y", handle: ".move", update: function (event, ui) {
            $.ajax({url: $(ui.item).data("url"), type: "POST", data: {orders: $(".gateways").sortable("toArray", {attribute: "data-id"})}});
        }
    });
});