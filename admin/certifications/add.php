<?php

require_once '../auth.php';

$pageTitle = 'Add Certification';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>


<main class="main-content">


    <header class="topbar">

        <div class="topbar-title">
            Add Certification
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


    <div class="content">


        <div class="page-header">

            <div>

                <h1>Add Certification</h1>

                <p>
                    Add a professional certification or credential.
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


                <!-- NAME -->

                <div class="form-group">

                    <label for="certification_name">
                        Certification Name *
                    </label>

                    <input
                        type="text"
                        id="certification_name"
                        name="certification_name"
                        class="form-control"
                        placeholder="e.g. Google Analytics Certification"
                        required
                    >

                </div>


                <!-- ISSUER -->

                <div class="form-group">

                    <label for="issuer">
                        Issuing Organization
                    </label>

                    <input
                        type="text"
                        id="issuer"
                        name="issuer"
                        class="form-control"
                        placeholder="e.g. Google"
                    >

                </div>


                <!-- IMAGE -->

                <div class="form-group">

                    <label for="certificate_image">
                        Certificate Image
                    </label>

                    <input
                        type="file"
                        id="certificate_image"
                        name="certificate_image"
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
                        Upload a scan or screenshot of the certificate.
                        JPG, PNG, or WEBP. Maximum 5 MB.
                    </small>

                </div>


                <!-- ISSUE DATE -->

                <div class="form-group">

                    <label for="issue_date">
                        Issue Date
                    </label>

                    <input
                        type="date"
                        id="issue_date"
                        name="issue_date"
                        class="form-control"
                    >

                </div>


                <!-- EXPIRATION -->

                <div class="form-group">

                    <label for="expiration_date">
                        Expiration Date
                    </label>

                    <input
                        type="date"
                        id="expiration_date"
                        name="expiration_date"
                        class="form-control"
                    >

                    <small
                        style="
                            display:block;
                            margin-top:7px;
                            color:#6b7280;
                            font-size:12px;
                        "
                    >
                        Leave empty if the certification does not expire.
                    </small>

                </div>


                <!-- CREDENTIAL ID -->

                <div class="form-group">

                    <label for="credential_id">
                        Credential ID
                    </label>

                    <input
                        type="text"
                        id="credential_id"
                        name="credential_id"
                        class="form-control"
                        placeholder="e.g. ABC123XYZ"
                    >

                </div>


                <!-- CREDENTIAL URL -->

                <div class="form-group">

                    <label for="credential_url">
                        Credential URL
                    </label>

                    <input
                        type="url"
                        id="credential_url"
                        name="credential_url"
                        class="form-control"
                        placeholder="https://..."
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
                        rows="6"
                        placeholder="Optional description about this certification..."
                    ></textarea>

                </div>


                <!-- ORDER -->

                <div class="form-group">

                    <label for="display_order">
                        Display Order
                    </label>

                    <input
                        type="number"
                        id="display_order"
                        name="display_order"
                        class="form-control"
                        value="0"
                        min="0"
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
                        Save Certification
                    </button>

                </div>


            </form>


        </div>

    </div>

</main>


<?php include '../../includes/admin_footer.php'; ?>