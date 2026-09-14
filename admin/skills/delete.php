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
    DELETE FROM skills
    WHERE id = ?
");

$stmt->execute([$id]);


redirect(
    'index.php?success=' .
    urlencode(
        'Skill successfully deleted.'
    )
);