<?php


/*
|--------------------------------------------------------------------------
| Escape HTML
|--------------------------------------------------------------------------
*/

function e($value)
{
    return htmlspecialchars(
        $value ?? '',
        ENT_QUOTES,
        'UTF-8'
    );
}


/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

function redirect($url)
{
    header("Location: " . $url);
    exit;
}


/*
|--------------------------------------------------------------------------
| Upload Image
|--------------------------------------------------------------------------
*/

function uploadImage(
    $file,
    $uploadDirectory,
    $prefix = 'image'
) {

    /*
    |--------------------------------------------------------------------------
    | Check upload
    |--------------------------------------------------------------------------
    */

    if (
        !isset($file) ||
        $file['error'] === UPLOAD_ERR_NO_FILE
    ) {
        return [
            'success' => false,
            'filename' => null,
            'error' => null
        ];
    }


    if ($file['error'] !== UPLOAD_ERR_OK) {

        return [
            'success' => false,
            'filename' => null,
            'error' => 'Failed to upload image.'
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Maximum file size
    |--------------------------------------------------------------------------
    |
    | 5 MB
    |
    */

    $maxFileSize = 5 * 1024 * 1024;


    if ($file['size'] > $maxFileSize) {

        return [
            'success' => false,
            'filename' => null,
            'error' => 'Image size must not exceed 5 MB.'
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Validate MIME type
    |--------------------------------------------------------------------------
    */

    $allowedMimeTypes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ];


    $finfo = finfo_open(
        FILEINFO_MIME_TYPE
    );


    $mimeType = finfo_file(
        $finfo,
        $file['tmp_name']
    );


    finfo_close($finfo);


    if (!isset(
        $allowedMimeTypes[$mimeType]
    )) {

        return [
            'success' => false,
            'filename' => null,
            'error' => 'Only JPG, PNG, and WEBP images are allowed.'
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Generate unique filename
    |--------------------------------------------------------------------------
    */

    $extension =
        $allowedMimeTypes[$mimeType];


    $filename =
        $prefix .
        '_' .
        bin2hex(random_bytes(8)) .
        '.' .
        $extension;


    /*
    |--------------------------------------------------------------------------
    | Create directory if needed
    |--------------------------------------------------------------------------
    */

    if (!is_dir($uploadDirectory)) {

        mkdir(
            $uploadDirectory,
            0755,
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Move file
    |--------------------------------------------------------------------------
    */

    $destination =
        rtrim(
            $uploadDirectory,
            DIRECTORY_SEPARATOR
        )
        .
        DIRECTORY_SEPARATOR
        .
        $filename;


    if (!move_uploaded_file(
        $file['tmp_name'],
        $destination
    )) {

        return [
            'success' => false,
            'filename' => null,
            'error' => 'Failed to save uploaded image.'
        ];
    }


    return [
        'success' => true,
        'filename' => $filename,
        'error' => null
    ];
}