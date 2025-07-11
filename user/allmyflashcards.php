<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_name'])) {
    header('location: ../guest/login.php');
    exit;
}

// Połączenie z bazą danych
require_once("../con.fig.php");

// Domyślna liczba fiszek na stronę
$fiszki_na_strone = 10;

// Pobranie id wybranego poziomu
if (isset($_GET['level_id'])) {
    $level_id = $_GET['level_id'];

    // Pobranie nazwy poziomu
    $get_level_name_query = "SELECT name FROM levels WHERE id = $level_id";
    $get_level_name_result = mysqli_query($conn, $get_level_name_query);
    $level_row = mysqli_fetch_assoc($get_level_name_result);
    $level_name = $level_row['name'];

    // Pobranie numeru strony, jeśli przekazany
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Obliczenie offsetu
    $offset = ($page - 1) * $fiszki_na_strone;

    // Pobranie fiszek użytkownika dla danego poziomu z bazy danych z uwzględnieniem paginacji
    $user_id = $_SESSION['user_id'];
    $get_flashcards_query = "SELECT flashcards.id, flashcards.title, flashcards.term, flashcards.definition FROM flashcards WHERE flashcards.user_id = $user_id AND flashcards.level_id = $level_id LIMIT $offset, $fiszki_na_strone";
    $get_flashcards_result = mysqli_query($conn, $get_flashcards_query);

    // Pobranie całkowitej liczby fiszek dla danego poziomu
    $count_query = "SELECT COUNT(*) AS total FROM flashcards WHERE user_id = $user_id AND level_id = $level_id";
    $count_result = mysqli_query($conn, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_fiszki = $count_row['total'];
    $total_pages = ceil($total_fiszki / $fiszki_na_strone);
} else {
    // Jeśli nie przekazano id poziomu, przekieruj użytkownika z powrotem do strony głównej
    header('location: myflashcards.php');
    exit;
}

include("../include/iuser/unav.php");
?>

<div class="container" style="margin-top: 100px;"> <!-- Dodany margines na górze -->
    <h2>Fiszki z poziomu <?php echo $level_name; ?></h2> <!-- Dodano nazwę poziomu -->
    <?php
    // Wyświetl fiszki użytkownika dla danego poziomu
    while ($flashcard = mysqli_fetch_assoc($get_flashcards_result)) {
    ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?php echo $flashcard['title']; ?></h5>
            <p class="card-text"><strong>Pojęcie:</strong> <?php echo $flashcard['term']; ?></p>
            <p class="card-text" style="display: none;" id="definition_<?php echo $flashcard['id']; ?>"><strong>Wyjaśnienie:</strong> <?php echo $flashcard['definition']; ?></p>
            <button class="btn btn-primary" onclick="showDefinition(<?php echo $flashcard['id']; ?>)">Zobacz wyjaśnienie</button>
            <!-- Przyciski Usuń i Edytuj -->
            <div class="mt-2">
                <button class="btn btn-danger mr-2" onclick="confirmDelete(<?php echo $flashcard['id']; ?>)">Usuń</button>
                <a href="editFlashcard.php?id=<?php echo $flashcard['id']; ?>" class="btn btn-secondary">Edytuj</a> <!-- Przenosi użytkownika do formularza edycji z odpowiednim id -->
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- Paginacja -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="allmyflashcards.php?level_id=<?php echo $level_id; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
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
            window.location.href = "../fun/delete_flashcard.php?id=" + id; // Tutaj zmień ścieżkę na odpowiednią
        }
    }

</script>

<?php
include("../include/iuser/ufooter.php");
?>
