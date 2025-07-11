<?php
session_start();

// Połączenie z bazą danych
require_once("../con.fig.php");

if(!isset($_SESSION['admin_name'])){
   header('location: ../guest/login.php');
   exit; 
}

if(isset($_POST['logout'])){
    session_destroy(); 
    header('location: ../index.php'); 
    exit; 
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Wylogowanie</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 100px;
            text-align: center;
        }
        h2 {
            margin-bottom: 30px;
        }
        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        p {
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Potwierdź wylogowanie</h2>
        <form action="admlogout.php" method="post">
            <p>Czy na pewno chcesz się wylogować?</p>
            <input type="submit" name="logout" value="Wyloguj">
        </form>
    </div>
</body>
</html>
