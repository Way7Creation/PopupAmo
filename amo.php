<?php


if(!empty($_POST['email']) and !empty($_POST['phone'])){
  $email = trim(strip_tags($_POST['email']));
  $phone = trim(strip_tags($_POST['phone']));
  $phone = str_replace(['(',')','-','+',' '], '', $phone );
  $from  = "От: $email";

  /* Ваш адрес и тема сообщения */
  $sub = "Сообщение с сайта https://w7c.ru/popuptest.php";

  /* Формат письма */
  mail('vseelectrocom@mail.ru', $sub, 
       "Вам написал: ".$email."\nЕго номер: ".$phone. "\n\nContent-type:text/html;charset=windows-1251");
}
else {
  echo "Не отправлено!";
}

require_once 'access.php';

$name = 'Мусинский Алексей';
$email = $_POST['email'];
$phone = $_POST['phone'];
$phone = str_replace(['(',')','-','+',' '], '', $phone );

$custom_field_id = 454021;
$custom_field_value = 'тест';

$ip = '1.2.3.4';
$domain = 'site.ua';
$price = 0;
$pipeline_id = 5704864;
$user_amo = 8483899;

$utm_source   = '';
$utm_content  = '';
$utm_medium   = '';
$utm_campaign = '';
$utm_term     = '';
$utm_referrer = '';

$data = [
    [
        "name" => $name,
        "price" => 0,
        "responsible_user_id" => (int) $user_amo,
        "pipeline_id" => (int) $pipeline_id,
        "_embedded" => [
            "contacts" => [
                [
                    "first_name" => $name,
                    "custom_fields_values" => [
                        [
                            "field_code" => "EMAIL",
                            "values" => [
                                [
                                    "enum_code" => "WORK",
                                    "value" => $email
                                ]
                            ]
                        ],
                        [
                            "field_code" => "PHONE",
                            "values" => [
                                [
                                    "enum_code" => "WORK",
                                    "value" => $phone
                                ]
                            ]
                        ],
                    ]
                ]
            ],
        ]
    ]
];

// остановлися тут
$method = "/api/v4/leads/complex";

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token,
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
curl_setopt($curl, CURLOPT_URL, "https://$subdomain.amocrm.ru".$method);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_COOKIEFILE, 'amo/cookie.txt');
curl_setopt($curl, CURLOPT_COOKIEJAR, 'amo/cookie.txt');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
$out = curl_exec($curl);
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$code = (int) $code;
$errors = [
    301 => 'Moved permanently.',
    400 => 'Wrong structure of the array of transmitted data, or invalid identifiers of custom fields.',
    401 => 'Not Authorized. There is no account information on the server. You need to make a request to another server on the transmitted IP.',
    403 => 'The account is blocked, for repeatedly exceeding the number of requests per second.',
    404 => 'Not found.',
    500 => 'Internal server error.',
    502 => 'Bad gateway.',
    503 => 'Service unavailable.'
];

if ($code < 200 || $code > 204) die( "Error $code. " . (isset($errors[$code]) ? $errors[$code] : 'Undefined error') );


$Response = json_decode($out, true);
$Response = $Response['_embedded']['items'];
$output = 'ID добавленных элементов списков:' . PHP_EOL;
foreach ($Response as $v)
    if (is_array($v))
        $output .= $v['id'] . PHP_EOL;
return $output;