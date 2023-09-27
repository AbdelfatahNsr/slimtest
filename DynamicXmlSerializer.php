<?php
class DynamicXmlSerializer
{
    public static function serialize($data, $rootElement = 'root')
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><' . $rootElement . '></' . $rootElement . '>');

        self::arrayToXmlAttribute($data, $xml);

        return $xml->asXML();
    }

    private static function arrayToXmlAttribute($data, &$xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // If the value is an array, create a new element for each item
                if (is_numeric($key)) {
                    $key = 'item'; // Use a generic key for indexed arrays
                }
                $subNode = $xml->addChild($key);
                self::arrayToXml($value, $subNode);
            } else {
                // If the value is not an array, add it as a child element
                if (is_numeric($key)) {
                    $key = 'item'; // Use a generic key for indexed arrays
                }
                $xml->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

    private static function arrayToXml($data, &$xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // If the value is an array, create a new element for each item
                if (is_numeric($key)) {
                    $key = 'item'; // Use a generic key for indexed arrays
                }
                $subNode = $xml->addChild($key);
                self::arrayToXml($value, $subNode);
            } else {
                // If the value is not an array, add it as a child element
                $xml->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
}


  // // Example usage with attributes:
    // $data = [
    //     'person' => [
    //         '_attributes' => ['id' => 1],
    //         'name' => 'John Doe',
    //         'age' => 30,
    //         'address' => [
    //             'street' => '123 Main St',
    //             'city' => 'Exampleville',
    //         ],
    //     ],
    // ];

    // $xmlString = DynamicXmlSerializer::serialize($data, 'data');
    // echo $xmlString;