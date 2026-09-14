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
    FROM organization
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$organization =
    $stmt->fetch();


if (!$organization) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Organization record not found.'
        )
    );

}


$pageTitle = 'Edit Organization';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>


<main class="main-content">


    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Edit Organization
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

                <h1>Edit Organization</h1>

                <p>
                    Update your organizational experience.
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
                    value="<?= $organization['id']; ?>"
                >


                <!-- ORGANIZATION -->

                <div class="form-group">

                    <label for="organization_name">
                        Organization Name *
                    </label>

                    <input
                        type="text"
                        id="organization_name"
                        name="organization_name"
                        class="form-control"
                        value="<?= e(
                            $organization['organization_name']
                        ); ?>"
                        required
                    >

                </div>


                <!-- LOGO -->

                <div class="form-group">

                    <label for="logo">
                        Organization Logo
                    </label>


                    <?php if (!empty($organization['logo'])): ?>

                        <div
                            style="
                                margin-bottom:12px;
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            <img
                                src="../../assets/images/organization/<?= e($organization['logo']); ?>"
                                alt="Organization Logo"
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
                                Current organization logo
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
                        Leave empty to keep the current logo.
                        JPG, PNG, or WEBP. Maximum 5 MB.
                    </small>

                </div>


                <!-- POSITION -->

                <div class="form-group">

                    <label for="position">
                        Position / Role *
                    </label>

                    <input
                        type="text"
                        id="position"
                        name="position"
                        class="form-control"
                        value="<?= e(
                            $organization['position']
                        ); ?>"
                        required
                    >

                </div>


                <!-- START DATE -->

                <div class="form-group">

                    <label for="start_date">
                        Start Date
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        class="form-control"
                        value="<?= e(
                            $organization['start_date']
                        ); ?>"
                    >

                </div>


                <!-- CURRENT -->

                <div
                    class="form-group"
                    style="
                        display:flex;
                        align-items:center;
                        gap:10px;
                    "
                >

                    <input
                        type="checkbox"
                        id="is_current"
                        name="is_current"
                        value="1"

                        <?= $organization['is_current']
                            ? 'checked'
                            : ''; ?>

                        style="
                            width:18px;
                            height:18px;
                            cursor:pointer;
                        "
                    >


                    <label
                        for="is_current"
                        style="
                            margin:0;
                            cursor:pointer;
                        "
                    >
                        I am currently active in this organization
                    </label>

                </div>


                <!-- END DATE -->

                <div
                    class="form-group"
                    id="end-date-group"
                >

                    <label for="end_date">
                        End Date
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        class="form-control"
                        value="<?= e(
                            $organization['end_date']
                        ); ?>"
                    >

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
                        rows="7"
                    ><?= e(
                        $organization['description']
                    ); ?></textarea>

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
                        Update Organization
                    </button>

                </div>


            </form>


        </div>

    </div>

</main>


<script>

const currentCheckbox =
    document.getElementById('is_current');

const endDateGroup =
    document.getElementById('end-date-group');

const endDateInput =
    document.getElementById('end_date');


function toggleEndDate() {

    if (currentCheckbox.checked) {

        endDateGroup.style.display = 'none';

        endDateInput.value = '';

    } else {

        endDateGroup.style.display = 'block';

    }

}


currentCheckbox.addEventListener(
    'change',
    toggleEndDate
);


toggleEndDate();

</script>


<?php include '../../includes/admin_footer.php'; ?>