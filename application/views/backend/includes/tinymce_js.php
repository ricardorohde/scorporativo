<script src="<?=base_url()?>js/vendor/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: "textarea:not(.mceNoEditor)",
    deseselector: "mceNoEditor",
    theme: "modern",
    plugins: [
        "autolink lists link preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor"
    ],
    toolbar1: "undo redo | styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
    //toolbar2: "print preview media | emoticons",
    image_advtab: true,
    entity_encoding : "raw",
    language: "pt_BR",
    element_format : "html"
});
</script>