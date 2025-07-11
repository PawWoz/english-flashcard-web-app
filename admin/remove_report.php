<?php
require_once("../con.fig.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_id = intval($_POST['report_id']);
    $flashcard_id = intval($_POST['flashcard_id']);

    // Usuń zgłoszenie z tabeli reported_flashcards
    $deleteReportQuery = "DELETE FROM reported_flashcards WHERE id = $report_id";
    mysqli_query($conn, $deleteReportQuery);

    // Usuń fiszkę z tabeli flashcards
    $deleteFlashcardQuery = "DELETE FROM flashcards WHERE id = $flashcard_id";
    mysqli_query($conn, $deleteFlashcardQuery);

    // Sprawdź, czy zapytania się powiodły
    if (mysqli_affected_rows($conn) > 0) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_close($conn);
}
?>
