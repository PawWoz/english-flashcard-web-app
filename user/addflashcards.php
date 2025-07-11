<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_name'])) {
    header('location: ../guest/login.php');
    exit;
}

// Połączenie z bazą danych
require_once("../con.fig.php");

// DODAWANIE FISZKI
if(isset($_POST['save_flashcard']))
{
    // Sprawdzenie, czy wszystkie pola formularza są uzupełnione
    if(empty($_POST['title']) || empty($_POST['term']) || empty($_POST['definition'])) {
        echo "Wszystkie pola formularza muszą być uzupełnione!";
    } else {
        // Jeśli pola formularza są uzupełnione, kontynuuj dodawanie fiszki

        $user_id = $_SESSION['user_id'];
        $title = $_POST['title'];
        $term = $_POST['term'];
        $definition = $_POST['definition'];
        $level_id = $_POST['level']; // Dodane pobranie poziomu z formularza

        // Tworzenie zapytania SQL
        $insert_flashcard_query = "INSERT INTO flashcards (title, term, definition, user_id, level_id) VALUES ('$title','$term','$definition','$user_id', '$level_id')";

        // Wykonanie zapytania
        $insert_flashcard_query_run = mysqli_query($conn, $insert_flashcard_query);

        if ($insert_flashcard_query_run) {
            echo "Rekord został dodany pomyślnie.";
        } else {
            echo "Błąd: " . mysqli_error($conn);
        }
    }
}

include ("../include/iuser/unav.php");
?>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>DODAWANIE FISZEK</h4>
                    </div>
                    <div class="card-body">

                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="title">Tytuł</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Wpisz tytuł" required>
                        </div>

                        <div class="form-group">
                            <label for="term">Termin</label>
                            <input type="text" name="term" id="term" class="form-control" placeholder="Wpisz termin" required>
                        </div>

                        <div class="form-group">
                            <label for="definition">Definicja</label>
                            <input type="text" name="definition" id="definition" class="form-control" placeholder="Wpisz definicję" required>
                        </div>

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
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" name="save_flashcard" class="btn btn-primary">Zapisz</button>
                        </div>
                    </form>

                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include ("../include/iuser/ufooter.php");
?>
