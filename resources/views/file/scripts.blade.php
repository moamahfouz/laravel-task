
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#uploadForm').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: '{{ route('upload') }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#fileDetails').show();
                    $('#fileName').text('File name: ' + response.file_name);
                    $('#fileSize').text('File sizze: ' + response.file_size + ' bytes');
                    $('#fileExtension').text('file extension: ' + response.file_extension);
                    $('#encryptForm').data('filePath', response.file_path);
                }
            });
        });

        $('#encryptForm').on('submit', function (e) {
            e.preventDefault();
            let key = $('#key').val();
            let filePath = $(this).data('filePath');

            $.ajax({
                url: '{{ route('encrypt') }}',
                method: 'POST',
                data: { file_path: filePath, key: key, _token: '{{csrf_token()}}' },
                success: function (response) {
                    alert('file encrypted successfully.');
                    $('#decryptForm').show().data('filePath', response.encrypted_file_path);
                }
            });
        });

        $('#decryptForm').on('submit', function (e) {
            e.preventDefault();
            let key = $('#decryptKey').val();
            let filePath = $(this).data('filePath');

            $.ajax({
                url: '{{ route('decrypt') }}',
                method: 'POST',
                data: { file_path: filePath, key: key, _token: '{{csrf_token()}}' },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function (response, status, xhr) {
                    const filename = xhr.getResponseHeader('Content-Disposition').split('filename=')[1].replace(/"/g, '');
                    const url = window.URL.createObjectURL(new Blob([response]));
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    alert('file downloaded successfully.');
                }
            });
        });
    });
</script>
