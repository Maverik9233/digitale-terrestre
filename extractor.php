<?php
// Disattiva limiti e avvisi
error_reporting(0);
header('Content-Type: application/json');

// Scarica la homepage
$html = @file_get_contents("https://www.vrsicilia.it/");
if(!$html) {
  echo json_encode(["error" => "Impossibile contattare il sito"]);
  exit;
}

// Trova l’URL .m3u8 con una regex
if(preg_match('/https[^\'"]+\.m3u8[^\'"]*/', $html, $match)) {
  echo json_encode(["url" => $match[0]]);
} else {
  echo json_encode(["error" => "Nessun link trovato"]);
}
?>
