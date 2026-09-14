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

    $company = trim(
        $_POST['company'] ?? ''
    );

    $position = trim(
        $_POST['position'] ?? ''
    );

    $startDate = !empty(
        $_POST['start_date'] ?? ''
    )
        ? $_POST['start_date']
        : null;

    $isCurrent = isset(
        $_POST['is_current']
    )
        ? 1
        : 0;

    $endDate = !$isCurrent && !empty(
        $_POST['end_date'] ?? ''
    )
        ? $_POST['end_date']
        : null;

    $description = trim(
        $_POST['description'] ?? ''
    );


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($company === '') {

        redirect(
            'add.php?error=' .
            urlencode('Company is required.')
        );

    }


    if ($position === '') {

        redirect(
            'add.php?error=' .
            urlencode('Position is required.')
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Upload company logo
    |--------------------------------------------------------------------------
    */

    $logoFilename = null;


    if (
        isset($_FILES['logo']) &&
        $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        $uploadResult = uploadImage(
            $_FILES['logo'],
            '../../assets/images/experience',
            'company'
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
        INSERT INTO experience
        (
            company,
            logo,
            position,
            start_date,
            end_date,
            is_current,
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

        $company,

        $logoFilename,

        $position,

        $startDate,

        $endDate,

        $isCurrent,

        $description !== ''
            ? $description
            : null

    ]);


    redirect(
        'index.php?success=' .
        urlencode(
            'Experience successfully added.'
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


    $company = trim(
        $_POST['company'] ?? ''
    );


    $position = trim(
        $_POST['position'] ?? ''
    );


    $startDate = !empty(
        $_POST['start_date'] ?? ''
    )
        ? $_POST['start_date']
        : null;


    $isCurrent = isset(
        $_POST['is_current']
    )
        ? 1
        : 0;


    $endDate = !$isCurrent && !empty(
        $_POST['end_date'] ?? ''
    )
        ? $_POST['end_date']
        : null;


    $description = trim(
        $_POST['description'] ?? ''
    );


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($id <= 0) {

        redirect(
            'index.php?error=' .
            urlencode(
                'Invalid experience ID.'
            )
        );

    }


    if ($company === '') {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Company is required.'
            )
        );

    }


    if ($position === '') {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Position is required.'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Get existing record
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT logo
        FROM experience
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $existingExperience =
        $stmt->fetch();


    if (!$existingExperience) {

        redirect(
            'index.php?error=' .
            urlencode(
                'Experience record not found.'
            )
        );

    }


    $logoFilename =
        $existingExperience['logo'];


    /*
    |--------------------------------------------------------------------------
    | Upload new logo
    |--------------------------------------------------------------------------
    */

    if (
        isset($_FILES['logo']) &&
        $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        $uploadResult = uploadImage(
            $_FILES['logo'],
            '../../assets/images/experience',
            'company'
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
            !empty(
                $existingExperience['logo']
            )
        ) {

            $oldLogo =
                '../../assets/images/experience/' .
                $existingExperience['logo'];


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
    | Update
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        UPDATE experience

        SET
            company = ?,
            logo = ?,
            position = ?,
            start_date = ?,
            end_date = ?,
            is_current = ?,
            description = ?

        WHERE id = ?
    ");


    $stmt->execute([

        $company,

        $logoFilename,

        $position,

        $startDate,

        $endDate,

        $isCurrent,

        $description !== ''
            ? $description
            : null,

        $id

    ]);


    redirect(
        'index.php?success=' .
        urlencode(
            'Experience successfully updated.'
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