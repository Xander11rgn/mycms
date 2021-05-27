<?php

$servername = "localhost";
$username = "root";
$pass = "root";

function addUser($login, $password, $lastName, $firstName, $middleName, $mail, $phone, $groupID)
{
    global $servername, $username, $pass;
    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);

        $query = "SELECT EXISTS(SELECT userID FROM user WHERE login=:login OR mail=:mail)";
        $stmt = $conn->prepare($query);
        $stmt->execute(['login' => $login, 'mail' => $mail]);
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $result = $row[0];
        }
        $stmt = null;

        if ($result == 1) {
            echo "Successn't";
        } else {
            $query = "INSERT INTO user (login, password, lastName, firstName, middleName, mail, phone, groupID) 
            VALUES (:login, :password, :lastName, :firstName, :middleName, :mail, :phone, :groupID)";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                'login' => $login, 'password' => $password, 'lastName' => $lastName,
                'firstName' => $firstName, 'middleName' => $middleName, 'mail' => $mail, 'phone' => $phone, 'groupID' => $groupID
            ]);
            $conn = null;
            $stmt = null;
            echo 'Success';
        }
        // echo $result;
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};

function checkUser($login, $password)
{
    global $servername, $username, $pass;
    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "SELECT EXISTS(SELECT userID FROM user WHERE login=:login AND password=:password)";
        $stmt = $conn->prepare($query);
        $stmt->execute(['login' => $login, 'password' => $password]);
        $conn = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $result = $row[0];
        }
        $stmt = null;
        echo $result;
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};

function addGroup($groupName)
{
    global $servername, $username, $pass;
    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "INSERT INTO usergroup (groupName) 
                  VALUES (:groupName)";
        $stmt = $conn->prepare($query);
        $stmt->execute(['groupName' => $groupName]);
        $conn = null;
        $stmt = null;
        echo 'Success';
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};


function create($shopName, $designName, $payments, $deliveries, $contactPhone, $contactMail, $imgSize)
{
    global $servername, $username, $pass;
    try {
        $designID = addDesign($designName);
        $payID = addPayment($payments);
        $delID = addDelivery($deliveries);
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "INSERT INTO configuration (shopName, designID, payID, delID, contactPhone, contactMail, imgSize) VALUES (:shopName, :designID, :payID, :delID, :contactPhone, :contactMail, :imgSize)";
        $stmt = $conn->prepare($query);
        $stmt->execute(['shopName' => $shopName, 'designID' => $designID, 'payID' => $payID, 'delID' => $delID, 'contactPhone' => $contactPhone,'contactMail' => $contactMail, 'imgSize' => intval($imgSize)]);
        $stmt = null;
        $conn = null;
        echo 'Success';
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};

function addDesign($designName)
{
    global $servername, $username, $pass;
    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "INSERT INTO design (designName) VALUES (:designName)";
        $stmt = $conn->prepare($query);
        $stmt->execute(['designName' => $designName]);
        $stmt = null;
        $query = "SELECT designID FROM design WHERE designName=:designName";
        $stmt = $conn->prepare($query);
        $stmt->execute(['designName' => $designName]);
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $result = $row[0];
        }
        $stmt = null;
        $conn = null;
        return $result;
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};

function addDelivery($deliveries)
{
    global $servername, $username, $pass;
    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "INSERT INTO delivery (delName, isAvailable) VALUES (:delName, :isAvailable)";
        foreach ($deliveries as $delName) {
            $stmt = $conn->prepare($query);
            $stmt->execute(['delName' => $delName, 'isAvailable' => 1]);
            $stmt = null;
        }

        $query = "SELECT delID FROM delivery WHERE delName=:delName";
        $stmt = $conn->prepare($query);
        $stmt->execute(['delName' => $deliveries[0]]);
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $result = $row[0];
        }
        $stmt = null;
        $conn = null;
        return $result;
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};


function addPayment($payments)
{
    global $servername, $username, $pass;
    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "INSERT INTO payment (payName, isAvailable) VALUES (:payName, :isAvailable)";
        foreach ($payments as $payName) {
            $stmt = $conn->prepare($query);
            $stmt->execute(['payName' => $payName, 'isAvailable' => 1]);
            $stmt = null;
        }

        $query = "SELECT payID FROM payment WHERE payName=:payName";
        $stmt = $conn->prepare($query);
        $stmt->execute(['payName' => $payments[0]]);
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $result = $row[0];
        }
        $stmt = null;
        $conn = null;
        return $result;
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};

function generateReport($reportType, $fields){
    global $servername, $username, $pass;

    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "SELECT productName";
        if (count($fields) != 0) {
            foreach ($fields as $field) {
                if ($field == 'count'){
                    $query .= ', SUM(po.' . $field . ') AS count';    
                }
                else{
                    $query .= ', ' . $field;
                }
                
            }
        }
        // $query .= "SELECT productName, description, price, discount, dateBuy, address, comment FROM product LEFT JOIN productorder USING(productID) LEFT JOIN orders USING(orderID)";
        $query .= " FROM product LEFT JOIN productorder AS po USING(productID) LEFT JOIN orders USING(orderID) GROUP BY (productName)";
        $stmt = $conn->prepare($query);
        $stmt->execute(['reportID' => 1]);
        $i = 0;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $result[$i]["productName"] = $row["productName"];
            if (count($fields) != 0) {
                foreach ($fields as $field) {
                    $result[$i][$field] = $row[$field];
                }
            }
            $i++;
        }
        $stmt = null;
        $conn = null;

        $html = '<!DOCTYPE html>
                 <html lang="ru">
                    <head>
                        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                        <meta charset="UTF-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                        <title>Отчёт</title>
                        <style>
                            tr{
                                text-align: center;
                            }
                        </style>
                    </head>
                    <body>
                        <table border="1" width="1200px" align="center">
                            <caption>Отчёт о продажах</caption>
                            <tr>
                                <th width="50px">№</th>
                                <th width="250px">Наименование товара</th>';
                                if (count($fields) != 0) {
                                    if (in_array("description", $fields)) { $html .= '<th width="45%">Описание товара</th>';}
                                    if (in_array("price", $fields)) { $html .= '<th>Стоимость товара</th>';}
                                    if (in_array("discount", $fields)) { $html .= '<th>Скидка</th>';}
                                    if (in_array("count", $fields)) { $html .= '<th>Количество</th>';}
                                    if (in_array("dateBuy", $fields)) { $html .= '<th>Дата покупки товара</th>';}
                                }

                            $html .= '</tr>';
        
                            $i = 1;
                            foreach ($result as $row) {
                                $html .= '<tr>
                                            <td>' . $i . '</td>
                                            <td>' . $row["productName"] . '</td>';
                                if (count($fields) != 0) {
                                    foreach ($fields as $field){
                                        if ($field == 'discount') {
                                            $html .= '<td>' . $row[$field] . '%</td>';    
                                        }
                                        else {
                                            $html .= '<td>' . $row[$field] . '</td>';
                                        }
                                    }
                                }
                                    $html .= '</tr>';
                                    $i++;
                                }
        $html .= '</table></body></html>';

        return html_entity_decode($html);
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
}


function addImage($productID, $imgData)
{
    global $servername, $username, $pass;
    $imgFormats =["JPG" => "\xFF\xD8\xFF","GIF" => "GIF","PNG" => "\x89\x50\x4e\x47\x0d\x0a\x1a\x0a",
                  "BMP" => "BM","PSD" => "8BPS","SWF" => "FWS"];
    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "INSERT INTO image (imageType, imageContent, imageSize, imageName, isBasic, productID) 
                  VALUES (:imageType, :imageContent, :imageSize, :imageName, :isBasic, :productID)";
        $stmt = $conn->prepare($query);
        $i=0;
        foreach ($imgData as $img) {
            foreach ($imgFormats as $key => $format) {
                if (substr(base64_decode($img), 0, strlen($format)) === $format) {
                    $imageType = $key;
                    break;
                }
            }
            $imageSize = round(strlen(base64_decode($img))/1024, 1);
            $imageName = intval(time()/($i*15));
            if ($i == 0) {$isBasic=1;} else {$isBasic = 0;}
            $stmt->execute(['imageType' => $imageType,'imageContent' => base64_decode($img),
            'imageSize' => $imageSize,'imageName' => $imageName,'isBasic' => $isBasic,
            'productID' => $productID,]);
            $i++;
        }
        $stmt = null;
        $conn = null;
        echo "Success";
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};


function addProduct($productName, $description, $price, $isAvailable, $count, $rating=0, $discount=0)
{
    global $servername, $username, $pass;
    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "INSERT INTO product (productName, description, rating, price, discount, isAvailable, count, userID) 
                  VALUES (:productName, :description, :rating, :price, :discount, :isAvailable, :count, :userID)";
        $stmt = $conn->prepare($query);
        $stmt->execute(['productName' => $productName, 'description' => trim($description), 'rating' => $rating,
                        'price' => intval(str_replace(" ", "", "$price")), 'discount' => $discount,'isAvailable' => intval($isAvailable),
                        'count' => intval($count),'userID' => 1]);
        $stmt = null;

        $query = "SELECT productID FROM product ORDER BY productID DESC LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $productID = $row[0];
        }
        $stmt = null;
        $conn = null;
        return $productID;
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};


function changeImageSizes($size)
{
    global $servername, $username, $pass;
    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "UPDATE configuration SET imgSize = :size WHERE configID=:configID";
        $stmt = $conn->prepare($query);
        $stmt->execute(['size' => intval($size), 'configID' => 5]);
        $stmt = null;
        $conn = null;
        echo 'Success';
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};


function getOrders(){
    global $servername, $username, $pass;
    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "SELECT orderID FROM orders";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $orderIDs[] = $row[0];
        }
        $stmt = null;

        $query = "SELECT orderID, productName, price, discount, po.count, dateBuy, address, pmt.payName, d.delName, comment, lastName, firstName, middleName, mail, phone, statusID 
                  FROM product AS p LEFT JOIN productorder AS po USING (productID) LEFT JOIN orders AS o USING (orderID) LEFT JOIN user AS u ON o.userID=u.userID 
                  LEFT JOIN delivery as d ON o.delID=d.delID LEFT JOIN payment as pmt ON o.payID=pmt.payID WHERE orderID=:orderID";
        $stmt = $conn->prepare($query);
        $i=0;
        foreach ($orderIDs as $orderID) {
            $stmt->execute(['orderID' => $orderID]);
            $j=0;
            while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                $result[$i][$j]['orderID'] = $row[0];
                $result[$i][$j]['productName'] = $row[1];
                $result[$i][$j]['price'] = $row[2];
                $result[$i][$j]['discount'] = $row[3];
                $result[$i][$j]['count'] = $row[4];
                $result[$i][$j]['dateBuy'] = $row[5];
                $result[$i][$j]['address'] = $row[6];
                $result[$i][$j]['payName'] = $row[7];
                $result[$i][$j]['delName'] = $row[8];
                $result[$i][$j]['comment'] = $row[9];
                $result[$i][$j]['lastName'] = $row[10];
                $result[$i][$j]['firstName'] = $row[11];
                $result[$i][$j]['middleName'] = $row[12];
                $result[$i][$j]['mail'] = $row[13];
                $result[$i][$j]['phone'] = $row[14];
                $result[$i][$j]['statusID'] = $row[15];
                $j++;
            }  
            $i++;  
        }
        $stmt = null;
        $conn = null;
        echo json_encode($result);
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
}


function changeOrderStatus($orderID, $statusID){
    global $servername, $username, $pass;
    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "UPDATE orders SET statusID = :statusID WHERE orderID=:orderID";
        $stmt = $conn->prepare($query);
        $stmt->execute(['statusID' => intval($statusID), 'orderID' => $orderID]);
        $stmt = null;
        $conn = null;
        echo 'Success';
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }   
}