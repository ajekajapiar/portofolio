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


    $skillName = trim(
        $_POST['skill_name'] ?? ''
    );


    $skillType =
        $_POST['skill_type'] ?? '';


    $proficiency =
        $_POST['proficiency'] ?? '';


    $displayOrder = (int) (
        $_POST['display_order'] ?? 0
    );


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($skillName === '') {

        redirect(
            'add.php?error=' .
            urlencode(
                'Skill name is required.'
            )
        );

    }


    if (
        !in_array(
            $skillType,
            [
                'hard_skill',
                'soft_skill'
            ],
            true
        )
    ) {

        redirect(
            'add.php?error=' .
            urlencode(
                'Invalid skill type.'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Proficiency
    |--------------------------------------------------------------------------
    */

    if ($skillType === 'hard_skill') {

        if (
            $proficiency === '' ||
            !is_numeric($proficiency) ||
            $proficiency < 1 ||
            $proficiency > 100
        ) {

            redirect(
                'add.php?error=' .
                urlencode(
                    'Hard skill proficiency must be between 1 and 100.'
                )
            );

        }


        $proficiency =
            (int) $proficiency;

    } else {

        $proficiency = null;

    }


    /*
    |--------------------------------------------------------------------------
    | Insert
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO skills
        (
            skill_name,
            skill_type,
            proficiency,
            display_order
        )

        VALUES
        (
            ?,
            ?,
            ?,
            ?
        )
    ");


    $stmt->execute([

        $skillName,

        $skillType,

        $proficiency,

        $displayOrder

    ]);


    redirect(
        'index.php?success=' .
        urlencode(
            'Skill successfully added.'
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


    $skillName = trim(
        $_POST['skill_name'] ?? ''
    );


    $skillType =
        $_POST['skill_type'] ?? '';


    $proficiency =
        $_POST['proficiency'] ?? '';


    $displayOrder = (int) (
        $_POST['display_order'] ?? 0
    );


    if ($id <= 0) {

        redirect('index.php');

    }


    if ($skillName === '') {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Skill name is required.'
            )
        );

    }


    if (
        !in_array(
            $skillType,
            [
                'hard_skill',
                'soft_skill'
            ],
            true
        )
    ) {

        redirect(
            'edit.php?id=' .
            $id .
            '&error=' .
            urlencode(
                'Invalid skill type.'
            )
        );

    }


    if ($skillType === 'hard_skill') {

        if (
            $proficiency === '' ||
            !is_numeric($proficiency) ||
            $proficiency < 1 ||
            $proficiency > 100
        ) {

            redirect(
                'edit.php?id=' .
                $id .
                '&error=' .
                urlencode(
                    'Hard skill proficiency must be between 1 and 100.'
                )
            );

        }


        $proficiency =
            (int) $proficiency;

    } else {

        $proficiency = null;

    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        UPDATE skills

        SET
            skill_name = ?,
            skill_type = ?,
            proficiency = ?,
            display_order = ?

        WHERE id = ?
    ");


    $stmt->execute([

        $skillName,

        $skillType,

        $proficiency,

        $displayOrder,

        $id

    ]);


    redirect(
        'index.php?success=' .
        urlencode(
            'Skill successfully updated.'
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