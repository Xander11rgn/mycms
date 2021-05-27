<?php
function parseProduct($url)
{
  // echo $url;
  //   $auth = base64_encode('LOGIN:PASSWORD');
  //   $ctx = stream_context_create(array('http'=>
  //     array(
  //         'timeout' => 1200,  //1200 Seconds is 20 Minutes
  //         'ignore_errors' => true,
  //         'proxy' => 'http://188.120.232.181:8118',
  //         'request_fulluri' => true,
  //     ),
  //     "ssl"=>array(
  //       "allow_self_signed"=>true,
  //       "verify_peer"=>false,
  //       "verify_peer_name"=>false,
  //   ),
  // ));
  //   $output = file_get_contents($url, false, $ctx);
  set_time_limit(600);
  // $proxy = '194.135.15.6:40040';
  // $proxy = '89.251.147.97:30048';
  // $proxy = '46.173.35.229:3629';
  $proxy = '77.37.240.23:4145';
  // $proxy = '46.35.249.189:49795';
  $output = "";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1');
  curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
  curl_setopt($ch, CURLOPT_HTTPHEADER, ["Accept-Language: en-us,en;q=0.5"]);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 25);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
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
  //   // var_dump($ch);
  // var_dump($output);

  //парсинг наименования товара
  $productName = explode("title-info-title-text", $output)[1];
  $productName = explode(htmlspecialchars(">"), strstr($productName, htmlspecialchars(">")), 2)[1];
  $productName = strstr($productName, htmlspecialchars("<"), true);
  $result["productName"] = $productName;

  //парсинг описания товара
  if (strpos($output, "item-description-text")) {
    $description = explode("item-description-text", $output)[1];
  } else if (strpos($output, "item-description-html")) {
    $description = explode("item-description-html", $output)[1];
  } else {
    $description = null;
  }
  $description = explode(htmlspecialchars(">"), strstr($description, htmlspecialchars(">")), 2)[1];
  $description = strstr($description, htmlspecialchars("</div>"), true);
  $description = str_replace([htmlspecialchars("<br />"), htmlspecialchars("<br>"), htmlspecialchars(" <br />"), htmlspecialchars("</p><p>")], " ", $description);
  $description = strip_tags(html_entity_decode($description));
  $result["description"] = $description;


  //парсинг цены товара
  $price = explode("js-item-price", $output)[1];
  $price = explode(htmlspecialchars(">"), strstr($price, htmlspecialchars(">")), 2)[1];
  $price = strstr($price, htmlspecialchars("<"), true);
  $result["price"] = $price;


  //парсинг изображений товара
  $urlsIMG = explode("gallery-extended-img-frame js-gallery-extended-img-frame", $output);
  $urlsIMG[0] = explode("gallery-extended-img-frame gallery-extended-img-frame_state-selected js-gallery-extended-img-frame", $urlsIMG[0])[1];
  for ($i = 0; $i < count($urlsIMG); $i++) {
    $urlsIMG[$i] = explode(htmlspecialchars('data-url="'), $urlsIMG[$i])[1];
    $urlsIMG[$i] = strstr($urlsIMG[$i], htmlspecialchars('"'), true);
  }
  foreach ($urlsIMG as $url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $img = curl_exec($ch);
    curl_close($ch);
    $result["img"][] = base64_encode($img);
  }

  // var_dump($result);
  return $result;
}
