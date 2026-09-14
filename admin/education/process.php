<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    redirect('index.php');
}


$action = $_POST['action'] ?? '';


/*
|--------------------------------------------------------------------------
| CREATE
|--------------------------------------------------------------------------
*/

if ($action === 'create') {


    $institution = trim(
        $_POST['institution'] ?? ''
    );


    $degree = trim(
        $_POST['degree'] ?? ''
    );


    $field = trim(
        $_POST['field'] ?? ''
    );


    $startYear = $_POST['start_year'] ?? null;


    $endYear = $_POST['end_year'] ?? null;


    $description = trim(
        $_POST['description'] ?? ''
    );


    /*
    |--------------------------------------------------------------------------
    | Validate institution
    |--------------------------------------------------------------------------
    */

    if ($institution === '') {

        redirect(
            'add.php?error=' .
            urlencode(
                'Institution is required.'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Upload logo
    |--------------------------------------------------------------------------
    */

    $logoFilename = null;


    if (
        isset($_FILES['logo']) &&
        $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        $uploadResult = uploadImage(

            $_FILES['logo'],

            '../../assets/images/education',

            'education'

        );


        if (!$uploadResult['success']) {

            redirect(
                'add.php?error=' .
                urlencode(
                    $uploadResult['error']
                )
            );
        }


        $logoFilename =
            $uploadResult['filename'];
    }


    /*
    |--------------------------------------------------------------------------
    | Insert
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO education
        (
            institution,
            logo,
            degree,
            field,
            start_year,
            end_year,
            description
        )

        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?
        )
    ");


    $stmt->execute([

        $institution,

        $logoFilename,

        $degree !== ''
            ? $degree
            : null,

        $field !== ''
            ? $field
            : null,

        $startYear !== ''
            ? $startYear
            : null,

        $endYear !== ''
            ? $endYear
            : null,

        $description !== ''
            ? $description
            : null

    ]);


    redirect(
        'index.php?success=' .
        urlencode(
            'Education successfully added.'
        )
    );
}


/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
*/

if ($action === 'update') {


    $id = (int) (
        $_POST['id'] ?? 0
    );


    $institution = trim(
        $_POST['institution'] ?? ''
    );


    $degree = trim(
        $_POST['degree'] ?? ''
    );


    $field = trim(
        $_POST['field'] ?? ''
    );


    $startYear = $_POST['start_year'] ?? null;


    $endYear = $_POST['end_year'] ?? null;


    $description = trim(
        $_POST['description'] ?? ''
    );


    /*
    |--------------------------------------------------------------------------
    | Validate ID
    |--------------------------------------------------------------------------
    */

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
    | Validate institution
    |--------------------------------------------------------------------------
    */

    if ($institution === '') {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Institution is required.'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Get existing education
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT logo
        FROM education
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $existingEducation =
        $stmt->fetch();


    if (!$existingEducation) {

        redirect(
            'index.php?error=' .
            urlencode(
                'Education record not found.'
            )
        );
    }


    $logoFilename =
        $existingEducation['logo'];


    /*
    |--------------------------------------------------------------------------
    | Upload new logo if provided
    |--------------------------------------------------------------------------
    */

    if (
        isset($_FILES['logo']) &&
        $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        $uploadResult = uploadImage(

            $_FILES['logo'],

            '../../assets/images/education',

            'education'

        );


        if (!$uploadResult['success']) {

            redirect(
                'edit.php?id=' .
                $id .
                '&error=' .
                urlencode(
                    $uploadResult['error']
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete old logo
        |--------------------------------------------------------------------------
        */

        if (
            !empty($existingEducation['logo'])
        ) {

            $oldLogo =
                '../../assets/images/education/' .
                $existingEducation['logo'];


            if (
                file_exists($oldLogo)
            ) {

                unlink($oldLogo);
            }
        }


        $logoFilename =
            $uploadResult['filename'];
    }


    /*
    |--------------------------------------------------------------------------
    | Update database
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        UPDATE education

        SET
            institution = ?,
            logo = ?,
            degree = ?,
            field = ?,
            start_year = ?,
            end_year = ?,
            description = ?

        WHERE id = ?
    ");


    $stmt->execute([

        $institution,

        $logoFilename,

        $degree !== ''
            ? $degree
            : null,

        $field !== ''
            ? $field
            : null,

        $startYear !== ''
            ? $startYear
            : null,

        $endYear !== ''
            ? $endYear
            : null,

        $description !== ''
            ? $description
            : null,

        $id

    ]);


    redirect(
        'index.php?success=' .
        urlencode(
            'Education successfully updated.'
        )
    );
}


/*
|--------------------------------------------------------------------------
| Invalid action
|--------------------------------------------------------------------------
*/

redirect(
    'index.php?error=' .
    urlencode(
        'Invalid action.'
    )
);