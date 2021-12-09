<?php
include_once("./PDOconnection.php");


$example = new Example();
$con = $example->con();
$example->statementCreate();
$example->insertEmployee("oliver", 1400);
$example->statementGetEmployeesData();
?>