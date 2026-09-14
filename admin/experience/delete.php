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
            'Invalid experience ID.'
        )
    );

}


/*
|--------------------------------------------------------------------------
| Get experience
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT logo
    FROM experience
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$experience =
    $stmt->fetch();


if (!$experience) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Experience record not found.'
        )
    );

}


/*
|--------------------------------------------------------------------------
| Delete database record
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    DELETE FROM experience
    WHERE id = ?
");

$stmt->execute([$id]);


/*
|--------------------------------------------------------------------------
| Delete company logo
|--------------------------------------------------------------------------
*/

if (!empty($experience['logo'])) {

    $logoPath =
        '../../assets/images/experience/' .
        $experience['logo'];


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
        'Experience successfully deleted.'
    )
);