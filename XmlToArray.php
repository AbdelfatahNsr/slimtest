<?php

function xmlToJson($xml) {
    $json = json_encode($xml, JSON_PRETTY_PRINT);
    return $json;
}

$xmlString = '<Patient xmlns="http://hl7.org/fhir">
  <text>
    <status value="generated" />
    <div xmlns="http://www.w3.org/1999/xhtml"><p>...</p></div>
  </text>
  <name id="f2">
    <use value="official" />
    <given value="Karen" />
    <family id="a2" value="Van" />
  </name>
</Patient>';

$xml = simplexml_load_string($xmlString);
$json = xmlToJson($xml);

echo $json;
