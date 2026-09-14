<?php

require_once 'auth.php';
require_once '../config/database.php';
require_once '../includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    redirect('profile.php');

}


$id = (int) (
    $_POST['id'] ?? 0
);


$fullName = trim(
    $_POST['full_name'] ?? ''
);


$professionalTitle = trim(
    $_POST['professional_title'] ?? ''
);


$shortBio = trim(
    $_POST['short_bio'] ?? ''
);


$aboutMe = trim(
    $_POST['about_me'] ?? ''
);


$location = trim(
    $_POST['location'] ?? ''
);


$email = trim(
    $_POST['email'] ?? ''
);


$phone = trim(
    $_POST['phone'] ?? ''
);


$linkedinUrl = trim(
    $_POST['linkedin_url'] ?? ''
);


$githubUrl = trim(
    $_POST['github_url'] ?? ''
);


$instagramUrl = trim(
    $_POST['instagram_url'] ?? ''
);


$websiteUrl = trim(
    $_POST['website_url'] ?? ''
);


$otherSocialUrl = trim(
    $_POST['other_social_url'] ?? ''
);


/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

if ($id <= 0) {

    redirect(
        'profile.php?error=' .
        urlencode(
            'Invalid profile.'
        )
    );

}


if ($fullName === '') {

    redirect(
        'profile.php?error=' .
        urlencode(
            'Full name is required.'
        )
    );

}


if (
    $email !== '' &&
    !filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    )
) {

    redirect(
        'profile.php?error=' .
        urlencode(
            'Invalid email address.'
        )
    );

}


/*
|--------------------------------------------------------------------------
| Validate URLs
|--------------------------------------------------------------------------
*/

$urls = [

    'LinkedIn' => $linkedinUrl,

    'GitHub' => $githubUrl,

    'Instagram' => $instagramUrl,

    'Website' => $websiteUrl,

    'Other link' => $otherSocialUrl

];


foreach ($urls as $label => $url) {


    if (
        $url !== '' &&
        !filter_var(
            $url,
            FILTER_VALIDATE_URL
        )
    ) {

        redirect(
            'profile.php?error=' .
            urlencode(
                'Invalid ' .
                $label .
                ' URL.'
            )
        );

    }

}


/*
|--------------------------------------------------------------------------
| Get existing profile
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT profile_image
    FROM profile
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([
    $id
]);


$existingProfile =
    $stmt->fetch();


if (!$existingProfile) {

    redirect(
        'profile.php?error=' .
        urlencode(
            'Profile not found.'
        )
    );

}


$profileImage =
    $existingProfile[
        'profile_image'
    ];


/*
|--------------------------------------------------------------------------
| Upload profile image
|--------------------------------------------------------------------------
*/

if (
    isset($_FILES['profile_image']) &&
    $_FILES['profile_image']['error']
    !== UPLOAD_ERR_NO_FILE
) {


    $uploadResult = uploadImage(

        $_FILES['profile_image'],

        '../assets/images/profile',

        'profile'

    );


    if (!$uploadResult['success']) {

        redirect(
            'profile.php?error=' .
            urlencode(
                $uploadResult['error']
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Delete old image
    |--------------------------------------------------------------------------
    */

    if (
        !empty(
            $existingProfile[
                'profile_image'
            ]
        )
    ) {

        $oldImage =
            '../assets/images/profile/' .
            $existingProfile[
                'profile_image'
            ];


        if (
            file_exists($oldImage)
        ) {

            unlink($oldImage);

        }

    }


    $profileImage =
        $uploadResult['filename'];

}


/*
|--------------------------------------------------------------------------
| Update profile
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    UPDATE profile

    SET

        full_name = ?,

        professional_title = ?,

        short_bio = ?,

        about_me = ?,

        location = ?,

        email = ?,

        phone = ?,

        profile_image = ?,

        linkedin_url = ?,

        github_url = ?,

        instagram_url = ?,

        website_url = ?,

        other_social_url = ?

    WHERE id = ?
");


$stmt->execute([

    $fullName,

    $professionalTitle !== ''
        ? $professionalTitle
        : null,

    $shortBio !== ''
        ? $shortBio
        : null,

    $aboutMe !== ''
        ? $aboutMe
        : null,

    $location !== ''
        ? $location
        : null,

    $email !== ''
        ? $email
        : null,

    $phone !== ''
        ? $phone
        : null,

    $profileImage,

    $linkedinUrl !== ''
        ? $linkedinUrl
        : null,

    $githubUrl !== ''
        ? $githubUrl
        : null,

    $instagramUrl !== ''
        ? $instagramUrl
        : null,

    $websiteUrl !== ''
        ? $websiteUrl
        : null,

    $otherSocialUrl !== ''
        ? $otherSocialUrl
        : null,

    $id

]);


redirect(
    'profile.php?success=' .
    urlencode(
        'Profile successfully updated.'
    )
);