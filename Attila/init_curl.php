<?php

$headers = [
    "User-Agent: Example REST API Client",
    "Authorization: token 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"
];

$ch=curl_init();
curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => true
]);

return $ch;