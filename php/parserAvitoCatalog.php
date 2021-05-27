<?php
require_once("parser.php");
set_time_limit(600);
$url = $_POST["url"];
$url = "https://www.avito.ru/titan43/kirovskaya_oblast_kirov/zapchasti_i_aksessuary";
// $proxy = '194.135.15.6:40040';
// $proxy = '89.251.147.97:30048';
// $proxy = '46.173.35.229:3629';
// $proxy = '46.35.249.189:49795';
$proxy = '77.37.240.23:4145';
$output = "";
$ch = curl_init();
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1');
curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept-Language: en-us,en;q=0.5"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 25);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
while (!$output) {
  $output = curl_exec($ch);
}
if ($output === false) {
  throw new Exception(curl_error($ch), curl_errno($ch));
}
curl_close($ch);

$output = htmlspecialchars($output);

$domen = "https://www.avito.ru";

//парсинг ссылок
$links = explode("item-description-title-link", $output);
unset($links[0]);
for ($i = 0; $i < count($links); $i++) {
  $links[$i] = explode(htmlspecialchars('href="'), $links[$i])[1];
  $links[$i] = explode(htmlspecialchars('"'), $links[$i])[0];
  $links[$i] = $domen . $links[$i];
}
unset($links[0]);
// var_dump($links);
for ($i=1; $i<11; $i++) {
  sleep(3);
  $products[] = parseProduct($links[$i]);
}

// foreach ($links as $link) {
//   sleep(3);
//   $products[] = parseProduct($link);
// }
// var_dump($products);

echo json_encode($products);
