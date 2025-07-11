<?php
session_start();

// Sprawdzenie, czy administrator jest zalogowany
if (!isset($_SESSION['admin_name'])) {
    header('location: ../guest/login.php');
    exit;
}

// Połączenie z bazą danych
require_once("../con.fig.php");

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Zgłoszenia Fiszek</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="../css/useradmstyles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <?php include("../include/iadmin/anav.php"); ?>

    <div class="container mt-5">
        <?php
        // Zapytanie SQL do pobrania zgłoszonych fiszek
        $query = "SELECT * FROM reported_flashcards";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<h2 class='text-center mb-4'>Zgłoszone fiszki:</h2>";
            echo "<table class='table table-striped'>";
            echo "<thead><tr><th>ID</th><th>ID Fiszki</th><th>Data zgłoszenia</th><th>Usuń/Zachowaj</th><th>Szczegóły</th></tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['id'])."</td>";
                echo "<td>".htmlspecialchars($row['flashcard_id'])."</td>";
                echo "<td>".htmlspecialchars($row['reported_at'])."</td>";
                echo "<td>
                          <button class='btn btn-danger btn-sm remove-report' data-report-id='".htmlspecialchars($row['id'])."' data-flashcard-id='".htmlspecialchars($row['flashcard_id'])."'>Usuń</button>
                          <button class='btn btn-success btn-sm keep-flashcard' data-report-id='".htmlspecialchars($row['id'])."' data-flashcard-id='".htmlspecialchars($row['flashcard_id'])."'>Zachowaj</button>
                      </td>";
                echo "<td><a href='#' class='btn btn-info btn-sm show-details' data-id='".htmlspecialchars($row['flashcard_id'])."'>Pokaż szczegóły</a></td>";
                echo "</tr>";
                echo "<tr class='details-row' id='details_".htmlspecialchars($row['flashcard_id'])."' style='display: none;'>";

                // Pobranie szczegółowych informacji o fiszce na podstawie jej ID
                $flashcardQuery = "SELECT * FROM flashcards WHERE id = " . intval($row['flashcard_id']);
                $flashcardResult = mysqli_query($conn, $flashcardQuery);
                if ($flashcardResult && mysqli_num_rows($flashcardResult) > 0) {
                    $flashcardData = mysqli_fetch_assoc($flashcardResult);
                    echo "<td colspan='5'>";
                    echo "<strong>Tytuł:</strong> " . htmlspecialchars($flashcardData['title']) . "<br>";
                    echo "<strong>Słowo:</strong> " . htmlspecialchars($flashcardData['term']) . "<br>";
                    echo "<strong>Definicja:</strong> " . htmlspecialchars($flashcardData['definition']) . "<br>";
                    echo "</td>";
                } else {
                    echo "<td colspan='5'>Brak szczegółowych informacji o fiszce.</td>";
                }

                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p class='text-center'>Brak zgłoszonych fiszek.</p>";
        }

        // Zamknięcie połączenia z bazą danych
        mysqli_close($conn);
        ?>
    </div>

    <?php include("../include/iadmin/afooter.php"); ?>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obsługa linków "Pokaż szczegóły"
        var showDetailsLinks = document.querySelectorAll(".show-details");
        showDetailsLinks.forEach(function(link) {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                var detailsRow = document.getElementById("details_" + this.dataset.id);
                if (detailsRow.style.display === "none") {
                    detailsRow.style.display = "table-row";
                } else {
                    detailsRow.style.display = "none";
                }
            });
        });

        // Obsługa przycisków "Usuń"
        var removeReportButtons = document.querySelectorAll(".remove-report");
        removeReportButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                if (confirm("Czy na pewno chcesz usunąć zgłoszenie i fiszkę?")) {
                    var reportId = this.dataset.reportId;
                    var flashcardId = this.dataset.flashcardId;
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "remove_report.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Usunięcie zgłoszenia i fiszki z tabeli
                            var reportRow = button.parentNode.parentNode;
                            reportRow.parentNode.removeChild(reportRow);
                            var detailsRow = document.getElementById("details_" + flashcardId);
                            if (detailsRow) {
                                detailsRow.parentNode.removeChild(detailsRow);
                            }
                        }
                    };
                    xhr.send("report_id=" + reportId + "&flashcard_id=" + flashcardId);
                }
            });
        });

        // Obsługa przycisków "Zachowaj"
        var keepFlashcardButtons = document.querySelectorAll(".keep-flashcard");
        keepFlashcardButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                if (confirm("Czy na pewno chcesz zachować fiszkę?")) {
                    var reportId = this.dataset.reportId;
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "keep_report.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Usunięcie zgłoszenia z tabeli
                            var reportRow = button.parentNode.parentNode;
                            reportRow.parentNode.removeChild(reportRow);
                        }
                    };
                    xhr.send("report_id=" + reportId);
                }
            });
        });
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
