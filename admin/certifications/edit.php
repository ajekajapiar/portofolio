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
    FROM certifications
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$certification =
    $stmt->fetch();


if (!$certification) {

    redirect(
        'index.php?error=' .
        urlencode(
            'Certification not found.'
        )
    );

}


$pageTitle = 'Edit Certification';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>


<main class="main-content">


    <header class="topbar">

        <div class="topbar-title">
            Edit Certification
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


    <div class="content">


        <div class="page-header">

            <div>

                <h1>Edit Certification</h1>

                <p>
                    Update your certification information.
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
                    value="<?= $certification['id']; ?>"
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
                        value="<?= e(
                            $certification[
                                'certification_name'
                            ]
                        ); ?>"
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
                        value="<?= e(
                            $certification['issuer']
                        ); ?>"
                    >

                </div>


                <!-- IMAGE -->

                <div class="form-group">

                    <label for="certificate_image">
                        Certificate Image
                    </label>


                    <?php if (
                        !empty(
                            $certification[
                                'certificate_image'
                            ]
                        )
                    ): ?>

                        <div
                            style="
                                margin-bottom:15px;
                            "
                        >

                            <img
                                src="../../assets/images/certifications/<?= e(
                                    $certification[
                                        'certificate_image'
                                    ]
                                ); ?>"
                                alt="Certificate"
                                style="
                                    max-width:400px;
                                    max-height:250px;
                                    object-fit:contain;
                                    border:1px solid #e5e7eb;
                                    border-radius:8px;
                                "
                            >

                        </div>

                    <?php endif; ?>


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
                        Leave empty to keep the current certificate image.
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
                        value="<?= e(
                            $certification['issue_date']
                        ); ?>"
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
                        value="<?= e(
                            $certification[
                                'expiration_date'
                            ]
                        ); ?>"
                    >

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
                        value="<?= e(
                            $certification['credential_id']
                        ); ?>"
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
                        value="<?= e(
                            $certification['credential_url']
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
                        rows="6"
                    ><?= e(
                        $certification['description']
                    ); ?></textarea>

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
                        value="<?= e(
                            $certification[
                                'display_order'
                            ]
                        ); ?>"
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
                        Update Certification
                    </button>

                </div>


            </form>


        </div>

    </div>

</main>


<?php include '../../includes/admin_footer.php'; ?>