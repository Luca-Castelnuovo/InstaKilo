FilePond.registerPlugin(
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType,
    FilePondPluginImageExifOrientation,
    FilePondPluginImageCrop,
    FilePondPluginImageTransform
);

FilePond.setOptions({
    maxFileSize: "5MB",
    acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
    imageCropAspectRatio: "1:1",
    server: "/includes/upload.php"
});

var pond = FilePond.create(document.querySelector('input[type="file"]'));

var upload_btn = document.querySelector("button.btn-large");
var caption_input = document.querySelector("#caption");
upload_btn.disabled = true;
var pond_instance = document.querySelector(".filepond--root");
pond_instance.addEventListener("FilePond:processfile", e => {
    if (e.detail.error !== null) {
        M.toast({
            html: "Please reupload image"
        });
    }

    upload_btn.disabled = false;
});
