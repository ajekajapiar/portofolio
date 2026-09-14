<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


$id = (int) (
    $_GET['id'] ?? 0
);


if ($id <= 0) {

    redirect('index.php');

}


$stmt = $pdo->prepare("
    SELECT *
    FROM projects
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$project =
    $stmt->fetch();


if (!$project) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Project not found.'
        )
    );

}


$pageTitle = 'Edit Project';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>


<main class="main-content">


    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Edit Project
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


    <!-- CONTENT -->

    <div class="content">


        <div class="page-header">

            <div>

                <h1>Edit Project</h1>

                <p>
                    Update your project information.
                </p>

            </div>

        </div>


        <?php if (isset($_GET['error'])): ?>

            <div
                class="alert alert-danger"
                style="margin-bottom:20px;"
            >
                <?= e($_GET['error']); ?>
            </div>

        <?php endif; ?>


        <div class="card">


            <form
                action="process.php"
                method="POST"
                enctype="multipart/form-data"
            >


                <input
                    type="hidden"
                    name="action"
                    value="update"
                >


                <input
                    type="hidden"
                    name="id"
                    value="<?= $project['id']; ?>"
                >


                <!-- TITLE -->

                <div class="form-group">

                    <label for="title">
                        Project Title *
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control"
                        value="<?= e(
                            $project['title']
                        ); ?>"
                        required
                    >

                </div>


                <!-- CATEGORY -->

                <div class="form-group">

                    <label for="category">
                        Category
                    </label>

                    <input
                        type="text"
                        id="category"
                        name="category"
                        class="form-control"
                        value="<?= e(
                            $project['category']
                        ); ?>"
                    >

                </div>


                <!-- COVER -->

                <div class="form-group">

                    <label for="cover_image">
                        Cover Image
                    </label>


                    <?php if (
                        !empty(
                            $project['cover_image']
                        )
                    ): ?>

                        <div
                            style="
                                margin-bottom:12px;
                            "
                        >

                            <img
                                src="../../assets/images/projects/<?= e($project['cover_image']); ?>"
                                alt="<?= e($project['title']); ?>"
                                style="
                                    width:220px;
                                    height:130px;
                                    object-fit:cover;
                                    border-radius:10px;
                                    border:1px solid #e5e7eb;
                                "
                            >

                        </div>

                    <?php endif; ?>


                    <input
                        type="file"
                        id="cover_image"
                        name="cover_image"
                        class="form-control"
                        accept="image/jpeg,image/png,image/webp"
                    >


                    <small
                        style="
                            display:block;
                            margin-top:7px;
                            color:#6b7280;
                            font-size:12px;
                        "
                    >
                        Leave empty to keep the current cover.
                        JPG, PNG, or WEBP. Maximum 5 MB.
                    </small>

                </div>


                <!-- TECHNOLOGIES -->

                <div class="form-group">

                    <label for="technologies">
                        Technologies / Tools
                    </label>

                    <input
                        type="text"
                        id="technologies"
                        name="technologies"
                        class="form-control"
                        value="<?= e(
                            $project['technologies']
                        ); ?>"
                    >

                    <small
                        style="
                            display:block;
                            margin-top:7px;
                            color:#6b7280;
                            font-size:12px;
                        "
                    >
                        Separate each technology with a comma.
                    </small>

                </div>


                <!-- DESCRIPTION -->

                <div class="form-group">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="9"
                    ><?= e(
                        $project['description']
                    ); ?></textarea>

                </div>


                <!-- PROJECT URL -->

                <div class="form-group">

                    <label for="project_url">
                        Live Project URL
                    </label>

                    <input
                        type="url"
                        id="project_url"
                        name="project_url"
                        class="form-control"
                        value="<?= e(
                            $project['project_url']
                        ); ?>"
                    >

                </div>


                <!-- GITHUB -->

                <div class="form-group">

                    <label for="github_url">
                        GitHub URL
                    </label>

                    <input
                        type="url"
                        id="github_url"
                        name="github_url"
                        class="form-control"
                        value="<?= e(
                            $project['github_url']
                        ); ?>"
                    >

                </div>


                <!-- BUTTONS -->

                <div
                    style="
                        display:flex;
                        gap:10px;
                        margin-top:25px;
                    "
                >

                    <a
                        href="index.php"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update Project
                    </button>

                </div>


            </form>


        </div>

    </div>

</main>


<?php include '../../includes/admin_footer.php'; ?>