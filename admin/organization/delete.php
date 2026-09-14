<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


$id = (int) (
    $_GET['id'] ?? 0
);


if ($id <= 0) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Invalid organization ID.'
        )
    );

}


/*
|--------------------------------------------------------------------------
| Get organization
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT logo
    FROM organization
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$organization =
    $stmt->fetch();


if (!$organization) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Organization record not found.'
        )
    );

}


/*
|--------------------------------------------------------------------------
| Delete database record
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    DELETE FROM organization
    WHERE id = ?
");

$stmt->execute([$id]);


/*
|--------------------------------------------------------------------------
| Delete logo
|--------------------------------------------------------------------------
*/

if (!empty($organization['logo'])) {

    $logoPath =
        '../../assets/images/organization/' .
        $organization['logo'];


    if (file_exists($logoPath)) {

        unlink($logoPath);

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
        'Organization successfully deleted.'
    )
);