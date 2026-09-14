<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


$id = (int) (
    $_GET['id'] ?? 0
);


$experienceId = (int) (
    $_GET['experience_id'] ?? 0
);


if (
    $id <= 0 ||
    $experienceId <= 0
) {

    redirect('index.php');

}


/*
|--------------------------------------------------------------------------
| Get image
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT image
    FROM experience_gallery
    WHERE id = ?
    AND experience_id = ?
    LIMIT 1
");

$stmt->execute([
    $id,
    $experienceId
]);


$gallery =
    $stmt->fetch();


if (!$gallery) {

    redirect(
        'gallery.php?id=' .
        $experienceId .
        '&error=' .
        urlencode(
            'Gallery image not found.'
        )
    );

}


/*
|--------------------------------------------------------------------------
| Delete database record
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    DELETE FROM experience_gallery
    WHERE id = ?
    AND experience_id = ?
");

$stmt->execute([
    $id,
    $experienceId
]);


/*
|--------------------------------------------------------------------------
| Delete image file
|--------------------------------------------------------------------------
*/

if (!empty($gallery['image'])) {

    $imagePath =
        '../../assets/images/experience/' .
        $gallery['image'];


    if (file_exists($imagePath)) {

        unlink($imagePath);

    }

}


/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

redirect(
    'gallery.php?id=' .
    $experienceId .
    '&success=' .
    urlencode(
        'Photo successfully deleted.'
    )
);