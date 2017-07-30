packageImageUpload = $('.package-image .upload-button');
packageImageRemove = $(".package-image .remove-button");
packageImagePreview = $(".package-image .image");
if ($("input[name=imageid]").val() == "") {
    packageImageUpload.show();
}
else {
    packageImageRemove.show();
}
$(".package-image .upload-button").fineUploader({
    uploaderType: 'basic',
    button: packageImageUpload[0],
    multiple: false,
    request: {
        endpoint: '/packages/uploadimage',
        inputName: "image",
        params: {packageID: packageImageUpload.data("package-id"), csrf: $('meta[name="csrf-token"]').attr('content')}
    },
    validation: {allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'], sizeLimit: 1048576},
    callbacks: {
        onError: function (id, name, reason, xhr) {
            showNotification("error", reason);
            packageImageUpload.button('reset');
        }, onSubmit: function (id, fileName) {
            packageImageUpload.button('loading');
        }, onComplete: function (id, fileName, responseJSON) {
            packageImagePreview.css("background", 'url(' + responseJSON.imageUrl + ') no-repeat center');
            $("input[name=imageid]").val(responseJSON.image);
            packageImageUpload.hide();
            packageImageRemove.show();
            packageImageUpload.button('reset');
            this.reset();
        }
    }
});
$(packageImageRemove).click(function () {
    imageId = $("input[name=imageid]").val();
    packageImageRemove.hide();
    packageImageUpload.show();
    packageImagePreview.css("background", 'url(/assets/img/empty.png) no-repeat center');
    $("input[name=imageid]").val("");
    $.ajax({type: 'POST', url: "/packages/removeimage", data: {image: imageId}, dataType: "json"});
});
    
    