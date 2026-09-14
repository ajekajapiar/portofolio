<?php

require_once '../auth.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';


$stmt = $pdo->query("
    SELECT *
    FROM skills
    ORDER BY
        skill_type ASC,
        display_order ASC,
        id ASC
");

$skills = $stmt->fetchAll();


$pageTitle = 'Skills';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>


<main class="main-content">


    <header class="topbar">

        <div class="topbar-title">
            Skills
        </div>

        <div class="topbar-user">

            Logged in as

            <strong>
                <?= e($_SESSION['admin_username']); ?>
            </strong>

        </div>

    </header>


    <div class="content">


        <div class="page-header">

            <div>

                <h1>Skills</h1>

                <p>
                    Manage your hard and soft skills.
                </p>

            </div>


            <a
                href="add.php"
                class="btn btn-primary"
            >
                + Add Skill
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

                            <th>Skill</th>

                            <th>Type</th>

                            <th>Proficiency</th>

                            <th>Order</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php if (count($skills) > 0): ?>


                            <?php foreach ($skills as $skill): ?>


                                <tr>


                                    <td>

                                        <strong>
                                            <?= e(
                                                $skill['skill_name']
                                            ); ?>
                                        </strong>

                                    </td>


                                    <td>

                                        <?php if (
                                            $skill['skill_type']
                                            === 'hard_skill'
                                        ): ?>

                                            <span
                                                style="
                                                    display:inline-block;
                                                    padding:5px 9px;
                                                    background:#f3f4f6;
                                                    border-radius:6px;
                                                    font-size:12px;
                                                "
                                            >
                                                Hard Skill
                                            </span>

                                        <?php else: ?>

                                            <span
                                                style="
                                                    display:inline-block;
                                                    padding:5px 9px;
                                                    background:#f3f4f6;
                                                    border-radius:6px;
                                                    font-size:12px;
                                                "
                                            >
                                                Soft Skill
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <td>

                                        <?php if (
                                            $skill['proficiency']
                                            !== null
                                        ): ?>

                                            <?= e(
                                                $skill['proficiency']
                                            ); ?>%

                                        <?php else: ?>

                                            —

                                        <?php endif; ?>

                                    </td>


                                    <td>

                                        <?= e(
                                            $skill['display_order']
                                        ); ?>

                                    </td>


                                    <td>

                                        <div class="actions">

                                            <a
                                                href="edit.php?id=<?= $skill['id']; ?>"
                                                class="btn btn-secondary"
                                            >
                                                Edit
                                            </a>


                                            <a
                                                href="delete.php?id=<?= $skill['id']; ?>"
                                                class="btn btn-danger"
                                                onclick="
                                                    return confirm(
                                                        'Are you sure you want to delete this skill?'
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

                                    No skills found.

                                    <br><br>

                                    <a
                                        href="add.php"
                                        style="
                                            color:#111827;
                                            font-weight:600;
                                        "
                                    >
                                        Add your first skill
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