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
            'Invalid education ID.'
        )
    );
}


/*
|--------------------------------------------------------------------------
| Get education
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT logo
    FROM education
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$education =
    $stmt->fetch();


if (!$education) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Education record not found.'
        )
    );
}


/*
|--------------------------------------------------------------------------
| Delete database record
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    DELETE FROM education
    WHERE id = ?
");

$stmt->execute([$id]);


/*
|--------------------------------------------------------------------------
| Delete logo file
|--------------------------------------------------------------------------
*/

if (!empty($education['logo'])) {

    $logoPath =
        '../../assets/images/education/' .
        $education['logo'];


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
        'Education successfully deleted.'
    )
);