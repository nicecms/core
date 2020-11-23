<script src="/js/ckeditor/ckeditor.js"></script>
<script>ClassicEditor
        .create( document.querySelector( '.editor' ), {
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
                    '|',
                    'heading',
                    'link',
                    'bold',
                    'italic',
                    'underline',
                    'fontColor',
                    'fontSize',
                    '|',
                    'indent',
                    'outdent',
                    'alignment',
                    '|',
                    'bulletedList',
                    'numberedList',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'undo',
                    'redo',
                    '|',
                    'htmlEmbed',
                    '|',
                    'removeFormat'
                ]
            },
            language: 'en',
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
                    'mergeTableCells'
                ]
            },
            licenseKey: '',

        } )
        .then( editor => {
            window.editor = editor;








        } )
        .catch( error => {
            console.error( 'Oops, something went wrong!' );
            console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
            console.warn( 'Build id: qtijbk8aztub-us2aenlmwq1w' );
            console.error( error );
        } );
</script>
