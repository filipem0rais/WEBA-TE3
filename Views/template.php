<?php
declare(strict_types=1);

http_response_code($code);
header("Content-Type: application/json");

echo json_encode($data);