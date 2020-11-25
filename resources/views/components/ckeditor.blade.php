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
                    'heading',
                    '|',
                    'fontSize',
                    'fontColor',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'indent',
                    'outdent',
                    '|',
                    'imageInsert',
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
                    'mergeTableCells',
                    'tableCellProperties',
                    'tableProperties'
                ]
            },
            licenseKey: '',

        } )
        .then( editor => {
            window.editor = editor;

        } )
        .catch( error => {
            console.error( error );
        } );
</script>

