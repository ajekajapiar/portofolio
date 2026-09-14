<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


$id = (int) (
    $_GET['id'] ?? 0
);


$projectId = (int) (
    $_GET['project_id'] ?? 0
);


if (
    $id <= 0 ||
    $projectId <= 0
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
    FROM project_gallery
    WHERE id = ?
    AND project_id = ?
    LIMIT 1
");

$stmt->execute([
    $id,
    $projectId
]);


$gallery =
    $stmt->fetch();


if (!$gallery) {

    redirect(
        'gallery.php?id=' .
        $projectId .
        '&error=' .
        urlencode(
            'Gallery image not found.'
        )
    );

}


/*
|--------------------------------------------------------------------------
| Delete record
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    DELETE FROM project_gallery
    WHERE id = ?
    AND project_id = ?
");

$stmt->execute([
    $id,
    $projectId
]);


/*
|--------------------------------------------------------------------------
| Delete file
|--------------------------------------------------------------------------
*/

if (!empty($gallery['image'])) {

    $imagePath =
        '../../assets/images/projects/' .
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
    $projectId .
    '&success=' .
    urlencode(
        'Photo successfully deleted.'
    )
);