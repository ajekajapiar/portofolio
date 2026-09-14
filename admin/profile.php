<?php

require_once 'auth.php';
require_once '../config/database.php';
require_once '../includes/functions.php';


/*
|--------------------------------------------------------------------------
| Get Profile
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM profile
    ORDER BY id ASC
    LIMIT 1
");

$profile = $stmt->fetch();


/*
|--------------------------------------------------------------------------
| Create profile automatically if empty
|--------------------------------------------------------------------------
*/

if (!$profile) {

    $stmt = $pdo->prepare("
        INSERT INTO profile
        (
            full_name
        )
        VALUES
        (
            ?
        )
    ");

    $stmt->execute([
        'Your Name'
    ]);


    $profileId =
        $pdo->lastInsertId();


    $stmt = $pdo->prepare("
        SELECT *
        FROM profile
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([
        $profileId
    ]);

    $profile =
        $stmt->fetch();
}


$pageTitle = 'Profile';


include '../includes/admin_header.php';
include '../includes/admin_sidebar.php';

?>


<main class="main-content">


    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Profile
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


    <!-- CONTENT -->

    <div class="content">


        <!-- PAGE HEADER -->

        <div class="page-header">

            <div>

                <h1>Profile</h1>

                <p>
                    Manage your personal information and social links.
                </p>

            </div>

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

                <?= e(
                    $_GET['success']
                ); ?>

            </div>

        <?php endif; ?>


        <?php if (isset($_GET['error'])): ?>

            <div
                class="alert alert-danger"
                style="margin-bottom:20px;"
            >

                <?= e(
                    $_GET['error']
                ); ?>

            </div>

        <?php endif; ?>


        <!-- PROFILE -->

        <div class="card">


            <form
                action="profile_process.php"
                method="POST"
                enctype="multipart/form-data"
            >


                <input
                    type="hidden"
                    name="id"
                    value="<?= $profile['id']; ?>"
                >


                <!-- PROFILE IMAGE -->

                <div class="form-group">


                    <label>
                        Profile Photo
                    </label>


                    <div
                        style="
                            display:flex;
                            align-items:center;
                            gap:20px;
                            margin-bottom:15px;
                        "
                    >


                        <?php if (
                            !empty(
                                $profile['profile_image']
                            )
                        ): ?>

                            <img
                                src="../assets/images/profile/<?= e(
                                    $profile['profile_image']
                                ); ?>"
                                alt="<?= e(
                                    $profile['full_name']
                                ); ?>"
                                style="
                                    width:120px;
                                    height:120px;
                                    object-fit:cover;
                                    border-radius:50%;
                                    border:1px solid #e5e7eb;
                                "
                            >

                        <?php else: ?>

                            <div
                                style="
                                    width:120px;
                                    height:120px;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    border-radius:50%;
                                    background:#f3f4f6;
                                    color:#9ca3af;
                                    font-size:12px;
                                "
                            >
                                No Photo
                            </div>

                        <?php endif; ?>


                    </div>


                    <input
                        type="file"
                        name="profile_image"
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
                        Recommended: square photo.
                        JPG, PNG, or WEBP. Maximum 5 MB.
                    </small>


                </div>


                <!-- FULL NAME -->

                <div class="form-group">

                    <label for="full_name">
                        Full Name *
                    </label>


                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        class="form-control"
                        value="<?= e(
                            $profile['full_name']
                        ); ?>"
                        required
                    >

                </div>


                <!-- PROFESSIONAL TITLE -->

                <div class="form-group">

                    <label for="professional_title">
                        Professional Title
                    </label>


                    <input
                        type="text"
                        id="professional_title"
                        name="professional_title"
                        class="form-control"
                        value="<?= e(
                            $profile[
                                'professional_title'
                            ]
                        ); ?>"
                        placeholder="e.g. Information Systems Student | Web Developer"
                    >

                </div>


                <!-- SHORT BIO -->

                <div class="form-group">

                    <label for="short_bio">
                        Short Bio
                    </label>


                    <textarea
                        id="short_bio"
                        name="short_bio"
                        class="form-control"
                        rows="5"
                        placeholder="A short introduction that will appear on your homepage..."
                    ><?= e(
                        $profile['short_bio']
                    ); ?></textarea>


                    <small
                        style="
                            display:block;
                            margin-top:7px;
                            color:#6b7280;
                            font-size:12px;
                        "
                    >
                        Keep this concise.
                        Around 2–4 sentences is ideal.
                    </small>


                </div>


                <!-- ABOUT ME -->

                <div class="form-group">

                    <label for="about_me">
                        About Me
                    </label>


                    <textarea
                        id="about_me"
                        name="about_me"
                        class="form-control"
                        rows="9"
                        placeholder="Tell visitors more about yourself, your interests, experience, and career direction..."
                    ><?= e(
                        $profile['about_me']
                    ); ?></textarea>


                </div>


                <!-- LOCATION -->

                <div class="form-group">

                    <label for="location">
                        Location
                    </label>


                    <input
                        type="text"
                        id="location"
                        name="location"
                        class="form-control"
                        value="<?= e(
                            $profile['location']
                        ); ?>"
                        placeholder="e.g. Jakarta, Indonesia"
                    >

                </div>


                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        Email
                    </label>


                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="<?= e(
                            $profile['email']
                        ); ?>"
                        placeholder="you@example.com"
                    >

                </div>


                <!-- PHONE -->

                <div class="form-group">

                    <label for="phone">
                        Phone
                    </label>


                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        class="form-control"
                        value="<?= e(
                            $profile['phone']
                        ); ?>"
                        placeholder="+62..."
                    >

                </div>


                <!-- SOCIAL MEDIA -->

                <hr
                    style="
                        border:0;
                        border-top:1px solid #e5e7eb;
                        margin:35px 0;
                    "
                >


                <h2
                    style="
                        margin-bottom:8px;
                    "
                >
                    Social Media
                </h2>


                <p
                    style="
                        color:#6b7280;
                        margin-bottom:25px;
                    "
                >
                    Add links to your professional and personal profiles.
                </p>


                <!-- LINKEDIN -->

                <div class="form-group">

                    <label for="linkedin_url">
                        LinkedIn
                    </label>


                    <input
                        type="url"
                        id="linkedin_url"
                        name="linkedin_url"
                        class="form-control"
                        value="<?= e(
                            $profile['linkedin_url']
                        ); ?>"
                        placeholder="https://linkedin.com/in/username"
                    >

                </div>


                <!-- GITHUB -->

                <div class="form-group">

                    <label for="github_url">
                        GitHub
                    </label>


                    <input
                        type="url"
                        id="github_url"
                        name="github_url"
                        class="form-control"
                        value="<?= e(
                            $profile['github_url']
                        ); ?>"
                        placeholder="https://github.com/username"
                    >

                </div>


                <!-- INSTAGRAM -->

                <div class="form-group">

                    <label for="instagram_url">
                        Instagram
                    </label>


                    <input
                        type="url"
                        id="instagram_url"
                        name="instagram_url"
                        class="form-control"
                        value="<?= e(
                            $profile['instagram_url']
                        ); ?>"
                        placeholder="https://instagram.com/username"
                    >

                </div>


                <!-- WEBSITE -->

                <div class="form-group">

                    <label for="website_url">
                        Personal Website
                    </label>


                    <input
                        type="url"
                        id="website_url"
                        name="website_url"
                        class="form-control"
                        value="<?= e(
                            $profile['website_url']
                        ); ?>"
                        placeholder="https://example.com"
                    >

                </div>


                <!-- OTHER -->

                <div class="form-group">

                    <label for="other_social_url">
                        Other Link
                    </label>


                    <input
                        type="url"
                        id="other_social_url"
                        name="other_social_url"
                        class="form-control"
                        value="<?= e(
                            $profile['other_social_url']
                        ); ?>"
                        placeholder="https://..."
                    >

                </div>


                <!-- BUTTON -->

                <div
                    style="
                        display:flex;
                        gap:10px;
                        margin-top:30px;
                    "
                >

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Save Profile
                    </button>

                </div>


            </form>


        </div>


    </div>

</main>


<?php include '../includes/admin_footer.php'; ?>