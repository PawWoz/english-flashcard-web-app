<?php
session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location: ../guest/login.php');
    exit;
}

require_once("../con.fig.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user_id'])) {
    $edit_user_id = $_POST['edit_user_id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $street_number = $_POST['street_number'];

    $update_query = "UPDATE users SET name='$name', surname='$surname', email='$email', city='$city', street='$street', street_number='$street_number' WHERE id='$edit_user_id'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        echo "<div class='alert alert-success' role='alert'>Profil użytkownika został zaktualizowany.</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Wystąpił błąd podczas aktualizacji profilu użytkownika.</div>";
    }
}

$user_query = "SELECT id, name, surname, email FROM users";
$user_result = mysqli_query($conn, $user_query);

$user_data = null;
if (isset($_GET['edit_user_id'])) {
    $edit_user_id = $_GET['edit_user_id'];
    $query = "SELECT name, surname, email, city, street, street_number FROM users WHERE id = $edit_user_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $user_data = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='alert alert-danger' role='alert'>Błąd podczas pobierania danych użytkownika: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<?php include("../include/iadmin/anav.php"); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="text-center mb-4">Lista użytkowników</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Email</th>
                        <th>Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($user_result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['surname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <a href="?edit_user_id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm">Edytuj</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if ($user_data) { ?>
    <div class="container rounded bg-white mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="p-5">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <h3 class="text-center mb-4">Edycja Profilu</h3>
                        <input type="hidden" name="edit_user_id" value="<?php echo htmlspecialchars($edit_user_id); ?>">
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <label for="name">Imię:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="surname">Nazwisko:</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo htmlspecialchars($user_data['surname']); ?>" required>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="city">Miejscowość:</label>
                                <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($user_data['city']); ?>" required>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <label for="street">Ulica:</label>
                                <input type="text" class="form-control" id="street" name="street" value="<?php echo htmlspecialchars($user_data['street']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="street_number">Numer ulicy:</label>
                                <input type="text" class="form-control" id="street_number" name="street_number" value="<?php echo htmlspecialchars($user_data['street_number']); ?>" required>
                            </div>
                        </div>
                        <div class="mt-5 text-center"><button class="btn btn-primary btn-lg profile-button" type="submit">Zapisz Profil</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php include("../include/iadmin/afooter.php"); ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
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
});
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
    });
</script>
</body>
</html>
