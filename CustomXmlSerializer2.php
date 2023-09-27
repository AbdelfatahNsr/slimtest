<?php
class CustomXmlSerializer
{
    public static function serialize($data, $namespace = 'http://hl7.org/fhir')
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Patient xmlns="' . $namespace . '"></Patient>');

        self::arrayToXml($data, $xml);

        return $xml->asXML();
    }

    private static function arrayToXml($data, &$xml)
    {
        foreach ($data as $key => $value) {
            $element = $xml->addChild($key);

            // Check if the element has attributes
            if (isset($value['_attributes'])) {
                foreach ($value['_attributes'] as $attrName => $attrValue) {
                    $element->addAttribute($attrName, htmlspecialchars($attrValue));
                }
                unset($value['_attributes']);
            }

            if (is_array($value)) {
                self::arrayToXml($value, $element);
            } else {
                $element[0] = htmlspecialchars($value);
            }

            if (is_numeric($key)) {
                $child = dom_import_simplexml($element);
                $child->parentNode->removeChild($child);
            }
        }
    }
}

// Example data in the format you provided
$data = [
    'text' => [
        'status' => [
            '_attributes' => ['value' => 'generated'],
        ],
        'div' => [
            '_attributes' => ['xmlns' => 'http://www.w3.org/1999/xhtml'],
            'p' => '...',
        ],
    ],
    'name' => [
        '_attributes' => ['id' => 'f2'],
        'use' => [
            'value' => 'official',
        ],
        'given' => [
            'value' => 'Karen',
        ],
        'family' => [
            '_attributes' => ['id' => 'a2', 'value' => 'Van'],
        ],
    ],
];

$xmlString = CustomXmlSerializer::serialize($data);
echo $xmlString;
