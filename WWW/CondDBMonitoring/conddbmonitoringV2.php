<H1>SiStrip Conditions DB Monitoring</H1>
You can find a description of the software used for this web tool in the following pages:<br>
<a href="https://twiki.cern.ch/twiki/bin/viewauth/CMS/StripTrackerMonitoringCondDb">Twiki page of the web interface software</a><br>
<a href="https://twiki.cern.ch/twiki/bin/viewauth/CMS/StripTrackerMonitoringCondsDb">Twiki page of DB monitoring software</a><br>
<br>
If you are interested in the noise and pedestal values of individual modules follow
<a href="singlemodules.php">this link</a>
<br><br>

<?php
include 'findbestIOV.php';
include 'listsubdirs.php';
include 'drawIOV.php';
include 'drawTrend.php';

#parameters
$sitename="https://test-stripdbmonitor.web.cern.ch/test-stripdbmonitor/CondDBMonitoringV2";
$storagename="/afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoringV2";
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

<form action="conddbmonitoringV2.php" method="post" enctype="multipart/form-data">



<?php

exec("cat LastJobDone",$ljdoutput);
echo "Last update: ".strtok($ljdoutput[0],"[]");
echo "<BR><BR>";

echo "Run Number (optional) <input type='text' value='$runnumber' name='runnumber'><br>";

echo "Database ";
listsubdirs("database","${storagename}","${database}");
echo "<BR>";

if ($database!="") {
  echo "Account ";
  listsubdirs("account","${storagename}/${database}","${account}");
  echo "<BR>";
 }

if ($account=="GlobalTags/") {
  echo "GlobalTag ";
  listsubdirs("globaltag","${storagename}/${database}GlobalTags","${globaltag}");
 }
elseif ($account!="") {
  echo "Condition Types ";
  listsubdirs("condtype","${storagename}/${database}${account}${TAGDIR}","${condtype}");
 }

if ($account!="") {
  echo "<BR>";
 }

if ($globaltag!="" && $condtype=="") {
  
  echo "Tags ";
  echo "<select multiple name='tags[]' size=5>";
  exec ("ls -F ${storagename}/$database/GlobalTags/$globaltag" , $taglist);
  
  foreach($taglist as $tag) {
    if(strstr($tag,"NoiseRatios")) {
      continue;
    }
    if(strstr($tag,"RunInfo")) {
      continue;
    }
    if(in_array($tag,$tags)) {
      echo "<option value=$tag SELECTED>$tag</option>";
    }
    else {
      echo "<option value=$tag>$tag</option>";
    }
  }
  exec ("ls -F ${storagename}/$database/GlobalTags/$globaltag/NoiseRatios" , $NRtaglist);
  foreach($NRtaglist as $tag) {
    if(in_array("NoiseRatios/$tag",$tags)) {
      echo "<option value=NoiseRatios/$tag SELECTED>NoiseRatios/$tag</option>";
    }
    else {
      echo "<option value=NoiseRatios/$tag>NoiseRatios/$tag</option>";
    }
  }
  exec ("ls -F ${storagename}/$database/GlobalTags/$globaltag/RunInfo" , $RItaglist);
  foreach($RItaglist as $tag) {
    if(in_array("RunInfo/$tag",$tags)) {
      echo "<option value=RunInfo/$tag SELECTED>RunInfo/$tag</option>";
    }
    else {
      echo "<option value=RunInfo/$tag>RunInfo/$tag</option>";
    }
  }
  
  echo "</select>";
  echo "<BR>";
 }
if ($globaltag=="" && $condtype!="") {
  
  echo "Tags ";
  echo "<select multiple name='tags[]' size=5>";
  exec ("ls -F ${storagename}/$database/$account/$TAGDIR/$condtype" , $taglist);
  
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
  $accname[$tagnum]="";
  if($globaltag!="" && $condtype=="") {
    $fh = fopen("${storagename}/${database}/GlobalTags/${globaltag}/$tags[$tagnum]","rb");
    while(!feof($fh)) {
      $content = fgetss($fh);
#    echo "$content <br>";
      if($dirname[$tagnum]=="") {
	list($tmp) =  sscanf($content,"${sitename}/${database}%s");
	$accname[$tagnum] = strtok($tmp,"/")."/";
	list($dirname[$tagnum]) = sscanf($content,"${sitename}/${database}$accname[$tagnum]${TAGDIR}/%s");
      }
      if($rcdname[$tagnum]=="") list($rcdname[$tagnum]) = sscanf($content,"Record name: %s");
      if($rcdname[$tagnum]=="") list($rcdname[$tagnum]) = sscanf($content,"Record Name: %s");
    }
    fclose($fh);
  }
  if($globaltag=="" && $condtype!="") {
#    list($dirname[$tagnum]) = sscanf($condtype,"%s/");    
    $dirname[$tagnum] = "${condtype}$tags[$tagnum]";
    $accname[$tagnum] = "${account}";
  }
  

  findbestIOV($runnumber,$tagnum,$dirname,"${storagename}/${database}$accname[$tagnum]${TAGDIR}",$wantediovs,$wantedtrend);

 }
?>
<p><input onClick="return true;" name="go" type="submit" value="Select"/> <input onClick="return true;" name="clear" type="submit" value="Clear"/></p>
</form>

<?php
for($tagcount=0;$tagcount<count($tags);$tagcount++) {

  echo "<H3> Account $accname[$tagcount] Tag $tags[$tagcount] Record Name: $rcdname[$tagcount]</H3>";

  echo "<a href='${sitename}/${database}$accname[$tagcount]${TAGDIR}/$dirname[$tagcount]/Documentation/$tags[$tagcount]_documentation'>Documentation</a>";

  foreach($wantediovs[$tagcount] as $wantediov) {
    drawIOV("${sitename}/${database}$accname[$tagcount]${TAGDIR}/",$dirname[$tagcount],"${wantediov}");
  }

  if($wantedtrend[$tagcount]=="yes") {
    drawTrend("${sitename}/${database}$accname[$tagcount]${TAGDIR}/",$dirname[$tagcount]);
  }

}
?>
