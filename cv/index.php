<?php

require_once '../config/database.php';
require_once '../includes/functions.php';


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


/*
|--------------------------------------------------------------------------
| Separate Skills
|--------------------------------------------------------------------------
*/

$hardSkills = [];

$softSkills = [];

foreach ($skills as $skill) {

    if ($skill['skill_type'] === 'hard_skill') {

        $hardSkills[] = $skill;

    } elseif ($skill['skill_type'] === 'soft_skill') {

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

?>


<!DOCTYPE html>

<html lang="en">


<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        CV —
        <?= e(
            $profile['full_name']
            ?? 'Portfolio'
        ); ?>
    </title>


    <link
        rel="stylesheet"
        href="../assets/css/cv.css"
    >

</head>


<body>


<div class="cv-page">


    <!-- =====================================================
         HEADER
    ====================================================== -->


    <header class="cv-header">


        <h1>

            <?= e(
                $profile['full_name']
                ?? ''
            ); ?>

        </h1>


        <?php if (
            !empty(
                $profile['professional_title']
            )
        ): ?>

            <p class="cv-headline">

                <?= e(
                    $profile['professional_title']
                ); ?>

            </p>

        <?php endif; ?>


        <div class="cv-contact">


            <?php if (
                !empty(
                    $profile['email']
                )
            ): ?>

                <span>
                    <?= e(
                        $profile['email']
                    ); ?>
                </span>

            <?php endif; ?>


            <?php if (
                !empty(
                    $profile['phone']
                )
            ): ?>

                <span>
                    <?= e(
                        $profile['phone']
                    ); ?>
                </span>

            <?php endif; ?>


            <?php if (
                !empty(
                    $profile['location']
                )
            ): ?>

                <span>
                    <?= e(
                        $profile['location']
                    ); ?>
                </span>

            <?php endif; ?>


            <?php if (
                !empty(
                    $profile['linkedin_url']
                )
            ): ?>

                <span>
                    <?= e(
                        $profile['linkedin_url']
                    ); ?>
                </span>

            <?php endif; ?>


            <?php if (
                !empty(
                    $profile['github_url']
                )
            ): ?>

                <span>
                    <?= e(
                        $profile['github_url']
                    ); ?>
                </span>

            <?php endif; ?>


        </div>


    </header>



    <!-- =====================================================
         PROFILE / SUMMARY
    ====================================================== -->


    <?php if (
        !empty(
            $profile['about_me']
        )
    ): ?>


        <section class="cv-section">


            <h2>
                ABOUT ME
            </h2>


            <p>
                <?= nl2br(
                    e(
                        $profile['about_me']
                    )
                ); ?>
            </p>


        </section>


    <?php endif; ?>



    <!-- =====================================================
         EDUCATION
    ====================================================== -->


    <?php if (
        count($educations) > 0
    ): ?>


        <section class="cv-section">


            <h2>
                EDUCATION
            </h2>


            <?php foreach (
                $educations as $education
            ): ?>


                <div class="cv-entry">


                    <div
                        class="cv-entry-header"
                    >


                        <div>


                            <h3>

                                <?= e(
                                    $education[
                                        'institution'
                                    ]
                                ); ?>

                            </h3>


                            <p>

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

                            </p>


                        </div>


                        <div
                            class="cv-date"
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

                        </div>


                    </div>


                    <?php if (
                        !empty(
                            $education[
                                'description'
                            ]
                        )
                    ): ?>

                        <p>

                            <?= nl2br(
                                e(
                                    $education[
                                        'description'
                                    ]
                                )
                            ); ?>

                        </p>

                    <?php endif; ?>


                </div>


            <?php endforeach; ?>


        </section>


    <?php endif; ?>



    <!-- =====================================================
         EXPERIENCE
    ====================================================== -->


    <?php if (
        count($experiences) > 0
    ): ?>


        <section class="cv-section">


            <h2>
                EXPERIENCE
            </h2>


            <?php foreach (
                $experiences as $experience
            ): ?>


                <div class="cv-entry">


                    <div
                        class="cv-entry-header"
                    >


                        <div>


                            <h3>

                                <?= e(
                                    $experience[
                                        'company'
                                    ]
                                ); ?>

                            </h3>


                            <p>

                                <?= e(
                                    $experience[
                                        'position'
                                    ]
                                ); ?>

                            </p>


                        </div>


                        <div
                            class="cv-date"
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

                        </div>


                    </div>


                    <?php if (
                        !empty(
                            $experience[
                                'description'
                            ]
                        )
                    ): ?>

                        <p>

                            <?= nl2br(
                                e(
                                    $experience[
                                        'description'
                                    ]
                                )
                            ); ?>

                        </p>

                    <?php endif; ?>


                </div>


            <?php endforeach; ?>


        </section>


    <?php endif; ?>



    <!-- =====================================================
         ORGANIZATION
    ====================================================== -->


    <?php if (
        count($organizations) > 0
    ): ?>


        <section class="cv-section">


            <h2>
                ORGANIZATIONAL EXPERIENCE
            </h2>


            <?php foreach (
                $organizations as $organization
            ): ?>


                <div class="cv-entry">


                    <div
                        class="cv-entry-header"
                    >


                        <div>


                            <h3>

                                <?= e(
                                    $organization[
                                        'organization_name'
                                    ]
                                ); ?>

                            </h3>


                            <p>

                                <?= e(
                                    $organization[
                                        'position'
                                    ]
                                ); ?>

                            </p>


                        </div>


                        <div
                            class="cv-date"
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

                        </div>


                    </div>


                    <?php if (
                        !empty(
                            $organization[
                                'description'
                            ]
                        )
                    ): ?>

                        <p>

                            <?= nl2br(
                                e(
                                    $organization[
                                        'description'
                                    ]
                                )
                            ); ?>

                        </p>

                    <?php endif; ?>


                </div>


            <?php endforeach; ?>


        </section>


    <?php endif; ?>



    <!-- =====================================================
         PROJECTS
    ====================================================== -->


    <?php if (
        count($projects) > 0
    ): ?>


        <section class="cv-section">


            <h2>
                PROJECTS
            </h2>


            <?php foreach (
                $projects as $project
            ): ?>


                <div class="cv-entry">


                    <div
                        class="cv-entry-header"
                    >


                        <div>


                            <h3>

                                <?= e(
                                    $project[
                                        'title'
                                    ]
                                ); ?>

                            </h3>


                            <?php if (
                                !empty(
                                    $project[
                                        'category'
                                    ]
                                )
                            ): ?>

                                <p>

                                    <?= e(
                                        $project[
                                            'category'
                                        ]
                                    ); ?>

                                </p>

                            <?php endif; ?>


                        </div>


                    </div>


                    <?php if (
                        !empty(
                            $project[
                                'description'
                            ]
                        )
                    ): ?>

                        <p>

                            <?= e(
                                $project[
                                    'description'
                                ]
                            ); ?>

                        </p>

                    <?php endif; ?>


                    <?php if (
                        !empty(
                            $project[
                                'technologies'
                            ]
                        )
                    ): ?>

                        <p>

                            <strong>
                                Technologies:
                            </strong>

                            <?= e(
                                $project[
                                    'technologies'
                                ]
                            ); ?>

                        </p>

                    <?php endif; ?>


                </div>


            <?php endforeach; ?>


        </section>


    <?php endif; ?>



    <!-- =====================================================
     SKILLS
====================================================== -->


<?php if (
    count($hardSkills) > 0 ||
    count($softSkills) > 0
): ?>


    <section class="cv-section">


        <h2>
            SKILLS
        </h2>



        <!-- HARD SKILLS -->


        <?php if (
            count($hardSkills) > 0
        ): ?>


            <div class="cv-skill-category">


                <h3>
                    Technical Skills
                </h3>


                <p class="cv-skill-text">

                    <?php

                    $hardSkillNames = [];

                    foreach (
                        $hardSkills as $skill
                    ) {

                        $hardSkillNames[] =
                            e(
                                $skill[
                                    'skill_name'
                                ]
                            );

                    }

                    echo implode(
                        ', ',
                        $hardSkillNames
                    );

                    ?>

                </p>


            </div>


        <?php endif; ?>



        <!-- SOFT SKILLS -->


        <?php if (
            count($softSkills) > 0
        ): ?>


            <div class="cv-skill-category">


                <h3>
                    Soft Skills
                </h3>


                <p class="cv-skill-text">

                    <?php

                    $softSkillNames = [];

                    foreach (
                        $softSkills as $skill
                    ) {

                        $softSkillNames[] =
                            e(
                                $skill[
                                    'skill_name'
                                ]
                            );

                    }

                    echo implode(
                        ', ',
                        $softSkillNames
                    );

                    ?>

                </p>


            </div>


        <?php endif; ?>


    </section>


<?php endif; ?>



    <!-- =====================================================
         CERTIFICATIONS
    ====================================================== -->


    <?php if (
        count($certifications) > 0
    ): ?>


        <section class="cv-section">


            <h2>
                CERTIFICATIONS
            </h2>


            <?php foreach (
                $certifications as $certification
            ): ?>


                <div class="cv-entry">


                    <h3>

                        <?= e(
                            $certification[
                                'certification_name'
                            ]
                        ); ?>

                    </h3>


                    <p>

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


                    </p>


                    <?php if (
                        !empty(
                            $certification[
                                'credential_id'
                            ]
                        )
                    ): ?>

                        <p>

                            Credential ID:
                            <?= e(
                                $certification[
                                    'credential_id'
                                ]
                            ); ?>

                        </p>

                    <?php endif; ?>


                </div>


            <?php endforeach; ?>


        </section>


    <?php endif; ?>


</div>


</body>

</html>