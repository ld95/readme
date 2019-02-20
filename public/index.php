<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1",shrink-to-fit=no">
    <link rel="stylesheet" href="http://maxdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>MacBook Pro</title>
</head>
<body>
<h1>More power.More performance.More pro</h1>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: yansong
 * Date: 2/18/19
 * Time: 11:49 PM
 */



main::start("example.csv");
class main  {
    static public function start($filename) {
        $records = csv::getRecords($filename);
        $table = html::generateTable($records);
    }
}
class html {
    public static function generateTable($records) {

        $html = '<table>';
        $count = 0;
        foreach ($records as $record) {
            if($count == 0) {
                $array = $record->returnArray();
                //$fields = array_keys($array);
                //$values = array_values($array);
                $html .= '<tr>';
                foreach($array as $key =>$value)
                {
                    $html .='<th>'.htmlspecialchars($key) . '</th>';
                }
                $html .='</tr>';

                $html .='<tr>';
                foreach($array as $key =>$value)
                {
                    $html .='<th>'.htmlspecialchars($value) . '</th>';
                }
                $html .='</tr>';

                //print_r($fields);
                //print_r($values);
            } else {
                $array = $record->returnArray();
                //$values = array_values($array);
                $html .='<tr>';
                foreach($array as $key =>$value)
                {
                    $html .='<th>'.htmlspecialchars($value) . '</th>';
                }
                $html .='</tr>';
                //print_r($values);
            }
            $count++;
        }
        $html .='</table>';
        echo $html;
    }
}
class csv {
    static public function getRecords($filename) {
        $file = fopen($filename,"r");
        $fieldNames = array();
        $count = 0;
        while(! feof($file))
        {
            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }
        fclose($file);
        return $records;
    }
}
class record {
    public function __construct(Array $fieldNames = null, $values = null )
    {
        $record = array_combine($fieldNames, $values);
        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }
    }
    public function returnArray() {
        $array = (array) $this;
        return $array;
    }
    public function createProperty($name = 'first', $value = 'keith') {
        $this->{$name} = $value;
    }
}
class recordFactory {
    public static function create(Array $fieldNames = null, Array $values = null) {
        $record = new record($fieldNames, $values);
        return $record;
    }
}
