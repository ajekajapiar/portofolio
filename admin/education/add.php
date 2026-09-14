<?php

require_once '../auth.php';

$pageTitle = 'Add Education';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>

<main class="main-content">

    <header class="topbar">

        <div class="topbar-title">
            Add Education
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

                <h1>Add Education</h1>

                <p>
                    Add a new educational background.
                </p>

            </div>

        </div>


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


                <div class="form-group">

                    <label for="institution">
                        Institution *
                    </label>

                    <input
                        type="text"
                        id="institution"
                        name="institution"
                        class="form-control"
                        placeholder="e.g. BINUS University"
                        required
                    >

                </div>

                                <div class="form-group">

                    <label for="logo">
                        Institution Logo
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

                <div class="form-group">

                    <label for="degree">
                        Degree
                    </label>

                    <input
                        type="text"
                        id="degree"
                        name="degree"
                        class="form-control"
                        placeholder="e.g. Bachelor's Degree"
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
                        placeholder="e.g. Information Systems"
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
                            placeholder="2022"
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
                            placeholder="2026"
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
                        placeholder="Describe your education..."
                    ></textarea>

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
                        Save Education
                    </button>

                </div>

            </form>

        </div>

    </div>

</main>


<?php include '../../includes/admin_footer.php'; ?>