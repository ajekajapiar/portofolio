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
| Get experience
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM experience
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$experience =
    $stmt->fetch();


if (!$experience) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Experience record not found.'
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
    FROM experience_gallery
    WHERE experience_id = ?
    ORDER BY id DESC
");

$stmt->execute([$id]);

$gallery =
    $stmt->fetchAll();


$pageTitle =
    'Gallery - ' .
    $experience['company'];


include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>


<main class="main-content">


    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Experience Gallery
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


        <!-- PAGE HEADER -->

        <div class="page-header">

            <div>

                <h1>
                    <?= e(
                        $experience['company']
                    ); ?>
                </h1>

                <p>
                    Manage photos related to this experience.
                </p>

            </div>


            <a
                href="index.php"
                class="btn btn-secondary"
            >
                ← Back to Experience
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
                    name="experience_id"
                    value="<?= $experience['id']; ?>"
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
                        You can select multiple photos at once.
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
                        placeholder="Optional caption for these photos"
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
                                src="../../assets/images/experience/<?= e($image['image']); ?>"
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
                                        href="delete_gallery.php?id=<?= $image['id']; ?>&experience_id=<?= $experience['id']; ?>"
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
                        📷
                    </div>

                    <p>
                        No photos have been added yet.
                    </p>

                </div>

            <?php endif; ?>


        </div>


    </div>

</main>


<?php include '../../includes/admin_footer.php'; ?>