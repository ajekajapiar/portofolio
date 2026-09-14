<?php

require_once '../vendor/autoload.php';
require_once '../config/database.php';
require_once '../includes/functions.php';

use Dompdf\Dompdf;
use Dompdf\Options;


/*
|--------------------------------------------------------------------------
| Get Profile
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM profile
    ORDER BY id ASC
    LIMIT 1
");

$profile = $stmt->fetch();


/*
|--------------------------------------------------------------------------
| Get Education
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM education
    ORDER BY
        start_year DESC,
        id DESC
");

$educations = $stmt->fetchAll();


/*
|--------------------------------------------------------------------------
| Get Experience
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM experience
    ORDER BY
        start_date DESC,
        id DESC
");

$experiences = $stmt->fetchAll();


/*
|--------------------------------------------------------------------------
| Get Organization
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM organization
    ORDER BY
        start_date DESC,
        id DESC
");

$organizations = $stmt->fetchAll();


/*
|--------------------------------------------------------------------------
| Get Projects
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM projects
    ORDER BY
        id DESC
");

$projects = $stmt->fetchAll();


/*
|--------------------------------------------------------------------------
| Get Skills
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM skills
    ORDER BY
        display_order ASC,
        id ASC
");

$skills = $stmt->fetchAll();


$hardSkills = [];

$softSkills = [];


foreach ($skills as $skill) {

    if (
        $skill['skill_type'] === 'hard_skill'
    ) {

        $hardSkills[] = $skill;

    } elseif (
        $skill['skill_type'] === 'soft_skill'
    ) {

        $softSkills[] = $skill;

    }

}


/*
|--------------------------------------------------------------------------
| Get Certifications
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM certifications
    ORDER BY
        display_order ASC,
        issue_date DESC,
        id DESC
");

$certifications = $stmt->fetchAll();


/*
|--------------------------------------------------------------------------
| Build CV HTML
|--------------------------------------------------------------------------
*/

ob_start();

?>


<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <style>

        @page {
            margin: 16mm;
        }


        * {
            box-sizing: border-box;
        }


        body {
            margin: 0;

            color: #111827;

            font-family:
                DejaVu Sans,
                sans-serif;

            font-size: 9.5pt;

            line-height: 1.45;
        }


        h1,
        h2,
        h3,
        p {
            margin-top: 0;
        }


        /* HEADER */

        .header {
            padding-bottom: 12px;

            border-bottom:
                2px solid #111827;
        }


        .name {
            margin-bottom: 4px;

            font-size: 23pt;

            font-weight: bold;
        }


        .headline {
            margin-bottom: 8px;

            color: #4b5563;

            font-size: 10pt;

            font-weight: bold;
        }


        .contact {
            color: #4b5563;

            font-size: 8.5pt;
        }


        /* SECTIONS */

        .section {
            margin-top: 14px;
        }


        .section-title {
            margin-bottom: 7px;

            padding-bottom: 3px;

            border-bottom:
                1px solid #d1d5db;

            font-size: 10pt;

            letter-spacing:
                0.08em;

            font-weight: bold;
        }


        /* ENTRIES */

        .entry {
            margin-bottom: 10px;
        }


        .entry:last-child {
            margin-bottom: 0;
        }


        .entry-header {
            width: 100%;
        }


        .entry-left {
            width: 75%;
        }


        .entry-right {
            width: 25%;

            text-align: right;

            color: #6b7280;

            font-size: 8.5pt;
        }


        .entry-title {
            margin-bottom: 2px;

            font-size: 9.8pt;

            font-weight: bold;
        }


        .entry-subtitle {
            margin-bottom: 2px;

            color: #374151;

            font-size: 9pt;

            font-weight: bold;
        }


        .entry-description {
            margin: 3px 0 0;

            color: #374151;

            font-size: 9pt;
        }


        /* SKILLS */

        .skill-category {
            margin-bottom: 5px;
        }


        .skill-category-title {
            font-weight: bold;
        }


        .skill-list {
            color: #374151;
        }


        /* CERTIFICATIONS */

        .certification {
            margin-bottom: 7px;
        }


        .certification-name {
            margin-bottom: 2px;

            font-weight: bold;
        }


        .certification-meta {
            color: #374151;

            font-size: 9pt;
        }


        /* PROJECT */

        .project {
            margin-bottom: 9px;
        }


        .project-name {
            margin-bottom: 2px;

            font-weight: bold;
        }


        .project-description {
            margin-bottom: 2px;

            color: #374151;
        }


        .project-tech {
            color: #4b5563;

            font-size: 8.8pt;
        }

    </style>

</head>


<body>


<!-- =====================================================
     HEADER
====================================================== -->


<div class="header">


    <div class="name">

        <?= e(
            $profile['full_name']
            ?? ''
        ); ?>

    </div>


    <?php if (
        !empty(
            $profile['headline']
        )
    ): ?>

        <div class="headline">

            <?= e(
                $profile['headline']
            ); ?>

        </div>

    <?php endif; ?>


    <div class="contact">

        <?php

        $contact = [];


        if (
            !empty(
                $profile['email']
            )
        ) {

            $contact[] =
                e(
                    $profile['email']
                );

        }


        if (
            !empty(
                $profile['phone']
            )
        ) {

            $contact[] =
                e(
                    $profile['phone']
                );

        }


        if (
            !empty(
                $profile['location']
            )
        ) {

            $contact[] =
                e(
                    $profile['location']
                );

        }


        if (
            !empty(
                $profile['linkedin_url']
            )
        ) {

            $contact[] =
                e(
                    $profile['linkedin_url']
                );

        }


        if (
            !empty(
                $profile['github_url']
            )
        ) {

            $contact[] =
                e(
                    $profile['github_url']
                );

        }


        echo implode(
            ' | ',
            $contact
        );

        ?>

    </div>


</div>



<!-- =====================================================
     PROFILE
====================================================== -->


<?php if (
    !empty(
        $profile['about_me']
    )
): ?>


    <div class="section">


        <div class="section-title">
            ABOUT ME
        </div>


        <div>

            <?= nl2br(
                e(
                    $profile['about_me']
                )
            ); ?>

        </div>


    </div>


<?php endif; ?>



<!-- =====================================================
     EDUCATION
====================================================== -->


<?php if (
    count($educations) > 0
): ?>


    <div class="section">


        <div class="section-title">
            EDUCATION
        </div>


        <?php foreach (
            $educations as $education
        ): ?>


            <div class="entry">


                <table
                    width="100%"
                    cellspacing="0"
                    cellpadding="0"
                >

                    <tr>


                        <td
                            class="entry-left"
                        >


                            <div
                                class="entry-title"
                            >

                                <?= e(
                                    $education[
                                        'institution'
                                    ]
                                ); ?>

                            </div>


                            <div
                                class="entry-subtitle"
                            >

                                <?= e(
                                    $education[
                                        'degree'
                                    ]
                                    ?? ''
                                ); ?>


                                <?php if (
                                    !empty(
                                        $education[
                                            'field'
                                        ]
                                    )
                                ): ?>

                                    —
                                    <?= e(
                                        $education[
                                            'field'
                                        ]
                                    ); ?>

                                <?php endif; ?>


                            </div>


                            <?php if (
                                !empty(
                                    $education[
                                        'description'
                                    ]
                                )
                            ): ?>


                                <div
                                    class="entry-description"
                                >

                                    <?= nl2br(
                                        e(
                                            $education[
                                                'description'
                                            ]
                                        )
                                    ); ?>

                                </div>


                            <?php endif; ?>


                        </td>


                        <td
                            class="entry-right"
                        >

                            <?= e(
                                $education[
                                    'start_year'
                                ]
                            ); ?>

                            —

                            <?= e(
                                $education[
                                    'end_year'
                                ]
                                ?? 'Present'
                            ); ?>

                        </td>


                    </tr>

                </table>


            </div>


        <?php endforeach; ?>


    </div>


<?php endif; ?>



<!-- =====================================================
     EXPERIENCE
====================================================== -->


<?php if (
    count($experiences) > 0
): ?>


    <div class="section">


        <div class="section-title">
            EXPERIENCE
        </div>


        <?php foreach (
            $experiences as $experience
        ): ?>


            <div class="entry">


                <table
                    width="100%"
                    cellspacing="0"
                    cellpadding="0"
                >

                    <tr>


                        <td
                            class="entry-left"
                        >


                            <div
                                class="entry-title"
                            >

                                <?= e(
                                    $experience[
                                        'company'
                                    ]
                                ); ?>

                            </div>


                            <div
                                class="entry-subtitle"
                            >

                                <?= e(
                                    $experience[
                                        'position'
                                    ]
                                ); ?>

                            </div>


                            <?php if (
                                !empty(
                                    $experience[
                                        'description'
                                    ]
                                )
                            ): ?>


                                <div class="entry-description">

                                    <?php
                                    $experienceLines = preg_split(
                                        '/\r\n|\r|\n/',
                                        trim(
                                            $experience['description'] ?? ''
                                        )
                                    );
                                    ?>

                                    <ul class="cv-bullets">

                                        <?php foreach (
                                            $experienceLines as $line
                                        ): ?>

                                            <?php if (
                                                trim($line) !== ''
                                            ): ?>

                                                <li>
                                                    <?= e(
                                                        trim($line)
                                                    ); ?>
                                                </li>

                                            <?php endif; ?>

                                        <?php endforeach; ?>

                                    </ul>

                                </div>


                            <?php endif; ?>


                        </td>


                        <td
                            class="entry-right"
                        >

                            <?= e(
                                date(
                                    'M Y',
                                    strtotime(
                                        $experience[
                                            'start_date'
                                        ]
                                    )
                                )
                            ); ?>

                            —

                            <?php if (
                                !empty(
                                    $experience[
                                        'end_date'
                                    ]
                                )
                            ): ?>

                                <?= e(
                                    date(
                                        'M Y',
                                        strtotime(
                                            $experience[
                                                'end_date'
                                            ]
                                        )
                                    )
                                ); ?>

                            <?php else: ?>

                                Present

                            <?php endif; ?>


                        </td>


                    </tr>

                </table>


            </div>


        <?php endforeach; ?>


    </div>


<?php endif; ?>



<!-- =====================================================
     ORGANIZATION
====================================================== -->


<?php if (
    count($organizations) > 0
): ?>


    <div class="section">


        <div class="section-title">
            ORGANIZATIONAL EXPERIENCE
        </div>


        <?php foreach (
            $organizations as $organization
        ): ?>


            <div class="entry">


                <table
                    width="100%"
                    cellspacing="0"
                    cellpadding="0"
                >

                    <tr>


                        <td
                            class="entry-left"
                        >


                            <div
                                class="entry-title"
                            >

                                <?= e(
                                    $organization[
                                        'organization_name'
                                    ]
                                ); ?>

                            </div>


                            <div
                                class="entry-subtitle"
                            >

                                <?= e(
                                    $organization[
                                        'position'
                                    ]
                                ); ?>

                            </div>


                            <?php if (
                                !empty(
                                    $organization[
                                        'description'
                                    ]
                                )
                            ): ?>


                                <div
                                    class="entry-description"
                                >

                                    <?= nl2br(
                                        e(
                                            $organization[
                                                'description'
                                            ]
                                        )
                                    ); ?>

                                </div>


                            <?php endif; ?>


                        </td>


                        <td
                            class="entry-right"
                        >

                            <?= e(
                                date(
                                    'M Y',
                                    strtotime(
                                        $organization[
                                            'start_date'
                                        ]
                                    )
                                )
                            ); ?>

                            —

                            <?php if (
                                !empty(
                                    $organization[
                                        'end_date'
                                    ]
                                )
                            ): ?>

                                <?= e(
                                    date(
                                        'M Y',
                                        strtotime(
                                            $organization[
                                                'end_date'
                                            ]
                                        )
                                    )
                                ); ?>

                            <?php else: ?>

                                Present

                            <?php endif; ?>


                        </td>


                    </tr>

                </table>


            </div>


        <?php endforeach; ?>


    </div>


<?php endif; ?>



<!-- =====================================================
     PROJECTS
====================================================== -->


<?php if (
    count($projects) > 0
): ?>


    <div class="section">


        <div class="section-title">
            PROJECTS
        </div>


        <?php foreach (
            $projects as $project
        ): ?>


            <div class="project">


                <div
                    class="project-name"
                >

                    <?= e(
                        $project[
                            'title'
                        ]
                    ); ?>


                    <?php if (
                        !empty(
                            $project[
                                'category'
                            ]
                        )
                    ): ?>

                        —
                        <?= e(
                            $project[
                                'category'
                            ]
                        ); ?>

                    <?php endif; ?>


                </div>


                <?php if (
                    !empty(
                        $project[
                            'description'
                        ]
                    )
                ): ?>


                    <div
                        class="project-description"
                    >

                        <?= e(
                            $project[
                                'description'
                            ]
                        ); ?>

                    </div>


                <?php endif; ?>


                <?php if (
                    !empty(
                        $project[
                            'technologies'
                        ]
                    )
                ): ?>


                    <div
                        class="project-tech"
                    >

                        <strong>
                            Technologies:
                        </strong>

                        <?= e(
                            $project[
                                'technologies'
                            ]
                        ); ?>

                    </div>


                <?php endif; ?>


            </div>


        <?php endforeach; ?>


    </div>


<?php endif; ?>



<!-- =====================================================
     SKILLS
====================================================== -->


<?php if (
    count($hardSkills) > 0 ||
    count($softSkills) > 0
): ?>


    <div class="section">


        <div class="section-title">
            SKILLS
        </div>


        <?php if (
            count($hardSkills) > 0
        ): ?>


            <div class="skill-category">


                <span
                    class="skill-category-title"
                >
                    Technical Skills:
                </span>


                <span
                    class="skill-list"
                >

                    <?php

                    $names = [];


                    foreach (
                        $hardSkills as $skill
                    ) {

                        $names[] =
                            e(
                                $skill[
                                    'skill_name'
                                ]
                            );

                    }


                    echo implode(
                        ', ',
                        $names
                    );

                    ?>

                </span>


            </div>


        <?php endif; ?>


        <?php if (
            count($softSkills) > 0
        ): ?>


            <div class="skill-category">


                <span
                    class="skill-category-title"
                >
                    Soft Skills:
                </span>


                <span
                    class="skill-list"
                >

                    <?php

                    $names = [];


                    foreach (
                        $softSkills as $skill
                    ) {

                        $names[] =
                            e(
                                $skill[
                                    'skill_name'
                                ]
                            );

                    }


                    echo implode(
                        ', ',
                        $names
                    );

                    ?>

                </span>


            </div>


        <?php endif; ?>


    </div>


<?php endif; ?>



<!-- =====================================================
     CERTIFICATIONS
====================================================== -->


<?php if (
    count($certifications) > 0
): ?>


    <div class="section">


        <div class="section-title">
            CERTIFICATIONS
        </div>


        <?php foreach (
            $certifications as $certification
        ): ?>


            <div
                class="certification"
            >


                <div
                    class="certification-name"
                >

                    <?= e(
                        $certification[
                            'certification_name'
                        ]
                    ); ?>

                </div>


                <div
                    class="certification-meta"
                >

                    <?= e(
                        $certification[
                            'issuer'
                        ]
                    ); ?>


                    <?php if (
                        !empty(
                            $certification[
                                'issue_date'
                            ]
                        )
                    ): ?>

                        —

                        <?= e(
                            date(
                                'M Y',
                                strtotime(
                                    $certification[
                                        'issue_date'
                                    ]
                                )
                            )
                        ); ?>

                    <?php endif; ?>


                    <?php if (
                        !empty(
                            $certification[
                                'credential_id'
                            ]
                        )
                    ): ?>

                        — ID:
                        <?= e(
                            $certification[
                                'credential_id'
                            ]
                        ); ?>

                    <?php endif; ?>


                </div>


            </div>


        <?php endforeach; ?>


    </div>


<?php endif; ?>


</body>

</html>


<?php


$html = ob_get_clean();


/*
|--------------------------------------------------------------------------
| Generate PDF
|--------------------------------------------------------------------------
*/

$options = new Options();

$options->set(
    'isRemoteEnabled',
    true
);

$options->set(
    'defaultFont',
    'DejaVu Sans'
);


$dompdf = new Dompdf(
    $options
);


$dompdf->loadHtml(
    $html,
    'UTF-8'
);


$dompdf->setPaper(
    'A4',
    'portrait'
);


$dompdf->render();


/*
|--------------------------------------------------------------------------
| Download
|--------------------------------------------------------------------------
*/

$fileName =
    'CV-' .
    preg_replace(
        '/[^A-Za-z0-9\-]/',
        '-',
        $profile['full_name']
        ?? 'Portfolio'
    ) .
    '.pdf';


$dompdf->stream(
    $fileName,
    [
        'Attachment' => true
    ]
);