<?php
require_once("../con.fig.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_id = intval($_POST['report_id']);

    // Usuń zgłoszenie z tabeli reported_flashcards
    $deleteReportQuery = "DELETE FROM reported_flashcards WHERE id = $report_id";
    mysqli_query($conn, $deleteReportQuery);

    // Sprawdź, czy zapytanie się powiodło
    if (mysqli_affected_rows($conn) > 0) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_close($conn);
}
?>
