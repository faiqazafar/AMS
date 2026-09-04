<?php
include "connection.php";
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    echo json_encode(["labs" => []]);
    exit();
}

$department = isset($_GET["department"]) ? $_GET["department"] : "";
$labs = array();

if ($department !== "") {
    $department_escaped = mysqli_real_escape_string($conn, $department);

    // Pulls every lab name that has ever been used for this department,
    // across all four asset tables, so the dropdown always reflects
    // real data instead of a hardcoded list.
    $sql = "
        SELECT DISTINCT lab FROM desktop   WHERE department='$department_escaped' AND lab IS NOT NULL AND lab <> ''
        UNION
        SELECT DISTINCT lab FROM laptop    WHERE department='$department_escaped' AND lab IS NOT NULL AND lab <> ''
        UNION
        SELECT DISTINCT lab FROM printer   WHERE department='$department_escaped' AND lab IS NOT NULL AND lab <> ''
        UNION
        SELECT DISTINCT lab FROM projector WHERE department='$department_escaped' AND lab IS NOT NULL AND lab <> ''
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $labs[] = $row["lab"];
        }
    }

    natsort($labs);
    $labs = array_values($labs);
}

echo json_encode(array("labs" => $labs));
