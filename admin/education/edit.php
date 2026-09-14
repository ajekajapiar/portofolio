<?php

require_once '../auth.php';
require_once '../../config/database.php';


$id = (int) ($_GET['id'] ?? 0);


if ($id <= 0) {

    header("Location: index.php");
    exit;

}


$stmt = $pdo->prepare("
    SELECT *
    FROM education
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$education = $stmt->fetch();


if (!$education) {

    header("Location: index.php");
    exit;

}


$pageTitle = 'Edit Education';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>

<main class="main-content">

    <header class="topbar">

        <div class="topbar-title">
            Edit Education
        </div>

        <div class="topbar-user">

            Logged in as
            <strong>
                <?= htmlspecialchars($_SESSION['admin_username']); ?>
            </strong>

        </div>

    </header>


    <div class="content">

        <div class="page-header">

            <div>

                <h1>Edit Education</h1>

                <p>
                    Update your educational background.
                </p>

            </div>

        </div>


        <div class="card">

            <?php if (isset($_GET['error'])): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($_GET['error']); ?>

                </div>

            <?php endif; ?>


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
                    value="<?= $education['id']; ?>"
                >


                <div class="form-group">

                    <label for="institution">
                        Institution *
                    </label>

                    <input
                        type="text"
                        id="institution"
                        name="institution"
                        class="form-control"
                        value="<?= htmlspecialchars(
                            $education['institution']
                        ); ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="logo">
                        Institution Logo
                    </label>


                    <?php if (!empty($education['logo'])): ?>

                        <div
                            style="
                                margin-bottom:12px;
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            <img
                                src="../../assets/images/education/<?= htmlspecialchars($education['logo']); ?>"
                                alt="Institution Logo"
                                style="
                                    width:70px;
                                    height:70px;
                                    object-fit:contain;
                                    border:1px solid #e5e7eb;
                                    border-radius:8px;
                                    padding:8px;
                                    background:white;
                                "
                            >

                            <span
                                style="
                                    color:#6b7280;
                                    font-size:13px;
                                "
                            >
                                Current logo
                            </span>

                        </div>

                    <?php endif; ?>


                    <input
                        type="file"
                        id="logo"
                        name="logo"
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
                        Upload a new logo only if you want to replace the current one.
                        JPG, PNG, or WEBP. Maximum 5 MB.
                    </small>

                </div>

                <div class="form-group">

                    <label for="degree">
                        Degree
                    </label>

                    <input
                        type="text"
                        id="degree"
                        name="degree"
                        class="form-control"
                        value="<?= htmlspecialchars(
                            $education['degree'] ?? ''
                        ); ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="field">
                        Field of Study
                    </label>

                    <input
                        type="text"
                        id="field"
                        name="field"
                        class="form-control"
                        value="<?= htmlspecialchars(
                            $education['field'] ?? ''
                        ); ?>"
                    >

                </div>


                <div
                    style="
                        display:grid;
                        grid-template-columns:1fr 1fr;
                        gap:20px;
                    "
                >

                    <div class="form-group">

                        <label for="start_year">
                            Start Year
                        </label>

                        <input
                            type="number"
                            id="start_year"
                            name="start_year"
                            class="form-control"
                            min="1900"
                            max="2100"
                            value="<?= htmlspecialchars(
                                $education['start_year'] ?? ''
                            ); ?>"
                        >

                    </div>


                    <div class="form-group">

                        <label for="end_year">
                            End Year
                        </label>

                        <input
                            type="number"
                            id="end_year"
                            name="end_year"
                            class="form-control"
                            min="1900"
                            max="2100"
                            value="<?= htmlspecialchars(
                                $education['end_year'] ?? ''
                            ); ?>"
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="6"
                    ><?= htmlspecialchars(
                        $education['description'] ?? ''
                    ); ?></textarea>

                </div>


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
                        Update Education
                    </button>

                </div>

            </form>

        </div>

    </div>

</main>


<?php include '../../includes/admin_footer.php'; ?>