<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header('location: ../guest/login.php');
    exit;
}

require_once("../con.fig.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $id = mysqli_real_escape_string($conn, $id);
    
    // Usuń fiszkę z bazy danych
    $delete_query = "DELETE FROM flashcards WHERE id = $id";
    mysqli_query($conn, $delete_query);
    
    // Przekieruj użytkownika z powrotem na stronę, z której usunięto fiszkę
    header("location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    // Jeśli nie przekazano id fiszki, przekieruj użytkownika na stronę główną
    header('location: myflashcards.php');
    exit;
}
?>
