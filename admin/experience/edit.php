<?php

require_once '../auth.php';
require_once '../../config/database.php';


$id = (int) (
    $_GET['id'] ?? 0
);


if ($id <= 0) {

    header("Location: index.php");

    exit;
}


$stmt = $pdo->prepare("
    SELECT *
    FROM experience
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$experience = $stmt->fetch();


if (!$experience) {

    header("Location: index.php");

    exit;
}


$pageTitle = 'Edit Experience';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>

<main class="main-content">


    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Edit Experience
        </div>

        <div class="topbar-user">

            Logged in as

            <strong>
                <?= htmlspecialchars($_SESSION['admin_username']); ?>
            </strong>

        </div>

    </header>


    <!-- CONTENT -->

    <div class="content">


        <div class="page-header">

            <div>

                <h1>Edit Experience</h1>

                <p>
                    Update your work or professional experience.
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
                    value="<?= $experience['id']; ?>"
                >


                <!-- COMPANY -->

                <div class="form-group">

                    <label for="company">
                        Company / Organization *
                    </label>

                    <input
                        type="text"
                        id="company"
                        name="company"
                        class="form-control"
                        value="<?= htmlspecialchars(
                            $experience['company']
                        ); ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="logo">
                        Company Logo
                    </label>


                    <?php if (!empty($experience['logo'])): ?>

                        <div
                            style="
                                margin-bottom:12px;
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            <img
                                src="../../assets/images/experience/<?= htmlspecialchars($experience['logo']); ?>"
                                alt="Company Logo"
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
                                Current company logo
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
                        Position *
                    </label>

                    <input
                        type="text"
                        id="position"
                        name="position"
                        class="form-control"
                        value="<?= htmlspecialchars(
                            $experience['position']
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
                        value="<?= htmlspecialchars(
                            $experience['start_date'] ?? ''
                        ); ?>"
                    >

                </div>


                <!-- CURRENT POSITION -->

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

                        <?= $experience['is_current']
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

                        I currently work here

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
                        value="<?= htmlspecialchars(
                            $experience['end_date'] ?? ''
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
                    ><?= htmlspecialchars(
                        $experience['description'] ?? ''
                    ); ?></textarea>

                </div>


                <!-- BUTTON -->

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
                        Update Experience
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