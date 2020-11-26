<?php
// $str = 'https://zalog.norvikbank.ru/?utm_source=site&utm_medium=article&utm_campaign=kvartirapodkvartiru';
$urlRefer = $_SERVER["HTTP_REFERER"] . '<br>';
// echo $urlRefer;
$replyText = $_REQUEST['replyText'] . '<br>';
// echo $replyText;
$replyName = $_REQUEST['replyName'] . '<br>';
// echo $replyName;
$replyTel = $_REQUEST['replyTel'] . '<br>';
// echo $replyTel;

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

$subject = "Отзыв от {$replyName}";

$message = '<html><body>';
$message .= "<p>Текст отзыва: {$replyText}</p>";
$message .= "<p>Имя: {$replyName}</p>";
$message .= "<p>Контактный телефон: {$replyTel}</p>";

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
