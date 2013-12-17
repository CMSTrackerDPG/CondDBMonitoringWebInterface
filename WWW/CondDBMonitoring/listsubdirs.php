<?php
function listsubdirs($postname,$directory,$selected) {

#  echo "${postname} <br>";
#  echo "${directory} <br>";
#  echo "${selected} <br>";

  echo "<select name='${postname}' >";
  exec ("ls -F ${directory} | grep /", $list);
  
  echo "<option value=''> </option>";
  foreach($list as $element) {
    if($element == $selected) {
      echo "<option value=$element SELECTED>$element</option>";
    }
    else {
      echo "<option value=$element>$element</option>";
    }
  }
  echo "</select>";
}

?>