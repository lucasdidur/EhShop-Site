<div class="advertisement"></div>

</div>
<div class="modal hide" id="popup-modal" tabindex="-1" role="dialog"></div>

<script src="<? echo URL ?>assets/js/jquery.min.js"></script>
<script src="<? echo URL ?>assets/js/jquery-ui.min.js"></script>

<script src="<? echo URL ?>assets/js/bootstrap.min.js"></script>

<script src="<? echo URL ?>assets/js/ckeditor/ckeditor.js"></script>
<script src="<? echo URL ?>assets/js/ckeditor/config.js"></script>

<script src="<? echo URL ?>assets/js/trumbowyg/trumbowyg.min.js"></script>
<script src="<? echo URL ?>assets/js/trumbowyg/langs/pt.min.js"></script>
<script src="<? echo URL ?>assets/js/trumbowyg/plugins/base64/trumbowyg.base64.js"></script>
<script src="<? echo URL ?>assets/js/trumbowyg/plugins/colors/trumbowyg.colors.js"></script>
<script src="<? echo URL ?>assets/js/trumbowyg/plugins/noembed/trumbowyg.noembed.js"></script>
<script src="<? echo URL ?>assets/js/trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.js"></script>
<script src="<? echo URL ?>assets/js/trumbowyg/plugins/preformatted/trumbowyg.preformatted.js"></script>
<script src="<? echo URL ?>assets/js/trumbowyg/plugins/upload/trumbowyg.upload.js"></script>

<script src="<? echo URL ?>admin/assets/js/bootstrap-slider.min.js"></script>
<script src="<? echo URL ?>admin/assets/js/sortables.js"></script>
<script src="<? echo URL ?>admin/assets/js/command.js"></script>
<script src="<? echo URL ?>assets/js/skin.min.js"></script>
<script src="<? echo URL ?>assets/js/site.js"></script>

<script>
    $(document).ready(function () {
        $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
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
                    $('[multiple]').selectpicker('refresh');
                }, async: true
            });
            e.preventDefault();
        });

        var configurations = {
            lang: 'pt',
            btnsDef: {
                // Customizables dropdowns
                image: {
                    dropdown: ['insertImage', 'upload', 'base64', 'noEmbed'],
                    ico: 'insertImage'
                }
            },
            btns: [
                ['viewHTML'],
                ['undo', 'redo'],
                ['formatting'],
                'btnGrp-design',
                ['link'],
                ['image'],
                'btnGrp-justify',
                'btnGrp-lists',
                ['foreColor', 'backColor'],
                ['preformatted'],
                ['horizontalRule'],
                ['fullscreen']
            ],
            plugins: {
                // Add imagur parameters to upload plugin
                upload: {
                    serverPath: '<?= URL ?>resource/trumbowyg.upload.php',
                    fileFieldName: 'image',
                    urlPropertyName: 'data.link'
                }
            }
        };

        $('.trumbowyg').trumbowyg(configurations);
    });

    var ckconfig =
    {
        contentsCss:
            [
                CKEDITOR.getUrl('css/contents.css'),
                '/assets/css/ckeditor-book.css',
            ],
        colorButton_colors: 'black/000000,dark_blue/0000AA,dark_green/00AA00,dark_aqua/00AAAA,dark_red/AA0000,dark_purple/AA00AA,gold/FFAA00,gray/AAAAAA,dark_gray/555555,blue/5555FF,green/55FF55,aqua/55FFFF,red/FF5555,light_purple/FF55FF,yellow/FFFF55,white/FFFFFF',

        removePlugins: 'mclink,mchover,selector,scoreboard',
        language: 'en',
        height: 400,
    };

    var ck_book = CKEDITOR.replace('description', ckconfig);

</script>

<script>
    $("#submit_button").on("click", function (e) {

        var form = $("#package_form");
        var button = $(this);

        $("#gui_description").val(CKEDITOR.instances.description.getData());

        button.html("Enviando...");

        $.ajax({
            type: 'POST',
            url: form.attr("action"),
            data: form.serialize(),
            dataType: "json",
            success: function (json) {
                if (json.type == "error") {
                    //notification.show("danger", json.message);
                    button.button("reset");
                }
                else if (json.type == "success") {

                    if(json.action == "edit")
                    {
                        button.html("Atualizado");

                        setTimeout(function (){button.html(" Atualizar item")}, 1000);
                    }

                    if(json.action == "add")
                    {
                        var r = confirm("Adicionar outro?");
                        if (r == true) {
                            button.html("Adicionado ID: " + json.id);

                            setTimeout(function (){button.html("Adicionar")}, 3000);
                        } else {
                            window.location =  window.location +"?id=" + json.id;
                        }
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.responseText);

                //notification.show("danger", "Nao foi possivel atualizar/adicionar");
                button.button("reset");
            }
        });

        return false;
    });
</script>


</body>
</html>