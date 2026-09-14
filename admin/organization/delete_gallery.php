<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


$id = (int) (
    $_GET['id'] ?? 0
);


$organizationId = (int) (
    $_GET['organization_id'] ?? 0
);


if (
    $id <= 0 ||
    $organizationId <= 0
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
    FROM organization_gallery
    WHERE id = ?
    AND organization_id = ?
    LIMIT 1
");

$stmt->execute([
    $id,
    $organizationId
]);


$gallery =
    $stmt->fetch();


if (!$gallery) {

    redirect(
        'gallery.php?id=' .
        $organizationId .
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
    DELETE FROM organization_gallery
    WHERE id = ?
    AND organization_id = ?
");

$stmt->execute([
    $id,
    $organizationId
]);


/*
|--------------------------------------------------------------------------
| Delete image
|--------------------------------------------------------------------------
*/

if (!empty($gallery['image'])) {

    $imagePath =
        '../../assets/images/organization/' .
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
    $organizationId .
    '&success=' .
    urlencode(
        'Photo successfully deleted.'
    )
);