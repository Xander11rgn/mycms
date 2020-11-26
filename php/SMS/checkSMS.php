<?php
session_start();
if (isset($_POST["inputCode"]) && isset($_SESSION["code"])) {
  if ($_POST["inputCode"] == $_SESSION["code"]) {
    echo true;
  } else {
    echo false;
  }
}
