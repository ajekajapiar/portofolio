<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    redirect('index.php');

}


$experienceId = (int) (
    $_POST['experience_id'] ?? 0
);


$caption = trim(
    $_POST['caption'] ?? ''
);


if ($experienceId <= 0) {

    redirect('index.php');

}


/*
|--------------------------------------------------------------------------
| Check experience
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id
    FROM experience
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([
    $experienceId
]);


$experience =
    $stmt->fetch();


if (!$experience) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Experience not found.'
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
        $experienceId .
        '&error=' .
        urlencode(
            'No images selected.'
        )
    );

}


$uploadedCount = 0;

$errorMessages = [];


/*
|--------------------------------------------------------------------------
| Upload each image
|--------------------------------------------------------------------------
*/

$totalFiles =
    count(
        $_FILES['images']['name']
    );


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
    | Upload
    |--------------------------------------------------------------------------
    */

    $uploadResult = uploadImage(

        $file,

        '../../assets/images/experience',

        'experience'

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
        INSERT INTO experience_gallery
        (
            experience_id,
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

        $experienceId,

        $uploadResult['filename'],

        $caption !== ''
            ? $caption
            : null

    ]);


    $uploadedCount++;

}


/*
|--------------------------------------------------------------------------
| Result message
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
        $experienceId .
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
    $experienceId .
    '&error=' .
    urlencode($errorMessage)
);