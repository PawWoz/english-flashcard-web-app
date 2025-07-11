<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['admin_name'])) {
    header('location: ../guest/login.php');
    exit;
}

// Połączenie z bazą danych
require_once("../con.fig.php");

// Pobranie wszystkich fiszek z bazy danych
$get_flashcards_query = "SELECT flashcards.id, flashcards.title, flashcards.term, flashcards.definition, levels.name AS level_name 
                        FROM flashcards 
                        JOIN levels ON flashcards.level_id = levels.id";
$get_flashcards_result = mysqli_query($conn, $get_flashcards_query);

include("../include/iadmin/anav.php");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edytuj Fiszki</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .card {
            margin-bottom: 20px;
        }
        .container {
            padding-bottom: 100px; /* Dodanie dodatkowego marginesu na dole */
        }
    </style>
</head>
<body>
<div class="container" style="margin-top: 100px;">
    <h2>Wszystkie Fiszki</h2>
    <div class="row">
    <?php
    // Wyświetl fiszki
    while ($flashcard = mysqli_fetch_assoc($get_flashcards_result)) {
    ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($flashcard['title']); ?></h5>
                    <p class="card-text"><strong>Poziom:</strong> <?php echo htmlspecialchars($flashcard['level_name']); ?></p>
                    <p class="card-text"><strong>Pojęcie:</strong> <?php echo htmlspecialchars($flashcard['term']); ?></p>
                    <p class="card-text" style="display: none;" id="definition_<?php echo $flashcard['id']; ?>"><strong>Wyjaśnienie:</strong> <?php echo htmlspecialchars($flashcard['definition']); ?></p>
                    <button class="btn btn-primary" onclick="showDefinition(<?php echo $flashcard['id']; ?>)">Zobacz wyjaśnienie</button>
                    <div class="mt-2">
                        <button class="btn btn-danger mr-2" onclick="confirmDelete(<?php echo $flashcard['id']; ?>)">Usuń</button>
                        <a href="edit_flashcard.php?id=<?php echo $flashcard['id']; ?>" class="btn btn-secondary">Edytuj</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>

<script>
    function showDefinition(id) {
        var definitionElement = document.getElementById("definition_" + id);
        if (definitionElement.style.display === "none") {
            definitionElement.style.display = "block";
        } else {
            definitionElement.style.display = "none";
        }
    }

    function confirmDelete(id) {
        if (confirm("Czy na pewno chcesz usunąć tę fiszkę?")) {
            window.location.href = "../fun/delete_flashcard.php?id=" + id;
        }
    }
</script>

<?php
include("../include/iadmin/afooter.php");
?>
</body>
</html>
