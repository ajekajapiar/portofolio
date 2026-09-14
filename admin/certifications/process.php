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


    $name = trim(
        $_POST['certification_name'] ?? ''
    );


    $issuer = trim(
        $_POST['issuer'] ?? ''
    );


    $issueDate = !empty(
        $_POST['issue_date'] ?? ''
    )
        ? $_POST['issue_date']
        : null;


    $expirationDate = !empty(
        $_POST['expiration_date'] ?? ''
    )
        ? $_POST['expiration_date']
        : null;


    $credentialId = trim(
        $_POST['credential_id'] ?? ''
    );


    $credentialUrl = trim(
        $_POST['credential_url'] ?? ''
    );


    $description = trim(
        $_POST['description'] ?? ''
    );


    $displayOrder = (int) (
        $_POST['display_order'] ?? 0
    );


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($name === '') {

        redirect(
            'add.php?error=' .
            urlencode(
                'Certification name is required.'
            )
        );

    }


    if (
        $credentialUrl !== '' &&
        !filter_var(
            $credentialUrl,
            FILTER_VALIDATE_URL
        )
    ) {

        redirect(
            'add.php?error=' .
            urlencode(
                'Invalid credential URL.'
            )
        );

    }


    if (
        $issueDate !== null &&
        $expirationDate !== null &&
        $expirationDate < $issueDate
    ) {

        redirect(
            'add.php?error=' .
            urlencode(
                'Expiration date cannot be earlier than issue date.'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Upload certificate
    |--------------------------------------------------------------------------
    */

    $certificateFilename = null;


    if (
        isset($_FILES['certificate_image']) &&
        $_FILES['certificate_image']['error']
        !== UPLOAD_ERR_NO_FILE
    ) {


        $uploadResult = uploadImage(

            $_FILES['certificate_image'],

            '../../assets/images/certifications',

            'certificate'

        );


        if (!$uploadResult['success']) {

            redirect(
                'add.php?error=' .
                urlencode(
                    $uploadResult['error']
                )
            );

        }


        $certificateFilename =
            $uploadResult['filename'];

    }


    /*
    |--------------------------------------------------------------------------
    | Insert
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO certifications
        (
            certification_name,
            issuer,
            issue_date,
            expiration_date,
            credential_id,
            credential_url,
            certificate_image,
            description,
            display_order
        )

        VALUES
        (
            ?,
            ?,
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

        $name,

        $issuer !== ''
            ? $issuer
            : null,

        $issueDate,

        $expirationDate,

        $credentialId !== ''
            ? $credentialId
            : null,

        $credentialUrl !== ''
            ? $credentialUrl
            : null,

        $certificateFilename,

        $description !== ''
            ? $description
            : null,

        $displayOrder

    ]);


    redirect(
        'index.php?success=' .
        urlencode(
            'Certification successfully added.'
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


    $name = trim(
        $_POST['certification_name'] ?? ''
    );


    $issuer = trim(
        $_POST['issuer'] ?? ''
    );


    $issueDate = !empty(
        $_POST['issue_date'] ?? ''
    )
        ? $_POST['issue_date']
        : null;


    $expirationDate = !empty(
        $_POST['expiration_date'] ?? ''
    )
        ? $_POST['expiration_date']
        : null;


    $credentialId = trim(
        $_POST['credential_id'] ?? ''
    );


    $credentialUrl = trim(
        $_POST['credential_url'] ?? ''
    );


    $description = trim(
        $_POST['description'] ?? ''
    );


    $displayOrder = (int) (
        $_POST['display_order'] ?? 0
    );


    if ($id <= 0) {

        redirect('index.php');

    }


    if ($name === '') {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Certification name is required.'
            )
        );

    }


    if (
        $credentialUrl !== '' &&
        !filter_var(
            $credentialUrl,
            FILTER_VALIDATE_URL
        )
    ) {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Invalid credential URL.'
            )
        );

    }


    if (
        $issueDate !== null &&
        $expirationDate !== null &&
        $expirationDate < $issueDate
    ) {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Expiration date cannot be earlier than issue date.'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Existing record
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT certificate_image
        FROM certifications
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $existing =
        $stmt->fetch();


    if (!$existing) {

        redirect(
            'index.php?error=' .
            urlencode(
                'Certification not found.'
            )
        );

    }


    $certificateFilename =
        $existing['certificate_image'];


    /*
    |--------------------------------------------------------------------------
    | New image
    |--------------------------------------------------------------------------
    */

    if (
        isset($_FILES['certificate_image']) &&
        $_FILES['certificate_image']['error']
        !== UPLOAD_ERR_NO_FILE
    ) {


        $uploadResult = uploadImage(

            $_FILES['certificate_image'],

            '../../assets/images/certifications',

            'certificate'

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
        | Delete old image
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $existing['certificate_image']
            )
        ) {

            $oldImage =
                '../../assets/images/certifications/' .
                $existing['certificate_image'];


            if (
                file_exists($oldImage)
            ) {

                unlink($oldImage);

            }

        }


        $certificateFilename =
            $uploadResult['filename'];

    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        UPDATE certifications

        SET
            certification_name = ?,
            issuer = ?,
            issue_date = ?,
            expiration_date = ?,
            credential_id = ?,
            credential_url = ?,
            certificate_image = ?,
            description = ?,
            display_order = ?

        WHERE id = ?
    ");


    $stmt->execute([

        $name,

        $issuer !== ''
            ? $issuer
            : null,

        $issueDate,

        $expirationDate,

        $credentialId !== ''
            ? $credentialId
            : null,

        $credentialUrl !== ''
            ? $credentialUrl
            : null,

        $certificateFilename,

        $description !== ''
            ? $description
            : null,

        $displayOrder,

        $id

    ]);


    redirect(
        'index.php?success=' .
        urlencode(
            'Certification successfully updated.'
        )
    );

}



/*
|--------------------------------------------------------------------------
| Invalid
|--------------------------------------------------------------------------
*/

redirect(
    'index.php?error=' .
    urlencode(
        'Invalid action.'
    )
);