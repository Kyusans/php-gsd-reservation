<?php
include "headers.php";

class Admin
{
    function login($json)
    {
        // {"username":"admin","password":"admin"}
        include "connection.php";
        $json = json_decode($json, true);
        $sql = "SELECT * FROM tbl_admin WHERE adm_employee_id = :userId AND BINARY adm_password = :password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":userId", $json["userId"]);
        $stmt->bindParam(":password", $json["password"]);
        $returnValue = 0;
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $rs = $stmt->fetch(PDO::FETCH_ASSOC);
            $returnValue = json_encode($rs);
        }
        return $returnValue;
    }

    function addVenue($json)
    {
        include "connection.php";
        $json = json_decode($json, true);
        $sql = "INSERT INTO tblrooms(rm_name, rm_occupancy) VALUES(:name, :occupancy)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":name", $json["name"]);
        $stmt->bindParam(":occupancy", $json["occupancy"]);
        $stmt->execute();
        return $stmt->rowCount() > 0 ? 1 : 0;
    }
} //admin 

$json = isset($_POST["json"]) ? $_POST["json"] : "0";
$operation = isset($_POST["operation"]) ? $_POST["operation"] : "0";

$admin = new Admin();

switch ($operation) {
    case "login":
        echo $admin->login($json);
        break;
    case "addVenue";
        echo $admin->addVenue($json);
        break;
}
