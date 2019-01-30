<?php
function getConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "000000";
    $dbname = "camagru";

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}catch (PDOException $e){
    echo " Connection failed: ".$e->getMessage();
}
}
function selectusers($query){
    $pdo = getConnection();

    $stmt=$pdo->query($query);
    return $stmt->fetch();
}

function updateusers($query){
    $pdo=getConnection();
    
    $stmt=$pdo->prepare($query);
    return $stmt->execute();
}
?>
