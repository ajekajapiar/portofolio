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
            'Invalid project ID.'
        )
    );

}


/*
|--------------------------------------------------------------------------
| Get project
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT cover_image
    FROM projects
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

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
| Delete project
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    DELETE FROM projects
    WHERE id = ?
");

$stmt->execute([$id]);


/*
|--------------------------------------------------------------------------
| Delete cover
|--------------------------------------------------------------------------
*/

if (!empty($project['cover_image'])) {

    $coverPath =
        '../../assets/images/projects/' .
        $project['cover_image'];


    if (file_exists($coverPath)) {

        unlink($coverPath);

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
        'Project successfully deleted.'
    )
);