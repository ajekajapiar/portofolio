<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    redirect('index.php');

}


$projectId = (int) (
    $_POST['project_id'] ?? 0
);


$caption = trim(
    $_POST['caption'] ?? ''
);


if ($projectId <= 0) {

    redirect('index.php');

}


/*
|--------------------------------------------------------------------------
| Check project
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id
    FROM projects
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([
    $projectId
]);


$project =
    $stmt->fetch();


if (!$project) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Project not found.'
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
        $projectId .
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
| Upload each image
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
    | Upload
    |--------------------------------------------------------------------------
    */

    $uploadResult = uploadImage(

        $file,

        '../../assets/images/projects',

        'project'

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
    | Insert gallery
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO project_gallery
        (
            project_id,
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

        $projectId,

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
        $projectId .
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
    $projectId .
    '&error=' .
    urlencode($errorMessage)
);