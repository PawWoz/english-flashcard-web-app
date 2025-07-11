<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_name'])) {
    header('location: ../guest/login.php');
    exit;
}

// Połączenie z bazą danych
require_once("../con.fig.php");

include("../include/iuser/unav.php");

// Sprawdzenie, czy przekazano id edytowanej fiszki
if(isset($_GET['id'])) {
    $flashcard_id = $_GET['id'];
    
    // Zapytanie o dane edytowanej fiszki
    $get_flashcard_query = "SELECT * FROM flashcards WHERE id = $flashcard_id";
    $get_flashcard_result = mysqli_query($conn, $get_flashcard_query);
    
    // Sprawdzenie czy znaleziono fiszkę o podanym id
    if(mysqli_num_rows($get_flashcard_result) > 0) {
        $flashcard = mysqli_fetch_assoc($get_flashcard_result);
        $title = $flashcard['title'];
        $term = $flashcard['term'];
        $definition = $flashcard['definition'];
        $level_id = $flashcard['level_id'];
    } else {
        // Jeśli nie znaleziono fiszki, przekieruj użytkownika
        header('location: myflashcards.php');
        exit;
    }
} else {
    // Jeśli nie przekazano id fiszki, przekieruj użytkownika
    header('location: myflashcards.php');
    exit;
}
?>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>EDYCJA FISZKI</h4>
                    </div>
                    <div class="card-body">
                        <form action="../fun/update_flashcard.php" method="POST">
                            <div class="form-group">
                                <label for="title">Tytuł</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Wpisz tytuł" value="<?php echo $title; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="term">Termin</label>
                                <input type="text" name="term" id="term" class="form-control" placeholder="Wpisz termin" value="<?php echo $term; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="definition">Definicja</label>
                                <input type="text" name="definition" id="definition" class="form-control" placeholder="Wpisz definicję" value="<?php echo $definition; ?>" required>
                            </div>

                            <!-- Ukryte pole przechowujące id edytowanej fiszki -->
                            <input type="hidden" name="flashcard_id" value="<?php echo $flashcard_id; ?>">

                            <!-- Pole wyboru (combobox) dla poziomów -->
                            <div class="form-group">
                                <label for="level">Poziom</label>
                                <select name="level" id="level" class="form-control" required>
                                    <option value="">Wybierz poziom</option>
                                    <?php
                                    // Pobranie poziomów z bazy danych
                                    $levels_query = "SELECT * FROM levels";
                                    $levels_result = mysqli_query($conn, $levels_query);
                                    while ($row = mysqli_fetch_assoc($levels_result)) {
                                        // Oznaczenie wybranego poziomu
                                        $selected = ($row['id'] == $level_id) ? "selected" : "";
                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" name="update_flashcard" class="btn btn-primary">Edytuj</button>
                                <a href="allmyflashcards.php" class="btn btn-secondary">Anuluj</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include("../include/iuser/ufooter.php");
?>
