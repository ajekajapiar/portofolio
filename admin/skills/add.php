<?php

require_once '../auth.php';

$pageTitle = 'Add Skill';

include '../../includes/admin_header.php';
include '../../includes/admin_sidebar.php';

?>


<main class="main-content">


    <header class="topbar">

        <div class="topbar-title">
            Add Skill
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

                <h1>Add Skill</h1>

                <p>
                    Add a hard skill or soft skill.
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
            >


                <input
                    type="hidden"
                    name="action"
                    value="create"
                >


                <!-- SKILL NAME -->

                <div class="form-group">

                    <label for="skill_name">
                        Skill Name *
                    </label>

                    <input
                        type="text"
                        id="skill_name"
                        name="skill_name"
                        class="form-control"
                        placeholder="e.g. PHP"
                        required
                    >

                </div>


                <!-- TYPE -->

                <div class="form-group">

                    <label for="skill_type">
                        Skill Type *
                    </label>

                    <select
                        id="skill_type"
                        name="skill_type"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Select skill type
                        </option>

                        <option value="hard_skill">
                            Hard Skill
                        </option>

                        <option value="soft_skill">
                            Soft Skill
                        </option>

                    </select>

                </div>


                <!-- PROFICIENCY -->

                <div
                    class="form-group"
                    id="proficiency-group"
                >

                    <label for="proficiency">
                        Proficiency
                    </label>

                    <input
                        type="number"
                        id="proficiency"
                        name="proficiency"
                        class="form-control"
                        min="1"
                        max="100"
                        placeholder="e.g. 80"
                    >

                    <small
                        style="
                            display:block;
                            margin-top:7px;
                            color:#6b7280;
                            font-size:12px;
                        "
                    >
                        Use this only for hard skills.
                        Leave empty for soft skills.
                    </small>

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

                    <small
                        style="
                            display:block;
                            margin-top:7px;
                            color:#6b7280;
                            font-size:12px;
                        "
                    >
                        Smaller numbers appear first.
                    </small>

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
                        Save Skill
                    </button>

                </div>


            </form>


        </div>

    </div>

</main>


<script>

const skillType =
    document.getElementById('skill_type');

const proficiencyGroup =
    document.getElementById('proficiency-group');

const proficiency =
    document.getElementById('proficiency');


function toggleProficiency() {

    if (
        skillType.value === 'soft_skill'
    ) {

        proficiencyGroup.style.display = 'none';

        proficiency.value = '';

    } else {

        proficiencyGroup.style.display = 'block';

    }

}


skillType.addEventListener(
    'change',
    toggleProficiency
);


toggleProficiency();

</script>


<?php include '../../includes/admin_footer.php'; ?>