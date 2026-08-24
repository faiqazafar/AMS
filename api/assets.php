<?php

header("Content-Type: application/json");

// Connect to the Railway MySQL database
require_once "../connection.php";

/*
|--------------------------------------------------------------------------
| API Authentication
|--------------------------------------------------------------------------
*/

$apiKey = getenv("AMS_API_KEY");

// Get Authorization header
$authorization = $_SERVER["HTTP_AUTHORIZATION"] ?? "";

// Check that the API key exists on the server
if (!$apiKey) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "API key is not configured on the server"
    ]);

    exit;
}

// Check Authorization header
$expectedAuthorization = "Bearer " . $apiKey;

if (!hash_equals($expectedAuthorization, $authorization)) {
    http_response_code(401);

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized"
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Allowed Asset Types
|--------------------------------------------------------------------------
*/

$allowedTypes = [
    "desktop"  => "desktop",
    "laptop"   => "laptop",
    "printer"  => "printer",
    "projector" => "projector"
];

/*
|--------------------------------------------------------------------------
| Get Requested Asset Type
|--------------------------------------------------------------------------
*/

$type = $_GET["type"] ?? null;

/*
|--------------------------------------------------------------------------
| Return One Asset Type
|--------------------------------------------------------------------------
*/

if ($type !== null) {

    // Check if requested type is allowed
    if (!isset($allowedTypes[$type])) {

        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" => "Invalid asset type",
            "allowed_types" => [
                "desktop",
                "laptop",
                "printer",
                "projector"
            ]
        ]);

        exit;
    }

    // Get the corresponding table
    $table = $allowedTypes[$type];

    /*
     * Table names come only from the whitelist above,
     * so they cannot be supplied directly by the user.
     */
    $query = "SELECT * FROM `$table`";

    $result = mysqli_query($conn, $query);

    // Check database query
    if (!$result) {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "Database query failed",
            "error" => mysqli_error($conn)
        ]);

        exit;
    }

    // Store records
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    /*
     * Return JSON response
     */
    echo json_encode([
        "success" => true,
        "type" => $type,
        "count" => count($data),
        "data" => $data
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| No Type Specified
| Return Desktop + Laptop + Printer + Projector
|--------------------------------------------------------------------------
*/

$data = [];

foreach ($allowedTypes as $typeName => $table) {

    $query = "SELECT * FROM `$table`";

    $result = mysqli_query($conn, $query);

    if (!$result) {

        $data[$typeName] = [];

        continue;
    }

    $data[$typeName] = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[$typeName][] = $row;
    }
}

/*
|--------------------------------------------------------------------------
| Return All Assets
|--------------------------------------------------------------------------
*/

echo json_encode([
    "success" => true,
    "data" => $data
]);