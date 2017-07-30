

$(document).ready(function () {
    $('body').tooltip({
        selector: "[data-tooltip=tooltip]",
        container: "body"
    });
});

$(document).ready(function () {
    notification.clear();

    $(".mc-skin").minecraftSkin({scale: 2});

    $(".toggle-tooltip").tooltip();

    $(".toggle-modal").on("click", function (e) {
        remote = $(this).data("remote");

        $.ajax({
            url: remote,
            success: function (data) {
                $('#popup-modal').html(data);
                $('#popup-modal').modal("show");
            },
            async: true
        });

        e.preventDefault();
    });

    $(document.body).on("submit", ".checkout form.gateway", function () {
        var form = $(this);
        var button = $(form).find("button[type=submit]");

        button.button("Carregando...");
        waitingDialog.show("Processando Pedido");

        $.ajax({
            type: 'POST',
            url: form.attr("action"),
            data: form.serialize(),
            dataType: "json",
            success: function (json) {
                if (json.type == "error") {
                    waitingDialog.hide();
                    notification.show("danger", json.message);
                    button.button("reset");
                }
                else if (json.type == "success") {
                    $("#payment").html("");
                    setTimeout(function ()
                    {
                        $("#payment").append("<h4><a href='" + json.data + "'>Clique aqui para fazer o pagamento</a></h4>");
                        button.button("reset");
                    }, 2000);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.responseText);
                alert(thrownError);

                waitingDialog.hide();
                notification.show("danger", "Nós nao conseguimos enviar para o portal de pagamento - por favor, atualize a página e tente novamente.");
                button.button("reset");
            }
        });

        return false;
    });
});

notification = new function () {
    this.show = function (type, message) {
        clearTimeout(this.timeout);

        $(".notification").empty().append('<div class="alert alert-' + type + ' alert-dismissable"></div>');
        $(".notification .alert").append('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').append(message);

        $("html, body").animate({scrollTop: $("body").offset().top}, "fast");

        this.clear();
    }

    this.clear = function () {
        this.timeout = window.setTimeout(function () {
            $(".alert").fadeTo(200, 0).slideUp(200, function () {
                $(this).remove();
            });
        }, 5000);
    }
};

var waitingDialog = waitingDialog || (function ($) {
        'use strict';

        // Creating modal dialog's DOM
        var $dialog = $(
            '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:5%; overflow-y:visible;">' +
            '<div class="modal-dialog modal-m">' +
            '<div class="modal-content">' +
            '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h3 style="margin:0; text-align:center"></h3></div>' +
            '<div class="modal-body">' +
            '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
            '<div style="padding:15px">' +
            '<h4>Seu pedido esta sendo processado, em breve será redireciona do para o portal de pagamento. Enquanto isso, lembre-se: </h4>' +
            '<ul>' +
            '<li>Seu benefício é <strong>ativado automaticamente</strong> após a confirmação de pagamento (instantaneamente até 3 dias úteis).</li>' +
            '<li>Caso encontre algum problema, contate-nos usando o live chat no canto inferior dessa página.</li>' +
            '<li>Todos os pedidos são <strong>intransferíveis</strong>.</li>' +
            '<li>Você ainda precisa seguir as regras do servidor.</li>' +
            '<li><strong>A sua ajuda é de suma importância para a Manutenção do servidor</strong>.</li>' +
            '<li>Isso não é uma compra, e sim uma doação. <strong>Ao fazer o pagamento, você concorda com estes termos.</strong></li>' +
            '</ul>' +
            '<hr>' +
            '<div id="payment" class="text-center"">' +

            '</div>' +
            '</div>' +
            '</div>' +
            '</div></div></div>');

        return {
            /**
             * Opens our dialog
             * @param message Custom message
             * @param options Custom options:
             *                  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
             *                  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
             */
            show: function (message, options) {


                // Assigning defaults
                if (typeof options === 'undefined') {
                    options = {};
                }
                if (typeof message === 'undefined') {
                    message = 'Loading';
                }
                var settings = $.extend({
                    dialogSize: 'm',
                    progressType: '',
                    onHide: null // This callback runs after the dialog was hidden
                }, options);

                // Configuring dialog
                $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
                $dialog.find('.progress-bar').attr('class', 'progress-bar');
                if (settings.progressType) {
                    $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
                }
                $dialog.find('h3').text(message);
                // Adding callbacks
                if (typeof settings.onHide === 'function') {
                    $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                        settings.onHide.call($dialog);
                    });
                }
                // Opening dialog
                $dialog.modal();
            },
            /**
             * Closes dialog
             */
            hide: function () {
                $dialog.modal('hide');
            }
        };

    })(jQuery);