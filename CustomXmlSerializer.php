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
    'id' => [
        '_attributes' => ['value' => 'example'],
    ],
    'meta' => [
        'versionId' => [
            '_attributes' => ['value' => '1'],
        ],
        'lastUpdated' => [
            '_attributes' => ['value' => '2021-09-27T14:45:00Z'],
        ],
    ],
    'text' => [
        'status' => [
            '_attributes' => ['value' => 'generated'],
        ],
        'div' => [
            '_attributes' => ['xmlns' => 'http://www.w3.org/1999/xhtml'],
            'div' => [
                'h1' => 'Patient John Doe',
                'p' => 'Male, born on 1980-01-15',
            ],
        ],
    ],
    'identifier' => [
        'use' => [
            '_attributes' => ['value' => 'official'],
        ],
        'system' => [
            '_attributes' => ['value' => 'urn:oid:2.16.840.1.113883.19.5'],
        ],
        'value' => [
            '_attributes' => ['value' => '12345'],
        ],
    ],
    'active' => [
        '_attributes' => ['value' => 'true'],
    ],
    'name' => [
        'use' => [
            '_attributes' => ['value' => 'official'],
        ],
        'family' => [
            '_attributes' => ['value' => 'Doe'],
        ],
        'given' => [
            '_attributes' => ['value' => 'John'],
        ],
    ],
    'gender' => [
        '_attributes' => ['value' => 'male'],
    ],
    'birthDate' => [
        '_attributes' => ['value' => '1980-01-15'],
    ],
];

$xmlString = CustomXmlSerializer::serialize($data);
echo $xmlString;
