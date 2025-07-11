<?php
session_start();

if(!isset($_SESSION['admin_name'])){

   header('location: ../guest/login.php');
   exit; 
}

// Połączenie z bazą danych
require_once("../con.fig.php");

//STRONA POWITALNA ADMINA
include ("../include/iadmin/anav.php");
include ("../include/iadmin/amiddle.php");
include ("../include/iadmin/afooter.php");
