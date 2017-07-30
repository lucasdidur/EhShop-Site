$(document).ready(function () {
    $('.trumbowyg').trumbowyg();
    $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
    $(".selectpicker").selectpicker();
    $("a[data-toggle='tooltip']").tooltip();
    $("a[data-toggle='popover']").popover({container: "body", trigger: "hover"});
    $('.slider').slider();
    $("a[data-toggle='popover']").on("mouseout", function (e) {
        $(this).popover("hide");
    });
    $(".toggle-modal").on("click", function (e) {
        remote = $(this).data("remote");
        $.ajax({
            url: remote, success: function (data) {
                $('#popupModal').html(data);
                $('#popupModal').modal("show");
                $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
                $('.selectpicker').selectpicker('refresh');
            }, async: true
        });
        e.preventDefault();
    });
    $("form").live("submit", function (e) {
        form = $(this);
        if (form.data("ignore") != null)return;
        var submit = form.find("input[type='submit']");
        submit.data("loading-text", "Loading...");
        submit.button('loading');
        $.ajax({
            type: 'POST', url: form.attr("action"), data: form.serialize(), dataType: "json", success: function (data) {
                if (data.type == 'success' && data.success_url != data.error_url) {
                    window.location.replace(data.success_url);
                }
                else {
                    if (form.data("clear") != null) {
                        form.each(function () {
                            this.reset();
                        });
                    }
                    if (data.type == "error" || data.message != "") {
                        submit.button('reset');
                        showNotification(data.type, data.message);
                    }
                    else {
                        submit.removeClass("btn-primary");
                        submit.addClass("btn-success");
                        submit.attr("value", "Saved");
                        setTimeout(function () {
                            submit.removeClass("btn-success");
                            submit.addClass("btn-primary");
                            submit.button('reset');
                        }, 1500);
                    }
                }
            }, error: function (data) {
                submit.button('reset');
                showNotification("error", "Error - please reload the page and try submitting the form again.");
            }
        });
        e.preventDefault();
    });
    $("#add-package-command").click(function (e) {
        clone = $("#package-command-template").clone();
        clone.find(".advanced").hide();
        clone.find(".command").attr("placeholder", "");
        clone.find(':text').attr("value", "");
        clone.find(".advanced .command-require-online").val("1");
        clone.find(".advanced .command-repeat").val("0");
        clone.find(".advanced .command-delay").val("0");
        clone.find(".advanced .repeat-period-input").attr("readonly", "readonly").val("0");
        clone.find(".advanced .repeat-cycle-input").attr("readonly", "readonly").val("0");
        $(".package-commands li:last").after(clone);
        e.preventDefault();
    });
    $(".package-commands").on("click", "li .delete-package-command", function (e) {
        rowCount = $(".package-commands li").length;
        if (rowCount > 1) {
            $(this).closest(".command").remove();
        }
        e.preventDefault();
    });
    $(".package-commands").on("click", "li .edit-package-command", function (e) {
        advancedBox = $(this).parents(".command").children(".advanced");
        if (advancedBox.is(":visible")) {
            advancedBox.hide();
        }
        else {
            $(".package-commands .advanced").hide();
            advancedBox.show();
        }
        e.preventDefault();
    });
    $(".command-repeat").live("change", function (event) {
        if ($(this).val() == "0") {
            $(".repeat-period-input, .repeat-cycle-input").attr("readonly", "readonly");
        }
        else {
            $(".repeat-period-input, .repeat-cycle-input").removeAttr("readonly");
        }
    });

    if (!$('#custom-domain-checkbox').is(':checked'))$('.custom-domain-input').hide();
    if ($('#custom-domain-checkbox').is(':checked'))$('.subdomain-input').hide();
    $('#custom-domain-checkbox').change(function () {
        if ($(this).is(':checked')) {
            $(".subdomain-input").slideUp();
            $('.custom-domain-input').slideDown();
        }
        else {
            $(".subdomain-input").slideDown();
            $('.custom-domain-input').slideUp();
        }
    });
    if ($(".coupon-effective-upon").val() != "package")$(".coupon-effective-package").hide();
    if ($(".coupon-effective-upon").val() != "category")$(".coupon-effective-category").hide();
    $('.coupon-effective-upon').change(function () {
        $(".coupon-effective-package").hide();
        $(".coupon-effective-category").hide();
        if ($(this).val() == "package") {
            $(".coupon-effective-package").show();
        }
        if ($(this).val() == "category") {
            $(".coupon-effective-category").show();
        }
    });
    if ($('.coupon-discount-type').val() != "percentage")$('.coupon-discount-percentage').hide();
    if ($('.coupon-discount-type').val() != "value")$('.coupon-discount-amount').hide();
    $('.coupon-discount-type').change(function () {
        $('.coupon-discount-amount').hide();
        $('.coupon-discount-percentage').hide();
        switch ($(this).val()) {
            case"percentage":
                $('.coupon-discount-percentage').show();
                break;
            case"value":
                $('.coupon-discount-amount').show();
                break;
        }
    });
    if ($('.coupon-expiry-type').val() != "limit")$('.coupon-redeem-limit').hide();
    if ($('.coupon-expiry-type').val() != "timestamp")$('.coupon-expire-date').hide();
    $('.coupon-expiry-type').change(function () {
        $('.coupon-redeem-limit').hide();
        $('.coupon-expire-date').hide();
        switch ($(this).val()) {
            case"timestamp":
                $('.coupon-expire-date').show();
                break;
            case"limit":
                $('.coupon-redeem-limit').show();
                break;
        }
    });
    if ($(".sale-effective-upon").val() != "package")$(".sale-effective-package").hide();
    if ($(".sale-effective-upon").val() != "category")$(".sale-effective-category").hide();
    $('.sale-effective-upon').change(function () {
        $(".sale-effective-package").hide();
        $(".sale-effective-category").hide();
        if ($(this).val() == "package") {
            $(".sale-effective-package").show();
        }
        if ($(this).val() == "category") {
            $(".sale-effective-category").show();
        }
    });
    if ($('.sale-discount-type').val() != "percentage")$('.sale-discount-percentage').hide();
    if ($('.sale-discount-type').val() != "amount")$('.sale-discount-amount').hide();
    $('.sale-discount-type').change(function () {
        $('.sale-discount-amount').hide();
        $('.sale-discount-percentage').hide();
        switch ($(this).val()) {
            case"percentage":
                $('.sale-discount-percentage').show();
                break;
            case"amount":
                $('.sale-discount-amount').show();
                break;
        }
    });
    $(".payment-search select[name=search_type]").live("change", function (event) {
        option = $(this).val();
        $(".payment-search .input").children().hide();
        $(".payment-search .input").find('input,select').attr('disabled', true);
        switch (option) {
            case"package":
                $(".payment-search .input .packages").show().find("select").removeAttr("disabled");
                break;
            case"category":
                $(".payment-search .input .categories").show().find("select").removeAttr("disabled");
                break;
            case"coupon":
                $(".payment-search .input .coupons").show().find("select").removeAttr("disabled");
                break;
            case"variable":
                $(".payment-search .input .variables").show().find("select").removeAttr("disabled");
                break;
            case"status":
                $(".payment-search .input .statuses").show().find("select").removeAttr("disabled");
                break;
            case"gateway":
                $(".payment-search .input .gateways").show().find("select").removeAttr("disabled");
                break;
            default:
                $(".payment-search .input .text").show().find("input").removeAttr("disabled")
                break;
        }
        $('.selectpicker').selectpicker('refresh');
    });
    $(".subaccount-radio input").live("change", function (event) {
        parent = $(this).closest("td");
        if ($(this).attr("checked") != "checked") {
            $(parent).removeClass("success");
            $(parent).addClass("danger");
        }
        else {
            $(parent).removeClass("danger");
            $(parent).addClass("success");
        }
    });
    $(".category-cumulative-checkbox").live("change", function (event) {
        if ($(this).is(':checked')) {
            $(".category-disable-lower").show();
        }
        else {
            $(".category-disable-lower").hide();
        }
    });
    if ($("#gateway-offset-type").val() != "both" && $("#gateway-offset-type").val() != "fixed")$("#gateway-offset-amount").hide();
    if ($("#gateway-offset-type").val() != "both" && $("#gateway-offset-type").val() != "percentage")$("#gateway-offset-percentage").hide();
    $("#gateway-offset-type").live("change", function (event) {
        $("#gateway-offset-amount").hide();
        $("#gateway-offset-percentage").hide();
        if ($(this).val() == "both" || $(this).val() == "fixed") {
            $("#gateway-offset-amount").show();
        }
        if ($(this).val() == "both" || $(this).val() == "percentage") {
            $("#gateway-offset-percentage").show();
        }
    });
    $('#variables-dropdown-add').click(function () {
        tr = $('#dropdown-template');
        clone = tr.clone();
        clone.find(':text').val('');
        $('#variable-dropdown-table tr:last').after(clone);
        return false;
    });
    $("#variables-dropdown-remove").live('click', function (event) {
        rowCount = $('#variable-dropdown-table >tbody >tr').length;
        if (rowCount > 1) {
            $(this).parents('tr').remove();
        }
        return false;
    });
    if ($('#variable-type-selection').val() != 'dropdown')$('.variable-options').hide();
    if ($('#variable-type-selection').val() == 'dropdown' || $('#variable-type-selection').val() == 'username' || $('#variable-type-selection').val() == 'email')$('.variable-input-type').hide();
    $('#variable-type-selection').change(function () {
        if ($('#variable-type-selection').val() == 'dropdown') {
            $('.variable-options').show();
        }
        if ($('#variable-type-selection').val() == 'dropdown' || $('#variable-type-selection').val() == 'username' || $('#variable-type-selection').val() == 'email') {
            $('.variable-input-type').hide();
        }
        if ($('#variable-type-selection').val() != 'dropdown') {
            $('.variable-options').hide();
            if ($('#variable-type-selection').val() != "username" && $('#variable-type-selection').val() != "email") {
                $('.variable-input-type').show();
            }
        }
    });
    $(".ckeditor").ckeditor({
        filebrowserUploadUrl: '/wysiwyg/upload',
        uiColor: '#EDEDED',
        extraPlugins: 'youtube',
        allowedContent: true,
        height: 150,
        toolbar: [{name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source']}, {
            name: 'clipboard',
            groups: ['undo'],
            items: ['Undo', 'Redo']
        }, {
            name: 'basicstyles',
            groups: ['basicstyles', 'cleanup'],
            items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat']
        }, {
            name: 'paragraph',
            groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
            items: ['NumberedList', 'BulletedList', '-', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
        }, {name: 'links', items: ['Link', 'Unlink']}, {name: 'insert', items: ['Image', 'Table', 'SpecialChar', "Youtube"]}, {
            name: 'styles',
            items: ['Format', 'Font', 'FontSize']
        }, {name: 'colors', items: ['TextColor', 'BGColor']}, {name: 'tools', items: ['Maximize']}, {name: 'others', items: ['-']}]
    });

    $("#tax-rate-country").change(function () {
        countryID = $(this).val();
        $("#tax-rate-state").attr("disabled", "disabled");
        $("#tax-rate-state").find("option").remove();
        $("#tax-rate-state").append('<option value="">Apply to all in selected country.</option>');
        $.ajax({
            type: 'POST', url: "/tax/states", data: {country: countryID}, dataType: "json", success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    $("#tax-rate-state").append('<option value="' + data[i]['id'] + '">' + data[i]['name'] + '</option>');
                }
                $("#tax-rate-state").removeAttr("disabled");
            }
        });
    });
    $(".webstore-logo .remove-button").click(function () {
        $(".webstore-logo .remove-button").button("loading");
        $.ajax({
            type: 'POST', url: "/design/logo", data: {action: "delete"}, success: function () {
                $(".webstore-logo .image p").show();
                $(".webstore-logo .image span").hide();
                $(".webstore-logo .remove-button").button("reset").hide();
                $('.webstore-logo .upload-button').show();
            }
        });
    });
    $('.webstore-logo .upload-button').fineUploader({
        uploaderType: 'basic',
        button: $('.webstore-logo .upload-button')[0],
        multiple: false,
        request: {endpoint: '/design/logo', inputName: "image", params: {action: "upload", csrf: $('meta[name="csrf-token"]').attr('content')}},
        validation: {allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'], sizeLimit: 1048576},
        callbacks: {
            onError: function (id, name, reason, xhr) {
                showNotification("error", reason);
                $('.webstore-logo .upload-button').button('reset');
            }, onSubmit: function (id, fileName) {
                $('.webstore-logo .upload-button').button('loading');
            }, onComplete: function (id, fileName, responseJSON) {
                $(".webstore-logo .image img").attr("src", responseJSON.imageUrl);
                $(".webstore-logo .image p").hide();
                $(".webstore-logo .image span").show();
                $('.webstore-logo .upload-button').button("reset").hide();
                $(".webstore-logo .remove-button").show();
                this.reset();
            }
        }
    });
    $(".pricing-table .plan-action a.slidedown").click(function () {
        $(".pricing-table .plan-action .prepay").slideUp("fast");
        $(".pricing-table .plan-action a").slideDown("fast");
        $(this).parent(".plan-action").children(".prepay").slideDown("fast");
        $(this).slideUp("fast");
        return false;
    });
    $("input[name=fraud-recharge]").change(function () {
        if (!this.checked) {
            $(".fraud-recharge-form input").attr("disabled", "disabled");
            $(".fraud-recharge-form input[name=recharge], .fraud-recharge-form input[name=minimum]").val(0).trigger("keyup");
        }
        else {
            $(".fraud-recharge-form input").removeAttr("disabled");
            $(".fraud-recharge-form input[name=recharge]").val(50).trigger("keyup");
            $(".fraud-recharge-form input[name=minimum]").val(10);
        }
    });
    $(".fraud-recharge-form input[name=recharge]").keyup(function (e) {
        if (/\D/g.test(this.value)) {
            this.value = this.value.replace(/\D/g, '');
        }
        var price = (0.04 * $(this).val());
        $(".fraud-recharge-form .input-group-addon").html("£" + price.toFixed(2));
    });
});

function showNotification(type, message) {
    $.doTimeout("notification-bar");
    if (type == "error")type = "danger";
    $('#popupModal').modal('hide');
    $("html, body").animate({scrollTop: 0}, "fast");
    $(".notification-bar").removeClass("alert-success alert-danger alert-info alert-warning");
    $(".notification-bar").addClass("alert-" + type);
    $(".notification-bar").slideDown("fast");
    $(".notification-bar").html(message);
    $.doTimeout("notification-bar", 7500, function () {
        $(".notification-bar").slideUp();
    });
}

function randomString(length) {
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var randomString = '';
    for (var i = 0; i < length; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        randomString += chars.substring(rnum, rnum + 1);
    }
    return randomString;
}