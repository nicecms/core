<script src="/js/ckeditor/ckeditor.js"></script>
<script>

    $('.editor').each(function(){

        ClassicEditor
            .create( this, {

                simpleUpload: {
                    // The URL that the images are uploaded to.
                    uploadUrl: '{{config('ckeditor-upload.upload_url')}}',

                    // Enable the XMLHttpRequest.withCredentials property.
                    withCredentials: true,

                    // Headers sent along with the XMLHttpRequest to the upload server.
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    }
                },
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'fontBackgroundColor',
                        'fontColor',
                        'fontSize',
                        '|',
                        'bold',
                        'italic',
                        'underline',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'subscript',
                        'superscript',
                        '|',
                        'alignment',
                        'indent',
                        'outdent',
                        '|',
                        'imageUpload',
                        'blockQuote',
                        'insertTable',
                        'mediaEmbed',
                        'htmlEmbed',
                        '|',
                        'removeFormat',
                        '|',
                        'undo',
                        'redo'
                    ]
                },
                language: 'ru',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:full',
                        'imageStyle:side',
                        'linkImage'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                        'tableCellProperties',
                        'tableProperties'
                    ]
                },
                licenseKey: '',

            } )
            .then( editor => {
                // window.editor = editor;

            } )
            .catch( error => {
                console.error( error );
            } );

    })


</script>

