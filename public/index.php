<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1",shrink-to-fit=no">
    <link rel="stylesheet" href="http://maxdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>MacBook Pro</title>
</head>
<body>
<h1>More power.More performance.More pro</h1>

<?php
/**
 * Created by PhpStorm.
 * User: peiran
 * Date: 10/6/18
 * Time: 9:56 PM
 */



main::start("example.csv");

class main  {
    static public function start($filename) {
        $records = csv::getRecords($filename);
        $table = html::generateTable($records);
        echo $table;
        //echo 'test';
    }
}
class html
{
    public static function generateTable($records)
    {
        // start table
        $html = '<table class="table">';

        $count = 0;
        foreach ($records as $record) {
            $array = html::makearray($record);
            if ($count == 0) {
                $html = html::tablehead($array,$html);
                $html = html::tablerows($array,$html);

            } else {
                $html = html::tablerows($array,$html);
            }
            $count++;
        }
        $html = html::endtable($html);
        return $html;
    }

    static public function makearray($record)
    {
        $ma = $record->returnArray();
        return $ma;
    }

    static public function sethead($sh)
    {
        $sh .= '<thead class="thead-light">';
        return $sh;
    }
    static public function makerow($mk)
    {
        $mk .= '<tr>';
        return $mk;
    }
    static public function endrow($er)
    {
        $er .= '</tr>';
        return $er;
    }
    static public function headline($hd, $key)
    {
        $hd .= '<th>' . htmlspecialchars($key) . '</th>';
        return $hd;
    }
    static public function tableline($td, $value)
    {
        $td .= '<td>' . htmlspecialchars($value) . '</td>';
        return $td;
    }
    static public function tablehead($ar,$hl)
    {
        $html = html::sethead($hl);
        $html = html::makerow($html);
        foreach ($ar as $key => $value) {
            $html = html::headline($html, $key);
            //$html .= '<th>' . htmlspecialchars($key) . '</th>';
        }
        $html = html::endrow($html);
        $html = html::endhead($html);
        return $html;
    }
    static public function tablerows($ar,$hl)
    {
        $hl = html::tablebody($hl);
        $hl = html::makerow($hl);
        foreach ($ar as $key => $value) {
            $hl = html::tableline($hl, $value);
            //$html .= '<td>' . htmlspecialchars($value) . '</td>';
        }
        $hl = html::endrow($hl);
        $hl = html::endbody($hl);;
        return $hl;
    }
    static public function tablebody($tb)
    {
        $tb .= '<tbody>';
        return $tb;
    }
    static public function endbody($eb)
    {
        $eb .= '</tbody>';
        return $eb;
    }
    static public function endhead($eh)
    {
        $eh .= '</thead>';
        return $eh;
    }
    static public function endtable($et)
    {
        $et .= '</table>';
        return $et;
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

?>

</body>
</html>
