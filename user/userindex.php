<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_name'])) {
    header('location: ../guest/login.php');
    exit;
}

// Połączenie z bazą danych
require_once("../con.fig.php");

// Pobranie poziomów
$get_levels_query = "SELECT * FROM levels";
$get_levels_result = mysqli_query($conn, $get_levels_query);

include("../include/iuser/unav.php");
?>

<div class="container" style="margin-top: 100px;"> <!-- Dodany margines na górze -->
    <?php
    // Dla każdego poziomu wyświetl nazwę i przycisk
    while($level = mysqli_fetch_assoc($get_levels_result)) {
        $level_id = $level['id'];
        $level_name = $level['name'];
    ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?php echo $level_name; ?></h5>
            <p class="card-text">Zobacz wszystkie fiszki z poziomu <?php echo $level_name; ?></p>
            <a href='allUserFlashcards.php?level_id=<?php echo $level_id; ?>' class="btn btn-primary">Przejdź</a>
        </div>
    </div>
    <?php } ?>
</div>

<?php
include ("../include/iuser/ufooter.php");
?>
