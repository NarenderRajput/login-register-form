<?php
include __DIR__."/../config/app.php";
include __DIR__."/../config/db.php";
include __DIR__."/../helper/common.php";

$conn = db_connect();

$name =  $data = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $_SESSION["nameErr"] = "Name is Required";
  } else {
    $name = test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
      $_SESSION["nameErr"]  = "Only letters and white space allowed";
    } else {
      $data .= "'$name',";
    }
  }

  if (empty($_POST["lastname"])) {
    $data .= "'',";
  } else {
    $lastname = test_input($_POST["lastname"]);
    $data .= "'$lastname',";
  }


  if (empty($_POST["email"])) {
    $_SESSION["emailErr"] = "Email id Is Required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION["emailErr"] = "Invalid Email format";
    } else {
      $data .= "'$email',";
    }
  }

  if (empty($_POST["password"])) {
    $_SESSION["passwordErr"] = "Password is Required ";
  } else {
    $password = password_hash(test_input($_POST["password"]), PASSWORD_BCRYPT);
    $data .= "'$password'";
  }
  
  if (isset($_SESSION["nameErr"]) || isset($_SESSION["emailErr"]) || isset($_SESSION["passwordErr"])) {
    header('location:'.ROOT.'/register.php');
  } else {
    insert_data($conn, $data);
  }
}


function test_input($data)
{
  $data = trim($data);
  $data = stripcslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function insert_data($conn, $data)
{
  $sql = "INSERT INTO users(firstname, lastname, email, password)
  VALUES($data)";
  
  if (Mysqli_query($conn, $sql)) {
    //echo "New record created Successfully";
    mysqli_close($conn);
    redirectToLogin();
  } else {
    echo "Error : " . $sql . "<br>" . mysqli_error($conn);
  }

  mysqli_close($conn);
}

function redirectToLogin() {
  header('location: '.ROOT.'/login.php', 302);
  exit;
}