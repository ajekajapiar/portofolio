<?php

require_once '../auth.php';

$pageTitle = 'Add Organization';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>

<main class="main-content">


    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Add Organization
        </div>

        <div class="topbar-user">

            Logged in as

            <strong>
                <?= htmlspecialchars(
                    $_SESSION['admin_username']
                ); ?>
            </strong>

        </div>

    </header>


    <!-- CONTENT -->

    <div class="content">


        <div class="page-header">

            <div>

                <h1>Add Organization</h1>

                <p>
                    Add a new organizational experience.
                </p>

            </div>

        </div>


        <?php if (isset($_GET['error'])): ?>

            <div
                class="alert alert-danger"
                style="margin-bottom:20px;"
            >
                <?= htmlspecialchars(
                    $_GET['error']
                ); ?>
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
                    value="create"
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
                        placeholder="e.g. BEM Faculty of Computer Science"
                        required
                    >

                </div>


                <!-- LOGO -->

                <div class="form-group">

                    <label for="logo">
                        Organization Logo
                    </label>

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
                        placeholder="e.g. Head of External Affairs"
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
                        placeholder="Describe your role, responsibilities, achievements, and contributions..."
                    ></textarea>

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
                        Save Organization
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