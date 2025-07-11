<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_name'])) {
    header('location: ../guest/login.php');
    exit;
}

// Połączenie z bazą danych
require_once("../con.fig.php");

// Sprawdzenie, czy przekazano dane formularza
if(isset($_POST['update_flashcard'])) {
    $flashcard_id = $_POST['flashcard_id'];
    $title = $_POST['title'];
    $term = $_POST['term'];
    $definition = $_POST['definition'];
    $level_id = $_POST['level'];

    // Aktualizacja danych fiszki w bazie danych
    $update_flashcard_query = "UPDATE flashcards SET title = '$title', term = '$term', definition = '$definition', level_id = '$level_id' WHERE id = $flashcard_id";
    $update_result = mysqli_query($conn, $update_flashcard_query);

    if($update_result) {
        // Jeśli aktualizacja powiodła się, przekieruj użytkownika z powrotem do listy jego fiszek
        echo "Aktualizacja fiszki powiodła się";
        header('location: ../user/allmyflashcards.php');
        exit;
    } else {
        // Jeśli wystąpił błąd, wyświetl komunikat błędu
        echo "Wystąpił błąd podczas aktualizacji fiszki.";
    }
} else {
    echo "Aktualizacja fiszki nie powiodła się";
    header('location: myflashcards.php');
    exit;
}
?>
