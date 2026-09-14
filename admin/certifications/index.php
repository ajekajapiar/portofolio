<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


$stmt = $pdo->query("
    SELECT *
    FROM certifications
    ORDER BY
        display_order ASC,
        issue_date DESC,
        id DESC
");

$certifications =
    $stmt->fetchAll();


$pageTitle = 'Certifications';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>


<main class="main-content">


    <header class="topbar">

        <div class="topbar-title">
            Certifications
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

                <h1>Certifications</h1>

                <p>
                    Manage your professional certifications and credentials.
                </p>

            </div>


            <a
                href="add.php"
                class="btn btn-primary"
            >
                + Add Certification
            </a>

        </div>


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


        <div class="card">

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>Certification</th>

                            <th>Issuer</th>

                            <th>Issue Date</th>

                            <th>Expiration</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php if (
                            count($certifications) > 0
                        ): ?>


                            <?php foreach (
                                $certifications
                                as $certification
                            ): ?>


                                <tr>


                                    <!-- CERTIFICATION -->

                                    <td>

                                        <div
                                            style="
                                                display:flex;
                                                align-items:center;
                                                gap:12px;
                                            "
                                        >


                                            <?php if (
                                                !empty(
                                                    $certification[
                                                        'certificate_image'
                                                    ]
                                                )
                                            ): ?>

                                                <img
                                                    src="../../assets/images/certifications/<?= e(
                                                        $certification[
                                                            'certificate_image'
                                                        ]
                                                    ); ?>"
                                                    alt="<?= e(
                                                        $certification[
                                                            'certification_name'
                                                        ]
                                                    ); ?>"
                                                    style="
                                                        width:65px;
                                                        height:45px;
                                                        object-fit:cover;
                                                        border-radius:6px;
                                                        border:1px solid #e5e7eb;
                                                    "
                                                >

                                            <?php else: ?>

                                                <div
                                                    style="
                                                        width:65px;
                                                        height:45px;
                                                        display:flex;
                                                        align-items:center;
                                                        justify-content:center;
                                                        background:#f3f4f6;
                                                        border-radius:6px;
                                                        color:#9ca3af;
                                                        font-size:10px;
                                                    "
                                                >
                                                    No Image
                                                </div>

                                            <?php endif; ?>


                                            <strong>

                                                <?= e(
                                                    $certification[
                                                        'certification_name'
                                                    ]
                                                ); ?>

                                            </strong>


                                        </div>

                                    </td>


                                    <!-- ISSUER -->

                                    <td>

                                        <?= e(
                                            $certification['issuer']
                                        ); ?>

                                    </td>


                                    <!-- ISSUE DATE -->

                                    <td>

                                        <?php if (
                                            !empty(
                                                $certification[
                                                    'issue_date'
                                                ]
                                            )
                                        ): ?>

                                            <?= date(
                                                'M Y',
                                                strtotime(
                                                    $certification[
                                                        'issue_date'
                                                    ]
                                                )
                                            ); ?>

                                        <?php else: ?>

                                            —

                                        <?php endif; ?>

                                    </td>


                                    <!-- EXPIRATION -->

                                    <td>

                                        <?php if (
                                            !empty(
                                                $certification[
                                                    'expiration_date'
                                                ]
                                            )
                                        ): ?>

                                            <?= date(
                                                'M Y',
                                                strtotime(
                                                    $certification[
                                                        'expiration_date'
                                                    ]
                                                )
                                            ); ?>

                                        <?php else: ?>

                                            No Expiration

                                        <?php endif; ?>

                                    </td>


                                    <!-- ACTION -->

                                    <td>

                                        <div class="actions">

                                            <a
                                                href="edit.php?id=<?= $certification['id']; ?>"
                                                class="btn btn-secondary"
                                            >
                                                Edit
                                            </a>


                                            <a
                                                href="delete.php?id=<?= $certification['id']; ?>"
                                                class="btn btn-danger"
                                                onclick="
                                                    return confirm(
                                                        'Are you sure you want to delete this certification?'
                                                    );
                                                "
                                            >
                                                Delete
                                            </a>

                                        </div>

                                    </td>


                                </tr>


                            <?php endforeach; ?>


                        <?php else: ?>


                            <tr>

                                <td
                                    colspan="5"
                                    style="
                                        text-align:center;
                                        padding:50px;
                                        color:#6b7280;
                                    "
                                >

                                    No certifications found.

                                    <br><br>

                                    <a
                                        href="add.php"
                                        style="
                                            color:#111827;
                                            font-weight:600;
                                        "
                                    >
                                        Add your first certification
                                    </a>

                                </td>

                            </tr>


                        <?php endif; ?>


                    </tbody>

                </table>

            </div>

        </div>


    </div>

</main>


<?php include '../../includes/admin_footer.php'; ?>