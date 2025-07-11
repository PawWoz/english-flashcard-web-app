<?php
session_start();

// Ustawienie raportowania błędów w trybie deweloperskim
if(isset($dev) && $dev == 1) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
}

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header('location: ../guest/login.php');
    exit;
}

// Połączenie z bazą danych
require_once("../con.fig.php");

include ("../include/iuser/unav.php");

// Pobranie danych aktualnie zalogowanego użytkownika z bazy danych
$user_id = $_SESSION['user_id'];
$query = "SELECT name, surname, email, city, street, street_number FROM users WHERE id = $user_id";

// Wykonanie zapytania SQL
$result = mysqli_query($conn, $query);

// Sprawdzenie, czy zapytanie się powiodło
if ($result) {
    // Pobranie danych użytkownika
    $user_data = mysqli_fetch_assoc($result);
} else {
    // Obsługa błędu, jeśli zapytanie się nie powiodło
    die("Błąd podczas pobierania danych użytkownika: " . mysqli_error($conn));
}

// Obsługa formularza aktualizacji profilu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobranie danych z formularza
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $street_number = $_POST['street_number'];

    // Aktualizacja danych w bazie danych
    $update_query = "UPDATE users SET name='$name', surname='$surname', email='$email', city='$city', street='$street', street_number='$street_number' WHERE id='$user_id'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        // Wyświetlenie komunikatu o sukcesie
        header('location: ../user/account.php');
    } else {
        // Wyświetlenie komunikatu o błędzie
        echo "<script>alert('Wystąpił błąd podczas aktualizacji profilu użytkownika.');</script>";
    }
}
?>

<div class="container rounded bg-white mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="p-5">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <h3 class="text-center mb-4">Edycja Profilu</h3>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <label for="name">Imię:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user_data['name']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="surname">Nazwisko:</label>
                            <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $user_data['surname']; ?>">
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_data['email']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="city">Miejscowość:</label>
                            <input type="text" class="form-control" id="city" name="city" value="<?php echo $user_data['city']; ?>">
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <label for="street">Ulica:</label>
                            <input type="text" class="form-control" id="street" name="street" value="<?php echo $user_data['street']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="street_number">Numer ulicy:</label>
                            <input type="text" class="form-control" id="street_number" name="street_number" value="<?php echo $user_data['street_number']; ?>">
                        </div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary btn-lg profile-button" type="submit">Zapisz Profil</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include ("../include/iuser/ufooter.php");
?>
