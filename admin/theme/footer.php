<div class="advertisement"></div>

</div>
<div class="modal hide" id="popup-modal" tabindex="-1" role="dialog"></div>

<script src="<? echo URL ?>assets/js/jquery.min.js"></script>
<script src="<? echo URL ?>assets/js/jquery-ui.min.js"></script>


<script src="<? echo URL ?>assets/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/i18n/defaults-pt_BR.js"></script>

<script src="<? echo URL ?>admin/assets/js/bootstrap-slider.min.js"></script>
<script src="<? echo URL ?>admin/assets/js/sortables.js"></script>
<script src="<? echo URL ?>admin/assets/js/upload-image.js"></script>
<script src="<? echo URL ?>admin/assets/js/command.js"></script>
<script src="<? echo URL ?>assets/js/skin.min.js"></script>
<script src="<? echo URL ?>assets/js/site.js"></script>

<script>
    $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
    $("[multiple]").selectpicker();
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

</script>



</body>
</html>