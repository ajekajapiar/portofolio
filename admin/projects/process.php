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


    $title = trim(
        $_POST['title'] ?? ''
    );


    $category = trim(
        $_POST['category'] ?? ''
    );


    $technologies = trim(
        $_POST['technologies'] ?? ''
    );


    $description = trim(
        $_POST['description'] ?? ''
    );


    $projectUrl = trim(
        $_POST['project_url'] ?? ''
    );


    $githubUrl = trim(
        $_POST['github_url'] ?? ''
    );


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($title === '') {

        redirect(
            'add.php?error=' .
            urlencode(
                'Project title is required.'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Validate URLs
    |--------------------------------------------------------------------------
    */

    if (
        $projectUrl !== '' &&
        !filter_var(
            $projectUrl,
            FILTER_VALIDATE_URL
        )
    ) {

        redirect(
            'add.php?error=' .
            urlencode(
                'Invalid project URL.'
            )
        );

    }


    if (
        $githubUrl !== '' &&
        !filter_var(
            $githubUrl,
            FILTER_VALIDATE_URL
        )
    ) {

        redirect(
            'add.php?error=' .
            urlencode(
                'Invalid GitHub URL.'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Upload cover
    |--------------------------------------------------------------------------
    */

    $coverFilename = null;


    if (
        isset($_FILES['cover_image']) &&
        $_FILES['cover_image']['error'] !== UPLOAD_ERR_NO_FILE
    ) {


        $uploadResult = uploadImage(

            $_FILES['cover_image'],

            '../../assets/images/projects',

            'project'

        );


        if (!$uploadResult['success']) {

            redirect(
                'add.php?error=' .
                urlencode(
                    $uploadResult['error']
                )
            );

        }


        $coverFilename =
            $uploadResult['filename'];

    }


    /*
    |--------------------------------------------------------------------------
    | Insert
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO projects
        (
            title,
            category,
            technologies,
            description,
            cover_image,
            project_url,
            github_url
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

        $title,

        $category !== ''
            ? $category
            : null,

        $technologies !== ''
            ? $technologies
            : null,

        $description !== ''
            ? $description
            : null,

        $coverFilename,

        $projectUrl !== ''
            ? $projectUrl
            : null,

        $githubUrl !== ''
            ? $githubUrl
            : null

    ]);


    redirect(
        'index.php?success=' .
        urlencode(
            'Project successfully added.'
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


    $title = trim(
        $_POST['title'] ?? ''
    );


    $category = trim(
        $_POST['category'] ?? ''
    );


    $technologies = trim(
        $_POST['technologies'] ?? ''
    );


    $description = trim(
        $_POST['description'] ?? ''
    );


    $projectUrl = trim(
        $_POST['project_url'] ?? ''
    );


    $githubUrl = trim(
        $_POST['github_url'] ?? ''
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
                'Invalid project ID.'
            )
        );

    }


    if ($title === '') {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Project title is required.'
            )
        );

    }


    if (
        $projectUrl !== '' &&
        !filter_var(
            $projectUrl,
            FILTER_VALIDATE_URL
        )
    ) {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Invalid project URL.'
            )
        );

    }


    if (
        $githubUrl !== '' &&
        !filter_var(
            $githubUrl,
            FILTER_VALIDATE_URL
        )
    ) {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Invalid GitHub URL.'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Get existing project
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT cover_image
        FROM projects
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $existingProject =
        $stmt->fetch();


    if (!$existingProject) {

        redirect(
            'index.php?error=' .
            urlencode(
                'Project not found.'
            )
        );

    }


    $coverFilename =
        $existingProject['cover_image'];


    /*
    |--------------------------------------------------------------------------
    | Upload new cover
    |--------------------------------------------------------------------------
    */

    if (
        isset($_FILES['cover_image']) &&
        $_FILES['cover_image']['error'] !== UPLOAD_ERR_NO_FILE
    ) {


        $uploadResult = uploadImage(

            $_FILES['cover_image'],

            '../../assets/images/projects',

            'project'

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
        | Delete old cover
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $existingProject['cover_image']
            )
        ) {

            $oldCover =
                '../../assets/images/projects/' .
                $existingProject['cover_image'];


            if (
                file_exists($oldCover)
            ) {

                unlink($oldCover);

            }

        }


        $coverFilename =
            $uploadResult['filename'];

    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        UPDATE projects

        SET
            title = ?,
            category = ?,
            technologies = ?,
            description = ?,
            cover_image = ?,
            project_url = ?,
            github_url = ?,
            updated_at = CURRENT_TIMESTAMP

        WHERE id = ?
    ");


    $stmt->execute([

        $title,

        $category !== ''
            ? $category
            : null,

        $technologies !== ''
            ? $technologies
            : null,

        $description !== ''
            ? $description
            : null,

        $coverFilename,

        $projectUrl !== ''
            ? $projectUrl
            : null,

        $githubUrl !== ''
            ? $githubUrl
            : null,

        $id

    ]);


    redirect(
        'index.php?success=' .
        urlencode(
            'Project successfully updated.'
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