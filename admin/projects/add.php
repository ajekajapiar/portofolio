<?php

require_once '../auth.php';

$pageTitle = 'Add Project';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>


<main class="main-content">


    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Add Project
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

                <h1>Add Project</h1>

                <p>
                    Add a project to your portfolio.
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
                        placeholder="e.g. Personal Portfolio Website"
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
                        placeholder="e.g. Web Development"
                    >

                </div>


                <!-- COVER -->

                <div class="form-group">

                    <label for="cover_image">
                        Cover Image
                    </label>

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
                        This image will be used as the project thumbnail
                        and main project image.
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
                        placeholder="PHP, MySQL, HTML, CSS, JavaScript"
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
                        placeholder="Describe the project, your role, the problem it solves, and the outcome..."
                    ></textarea>

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
                        placeholder="https://example.com"
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
                        placeholder="https://github.com/username/project"
                    >

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
                        Save Project
                    </button>

                </div>


            </form>


        </div>

    </div>

</main>


<?php include '../../includes/admin_footer.php'; ?>