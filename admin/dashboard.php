<?php

require_once 'auth.php';
require_once '../config/database.php';
require_once '../includes/functions.php';


/*
|--------------------------------------------------------------------------
| Get statistics
|--------------------------------------------------------------------------
*/

$profileCount = 0;


$educationCount = 0;


$experienceCount = 0;


$organizationCount = 0;


$projectCount = 0;


$skillCount = 0;


$certificationCount = 0;


/*
|--------------------------------------------------------------------------
| Profile status
|--------------------------------------------------------------------------
*/

$profileStatus = $profileCount > 0
    ? 'Completed'
    : 'Not Set';


$profileStatusClass = $profileCount > 0
    ? 'status-complete'
    : 'status-empty';


/*
|--------------------------------------------------------------------------
| Page title
|--------------------------------------------------------------------------
*/

$pageTitle = 'Dashboard';

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
        Dashboard | Portfolio Admin
    </title>


    <link
        rel="stylesheet"
        href="../assets/css/admin.css"
    >


</head>


<body>


<div class="admin-layout">


    <!-- =====================================================
         SIDEBAR
    ====================================================== -->


    <aside class="sidebar">


        <!-- BRAND -->

        <div class="sidebar-brand">

            <h2>PORTFOLIO</h2>

            <p>
                Administrator Panel
            </p>

        </div>



        <!-- MENU -->

        <nav class="sidebar-menu">


            <!-- DASHBOARD -->

            <a
                href="dashboard.php"
                class="active"
            >

                <span class="sidebar-icon">
                    ⌂
                </span>

                <span>
                    Dashboard
                </span>

            </a>



            <!-- PROFILE -->

            <a href="profile.php">

                <span class="sidebar-icon">
                    ◉
                </span>

                <span>
                    Profile
                </span>

            </a>



            <!-- EDUCATION -->

            <a href="education/index.php">

                <span class="sidebar-icon">
                    ▣
                </span>

                <span>
                    Education
                </span>

            </a>



            <!-- EXPERIENCE -->

            <a href="experience/index.php">

                <span class="sidebar-icon">
                    ▤
                </span>

                <span>
                    Experience
                </span>

            </a>



            <!-- ORGANIZATION -->

            <a href="organization/index.php">

                <span class="sidebar-icon">
                    ◎
                </span>

                <span>
                    Organization
                </span>

            </a>



            <!-- PROJECTS -->

            <a href="projects/index.php">

                <span class="sidebar-icon">
                    ◆
                </span>

                <span>
                    Projects
                </span>

            </a>



            <!-- SKILLS -->

            <a href="skills/index.php">

                <span class="sidebar-icon">
                    ★
                </span>

                <span>
                    Skills
                </span>

            </a>



            <!-- CERTIFICATIONS -->

            <a href="certifications/index.php">

                <span class="sidebar-icon">
                    ◈
                </span>

                <span>
                    Certifications
                </span>

            </a>


        </nav>



        <!-- SIDEBAR BOTTOM -->

        <div class="sidebar-bottom">


            <a
                href="logout.php"
                class="sidebar-menu-link"
                style="
                    display:flex;
                    align-items:center;
                    padding:12px 14px;
                    color:#fca5a5;
                    text-decoration:none;
                    font-size:14px;
                "
            >

                <span class="sidebar-icon">
                    ↪
                </span>

                <span>
                    Logout
                </span>

            </a>


        </div>


    </aside>



    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->


    <main class="main-content">


        <!-- TOPBAR -->

        <header class="topbar">


            <div class="topbar-title">

                Dashboard

            </div>


            <div class="topbar-user">

                Logged in as

                <strong>

                    <?= e(
                        $_SESSION['admin_username']
                    ); ?>

                </strong>

            </div>


        </header>



        <!-- =================================================
             CONTENT
        ================================================== -->


        <div class="content">


            <!-- PAGE HEADER -->


            <div class="page-header">


                <div>

                    <h1>
                        Dashboard
                    </h1>

                    <p>
                        Manage and monitor your portfolio content.
                    </p>

                </div>


            </div>



            <!-- =================================================
                 PROFILE OVERVIEW
            ================================================== -->


            <div
                class="card"
                style="
                    margin-bottom:24px;
                "
            >


                <div
                    style="
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                        gap:20px;
                        flex-wrap:wrap;
                    "
                >


                    <div>


                        <div
                            style="
                                font-size:12px;
                                color:#6b7280;
                                text-transform:uppercase;
                                letter-spacing:.08em;
                                font-weight:600;
                                margin-bottom:6px;
                            "
                        >

                            Profile

                        </div>


                        <h2
                            style="
                                margin:0 0 6px;
                                font-size:20px;
                            "
                        >

                            Your personal information

                        </h2>


                        <p
                            style="
                                margin:0;
                                color:#6b7280;
                                font-size:14px;
                            "
                        >

                            Keep your profile information
                            updated for the public portfolio.

                        </p>


                    </div>



                    <div
                        style="
                            display:flex;
                            align-items:center;
                            gap:12px;
                        "
                    >


                        <span
                            class="<?= $profileStatusClass; ?>"
                            style="
                                display:inline-flex;
                                align-items:center;
                                padding:7px 12px;
                                border-radius:999px;
                                font-size:12px;
                                font-weight:600;
                            "
                        >

                            <?= e(
                                $profileStatus
                            ); ?>

                        </span>


                        <a
                            href="profile.php"
                            class="btn btn-primary"
                        >

                            Edit Profile

                        </a>


                    </div>


                </div>


            </div>



            <!-- =================================================
                 STATISTICS
            ================================================== -->


            <div class="stats-grid">


                <!-- EDUCATION -->


                <div class="stat-card">


                    <div class="stat-card-label">

                        Education

                    </div>


                    <div class="stat-card-number">

                        <?= $educationCount; ?>

                    </div>


                    <a
                        href="education/index.php"
                        style="
                            display:inline-block;
                            margin-top:8px;
                            color:#6b7280;
                            font-size:12px;
                            text-decoration:none;
                        "
                    >

                        Manage education →

                    </a>


                </div>



                <!-- EXPERIENCE -->


                <div class="stat-card">


                    <div class="stat-card-label">

                        Experience

                    </div>


                    <div class="stat-card-number">

                        <?= $experienceCount; ?>

                    </div>


                    <a
                        href="experience/index.php"
                        style="
                            display:inline-block;
                            margin-top:8px;
                            color:#6b7280;
                            font-size:12px;
                            text-decoration:none;
                        "
                    >

                        Manage experience →

                    </a>


                </div>



                <!-- ORGANIZATION -->


                <div class="stat-card">


                    <div class="stat-card-label">

                        Organization

                    </div>


                    <div class="stat-card-number">

                        <?= $organizationCount; ?>

                    </div>


                    <a
                        href="organization/index.php"
                        style="
                            display:inline-block;
                            margin-top:8px;
                            color:#6b7280;
                            font-size:12px;
                            text-decoration:none;
                        "
                    >

                        Manage organization →

                    </a>


                </div>



                <!-- PROJECTS -->


                <div class="stat-card">


                    <div class="stat-card-label">

                        Projects

                    </div>


                    <div class="stat-card-number">

                        <?= $projectCount; ?>

                    </div>


                    <a
                        href="projects/index.php"
                        style="
                            display:inline-block;
                            margin-top:8px;
                            color:#6b7280;
                            font-size:12px;
                            text-decoration:none;
                        "
                    >

                        Manage projects →

                    </a>


                </div>



                <!-- SKILLS -->


                <div class="stat-card">


                    <div class="stat-card-label">

                        Skills

                    </div>


                    <div class="stat-card-number">

                        <?= $skillCount; ?>

                    </div>


                    <a
                        href="skills/index.php"
                        style="
                            display:inline-block;
                            margin-top:8px;
                            color:#6b7280;
                            font-size:12px;
                            text-decoration:none;
                        "
                    >

                        Manage skills →

                    </a>


                </div>



                <!-- CERTIFICATIONS -->


                <div class="stat-card">


                    <div class="stat-card-label">

                        Certifications

                    </div>


                    <div class="stat-card-number">

                        <?= $certificationCount; ?>

                    </div>


                    <a
                        href="certifications/index.php"
                        style="
                            display:inline-block;
                            margin-top:8px;
                            color:#6b7280;
                            font-size:12px;
                            text-decoration:none;
                        "
                    >

                        Manage certifications →

                    </a>


                </div>


            </div>



            <!-- =================================================
                 QUICK ACTIONS
            ================================================== -->


            <div
                class="card"
                style="
                    margin-top:24px;
                "
            >


                <div class="card-header">


                    <div>

                        <h2>
                            Quick Actions
                        </h2>

                        <p
                            style="
                                margin-top:5px;
                                color:#6b7280;
                                font-size:13px;
                            "
                        >

                            Quickly add new content to your portfolio.

                        </p>

                    </div>


                </div>



                <div
                    style="
                        display:grid;
                        grid-template-columns:
                            repeat(
                                auto-fit,
                                minmax(180px, 1fr)
                            );
                        gap:12px;
                        margin-top:20px;
                    "
                >


                    <!-- ADD EDUCATION -->


                    <a
                        href="education/add.php"
                        style="
                            display:flex;
                            align-items:center;
                            gap:12px;
                            padding:16px;
                            border:1px solid #e5e7eb;
                            border-radius:10px;
                            text-decoration:none;
                            color:#111827;
                            transition:.2s;
                        "
                    >

                        <span
                            style="
                                font-size:20px;
                            "
                        >
                            +
                        </span>

                        <span>

                            <strong
                                style="
                                    display:block;
                                    font-size:14px;
                                "
                            >
                                Add Education
                            </strong>

                            <small
                                style="
                                    color:#9ca3af;
                                    font-size:11px;
                                "
                            >
                                Add academic history
                            </small>

                        </span>

                    </a>



                    <!-- ADD EXPERIENCE -->


                    <a
                        href="experience/add.php"
                        style="
                            display:flex;
                            align-items:center;
                            gap:12px;
                            padding:16px;
                            border:1px solid #e5e7eb;
                            border-radius:10px;
                            text-decoration:none;
                            color:#111827;
                            transition:.2s;
                        "
                    >

                        <span
                            style="
                                font-size:20px;
                            "
                        >
                            +
                        </span>

                        <span>

                            <strong
                                style="
                                    display:block;
                                    font-size:14px;
                                "
                            >
                                Add Experience
                            </strong>

                            <small
                                style="
                                    color:#9ca3af;
                                    font-size:11px;
                                "
                            >
                                Add work experience
                            </small>

                        </span>

                    </a>



                    <!-- ADD ORGANIZATION -->


                    <a
                        href="organization/add.php"
                        style="
                            display:flex;
                            align-items:center;
                            gap:12px;
                            padding:16px;
                            border:1px solid #e5e7eb;
                            border-radius:10px;
                            text-decoration:none;
                            color:#111827;
                            transition:.2s;
                        "
                    >

                        <span
                            style="
                                font-size:20px;
                            "
                        >
                            +
                        </span>

                        <span>

                            <strong
                                style="
                                    display:block;
                                    font-size:14px;
                                "
                            >
                                Add Organization
                            </strong>

                            <small
                                style="
                                    color:#9ca3af;
                                    font-size:11px;
                                "
                            >
                                Add organizational activity
                            </small>

                        </span>

                    </a>



                    <!-- ADD PROJECT -->


                    <a
                        href="projects/add.php"
                        style="
                            display:flex;
                            align-items:center;
                            gap:12px;
                            padding:16px;
                            border:1px solid #e5e7eb;
                            border-radius:10px;
                            text-decoration:none;
                            color:#111827;
                            transition:.2s;
                        "
                    >

                        <span
                            style="
                                font-size:20px;
                            "
                        >
                            +
                        </span>

                        <span>

                            <strong
                                style="
                                    display:block;
                                    font-size:14px;
                                "
                            >
                                Add Project
                            </strong>

                            <small
                                style="
                                    color:#9ca3af;
                                    font-size:11px;
                                "
                            >
                                Add portfolio project
                            </small>

                        </span>

                    </a>



                    <!-- ADD SKILL -->


                    <a
                        href="skills/add.php"
                        style="
                            display:flex;
                            align-items:center;
                            gap:12px;
                            padding:16px;
                            border:1px solid #e5e7eb;
                            border-radius:10px;
                            text-decoration:none;
                            color:#111827;
                            transition:.2s;
                        "
                    >

                        <span
                            style="
                                font-size:20px;
                            "
                        >
                            +
                        </span>

                        <span>

                            <strong
                                style="
                                    display:block;
                                    font-size:14px;
                                "
                            >
                                Add Skill
                            </strong>

                            <small
                                style="
                                    color:#9ca3af;
                                    font-size:11px;
                                "
                            >
                                Add technical or soft skill
                            </small>

                        </span>

                    </a>



                    <!-- ADD CERTIFICATION -->


                    <a
                        href="certifications/add.php"
                        style="
                            display:flex;
                            align-items:center;
                            gap:12px;
                            padding:16px;
                            border:1px solid #e5e7eb;
                            border-radius:10px;
                            text-decoration:none;
                            color:#111827;
                            transition:.2s;
                        "
                    >

                        <span
                            style="
                                font-size:20px;
                            "
                        >
                            +
                        </span>

                        <span>

                            <strong
                                style="
                                    display:block;
                                    font-size:14px;
                                "
                            >
                                Add Certification
                            </strong>

                            <small
                                style="
                                    color:#9ca3af;
                                    font-size:11px;
                                "
                            >
                                Add certification
                            </small>

                        </span>

                    </a>


                </div>


            </div>



            <!-- =================================================
                 WELCOME CARD
            ================================================== -->


            <div
                class="card"
                style="
                    margin-top:24px;
                "
            >


                <div class="card-header">


                    <h2>
                        Portfolio Overview
                    </h2>


                </div>


                <p
                    style="
                        color:#6b7280;
                        line-height:1.8;
                        font-size:14px;
                    "
                >

                    This dashboard is the central place
                    for managing your personal portfolio.
                    All content added through the administrator
                    panel will be displayed automatically on
                    your public portfolio website.

                </p>


                <div
                    style="
                        margin-top:20px;
                        padding:16px;
                        background:#f9fafb;
                        border-radius:10px;
                        color:#6b7280;
                        font-size:13px;
                        line-height:1.7;
                    "
                >

                    <strong
                        style="
                            color:#111827;
                        "
                    >
                        Tip:
                    </strong>

                    Keep your profile, experience, projects,
                    and certifications updated so your public
                    portfolio and future ATS CV always contain
                    your latest information.

                </div>


            </div>


        </div>


    </main>


</div>


</body>

</html>