<?php

require_once '../auth.php';
require_once '../../config/database.php';

$pageTitle = 'Education';

$stmt = $pdo->query("
    SELECT *
    FROM education
    ORDER BY start_year DESC, id DESC
");

$educations = $stmt->fetchAll();

include '../../includes/admin_header.php';

include '../../includes/admin_sidebar.php';

?>

<main class="main-content">

    <header class="topbar">

        <div class="topbar-title">
            Education
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

                <h1>Education</h1>

                <p>
                    Manage your educational background.
                </p>

            </div>

            <a
                href="add.php"
                class="btn btn-primary"
            >
                + Add Education
            </a>

        </div>


        <div class="card">

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


            <?php if (isset($_GET['error'])): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($_GET['error']); ?>

                </div>

            <?php endif; ?>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>Institution</th>

                            <th>Degree</th>

                            <th>Field</th>

                            <th>Period</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (count($educations) > 0): ?>

                            <?php foreach ($educations as $education): ?>

                                <tr>

                                    <td>

                                        <div
                                            style="
                                                display:flex;
                                                align-items:center;
                                                gap:12px;
                                            "
                                        >

                                            <?php if (!empty($education['logo'])): ?>

                                                <img
                                                    src="../../assets/images/education/<?= htmlspecialchars($education['logo']); ?>"
                                                    alt="Logo"
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
                                                        font-size:12px;
                                                    "
                                                >
                                                    N/A
                                                </div>

                                            <?php endif; ?>


                                            <strong>

                                                <?= htmlspecialchars(
                                                    $education['institution']
                                                ); ?>

                                            </strong>

                                        </div>

                                    </td>


                                    <td>

                                        <?= htmlspecialchars(
                                            $education['degree'] ?? '-'
                                        ); ?>

                                    </td>


                                    <td>

                                        <?= htmlspecialchars(
                                            $education['field'] ?? '-'
                                        ); ?>

                                    </td>


                                    <td>

                                        <?= htmlspecialchars(
                                            $education['start_year'] ?? '-'
                                        ); ?>

                                        -

                                        <?= htmlspecialchars(
                                            $education['end_year'] ?? 'Present'
                                        ); ?>

                                    </td>


                                    <td>

                                        <div class="actions">

                                            <a
                                                href="edit.php?id=<?= $education['id']; ?>"
                                                class="btn btn-secondary"
                                            >
                                                Edit
                                            </a>


                                            <a
                                                href="delete.php?id=<?= $education['id']; ?>"
                                                class="btn btn-danger"
                                                onclick="
                                                    return confirm(
                                                        'Are you sure you want to delete this education record?'
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
                                        padding:40px;
                                        color:#6b7280;
                                    "
                                >

                                    No education records found.

                                    <br>

                                    <a
                                        href="add.php"
                                        style="
                                            color:#111827;
                                            font-weight:600;
                                        "
                                    >
                                        Add your first education
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