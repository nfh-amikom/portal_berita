import './bootstrap';

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'summernote/dist/summernote-lite';

$(document).ready(function() {
    $('.summernote').summernote({
        lang: 'en-US',
        imageAttributes: {
            icon: '<i class="note-icon-pencil"/>',
            removeEmpty: false, // true = remove attributes | false = leave empty if present
            disableUpload: false // true = don't display Upload Options | Display Upload Options
        },
        popover: {
            image: [
                ['custom', ['imageAttributes']],
                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['style', 'ul', 'ol', 'paragraph', 'height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr', 'grid']],
            ['view', ['fullscreen', 'codeview', 'undo', 'redo', 'help']],
        ],
        grid: {
            wrapper: "row",
            columns: [
                "col-md-12",
                "col-md-6",
                "col-md-4",
                "col-md-3",
                "col-md-24",
            ]
        },
        callbacks: {
            onImageUpload: function (image) {
                sendFile(image[0]);
            },
            onMediaDelete: function (target) {
                deleteFile(target[0].src);
            }
        },
        icons: {
            grid: "bi bi-grid-3x2"
        },
        height: 300
    });

    function sendFile(file) {
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let data = new FormData();
        data.append("file", file);
        data.append('_token', token);
        
        // $('#loading-image-summernote').show(); // No loading indicator implemented yet
        $('.summernote').summernote('disable'); // Use .summernote as it's a class
        
        $.ajax({
            data: data,
            type: "POST",
            url: "/summernote/picture/upload/article", // Use Laravel route
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                console.log(url);
                if (url['status'] === "success") {
                    $('.summernote').summernote('enable');
                    // $('#loading-image-summernote').hide();
                    $('.summernote').summernote('editor.saveRange');
                    $('.summernote').summernote('editor.restoreRange');
                    $('.summernote').summernote('editor.focus');
                    $('.summernote').summernote('editor.insertImage', url['image_url']);
                } else {
                    alert(url['messages'].join('\\n'));
                }
                // $("img").addClass("img-fluid"); // Apply styling as needed in CSS
            },
            error: function (data) {
                console.log(data);
                $('.summernote').summernote('enable');
                // $('#loading-image-summernote').hide();
                alert('Error uploading image.');
            }
        });
    }

    function deleteFile(target) {
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let data = new FormData();
        data.append("target", target);
        data.append('_token', token);
        
        // $('#loading-image-summernote').show();
        $('.summernote').summernote('disable');
        
        $.ajax({
            data: data,
            type: "POST",
            url: "/summernote/picture/delete/article", // Use Laravel route
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                console.log(result);
                if (result['status'] === "success") {
                    $('.summernote').summernote('enable');
                    // $('#loading-image-summernote').hide();
                }
            },
            error: function (data) {
                console.log(data);
                $('.summernote').summernote('enable');
                // $('#loading-image-summernote').hide();
                alert('Error deleting image.');
            }
        });
    }
});
