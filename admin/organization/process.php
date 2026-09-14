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


    $organizationName = trim(
        $_POST['organization_name'] ?? ''
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

    if ($organizationName === '') {

        redirect(
            'add.php?error=' .
            urlencode(
                'Organization name is required.'
            )
        );

    }


    if ($position === '') {

        redirect(
            'add.php?error=' .
            urlencode(
                'Position or role is required.'
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

            '../../assets/images/organization',

            'organization'

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
        INSERT INTO organization
        (
            organization_name,
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

        $organizationName,

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
            'Organization successfully added.'
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


    $organizationName = trim(
        $_POST['organization_name'] ?? ''
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
                'Invalid organization ID.'
            )
        );

    }


    if ($organizationName === '') {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Organization name is required.'
            )
        );

    }


    if ($position === '') {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Position or role is required.'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Get existing organization
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT logo
        FROM organization
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $existingOrganization =
        $stmt->fetch();


    if (!$existingOrganization) {

        redirect(
            'index.php?error=' .
            urlencode(
                'Organization record not found.'
            )
        );

    }


    $logoFilename =
        $existingOrganization['logo'];


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

            '../../assets/images/organization',

            'organization'

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
                $existingOrganization['logo']
            )
        ) {

            $oldLogo =
                '../../assets/images/organization/' .
                $existingOrganization['logo'];


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
        UPDATE organization

        SET
            organization_name = ?,
            logo = ?,
            position = ?,
            start_date = ?,
            end_date = ?,
            is_current = ?,
            description = ?

        WHERE id = ?
    ");


    $stmt->execute([

        $organizationName,

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
            'Organization successfully updated.'
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