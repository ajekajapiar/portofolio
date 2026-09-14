<?php

require_once 'config/database.php';
require_once 'includes/functions.php';


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
        display_order ASC,
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
        display_order ASC,
        start_date DESC,
        id DESC
");

$experiences = $stmt->fetchAll();

/*
|--------------------------------------------------------------------------
| Get Experience Gallery
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM experience_gallery
    ORDER BY
        id ASC
");

$experienceGallery = $stmt->fetchAll();

/*
|--------------------------------------------------------------------------
| Group Experience Gallery
|--------------------------------------------------------------------------
*/

$experienceGalleries = [];


foreach (
    $experienceGallery as $gallery
) {

    $experienceId =
        $gallery['experience_id'];


    if (
        !isset(
            $experienceGalleries[
                $experienceId
            ]
        )
    ) {

        $experienceGalleries[
            $experienceId
        ] = [];

    }


    $experienceGalleries[
        $experienceId
    ][] = $gallery;

}

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
| Get Organization Gallery
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM organization_gallery
    ORDER BY
        id ASC
");

$organizationGallery =
    $stmt->fetchAll();

/*
|--------------------------------------------------------------------------
| Group Organization Gallery
|--------------------------------------------------------------------------
*/

$organizationGalleries = [];


foreach (
    $organizationGallery as $gallery
) {

    $organizationId =
        $gallery['organization_id'];


    if (
        !isset(
            $organizationGalleries[
                $organizationId
            ]
        )
    ) {

        $organizationGalleries[
            $organizationId
        ] = [];

    }


    $organizationGalleries[
        $organizationId
    ][] = $gallery;

}

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
| Get Project Gallery
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM project_gallery
    ORDER BY
        id ASC
");

$projectGallery =
    $stmt->fetchAll();


/*
|--------------------------------------------------------------------------
| Group Project Gallery
|--------------------------------------------------------------------------
*/

$projectGalleries = [];


foreach (
    $projectGallery as $gallery
) {

    $projectId =
        $gallery['project_id'];


    if (
        !isset(
            $projectGalleries[
                $projectId
            ]
        )
    ) {

        $projectGalleries[
            $projectId
        ] = [];

    }


    $projectGalleries[
        $projectId
    ][] = $gallery;

}

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
| Group Skills By Type
|--------------------------------------------------------------------------
*/

$hardSkills = [];

$softSkills = [];


foreach (
    $skills as $skill
) {

    $skillType =
        strtolower(
            trim(
                $skill['skill_type']
            )
        );


    if (
        $skillType === 'hard_skill'
    ) {

        $hardSkills[] = $skill;

    } elseif (
        $skillType === 'soft_skill'
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
| Default values
|--------------------------------------------------------------------------
*/

if (!$profile) {

    $profile = [

        'full_name' => 'Your Name',

        'professional_title' =>
            'Professional Title',

        'short_bio' =>
            'Welcome to my personal portfolio.',

        'about_me' =>
            'This is my personal portfolio website.',

        'location' => '',

        'email' => '',

        'phone' => '',

        'profile_image' => '',

        'linkedin_url' => '',

        'github_url' => '',

        'instagram_url' => '',

        'website_url' => '',

        'other_social_url' => ''

    ];

}


$pageTitle =
    !empty($profile['full_name'])
        ? $profile['full_name']
        : 'Portfolio';


?>


<!DOCTYPE html>

<html lang="en">


<head>


    <meta charset="UTF-8">


    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    <meta
        name="description"
        content="<?= e(
            $profile['short_bio']
        ); ?>"
    >


    <title>
        <?= e($pageTitle); ?> — Portfolio
    </title>


    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >


</head>


<body>


<!-- =========================================================
     NAVBAR
========================================================= -->


<nav class="navbar">


    <div class="container navbar-inner">


        <!-- LOGO -->


        <a
            href="#home"
            class="navbar-logo"
        >

            <?= e(
                $profile['full_name']
            ); ?>

        </a>


        <!-- DESKTOP NAVIGATION -->


        <div class="navbar-links">


            <a href="#home">
                Home
            </a>


            <a href="#about">
                About
            </a>


            <a href="#education">
                Education
            </a>


            <a href="#experience">
                Experience
            </a>


            <a href="#organization">
                Organization
            </a>


            <a href="#projects">
                Projects
            </a>


            <a href="#skills">
                Skills
            </a>


            <a href="#certifications">
                Certifications
            </a>


            <a href="#contact">
                Contact
            </a>


        </div>


        <!-- MOBILE BUTTON -->


        <button
            class="mobile-menu-button"
            id="mobileMenuButton"
            type="button"
            aria-label="Open menu"
        >

            ☰

        </button>


    </div>


    <!-- MOBILE MENU -->


    <div
        class="mobile-menu"
        id="mobileMenu"
    >


        <a href="#home">
            Home
        </a>


        <a href="#about">
            About
        </a>


        <a href="#education">
            Education
        </a>


        <a href="#experience">
            Experience
        </a>


        <a href="#organization">
            Organization
        </a>


        <a href="#projects">
            Projects
        </a>


        <a href="#skills">
            Skills
        </a>


        <a href="#certifications">
            Certifications
        </a>


        <a href="#contact">
            Contact
        </a>


    </div>


</nav>



<!-- =========================================================
     HERO
========================================================= -->


<section
    class="hero"
    id="home"
>


    <div class="container hero-grid">


        <!-- HERO TEXT -->


        <div class="hero-content">


            <p class="hero-eyebrow">
                Hello, I'm
            </p>


            <h1 class="hero-title">

                <?= e(
                    $profile['full_name']
                ); ?>

            </h1>


            <h2 class="hero-subtitle">

                <?= e(
                    $profile['professional_title']
                ); ?>

            </h2>


            <p class="hero-description">

                <?= e(
                    $profile['short_bio']
                ); ?>

            </p>


            <!-- HERO BUTTONS -->


            <div class="hero-actions">


                <a
                    href="#about"
                    class="btn btn-primary"
                >
                    About Me
                </a>


                <a
                    href="#contact"
                    class="btn btn-outline"
                >
                    Get in Touch
                </a>


            </div>


            <!-- SOCIAL LINKS -->


            <div class="hero-socials">


                <?php if (
                    !empty(
                        $profile['linkedin_url']
                    )
                ): ?>

                    <a
                        href="<?= e(
                            $profile['linkedin_url']
                        ); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        LinkedIn
                    </a>

                <?php endif; ?>


                <?php if (
                    !empty(
                        $profile['github_url']
                    )
                ): ?>

                    <a
                        href="<?= e(
                            $profile['github_url']
                        ); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        GitHub
                    </a>

                <?php endif; ?>


                <?php if (
                    !empty(
                        $profile['instagram_url']
                    )
                ): ?>

                    <a
                        href="<?= e(
                            $profile['instagram_url']
                        ); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Instagram
                    </a>

                <?php endif; ?>


            </div>


        </div>



        <!-- HERO IMAGE -->


        <div class="hero-image-wrapper">


            <?php if (
                !empty(
                    $profile['profile_image']
                )
            ): ?>


                <div class="hero-image-container">


                    <img
                        src="assets/images/profile/<?= e(
                            $profile['profile_image']
                        ); ?>"
                        alt="<?= e(
                            $profile['full_name']
                        ); ?>"
                        class="hero-image"
                    >


                </div>


            <?php else: ?>


                <div class="hero-image-placeholder">

                    <span>
                        <?= e(
                            strtoupper(
                                substr(
                                    $profile['full_name'],
                                    0,
                                    1
                                )
                            )
                        ); ?>
                    </span>

                </div>


            <?php endif; ?>


        </div>


    </div>


</section>



<!-- =========================================================
     ABOUT
========================================================= -->


<section
    class="section about-section"
    id="about"
>


    <div class="container">


        <div class="section-heading">


            <p class="section-eyebrow">
                About
            </p>


            <h2 class="section-title">
                A little about me
            </h2>


        </div>



        <div class="about-grid">


            <!-- ABOUT TEXT -->


            <div class="about-content">


                <p class="about-text">

                    <?= nl2br(
                        e(
                            $profile['about_me']
                        )
                    ); ?>

                </p>


            </div>



            <!-- ABOUT INFO -->


            <div class="about-info">


                <?php if (
                    !empty(
                        $profile['location']
                    )
                ): ?>


                    <div class="info-item">


                        <span class="info-label">
                            Location
                        </span>


                        <span class="info-value">

                            <?= e(
                                $profile['location']
                            ); ?>

                        </span>


                    </div>


                <?php endif; ?>



                <?php if (
                    !empty(
                        $profile['email']
                    )
                ): ?>


                    <div class="info-item">


                        <span class="info-label">
                            Email
                        </span>


                        <a
                            href="mailto:<?= e(
                                $profile['email']
                            ); ?>"
                            class="info-value"
                        >

                            <?= e(
                                $profile['email']
                            ); ?>

                        </a>


                    </div>


                <?php endif; ?>



                <?php if (
                    !empty(
                        $profile['phone']
                    )
                ): ?>


                    <div class="info-item">


                        <span class="info-label">
                            Phone
                        </span>


                        <a
                            href="https://wa.me/<?= e(
                                $profile['phone']
                            ); ?>"
                            class="info-value"
                        >

                            <?= e(
                                $profile['phone']
                            ); ?>

                        </a>


                    </div>


                <?php endif; ?>


            </div>


        </div>


    </div>


</section>



<!-- =========================================================
     SECTION PLACEHOLDERS
========================================================= -->


<!-- =========================================================
     EDUCATION
========================================================= -->


<section
    class="section education-section"
    id="education"
>


    <div class="container">


        <!-- SECTION HEADER -->


        <div class="section-heading">


            <p class="section-eyebrow">
                Education
            </p>


            <h2 class="section-title">
                Academic Journey
            </h2>


        </div>



        <?php if (
            count($educations) > 0
        ): ?>


            <div class="education-list">


                <?php foreach (
                    $educations as $education
                ): ?>


                    <article
                        class="education-item"
                    >


                        <!-- LOGO -->


                        <div class="education-logo">


                            <?php if (
                                !empty(
                                    $education['logo']
                                )
                            ): ?>


                                <img
                                    src="assets/images/education/<?= e(
                                        $education['logo']
                                    ); ?>"
                                    alt="<?= e(
                                        $education['institution']
                                    ); ?>"
                                >


                            <?php else: ?>


                                <div
                                    class="education-logo-placeholder"
                                >

                                    <?= e(
                                        strtoupper(
                                            substr(
                                                $education[
                                                    'institution'
                                                ],
                                                0,
                                                1
                                            )
                                        )
                                    ); ?>

                                </div>


                            <?php endif; ?>


                        </div>



                        <!-- CONTENT -->


                        <div
                            class="education-content"
                        >


                            <!-- DATE -->


                            <div
                                class="education-period"
                            >

                                <?= e(
                                    $education[
                                        'start_year'
                                    ]
                                ); ?>


                                —

                                <?php if (
                                    !empty(
                                        $education[
                                            'end_year'
                                        ]
                                    )
                                ): ?>

                                    <?= e(
                                        $education[
                                            'end_year'
                                        ]
                                    ); ?>

                                <?php else: ?>

                                    Present

                                <?php endif; ?>


                            </div>



                            <!-- INSTITUTION -->


                            <h3
                                class="education-institution"
                            >

                                <?= e(
                                    $education[
                                        'institution'
                                    ]
                                ); ?>

                            </h3>



                            <!-- DEGREE + FIELD -->


                            <?php if (
                                !empty(
                                    $education[
                                        'degree'
                                    ]
                                ) ||
                                !empty(
                                    $education[
                                        'field'
                                    ]
                                )
                            ): ?>


                                <p
                                    class="education-degree"
                                >

                                    <?php if (
                                        !empty(
                                            $education[
                                                'degree'
                                            ]
                                        )
                                    ): ?>

                                        <?= e(
                                            $education[
                                                'degree'
                                            ]
                                        ); ?>

                                    <?php endif; ?>


                                    <?php if (
                                        !empty(
                                            $education[
                                                'degree'
                                            ]
                                        ) &&
                                        !empty(
                                            $education[
                                                'field'
                                            ]
                                        )
                                    ): ?>

                                        <span>
                                            ·
                                        </span>

                                    <?php endif; ?>


                                    <?php if (
                                        !empty(
                                            $education[
                                                'field'
                                            ]
                                        )
                                    ): ?>

                                        <?= e(
                                            $education[
                                                'field'
                                            ]
                                        ); ?>

                                    <?php endif; ?>

                                </p>


                            <?php endif; ?>



                            <!-- DESCRIPTION -->


                            <?php if (
                                !empty(
                                    $education[
                                        'description'
                                    ]
                                )
                            ): ?>


                                <p
                                    class="education-description"
                                >

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


                    </article>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <div
                class="empty-section"
            >

                <p>
                    No education information available yet.
                </p>

            </div>


        <?php endif; ?>


    </div>


</section>



<!-- =========================================================
     EXPERIENCE
========================================================= -->


<section
    class="section experience-section"
    id="experience"
>


    <div class="container">


        <!-- SECTION HEADER -->


        <div class="section-heading">


            <p class="section-eyebrow">
                Experience
            </p>


            <h2 class="section-title">
                Professional Experience
            </h2>


        </div>



        <?php if (
            count($experiences) > 0
        ): ?>


            <div class="experience-list">


                <?php foreach (
                    $experiences as $experience
                ): ?>


                    <article
                        class="experience-item"
                    >


                        <!-- =================================================
                             COMPANY LOGO
                        ================================================== -->


                        <div
                            class="experience-logo"
                        >


                            <?php if (
                                !empty(
                                    $experience[
                                        'logo'
                                    ]
                                )
                            ): ?>


                                <img
                                    src="assets/images/experience/<?= e(
                                        $experience[
                                            'logo'
                                        ]
                                    ); ?>"
                                    alt="<?= e(
                                        $experience[
                                            'company'
                                        ]
                                    ); ?>"
                                >


                            <?php else: ?>


                                <div
                                    class="experience-logo-placeholder"
                                >

                                    <?= e(
                                        strtoupper(
                                            substr(
                                                $experience[
                                                    'company'
                                                ],
                                                0,
                                                1
                                            )
                                        )
                                    ); ?>

                                </div>


                            <?php endif; ?>


                        </div>



                        <!-- =================================================
                             EXPERIENCE CONTENT
                        ================================================== -->


                        <div
                            class="experience-content"
                        >


                            <!-- PERIOD -->


                            <div
                                class="experience-period"
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



                            <!-- COMPANY -->


                            <h3
                                class="experience-company"
                            >

                                <?= e(
                                    $experience[
                                        'company'
                                    ]
                                ); ?>

                            </h3>



                            <!-- POSITION -->


                            <?php if (
                                !empty(
                                    $experience[
                                        'position'
                                    ]
                                )
                            ): ?>


                                <p
                                    class="experience-position"
                                >

                                    <?= e(
                                        $experience[
                                            'position'
                                        ]
                                    ); ?>

                                </p>


                            <?php endif; ?>



                            <!-- DESCRIPTION -->


                            <?php if (
                                !empty(
                                    $experience[
                                        'description'
                                    ]
                                )
                            ): ?>


                                <div class="experience-description">

                                    <?php

                                    $experienceLines = preg_split(
                                        '/\r\n|\r|\n/',
                                        trim(
                                            $experience['description'] ?? ''
                                        )
                                    );

                                    ?>

                                    <?php if (
                                        count($experienceLines) > 0
                                    ): ?>

                                        <ul class="experience-bullets">

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

                                    <?php endif; ?>

                                </div>


                            <?php endif; ?>



                            <!-- =================================================
                                 GALLERY
                            ================================================== -->


                            <?php

                            $experienceId =
                                $experience['id'];

                            $gallery =
                                $experienceGalleries[
                                    $experienceId
                                ] ?? [];

                            ?>


                            <?php if (
                                count($gallery) > 0
                            ): ?>


                                <div
                                    class="experience-gallery"
                                >


                                    <?php foreach (
                                        $gallery as $photo
                                    ): ?>


                                        <a
                                            href="assets/images/experience/<?= e(
                                                $photo[
                                                    'image'
                                                ]
                                            ); ?>"
                                            class="experience-gallery-item"
                                            target="_blank"
                                        >

                                            <img
                                                src="assets/images/experience/<?= e(
                                                    $photo[
                                                        'image'
                                                    ]
                                                ); ?>"
                                                alt="<?= e(
                                                    $photo[
                                                        'caption'
                                                    ] ?? $experience[
                                                        'company'
                                                    ]
                                                ); ?>"
                                                loading="lazy"
                                            >

                                        </a>


                                    <?php endforeach; ?>


                                </div>


                            <?php endif; ?>


                        </div>


                    </article>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <div
                class="empty-section"
            >

                <p>
                    No professional experience available yet.
                </p>

            </div>


        <?php endif; ?>


    </div>


</section>



<!-- =========================================================
     ORGANIZATION
========================================================= -->


<section
    class="section organization-section"
    id="organization"
>


    <div class="container">


        <!-- SECTION HEADER -->


        <div class="section-heading">


            <p class="section-eyebrow">
                Organization
            </p>


            <h2 class="section-title">
                Organizational Experience
            </h2>


        </div>



        <?php if (
            count($organizations) > 0
        ): ?>


            <div class="organization-list">


                <?php foreach (
                    $organizations as $organization
                ): ?>


                    <article
                        class="organization-item"
                    >


                        <!-- LOGO -->


                        <div
                            class="organization-logo"
                        >


                            <?php if (
                                !empty(
                                    $organization['logo']
                                )
                            ): ?>


                                <img
                                    src="assets/images/organization/<?= e(
                                        $organization['logo']
                                    ); ?>"
                                    alt="<?= e(
                                        $organization[
                                            'organization_name'
                                        ]
                                    ); ?>"
                                >


                            <?php else: ?>


                                <div
                                    class="organization-logo-placeholder"
                                >

                                    <?= e(
                                        strtoupper(
                                            substr(
                                                $organization[
                                                    'organization_name'
                                                ],
                                                0,
                                                1
                                            )
                                        )
                                    ); ?>

                                </div>


                            <?php endif; ?>


                        </div>



                        <!-- CONTENT -->


                        <div
                            class="organization-content"
                        >


                            <!-- PERIOD -->


                            <div
                                class="organization-period"
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



                            <!-- ORGANIZATION NAME -->


                            <h3
                                class="organization-name"
                            >

                                <?= e(
                                    $organization[
                                        'organization_name'
                                    ]
                                ); ?>

                            </h3>



                            <!-- POSITION -->


                            <?php if (
                                !empty(
                                    $organization[
                                        'position'
                                    ]
                                )
                            ): ?>


                                <p
                                    class="organization-position"
                                >

                                    <?= e(
                                        $organization[
                                            'position'
                                        ]
                                    ); ?>

                                </p>


                            <?php endif; ?>



                            <!-- DESCRIPTION -->


                            <?php if (
                                !empty(
                                    $organization[
                                        'description'
                                    ]
                                )
                            ): ?>


                                <div class="organization-description">

                                    <?php

                                    $organizationLines = preg_split(
                                        '/\r\n|\r|\n/',
                                        trim(
                                            $organization['description'] ?? ''
                                        )
                                    );

                                    ?>

                                    <?php if (
                                        count($organizationLines) > 0
                                    ): ?>

                                        <ul class="organization-bullets">

                                            <?php foreach (
                                                $organizationLines as $line
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

                                    <?php endif; ?>

                                </div>


                            <?php endif; ?>



                            <!-- GALLERY -->


                            <?php

                            $organizationId =
                                $organization['id'];

                            $gallery =
                                $organizationGalleries[
                                    $organizationId
                                ] ?? [];

                            ?>


                            <?php if (
                                count($gallery) > 0
                            ): ?>


                                <div
                                    class="organization-gallery"
                                >


                                    <?php foreach (
                                        $gallery as $photo
                                    ): ?>


                                        <a
                                            href="assets/images/organization/<?= e(
                                                $photo['image']
                                            ); ?>"
                                            class="organization-gallery-item"
                                            target="_blank"
                                        >

                                            <img
                                                src="assets/images/organization/<?= e(
                                                    $photo['image']
                                                ); ?>"
                                                alt="<?= e(
                                                    $photo['caption']
                                                    ?? $organization[
                                                        'organization_name'
                                                    ]
                                                ); ?>"
                                                loading="lazy"
                                            >

                                        </a>


                                    <?php endforeach; ?>


                                </div>


                            <?php endif; ?>


                        </div>


                    </article>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <div class="empty-section">

                <p>
                    No organizational experience available yet.
                </p>

            </div>


        <?php endif; ?>


    </div>


</section>



<!-- =========================================================
     PROJECTS
========================================================= -->


<section
    class="section projects-section"
    id="projects"
>


    <div class="container">


        <!-- SECTION HEADER -->


        <div class="section-heading">


            <p class="section-eyebrow">
                Projects
            </p>


            <h2 class="section-title">
                Selected Works
            </h2>


        </div>



        <?php if (
            count($projects) > 0
        ): ?>


            <div class="projects-grid">


                <?php foreach (
                    $projects as $project
                ): ?>


                    <?php

                    $projectId =
                        $project['id'];

                    $gallery =
                        $projectGalleries[
                            $projectId
                        ] ?? [];

                    ?>


                    <article
                        class="project-card"
                    >


                        <!-- =================================================
                             PROJECT COVER
                        ================================================== -->


                        <div
                            class="project-cover"
                        >


                            <?php if (
                                !empty(
                                    $project['cover_image']
                                )
                            ): ?>


                                <img
                                    src="assets/images/projects/<?= e(
                                        $project[
                                            'cover_image'
                                        ]
                                    ); ?>"
                                    alt="<?= e(
                                        $project[
                                            'title'
                                        ]
                                    ); ?>"
                                    loading="lazy"
                                >


                            <?php else: ?>


                                <div
                                    class="project-cover-placeholder"
                                >

                                    <span>
                                        Project
                                    </span>

                                </div>


                            <?php endif; ?>


                        </div>



                        <!-- =================================================
                             PROJECT CONTENT
                        ================================================== -->


                        <div
                            class="project-content"
                        >


                            <!-- META -->


                            <div
                                class="project-meta"
                            >


                                <?php if (
                                    !empty(
                                        $project[
                                            'category'
                                        ]
                                    )
                                ): ?>

                                    <span>
                                        <?= e(
                                            $project[
                                                'category'
                                            ]
                                        ); ?>
                                    </span>

                                <?php endif; ?>


                            </div>



                            <!-- TITLE -->


                            <h3
                                class="project-title"
                            >

                                <?= e(
                                    $project[
                                        'title'
                                    ]
                                ); ?>

                            </h3>



                            <!-- DESCRIPTION -->


                            <?php if (
                                !empty(
                                    $project[
                                        'description'
                                    ]
                                )
                            ): ?>


                                <p
                                    class="project-description"
                                >

                                    <?= e(
                                        $project[
                                            'description'
                                        ]
                                    ); ?>

                                </p>


                            <?php endif; ?>



                            <!-- TECHNOLOGIES -->


                            <?php if (
                                !empty(
                                    $project[
                                        'technologies'
                                    ]
                                )
                            ): ?>


                                <div
                                    class="project-technologies"
                                >


                                    <?php

                                    $technologies =
                                        explode(
                                            ',',
                                            $project[
                                                'technologies'
                                            ]
                                        );

                                    ?>


                                    <?php foreach (
                                        $technologies
                                        as $technology
                                    ): ?>


                                        <?php

                                        $technology =
                                            trim(
                                                $technology
                                            );

                                        ?>


                                        <?php if (
                                            $technology
                                            !== ''
                                        ): ?>


                                            <span>
                                                <?= e(
                                                    $technology
                                                ); ?>
                                            </span>


                                        <?php endif; ?>


                                    <?php endforeach; ?>


                                </div>


                            <?php endif; ?>



                            <!-- LINKS -->


                            <div
                                class="project-links"
                            >


                                <?php if (
                                    !empty(
                                        $project[
                                            'github_url'
                                        ]
                                    )
                                ): ?>


                                    <a
                                        href="<?= e(
                                            $project[
                                                'github_url'
                                            ]
                                        ); ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >

                                        GitHub
                                        ↗

                                    </a>


                                <?php endif; ?>



                                <?php if (
                                    !empty(
                                        $project[
                                            'project_url'
                                        ]
                                    )
                                ): ?>


                                    <a
                                        href="<?= e(
                                            $project[
                                                'project_url'
                                            ]
                                        ); ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >

                                        Project Demo
                                        ↗

                                    </a>


                                <?php endif; ?>


                            </div>



                            <!-- =================================================
                                 GALLERY
                            ================================================== -->


                            <?php if (
                                count($gallery) > 0
                            ): ?>


                                <div
                                    class="project-gallery"
                                >


                                    <?php foreach (
                                        array_slice(
                                            $gallery,
                                            0,
                                            4
                                        )
                                        as $photo
                                    ): ?>


                                        <a
                                            href="assets/images/projects/<?= e(
                                                $photo[
                                                    'image'
                                                ]
                                            ); ?>"
                                            class="project-gallery-item"
                                            target="_blank"
                                        >

                                            <img
                                                src="assets/images/projects/<?= e(
                                                    $photo[
                                                        'image'
                                                    ]
                                                ); ?>"
                                                alt="<?= e(
                                                    $photo[
                                                        'caption'
                                                    ]
                                                    ?? $project[
                                                        'title'
                                                    ]
                                                ); ?>"
                                                loading="lazy"
                                            >

                                        </a>


                                    <?php endforeach; ?>


                                </div>


                            <?php endif; ?>


                        </div>


                    </article>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <div
                class="empty-section"
            >

                <p>
                    No projects available yet.
                </p>

            </div>


        <?php endif; ?>


    </div>


</section>



<!-- =========================================================
     SKILLS
========================================================= -->


<section
    class="section skills-section"
    id="skills"
>


    <div class="container">


        <!-- SECTION HEADER -->


        <div class="section-heading">


            <p class="section-eyebrow">
                Skills
            </p>


            <h2 class="section-title">
                Skills & Capabilities
            </h2>


        </div>



        <div class="skills-grid">


            <!-- =================================================
                 HARD SKILLS
            ================================================== -->


            <div class="skills-group">


                <div class="skills-group-header">


                    <span class="skills-number">
                        01
                    </span>


                    <h3>
                        Technical Skills
                    </h3>


                </div>



                <?php if (
                    count($hardSkills) > 0
                ): ?>


                    <div class="skills-list">


                        <?php foreach (
                            $hardSkills as $skill
                        ): ?>


                            <div
                                class="skill-item"
                            >


                                <div
                                    class="skill-item-top"
                                >


                                    <span
                                        class="skill-name"
                                    >

                                        <?= e(
                                            $skill[
                                                'skill_name'
                                            ]
                                        ); ?>

                                    </span>


                                    <?php if (
                                        $skill[
                                            'proficiency'
                                        ] !== null &&
                                        $skill[
                                            'proficiency'
                                        ] !== ''
                                    ): ?>


                                        <span
                                            class="skill-level"
                                        >

                                            <?= e(
                                                $skill[
                                                    'proficiency'
                                                ]
                                            ); ?>%

                                        </span>


                                    <?php endif; ?>


                                </div>



                                <!-- PROFICIENCY BAR -->


                                <?php if (
                                    $skill[
                                        'proficiency'
                                    ] !== null &&
                                    $skill[
                                        'proficiency'
                                    ] !== ''
                                ): ?>


                                    <div
                                        class="skill-bar"
                                    >


                                        <div
                                            class="skill-bar-fill"
                                            style="
                                                width:
                                                <?= max(
                                                    0,
                                                    min(
                                                        100,
                                                        (int)
                                                        $skill[
                                                            'proficiency'
                                                        ]
                                                    )
                                                ); ?>%;
                                            "
                                        ></div>


                                    </div>


                                <?php endif; ?>


                            </div>


                        <?php endforeach; ?>


                    </div>


                <?php else: ?>


                    <div
                        class="skills-empty"
                    >

                        No technical skills available yet.

                    </div>


                <?php endif; ?>


            </div>



            <!-- =================================================
                 SOFT SKILLS
            ================================================== -->


            <div class="skills-group">


                <div class="skills-group-header">


                    <span class="skills-number">
                        02
                    </span>


                    <h3>
                        Soft Skills
                    </h3>


                </div>



                <?php if (
                    count($softSkills) > 0
                ): ?>


                    <div class="skills-list">


                        <?php foreach (
                            $softSkills as $skill
                        ): ?>


                            <div
                                class="skill-item"
                            >


                                <div
                                    class="skill-item-top"
                                >


                                    <span
                                        class="skill-name"
                                    >

                                        <?= e(
                                            $skill[
                                                'skill_name'
                                            ]
                                        ); ?>

                                    </span>


                                    <?php if (
                                        $skill[
                                            'proficiency'
                                        ] !== null &&
                                        $skill[
                                            'proficiency'
                                        ] !== ''
                                    ): ?>


                                        <span
                                            class="skill-level"
                                        >

                                            <?= e(
                                                $skill[
                                                    'proficiency'
                                                ]
                                            ); ?>%

                                        </span>


                                    <?php endif; ?>


                                </div>



                                <?php if (
                                    $skill[
                                        'proficiency'
                                    ] !== null &&
                                    $skill[
                                        'proficiency'
                                    ] !== ''
                                ): ?>


                                    <div
                                        class="skill-bar"
                                    >


                                        <div
                                            class="skill-bar-fill"
                                            style="
                                                width:
                                                <?= max(
                                                    0,
                                                    min(
                                                        100,
                                                        (int)
                                                        $skill[
                                                            'proficiency'
                                                        ]
                                                    )
                                                ); ?>%;
                                            "
                                        ></div>


                                    </div>


                                <?php endif; ?>


                            </div>


                        <?php endforeach; ?>


                    </div>


                <?php else: ?>


                    <div
                        class="skills-empty"
                    >

                        No soft skills available yet.

                    </div>


                <?php endif; ?>


            </div>


        </div>


    </div>


</section>



<!-- =========================================================
     CERTIFICATIONS
========================================================= -->


<section
    class="section certifications-section"
    id="certifications"
>


    <div class="container">


        <!-- SECTION HEADER -->


        <div class="section-heading">


            <p class="section-eyebrow">
                Certifications
            </p>


            <h2 class="section-title">
                Certifications & Credentials
            </h2>


        </div>



        <?php if (
            count($certifications) > 0
        ): ?>


            <div class="certifications-grid">


                <?php foreach (
                    $certifications as $certification
                ): ?>


                    <article
                        class="certification-card"
                    >


                        <!-- =================================================
                             CERTIFICATE IMAGE
                        ================================================== -->


                        <div
                            class="certification-image"
                        >


                            <?php if (
                                !empty(
                                    $certification[
                                        'certificate_image'
                                    ]
                                )
                            ): ?>


                                <img
                                    src="assets/images/certifications/<?= e(
                                        $certification[
                                            'certificate_image'
                                        ]
                                    ); ?>"
                                    alt="<?= e(
                                        $certification[
                                            'certification_name'
                                        ]
                                    ); ?>"
                                    loading="lazy"
                                >


                            <?php else: ?>


                                <div
                                    class="certification-image-placeholder"
                                >

                                    <span>
                                        Certificate
                                    </span>

                                </div>


                            <?php endif; ?>


                        </div>



                        <!-- =================================================
                             CERTIFICATE CONTENT
                        ================================================== -->


                        <div
                            class="certification-content"
                        >


                            <!-- ISSUER -->


                            <p
                                class="certification-issuer"
                            >

                                <?= e(
                                    $certification[
                                        'issuer'
                                    ]
                                ); ?>

                            </p>



                            <!-- NAME -->


                            <h3
                                class="certification-name"
                            >

                                <?= e(
                                    $certification[
                                        'certification_name'
                                    ]
                                ); ?>

                            </h3>



                            <!-- ISSUE DATE -->


                            <div
                                class="certification-date"
                            >

                                <?php if (
                                    !empty(
                                        $certification[
                                            'issue_date'
                                        ]
                                    )
                                ): ?>

                                    Issued

                                    <?= e(
                                        date(
                                            'F Y',
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
                                            'expiration_date'
                                        ]
                                    )
                                ): ?>


                                    <span>
                                        ·
                                    </span>

                                    Expires

                                    <?= e(
                                        date(
                                            'F Y',
                                            strtotime(
                                                $certification[
                                                    'expiration_date'
                                                ]
                                            )
                                        )
                                    ); ?>


                                <?php endif; ?>


                            </div>



                            <!-- CREDENTIAL ID -->


                            <?php if (
                                !empty(
                                    $certification[
                                        'credential_id'
                                    ]
                                )
                            ): ?>


                                <div
                                    class="certification-credential"
                                >

                                    <span>
                                        Credential ID
                                    </span>

                                    <strong>
                                        <?= e(
                                            $certification[
                                                'credential_id'
                                            ]
                                        ); ?>
                                    </strong>

                                </div>


                            <?php endif; ?>



                            <!-- DESCRIPTION -->


                            <?php if (
                                !empty(
                                    $certification[
                                        'description'
                                    ]
                                )
                            ): ?>


                                <p
                                    class="certification-description"
                                >

                                    <?= nl2br(
                                        e(
                                            $certification[
                                                'description'
                                            ]
                                        )
                                    ); ?>

                                </p>


                            <?php endif; ?>



                            <!-- CREDENTIAL URL -->


                            <?php if (
                                !empty(
                                    $certification[
                                        'credential_url'
                                    ]
                                )
                            ): ?>


                                <div
                                    class="certification-link"
                                >

                                    <a
                                        href="<?= e(
                                            $certification[
                                                'credential_url'
                                            ]
                                        ); ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >

                                        View Credential
                                        ↗

                                    </a>

                                </div>


                            <?php endif; ?>


                        </div>


                    </article>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <div
                class="empty-section"
            >

                <p>
                    No certifications available yet.
                </p>

            </div>


        <?php endif; ?>


    </div>


</section>



<!-- =========================================================
     CONTACT
========================================================= -->


<section
    class="section contact-section"
    id="contact"
>


    <div class="container">


        <div class="contact-wrapper">


            <!-- =================================================
                 LEFT
            ================================================== -->


            <div class="contact-intro">


                <p class="section-eyebrow">
                    Contact
                </p>


                <h2 class="contact-title">
                    Let's work
                    <br>
                    together.
                </h2>


                <p class="contact-description">

                    Have a project, opportunity,
                    or just want to say hello?
                    Feel free to reach out.

                </p>


            </div>



            <!-- =================================================
                 RIGHT
            ================================================== -->


            <div class="contact-details">


                <!-- EMAIL -->


                <?php if (
                    !empty(
                        $profile['email']
                    )
                ): ?>


                    <a
                        href="mailto:<?= e(
                            $profile['email']
                        ); ?>"
                        class="contact-item"
                    >


                        <span
                            class="contact-label"
                        >
                            Email
                        </span>


                        <span
                            class="contact-value"
                        >

                            <?= e(
                                $profile['email']
                            ); ?>

                        </span>


                    </a>


                <?php endif; ?>



                <!-- LOCATION -->


                <?php if (
                    !empty(
                        $profile['location']
                    )
                ): ?>


                    <div
                        class="contact-item"
                    >


                        <span
                            class="contact-label"
                        >
                            Location
                        </span>


                        <span
                            class="contact-value"
                        >

                            <?= e(
                                $profile['location']
                            ); ?>

                        </span>


                    </div>


                <?php endif; ?>



                <!-- SOCIAL LINKS -->


                <div
                    class="contact-socials"
                >


                    <?php if (
                        !empty(
                            $profile[
                                'linkedin_url'
                            ]
                        )
                    ): ?>


                        <a
                            href="<?= e(
                                $profile[
                                    'linkedin_url'
                                ]
                            ); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                        >

                            LinkedIn
                            ↗

                        </a>


                    <?php endif; ?>



                    <?php if (
                        !empty(
                            $profile[
                                'github_url'
                            ]
                        )
                    ): ?>


                        <a
                            href="<?= e(
                                $profile[
                                    'github_url'
                                ]
                            ); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                        >

                            GitHub
                            ↗

                        </a>


                    <?php endif; ?>


                </div>



                <!-- CV -->


                <div
                    class="contact-cv"
                >


                    <a
                        href="cv/download.php"
                        class="contact-cv-button"
                    >

                        Download CV
                        ↓

                    </a>


                </div>


            </div>


        </div>


    </div>


</section>



<!-- =========================================================
     FOOTER
========================================================= -->


<footer class="footer">


    <div class="container">


        <p>

            © <?= date('Y'); ?>

            <?= e(
                $profile['full_name']
            ); ?>

            . All rights reserved.

        </p>


    </div>


</footer>



<script>

const mobileMenuButton =
    document.getElementById(
        'mobileMenuButton'
    );

const mobileMenu =
    document.getElementById(
        'mobileMenu'
    );


mobileMenuButton.addEventListener(
    'click',
    function () {

        mobileMenu.classList.toggle(
            'active'
        );

    }
);


document
    .querySelectorAll(
        '.mobile-menu a'
    )
    .forEach(
        function (link) {

            link.addEventListener(
                'click',
                function () {

                    mobileMenu.classList.remove(
                        'active'
                    );

                }
            );

        }
    );

</script>


</body>

</html>