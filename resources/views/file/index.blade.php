<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Encryption</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">File Encryption</h1>
    <div class="card">
        <div class="card-body">
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Select File</label>
                    <input type="file" class="form-control" id="file" name="file" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>

    <div class="card mt-3" id="fileDetails" style="display: none;">
        <div class="card-body">
            <h5>File Details</h5>
            <p id="fileName"></p>
            <p id="fileSize"></p>
            <p id="fileExtension"></p>

            <form id="encryptForm">
                @csrf
                <div class="form-group">
                    <label for="key">Encryption Key (32 characters)</label>
                    <input type="text" class="form-control" id="key" name="key" required maxlength="32" minlength="32">
                </div>
                <button type="submit" class="btn btn-primary">Encrypt</button>
            </form>

            <form id="decryptForm" style="display: none;">
                @csrf
                <div class="form-group">
                    <label for="decryptKey">Decryption Key (32 characters)</label>
                    <input type="text" class="form-control" id="decryptKey" name="decryptKey" required maxlength="32"
                           minlength="32">
                </div>
                <button type="submit" class="btn btn-secondary mt-2">Decrypt</button>
            </form>
        </div>
    </div>
</div>

@include('file.scripts')

</body>
</html>
