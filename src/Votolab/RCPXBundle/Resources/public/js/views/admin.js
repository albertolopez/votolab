tinymce.init({
    selector: "textarea",
    height: 300,
    content_css : tinymce_stylesheet + ",http://fonts.googleapis.com/css?family=Open+Sans",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
