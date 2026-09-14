<?php

require_once '../auth.php';
require_once '../../config/database.php';


$stmt = $pdo->query("
    SELECT *
    FROM experience
    ORDER BY start_date DESC, id DESC
");

$experiences = $stmt->fetchAll();


$pageTitle = 'Experience';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>

<main class="main-content">

    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Experience
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


        <!-- PAGE HEADER -->

        <div class="page-header">

            <div>

                <h1>Experience</h1>

                <p>
                    Manage your work and professional experience.
                </p>

            </div>


            <a
                href="add.php"
                class="btn btn-primary"
            >
                + Add Experience
            </a>

        </div>


        <!-- CARD -->

        <div class="card">


            <!-- SUCCESS MESSAGE -->

            <?php if (isset($_GET['success'])): ?>

                <div
                    class="alert"
                    style="
                        background:#dcfce7;
                        color:#166534;
                        margin-bottom:20px;
                    "
                >

                    <?= htmlspecialchars($_GET['success']); ?>

                </div>

            <?php endif; ?>


            <!-- ERROR MESSAGE -->

            <?php if (isset($_GET['error'])): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($_GET['error']); ?>

                </div>

            <?php endif; ?>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>Company</th>

                            <th>Position</th>

                            <th>Period</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php if (count($experiences) > 0): ?>


                            <?php foreach ($experiences as $experience): ?>

                                <tr>


                                    <!-- COMPANY -->

                                    <td>

                                        <strong>
                                            <?= htmlspecialchars(
                                                $experience['company']
                                            ); ?>
                                        </strong>

                                    </td>


                                    <!-- POSITION -->

                                    <td>

                                        <?= htmlspecialchars(
                                            $experience['position']
                                        ); ?>

                                    </td>


                                    <!-- PERIOD -->

                                    <td>

                                        <?php

                                        $startDate = !empty(
                                            $experience['start_date']
                                        )
                                            ? date(
                                                'M Y',
                                                strtotime(
                                                    $experience['start_date']
                                                )
                                            )
                                            : '-';


                                        if ($experience['is_current']) {

                                            $endDate = 'Present';

                                        } elseif (!empty(
                                            $experience['end_date']
                                        )) {

                                            $endDate = date(
                                                'M Y',
                                                strtotime(
                                                    $experience['end_date']
                                                )
                                            );

                                        } else {

                                            $endDate = '-';

                                        }

                                        ?>


                                        <?= htmlspecialchars($startDate); ?>

                                        -

                                        <?= htmlspecialchars($endDate); ?>


                                    </td>


                                    <!-- ACTION -->

                                    <td>

                                        <div class="actions">

                                            <a
                                                href="edit.php?id=<?= $experience['id']; ?>"
                                                class="btn btn-secondary"
                                            >
                                                Edit
                                            </a>


                                            <a
                                                href="gallery.php?id=<?= $experience['id']; ?>"
                                                class="btn btn-secondary"
                                            >
                                                Gallery
                                            </a>


                                            <a
                                                href="delete.php?id=<?= $experience['id']; ?>"
                                                class="btn btn-danger"
                                                onclick="
                                                    return confirm(
                                                        'Are you sure you want to delete this experience?'
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

                                    No experience records found.

                                    <br><br>

                                    <a
                                        href="add.php"
                                        style="
                                            color:#111827;
                                            font-weight:600;
                                        "
                                    >
                                        Add your first experience
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