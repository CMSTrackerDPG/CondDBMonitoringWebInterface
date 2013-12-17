<H1>SiStrip Conditions DB Monitoring</H1>


<?php
include 'findbestIOV.php';
include 'listsubdirs.php';
include 'drawIOV.php';
include 'drawTrend.php';

#parameters
$sitename="https://test-stripdbmonitor.web.cern.ch/test-stripdbmonitor/CondDBMonitoring";
$TAGDIR="DBTagCollection";

$database="";
$account="";
$globaltag="";
$condtype="";
$tags=array();
$wantediovs=array();
$wantedtrend=array();
if ($_POST['go']) {
  $runnumber = $_POST['runnumber'];
  $database = $_POST['database'];
  $account = $_POST['account'];
  $globaltag = $_POST['globaltag'];
  $condtype = $_POST['condtype'];
  $tags = $_POST['tags'];
  for($tagcount=0;$tagcount<count($tags);$tagcount++) {
    $postname="wantediovs${tagcount}";
    $wantediovs[$tagcount] = $_POST[$postname];
    $postname="wantedtrend${tagcount}";
    $wantedtrend[$tagcount] = $_POST[$postname];
  }
 }
?>

<form action="conddbmonitoring.php" method="post" enctype="multipart/form-data">



<?php

exec("cat LastJobDone",$ljdoutput);
echo "Last update: ".strtok($ljdoutput[0],"[]");
echo "<BR><BR>";

echo "Run Number (optional) <input type='text' value='$runnumber' name='runnumber'><br>";

echo "Database ";
listsubdirs("database",".","${database}");
echo "<BR>";

if ($database!="") {
  echo "Account ";
  listsubdirs("account","${database}","${account}");
  echo "<BR>";
 }

if ($account!="" && $condtype=="") {
  echo "GlobalTag ";
  listsubdirs("globaltag","${database}${account}GlobalTags","${globaltag}");
 }

if ($account!="" && $globaltag=="" && $condtype=="") {
  echo " OR ";
 }

if ($account!="" && $globaltag=="") {
  echo "Condition Types ";
  listsubdirs("condtype","${database}${account}${TAGDIR}","${condtype}");
 }

if ($account!="") {
  echo "<BR>";
 }

if ($globaltag!="" && $condtype=="") {
  
  echo "Tags ";
  echo "<select multiple name='tags[]' size=5>";
  exec ("ls -F $database/$account/GlobalTags/$globaltag" , $taglist);
  
  foreach($taglist as $tag) {
    if(strstr($tag,"NoiseRatio")) {
      continue;
    }
    if(in_array($tag,$tags)) {
      echo "<option value=$tag SELECTED>$tag</option>";
    }
    else {
      echo "<option value=$tag>$tag</option>";
    }
  }
  exec ("ls -F $database/$account/GlobalTags/$globaltag/NoiseRatio" , $NRtaglist);
  foreach($NRtaglist as $tag) {
    if(in_array("NoiseRatio/$tag",$tags)) {
      echo "<option value=NoiseRatio/$tag SELECTED>NoiseRatio/$tag</option>";
    }
    else {
      echo "<option value=NoiseRatio/$tag>NoiseRatio/$tag</option>";
    }
  }
  
  echo "</select>";
  echo "<BR>";
 }
if ($globaltag=="" && $condtype!="") {
  
  echo "Tags ";
  echo "<select multiple name='tags[]' size=5>";
  exec ("ls -F $database/$account/$TAGDIR/$condtype" , $taglist);
  
  foreach($taglist as $rawtag) {
    $tag=substr($rawtag,0,strlen($rawtag)-1);
    if(in_array($tag,$tags)) {
      echo "<option value=$tag SELECTED>$tag</option>";
    }
    else {
      echo "<option value=$tag>$tag</option>";
    }
  }
  echo "</select>";
  echo "<BR>";
 }
#echo  $runnumber ;
#echo  $database ;
#echo  $account ;
#echo  $globaltag ;
#echo "<BR>";

for($tagnum=0;$tagnum<count($tags);$tagnum++) {
  $dirname[$tagnum]="";
  $rcdname[$tagnum]="";
  if($globaltag!="" && $condtype=="") {
    $fh = fopen("${database}${account}/GlobalTags/${globaltag}/$tags[$tagnum]","rb");
    while(!feof($fh)) {
      $content = fgetss($fh);
#    echo "$content <br>";
      if($dirname[$tagnum]=="") list($dirname[$tagnum]) = sscanf($content,"${sitename}/${database}${account}${TAGDIR}/%s");
      if($rcdname[$tagnum]=="") list($rcdname[$tagnum]) = sscanf($content,"Record Name: %s");
    }
    fclose($fh);
  }
  if($globaltag=="" && $condtype!="") {
#    list($dirname[$tagnum]) = sscanf($condtype,"%s/");    
    $dirname[$tagnum] = "${condtype}$tags[$tagnum]";
  }
  
  findbestIOV($runnumber,$tagnum,$dirname,"${database}${account}${TAGDIR}",$wantediovs,$wantedtrend);

 }
?>
<p><input onClick="return true;" name="go" type="submit" value="Select"/> <input onClick="return true;" name="clear" type="submit" value="Clear"/></p>
</form>

<?php
for($tagcount=0;$tagcount<count($tags);$tagcount++) {

  echo "<H3> Tag $tags[$tagcount] Record Name: $rcdname[$tagcount]</H3>";

  echo "<a href='${sitename}/${database}${account}${TAGDIR}/$dirname[$tagcount]/Documentation/$tags[$tagcount]_documentation'>Documentation</a>";

  foreach($wantediovs[$tagcount] as $wantediov) {
    drawIOV("${sitename}/${database}${account}${TAGDIR}/",$dirname[$tagcount],"${wantediov}");
  }

  if($wantedtrend[$tagcount]=="yes") {
    drawTrend("${sitename}/${database}${account}${TAGDIR}/",$dirname[$tagcount]);
  }

}
?>
