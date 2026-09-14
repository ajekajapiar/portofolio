<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


$stmt = $pdo->query("
    SELECT
        p.*,
        (
            SELECT COUNT(*)
            FROM project_gallery pg
            WHERE pg.project_id = p.id
        ) AS gallery_count

    FROM projects p

    ORDER BY
        p.display_order ASC,
        p.created_at DESC,
        p.id DESC
");


$projects = $stmt->fetchAll();


$pageTitle = 'Projects';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>


<main class="main-content">


    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Projects
        </div>

        <div class="topbar-user">

            Logged in as

            <strong>
                <?= e($_SESSION['admin_username']); ?>
            </strong>

        </div>

    </header>


    <!-- CONTENT -->

    <div class="content">


        <!-- HEADER -->

        <div class="page-header">

            <div>

                <h1>Projects</h1>

                <p>
                    Manage your portfolio projects and case studies.
                </p>

            </div>


            <a
                href="add.php"
                class="btn btn-primary"
            >
                + Add Project
            </a>

        </div>


        <!-- MESSAGES -->

        <?php if (isset($_GET['success'])): ?>

            <div
                class="alert"
                style="
                    background:#dcfce7;
                    color:#166534;
                    margin-bottom:20px;
                "
            >
                <?= e($_GET['success']); ?>
            </div>

        <?php endif; ?>


        <?php if (isset($_GET['error'])): ?>

            <div
                class="alert alert-danger"
                style="margin-bottom:20px;"
            >
                <?= e($_GET['error']); ?>
            </div>

        <?php endif; ?>


        <!-- PROJECTS -->

        <div class="card">

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>Project</th>

                            <th>Category</th>

                            <th>Technologies</th>

                            <th>Gallery</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php if (count($projects) > 0): ?>


                            <?php foreach ($projects as $project): ?>


                                <tr>


                                    <!-- PROJECT -->

                                    <td>

                                        <div
                                            style="
                                                display:flex;
                                                align-items:center;
                                                gap:12px;
                                            "
                                        >


                                            <?php if (!empty($project['cover_image'])): ?>

                                                <img
                                                    src="../../assets/images/projects/<?= e($project['cover_image']); ?>"
                                                    alt="<?= e($project['title']); ?>"
                                                    style="
                                                        width:70px;
                                                        height:50px;
                                                        object-fit:cover;
                                                        border-radius:8px;
                                                        border:1px solid #e5e7eb;
                                                    "
                                                >

                                            <?php else: ?>

                                                <div
                                                    style="
                                                        width:70px;
                                                        height:50px;
                                                        display:flex;
                                                        align-items:center;
                                                        justify-content:center;
                                                        background:#f3f4f6;
                                                        border-radius:8px;
                                                        color:#9ca3af;
                                                        font-size:11px;
                                                    "
                                                >
                                                    No Image
                                                </div>

                                            <?php endif; ?>


                                            <strong>
                                                <?= e(
                                                    $project['title']
                                                ); ?>
                                            </strong>


                                        </div>

                                    </td>


                                    <!-- CATEGORY -->

                                    <td>

                                        <?php if (
                                            !empty(
                                                $project['category']
                                            )
                                        ): ?>

                                            <span
                                                style="
                                                    display:inline-block;
                                                    padding:5px 9px;
                                                    background:#f3f4f6;
                                                    border-radius:6px;
                                                    font-size:12px;
                                                "
                                            >
                                                <?= e(
                                                    $project['category']
                                                ); ?>
                                            </span>

                                        <?php else: ?>

                                            -

                                        <?php endif; ?>

                                    </td>


                                    <!-- TECHNOLOGIES -->

                                    <td>

                                        <?= e(
                                            $project['technologies']
                                        ); ?>

                                    </td>


                                    <!-- GALLERY -->

                                    <td>

                                        <?= e(
                                            $project['gallery_count']
                                        ); ?>

                                        photos

                                    </td>


                                    <!-- ACTION -->

                                    <td>

                                        <div class="actions">


                                            <a
                                                href="edit.php?id=<?= $project['id']; ?>"
                                                class="btn btn-secondary"
                                            >
                                                Edit
                                            </a>


                                            <a
                                                href="gallery.php?id=<?= $project['id']; ?>"
                                                class="btn btn-secondary"
                                            >
                                                Gallery
                                            </a>


                                            <a
                                                href="delete.php?id=<?= $project['id']; ?>"
                                                class="btn btn-danger"
                                                onclick="
                                                    return confirm(
                                                        'Are you sure you want to delete this project?'
                                                    );
                                                "
                                            >
                                                Delete
                                            </a>


                                        </div>

                                    </td>


                                </tr>


                            <?php endforeach; ?>


                        <?php else: ?>


                            <tr>

                                <td
                                    colspan="5"
                                    style="
                                        text-align:center;
                                        padding:50px;
                                        color:#6b7280;
                                    "
                                >

                                    No projects found.

                                    <br><br>

                                    <a
                                        href="add.php"
                                        style="
                                            color:#111827;
                                            font-weight:600;
                                        "
                                    >
                                        Add your first project
                                    </a>

                                </td>

                            </tr>


                        <?php endif; ?>


                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>


<?php include '../../includes/admin_footer.php'; ?>