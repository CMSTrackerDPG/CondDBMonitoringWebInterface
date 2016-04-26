<?php

function readcsv($filename, $header=true) {
$handle = fopen($filename, "r");
echo '<table border="1">';
//display header row if true
if ($header) {
    $csvcontents = fgetcsv($handle);
    echo '<tr>';
    foreach ($csvcontents as $headercolumn) {
        echo "<th align=\"center\">$headercolumn</th>";
    }
    echo '</tr>';
}
// displaying contents
while ($csvcontents = fgetcsv($handle)) {
    echo '<tr>';
    foreach ($csvcontents as $column) {
        echo "<td align=\"right\">$column</td>";
    }
    echo '</tr>';
}
echo '</table>';
fclose($handle);
}

?>
