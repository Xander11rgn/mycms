<?php
require_once 'sms.ru.php';
require_once '../generateCode.php';

session_start();

$smsObject = new SMSRU('EFBE1E46-D898-8BF3-4427-4E8D39B63291');
$data = new stdClass();
$data->to = $_POST['tel'];
$code = generateCode(6, 1);
$data->text = "Для подтверждения заявки введите следующий код:" . $code;
$sms = $smsObject->send_one($data);

if ($sms->status == "OK") {
  $_SESSION["code"] = $code;
  $_SESSION["sms_id"] = $sms->sms_id;
}
// echo $_SESSION["code"];
// echo $_SESSION["sms_id"];

// if ($sms->status == "OK") { 
//   echo "Сообщение отправлено успешно. ";
//   echo "ID сообщения: $sms->sms_id. ";
//   echo "Ваш новый баланс: $sms->balance";
// } else {
//   echo "Сообщение не отправлено. ";
//   echo "Код ошибки: $sms->status_code. ";
//   echo "Текст ошибки: $sms->status_text.";
// }
