<?php

header("Content-Type: application/json");

require_once "../connection.php";

/*
 * API key will be stored in Railway Environment Variables.
 */
$apiKey = getenv("AMS_API_KEY");

/*
 * Get Authorization header.
 */
$headers = getallheaders();

$authorization = $headers["Authorization"] ?? "";

if (!$apiKey || $authorization !== "Bearer " . $apiKey) {
    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);

    exit;
}

/*
 * Allowed asset types.
 */
$allowedTypes = [
    "desktop" => "desktop",
    "laptop" => "laptop",
    "printer" => "printer",
    "projector" => "projector"
];

$type = $_GET["type"] ?? null;

/*
 * If a specific type was requested.
 */
if ($type !== null) {

    if (!isset($allowedTypes[$type])) {
        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" => "Invalid asset type"
        ]);

        exit;
    }

    $table = $allowedTypes[$type];

    $query = "SELECT * FROM `$table`";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "Database query failed"
        ]);

        exit;
    }

    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode([
        "success" => true,
        "type" => $type,
        "count" => count($data),
        "data" => $data
    ]);

    exit;
}

/*
 * No type specified:
 * return all four asset categories.
 */

$data = [];

foreach ($allowedTypes as $typeName => $table) {

    $query = "SELECT * FROM `$table`";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        continue;
    }

    $data[$typeName] = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[$typeName][] = $row;
    }
}

echo json_encode([
    "success" => true,
    "data" => $data
]);