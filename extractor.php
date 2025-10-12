<?php
error_reporting(0);
header('Content-Type: application/json');

// Lista dei siti da cui estrarre lo streaming
$sites = [
  "vrsicilia" => "https://www.vrsicilia.it/",
  "canale2"   => "",
  "canale3"   => ""
];

// Legge quale canale richiedere (es: ?site=vrsicilia)
$siteKey = $_GET['site'] ?? "vrsicilia";

if (!isset($sites[$siteKey])) {
  echo json_encode(["error" => "Sito non trovato"]);
  exit;
}

// Scarica la pagina del sito
$html = @file_get_contents($sites[$siteKey]);
if (!$html) {
  echo json_encode(["error" => "Impossibile contattare il sito"]);
  exit;
}

// Cerca il link .m3u8
if (preg_match('/https[^\'"]+\.m3u8[^\'"]*/', $html, $match)) {
  echo json_encode([
    "site" => $siteKey,
    "url"  => $match[0]
  ]);
} else {
  echo json_encode(["error" => "Nessun link trovato per $siteKey"]);
}
?>
