<?php
require_once 'getFullName.php';

session_start();

if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
	$title = $_REQUEST['title'];
	echo $title . "<br>";
	$sourceID = 1;
	echo $sourceID . "<br>";

	$sourceDescription = $_REQUEST['sourceDescription'];
	echo $sourceDescription . "<br>";

	$fullName = getBreakApartFullNameByArray($title);
	$lastName = $fullName['LAST_NAME'];
	echo $lastName . "<br>";

	$name = $fullName['NAME'];
	echo $name . "<br>";

	if (!empty($fullName['SECOND_NAME'])) {
		$secondName = $fullName['SECOND_NAME'];
		echo $secondName . "<br>";
	}

	$phone = $_REQUEST['phone'];
	echo $phone . "<br>";

	$trace = $_REQUEST['trace'];
	echo $trace . "<br>";

	// $to  = '<incrk@yandex.ru>';

	// $subject = "Заявка на кредит от {$name}";

	// $headers = "From: {$name} <robot@vtkbank.ru> \r\n";
	// $headers .= "MIME-Version: 1.0\r\n";
	// $headers .= "Content-Type: text/html;charset=utf-8 \r\n";

	// $message = '<html><body>';
	// $message .= "<p>Имя: {$name}<br>";
	// $message .= "Телефон: {$phone}<br>";
	// $message .= "Сумма: {$amount}<br>";

	if ($curl = curl_init())
	{
		$queryUrl =  "https://24tst.vtkbank.ru/rest/160/gqtfmcf9udz3dx3x/crm.lead.add/";

		$queryData = [
			'fields' => [
				'TITLE' => $title,
				'SOURCE_ID' => $sourceID,
				'SOURCE_DESCRIPTION' => $sourceDescription,
				'NAME' => $name,
				'LAST_NAME' => $lastName,
				'SECOND_NAME' => $secondName,
				'PHONE' => [['VALUE' => $phone, 'VALUE_TYPE' => 'MOBILE']],
				'TRACE' => $trace,
			],
			'params' => ['REGISTER_SONET_EVENT' => 'Y']

		];

		curl_setopt_array(
			$curl,
			[
				CURLOPT_SSL_VERIFYPEER => 1,
				CURLOPT_POST => 1,
				CURLOPT_HEADER => 0,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => $queryUrl,
				CURLOPT_POSTFIELDS => http_build_query($queryData),
				CURLOPT_CONNECTTIMEOUT => 10,
				CURLOPT_TIMEOUT => 15,
			]
		);

		$result = curl_exec($curl);

		if ($result === false)
		{
			// $message .= '<br>Ошибка соединения с порталом: ' . curl_error($curl) . '<br>';

			echo 0;
		}
		elseif (!empty($result['result']['error']))
		{
			// $message .= "<br>Ошибка создания лида<br><b>{$result['result']['error']}: {$result['result']['error_message']}</b><br>";

			echo 0;
		}
		else
		{
			$result = json_decode($result, true);
			$id = intval($result['result']);
			// $message .= "<br>Создан лид: <a href='https://24.vtkbank.ru/crm/lead/details/{$id}/' target='_blank'>{$name}</a><br>";

			echo 1;
		}

		curl_close($curl);
	}

	// $message .= '<br><br>-------<br>Данное сообщение создано автоматически';
	// $message .= '</p></body></html>';

	// mail($to, $subject, $message, $headers);
} else {
	echo 0;
}
