<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


$stmt = $pdo->query("
    SELECT *
    FROM organization
    ORDER BY display_order ASC, start_date DESC, id DESC
");

$organizations = $stmt->fetchAll();


$pageTitle = 'Organization';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>

<main class="main-content">


    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Organization
        </div>

        <div class="topbar-user">

            Logged in as

            <strong>
                <?= e($_SESSION['admin_username']); ?>
            </strong>

        </div>

    </header>


    <!-- CONTENT -->

    <div class="content">


        <!-- PAGE HEADER -->

        <div class="page-header">

            <div>

                <h1>Organization</h1>

                <p>
                    Manage your organizational experiences and activities.
                </p>

            </div>


            <a
                href="add.php"
                class="btn btn-primary"
            >
                + Add Organization
            </a>

        </div>


        <!-- SUCCESS -->

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


        <!-- ERROR -->

        <?php if (isset($_GET['error'])): ?>

            <div
                class="alert alert-danger"
                style="margin-bottom:20px;"
            >
                <?= e($_GET['error']); ?>
            </div>

        <?php endif; ?>


        <!-- CARD -->

        <div class="card">

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>Organization</th>

                            <th>Role</th>

                            <th>Period</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php if (count($organizations) > 0): ?>


                            <?php foreach ($organizations as $organization): ?>


                                <tr>


                                    <!-- ORGANIZATION -->

                                    <td>

                                        <div
                                            style="
                                                display:flex;
                                                align-items:center;
                                                gap:12px;
                                            "
                                        >


                                            <?php if (!empty($organization['logo'])): ?>

                                                <img
                                                    src="../../assets/images/organization/<?= e($organization['logo']); ?>"
                                                    alt="Organization Logo"
                                                    style="
                                                        width:45px;
                                                        height:45px;
                                                        object-fit:contain;
                                                        border:1px solid #e5e7eb;
                                                        border-radius:8px;
                                                        padding:5px;
                                                        background:white;
                                                    "
                                                >

                                            <?php else: ?>

                                                <div
                                                    style="
                                                        width:45px;
                                                        height:45px;
                                                        display:flex;
                                                        align-items:center;
                                                        justify-content:center;
                                                        border:1px solid #e5e7eb;
                                                        border-radius:8px;
                                                        color:#9ca3af;
                                                        font-size:11px;
                                                    "
                                                >
                                                    N/A
                                                </div>

                                            <?php endif; ?>


                                            <strong>

                                                <?= e(
                                                    $organization['organization_name']
                                                ); ?>

                                            </strong>


                                        </div>

                                    </td>


                                    <!-- ROLE -->

                                    <td>

                                        <?= e(
                                            $organization['position']
                                        ); ?>

                                    </td>


                                    <!-- PERIOD -->

                                    <td>

                                        <?php

                                        $startDate = !empty(
                                            $organization['start_date']
                                        )
                                            ? date(
                                                'M Y',
                                                strtotime(
                                                    $organization['start_date']
                                                )
                                            )
                                            : '-';


                                        if (
                                            $organization['is_current']
                                        ) {

                                            $endDate = 'Present';

                                        } elseif (
                                            !empty(
                                                $organization['end_date']
                                            )
                                        ) {

                                            $endDate = date(
                                                'M Y',
                                                strtotime(
                                                    $organization['end_date']
                                                )
                                            );

                                        } else {

                                            $endDate = '-';

                                        }

                                        ?>


                                        <?= e($startDate); ?>

                                        -

                                        <?= e($endDate); ?>

                                    </td>


                                    <!-- ACTION -->

                                    <td>

                                        <div class="actions">


                                            <a
                                                href="edit.php?id=<?= $organization['id']; ?>"
                                                class="btn btn-secondary"
                                            >
                                                Edit
                                            </a>


                                            <a
                                                href="gallery.php?id=<?= $organization['id']; ?>"
                                                class="btn btn-secondary"
                                            >
                                                Gallery
                                            </a>


                                            <a
                                                href="delete.php?id=<?= $organization['id']; ?>"
                                                class="btn btn-danger"
                                                onclick="
                                                    return confirm(
                                                        'Are you sure you want to delete this organization?'
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
                                    colspan="4"
                                    style="
                                        text-align:center;
                                        padding:40px;
                                        color:#6b7280;
                                    "
                                >

                                    No organization records found.

                                    <br><br>

                                    <a
                                        href="add.php"
                                        style="
                                            color:#111827;
                                            font-weight:600;
                                        "
                                    >
                                        Add your first organization
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