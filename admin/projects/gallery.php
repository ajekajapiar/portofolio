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


/*
|--------------------------------------------------------------------------
| Get project
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Get gallery
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM project_gallery
    WHERE project_id = ?
    ORDER BY id DESC
");

$stmt->execute([$id]);

$gallery =
    $stmt->fetchAll();


$pageTitle =
    'Gallery - ' .
    $project['title'];


include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>


<main class="main-content">


    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Project Gallery
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


        <!-- HEADER -->

        <div class="page-header">

            <div>

                <h1>
                    <?= e(
                        $project['title']
                    ); ?>
                </h1>

                <p>
                    Manage project screenshots, documentation,
                    and supporting photos.
                </p>

            </div>


            <a
                href="index.php"
                class="btn btn-secondary"
            >
                ← Back to Projects
            </a>

        </div>


        <!-- UPLOAD -->

        <div class="card">

            <div class="card-header">

                <h2>
                    Upload Photos
                </h2>

            </div>


            <form
                action="upload_gallery.php"
                method="POST"
                enctype="multipart/form-data"
            >


                <input
                    type="hidden"
                    name="project_id"
                    value="<?= $project['id']; ?>"
                >


                <div class="upload-area">

                    <input
                        type="file"
                        name="images[]"
                        accept="image/jpeg,image/png,image/webp"
                        multiple
                        required
                    >


                    <p>
                        Select multiple images at once.
                    </p>

                    <p>
                        JPG, PNG, or WEBP. Maximum 5 MB per image.
                    </p>

                </div>


                <div class="form-group">

                    <label for="caption">
                        Caption
                    </label>

                    <input
                        type="text"
                        id="caption"
                        name="caption"
                        class="form-control"
                        placeholder="e.g. Dashboard page"
                    >

                </div>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Upload Photos
                </button>


            </form>

        </div>


        <!-- GALLERY -->

        <div
            class="card"
            style="margin-top:25px;"
        >

            <div class="card-header">

                <h2>
                    Gallery
                </h2>

                <span
                    style="
                        color:#6b7280;
                        font-size:13px;
                    "
                >
                    <?= count($gallery); ?> photos
                </span>

            </div>


            <?php if (count($gallery) > 0): ?>


                <div class="gallery-grid">


                    <?php foreach ($gallery as $image): ?>


                        <div class="gallery-item">


                            <img
                                src="../../assets/images/projects/<?= e($image['image']); ?>"
                                alt="<?= e($image['caption']); ?>"
                                class="gallery-image"
                            >


                            <div class="gallery-info">


                                <?php if (!empty($image['caption'])): ?>

                                    <div class="gallery-caption">

                                        <?= e(
                                            $image['caption']
                                        ); ?>

                                    </div>

                                <?php else: ?>

                                    <div
                                        class="gallery-caption"
                                        style="
                                            color:#9ca3af;
                                        "
                                    >
                                        No caption
                                    </div>

                                <?php endif; ?>


                                <div class="gallery-actions">

                                    <a
                                        href="delete_gallery.php?id=<?= $image['id']; ?>&project_id=<?= $project['id']; ?>"
                                        class="btn btn-danger"
                                        onclick="
                                            return confirm(
                                                'Delete this photo?'
                                            );
                                        "
                                    >
                                        Delete
                                    </a>

                                </div>


                            </div>


                        </div>


                    <?php endforeach; ?>


                </div>


            <?php else: ?>


                <div
                    style="
                        text-align:center;
                        padding:50px 20px;
                        color:#6b7280;
                    "
                >

                    <div
                        style="
                            font-size:40px;
                            margin-bottom:15px;
                        "
                    >
                        🖼️
                    </div>

                    <p>
                        No project photos have been added yet.
                    </p>

                </div>


            <?php endif; ?>


        </div>


    </div>

</main>


<?php include '../../includes/admin_footer.php'; ?>