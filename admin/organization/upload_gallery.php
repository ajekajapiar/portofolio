<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    redirect('index.php');

}


$organizationId = (int) (
    $_POST['organization_id'] ?? 0
);


$caption = trim(
    $_POST['caption'] ?? ''
);


if ($organizationId <= 0) {

    redirect('index.php');

}


/*
|--------------------------------------------------------------------------
| Check organization
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id
    FROM organization
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([
    $organizationId
]);


$organization =
    $stmt->fetch();


if (!$organization) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Organization not found.'
        )
    );

}


/*
|--------------------------------------------------------------------------
| Check files
|--------------------------------------------------------------------------
*/

if (
    !isset($_FILES['images']) ||
    !is_array($_FILES['images']['name'])
) {

    redirect(
        'gallery.php?id=' .
        $organizationId .
        '&error=' .
        urlencode(
            'No images selected.'
        )
    );

}


$uploadedCount = 0;

$errorMessages = [];


$totalFiles =
    count(
        $_FILES['images']['name']
    );


/*
|--------------------------------------------------------------------------
| Upload files
|--------------------------------------------------------------------------
*/

for (
    $i = 0;
    $i < $totalFiles;
    $i++
) {


    $file = [

        'name' =>
            $_FILES['images']['name'][$i],

        'type' =>
            $_FILES['images']['type'][$i],

        'tmp_name' =>
            $_FILES['images']['tmp_name'][$i],

        'error' =>
            $_FILES['images']['error'][$i],

        'size' =>
            $_FILES['images']['size'][$i]

    ];


    /*
    |--------------------------------------------------------------------------
    | Upload image
    |--------------------------------------------------------------------------
    */

    $uploadResult = uploadImage(

        $file,

        '../../assets/images/organization',

        'organization'

    );


    if (!$uploadResult['success']) {

        if (
            $uploadResult['error'] !== null
        ) {

            $errorMessages[] =
                $file['name'] .
                ': ' .
                $uploadResult['error'];

        }

        continue;

    }


    /*
    |--------------------------------------------------------------------------
    | Insert gallery record
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO organization_gallery
        (
            organization_id,
            image,
            caption
        )

        VALUES
        (
            ?,
            ?,
            ?
        )
    ");


    $stmt->execute([

        $organizationId,

        $uploadResult['filename'],

        $caption !== ''
            ? $caption
            : null

    ]);


    $uploadedCount++;

}


/*
|--------------------------------------------------------------------------
| Result
|--------------------------------------------------------------------------
*/

if ($uploadedCount > 0) {


    $message =
        $uploadedCount .
        ' photo(s) successfully uploaded.';


    if (count($errorMessages) > 0) {

        $message .=
            ' Some files could not be uploaded.';

    }


    redirect(
        'gallery.php?id=' .
        $organizationId .
        '&success=' .
        urlencode($message)
    );

}


$errorMessage =
    count($errorMessages) > 0
        ? implode(
            ' | ',
            $errorMessages
        )
        : 'No photos were uploaded.';


redirect(
    'gallery.php?id=' .
    $organizationId .
    '&error=' .
    urlencode($errorMessage)
);