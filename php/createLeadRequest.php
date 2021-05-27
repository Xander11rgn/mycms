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


	$productName = 85;
	echo $productName . "<br>";


	$opportunity = $_REQUEST['opportunity'];
	echo $opportunity . "<br>";


	$currencyID = "RUB";
	echo $currencyID . "<br>";


	$creditTime = $_REQUEST['creditTime'];
	echo $creditTime . "<br>";

	$creditRate = $_REQUEST['creditRate'];
	echo $creditRate . "<br>";


	$income = $_REQUEST['income'];
	echo $income . "<br>";

	$consumption = $_REQUEST['consumption'];
	echo $consumption . "<br>";


	$pledges = [
		"квартира" => 1038,
		"апартаменты" => 1233,
		"таунхаус" => 1425,
		"дом с земельным участком" => 1426
	];
	$pledgeVar = $pledges[$_REQUEST['pledgeVar']];
	echo $pledgeVar . "<br>";


	$pledgeCities = [
		"киров" => 627,
		"москва" => 628,
		"санкт-петербург" => 629,
		"пермь" => 630,
		"йошкар-ола" => 631,
		"нижний новгород" => 632
	];
	$pledgeCity = $pledgeCities[$_REQUEST['pledgeCity']];
	echo $pledgeCity . "<br>";


	$phone = $_REQUEST['phone'];
	echo $phone . "<br>";

	if (!empty($_REQUEST['email'])) {
		$email = $_REQUEST['email'];
		echo $email . "<br>";
	}


	$acceptType = 'PHONE';
	echo $acceptType . "<br>";

	$acceptPhone = $phone;
	echo $acceptPhone . "<br>";

	$acceptCode = $_SESSION['code'];
	echo $acceptCode . "<br>";

	$acceptDate = $_REQUEST['acceptDate'];
	echo $acceptDate . "<br>";

	$acceptSMSID = $_SESSION['sms_id'];
	echo $acceptSMSID . "<br>";


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
				'UF_PRODUCT_NAME' => $productName,
				'OPPORTUNITY' => $opportunity,
				'CURRENCY_ID' => $currencyID,
				'UF_CREDIT_TIME' => $creditTime,
				'UF_CREDIT_RATE' => $creditRate,
				'UF_INCOME_BY_MONTH' => $income,
				'UF_CREDIT_PAY_BY_MON' => $consumption,
				'UF_PLEDGE_VAR' => $pledgeVar,
				'UF_PLEDGE_ADDRESS_CITY' => $pledgeCity,
				'PHONE' => [['VALUE' => $phone, 'VALUE_TYPE' => 'MOBILE']],
				'UF_EMAIL_INFO' => $email,
				'EMAIL' => [['VALUE' => $email, 'VALUE_TYPE' => 'HOME']],
				'UF_ACCEPT_TYPE' => $acceptType,
				'UF_ACCEPT_PHONE' => $phone,
				'UF_ACCEPT_CODE' => $acceptCode,
				'UF_ACCEPT_DATE' => $acceptDate,
				'UF_ACCEPT_SMS_ID' => $acceptSMSID,
				'TRACE' => $trace
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
