<?php
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location: ../guest/login.php');
    exit;
}

require_once("../con.fig.php");

// Funkcja do pobierania liczby użytkowników
function getUserCount($conn) {
    $query = "SELECT COUNT(*) as user_count FROM users";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['user_count'];
}

// Funkcja do pobierania liczby fiszek
function getFlashcardCount($conn) {
    $query = "SELECT COUNT(*) as flashcard_count FROM flashcards";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['flashcard_count'];
}

// Funkcja do pobierania liczby zgłoszonych fiszek
function getReportedFlashcardCount($conn) {
    $query = "SELECT COUNT(*) as reported_flashcard_count FROM reported_flashcards";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['reported_flashcard_count'];
}

// Pobieranie danych statystycznych
$user_count = getUserCount($conn);
$flashcard_count = getFlashcardCount($conn);
$reported_flashcard_count = getReportedFlashcardCount($conn);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Fiszki - Panel Administratora</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="../css/useradmstyles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Witaj <?php echo $_SESSION['admin_name']; ?> w panelu administratora</h1>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Liczba użytkowników</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $user_count; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Liczba fiszek</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $flashcard_count; ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Liczba zgłoszonych fiszek</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $reported_flashcard_count; ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
