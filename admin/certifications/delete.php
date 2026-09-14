<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


$id = (int) (
    $_GET['id'] ?? 0
);


if ($id <= 0) {

    redirect('index.php');

}


/*
|--------------------------------------------------------------------------
| Get certificate
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT certificate_image
    FROM certifications
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$certification =
    $stmt->fetch();


if (!$certification) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Certification not found.'
        )
    );

}


/*
|--------------------------------------------------------------------------
| Delete database record
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    DELETE FROM certifications
    WHERE id = ?
");

$stmt->execute([$id]);


/*
|--------------------------------------------------------------------------
| Delete image
|--------------------------------------------------------------------------
*/

if (
    !empty(
        $certification['certificate_image']
    )
) {

    $imagePath =
        '../../assets/images/certifications/' .
        $certification['certificate_image'];


    if (
        file_exists($imagePath)
    ) {

        unlink($imagePath);

    }

}


/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

redirect(
    'index.php?success=' .
    urlencode(
        'Certification successfully deleted.'
    )
);