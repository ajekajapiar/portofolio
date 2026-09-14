<?php

$currentPage = basename(
    $_SERVER['PHP_SELF']
);

$currentPath = $_SERVER['PHP_SELF'];

?>


<aside class="sidebar">


    <!-- =====================================================
         BRAND
    ====================================================== -->


    <div class="sidebar-brand">

        <h2>
            PORTFOLIO
        </h2>

        <p>
            Administrator Panel
        </p>

    </div>



    <!-- =====================================================
         MENU
    ====================================================== -->


    <nav class="sidebar-menu">


        <!-- DASHBOARD -->


        <a
            href="/admin/dashboard.php"
            class="<?= strpos(
                $currentPath,
                '/admin/dashboard.php'
            ) !== false
                ? 'active'
                : ''; ?>"
        >

            <span class="sidebar-icon">
                ⌂
            </span>

            <span>
                Dashboard
            </span>

        </a>



        <!-- PROFILE -->


        <a
            href="/admin/profile.php"
            class="<?= strpos(
                $currentPath,
                '/admin/profile.php'
            ) !== false
                ? 'active'
                : ''; ?>"
        >

            <span class="sidebar-icon">
                ◉
            </span>

            <span>
                Profile
            </span>

        </a>



        <!-- EDUCATION -->


        <a
            href="/admin/education/index.php"
            class="<?= strpos(
                $currentPath,
                '/admin/education/'
            ) !== false
                ? 'active'
                : ''; ?>"
        >

            <span class="sidebar-icon">
                ▣
            </span>

            <span>
                Education
            </span>

        </a>



        <!-- EXPERIENCE -->


        <a
            href="/admin/experience/index.php"
            class="<?= strpos(
                $currentPath,
                '/admin/experience/'
            ) !== false
                ? 'active'
                : ''; ?>"
        >

            <span class="sidebar-icon">
                ▤
            </span>

            <span>
                Experience
            </span>

        </a>



        <!-- ORGANIZATION -->


        <a
            href="/admin/organization/index.php"
            class="<?= strpos(
                $currentPath,
                '/admin/organization/'
            ) !== false
                ? 'active'
                : ''; ?>"
        >

            <span class="sidebar-icon">
                ◎
            </span>

            <span>
                Organization
            </span>

        </a>



        <!-- PROJECTS -->


        <a
            href="/admin/projects/index.php"
            class="<?= strpos(
                $currentPath,
                '/admin/projects/'
            ) !== false
                ? 'active'
                : ''; ?>"
        >

            <span class="sidebar-icon">
                ◆
            </span>

            <span>
                Projects
            </span>

        </a>



        <!-- SKILLS -->


        <a
            href="/admin/skills/index.php"
            class="<?= strpos(
                $currentPath,
                '/admin/skills/'
            ) !== false
                ? 'active'
                : ''; ?>"
        >

            <span class="sidebar-icon">
                ★
            </span>

            <span>
                Skills
            </span>

        </a>



        <!-- CERTIFICATIONS -->


        <a
            href="/admin/certifications/index.php"
            class="<?= strpos(
                $currentPath,
                '/admin/certifications/'
            ) !== false
                ? 'active'
                : ''; ?>"
        >

            <span class="sidebar-icon">
                ◈
            </span>

            <span>
                Certifications
            </span>

        </a>


    </nav>



    <!-- =====================================================
         BOTTOM
    ====================================================== -->


    <div class="sidebar-bottom">


        <a
            href="/admin/logout.php"
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