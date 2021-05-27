<?php
// $str = 'https://zalog.norvikbank.ru/?utm_source=site&utm_medium=article&utm_campaign=kvartirapodkvartiru';
$urlRefer = $_SERVER["HTTP_REFERER"] . '<br>';
// echo $urlRefer;
$improveText = $_REQUEST['improveText'] . '<br>';
// echo $improveText;
$rating = $_REQUEST['rating'] . '<br>';
// echo $rating;

$arUTM = [
  'utm_source',
  'utm_medium',
  'utm_campaign',
  'utm_term',
  'utm_content',
];

$utmString = explode('?', $urlRefer)[1];

foreach ($arUTM as $value) {
  if (strpos($utmString, $value) !== false) {
    $utm = explode('&', explode($value . '=', $utmString)[1])[0];
    $utms[$value] = $utm;
    setcookie($value, $utm);
    // echo $utm . '<br>';
  }  
}


$to  = '<incrk@yandex.ru>';

$subject = "Оценка полезности страницы";

$message = '<html><body>';
$message .= "<p>Оценка страницы: {$rating}</p>";
$message .= "<p>Текст сообщения: {$improveText}</p>";

$message .= "<p>UTM-метки:<br>";
if (isset($utms)) {
  foreach ($utms as $key => $value) {
    $message .= "{$key} = {$value}<br>";
  }
} else {
  $message .= 'отсутствуют.';
}

$message .= '</p><br><br>-------<br>Данное сообщение создано автоматически';
$message .= '</body></html>';

$headers = "From: <robot@vtkbank.ru> \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html;charset=utf-8 \r\n";

if ($mail = mail($to, $subject, $message, $headers)) {
  echo 'Сообщение успешно отправлено';
} else {
  echo 'Сообщение не было отправлено';
}

// echo $message;
