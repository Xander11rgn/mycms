<?php
function addUser($login, $password, $lastName, $firstName, $middleName, $mail, $phone, $groupID)
{
    $servername = "localhost";
    $username = "root";
    $pass = "root";

    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "INSERT INTO user (login, password, lastName, firstName, middleName, mail, phone, groupID) 
                  VALUES (:login, :password, :lastName, :firstName, :middleName, :mail, :phone, :groupID)";
        $stmt = $conn->prepare($query);
        $stmt->execute(['login' => $login, 'password' => $password, 'lastName' => $lastName, 
                        'firstName' => $firstName,'middleName' => $middleName, 'mail' => $mail,'phone' => $phone,'groupID' => $groupID]);
        $conn = null;
        $stmt = null;
        echo 'Success';
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
};

function checkUser($login, $password)
{
    $servername = "localhost";
    $username = "root";
    $pass = "root";

    try {
        $conn = new PDO("mysql:host=$servername; dbname=mycmsdb", $username, $pass);
        $query = "SELECT EXISTS(SELECT userID FROM user WHERE login=:login AND password=:password)";
        $stmt = $conn->prepare($query);
        $stmt->execute(['login' => $login, 'password' => $password]);
        $conn = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY))
        {
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
    $servername = "localhost";
    $username = "root";
    $pass = "root";

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