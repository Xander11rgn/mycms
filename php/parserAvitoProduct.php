<?php
require_once("parser.php");
set_time_limit(600);
if (isset($_POST["url"])) {
  $url = $_POST["url"];
}
// $url = "https://www.avito.ru/kirovskaya_oblast_kirov/zapchasti_i_aksessuary/navigator_prology_imap-5800_an_2059574979";
echo json_encode(parseProduct($url));


