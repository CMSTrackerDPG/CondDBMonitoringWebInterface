<H1>SiStrip Modules Pedestal and Noise Monitoring</H1>
You can find a description of the software used for this web tool in the following pages:<br>
<a href="https://twiki.cern.ch/twiki/bin/viewauth/CMS/StripTrackerMonitoringCondDb">Twiki page of the web interface software</a><br>
<a href="https://twiki.cern.ch/twiki/bin/viewauth/CMS/StripTrackerMonitoringCondsDb">Twiki page of DB monitoring software</a><br>
<br>
If you are interested in the SiStrip conditions DB content follow 
<a href="conddbmonitoring.php">this link</a>
<br><br>
<font color="red">The web site runs on a SLC6 machine. In case of issues try with an older CMSSW release using the checkbox below 
and report the problem</font><br>

<?php
#parameters<
$debug=0;
if(isset($_GET['debug'])) $debug=$_GET['debug'];
$connstring="frontier://PromptProd/CMS_COND_31X_STRIP";
$runnumber=1;
$globaltag="DONOTEXIST";
$tag="";
$record="";
$condtype=0;
$wantednorm="False";
$wantedsimnorm="False";
$modulelist="";
$modulefile="";
$time=0;
$release="CMSSW_9_0_0";
if ($_POST['go']) {
  $time=time();
  $release=$_POST["release"];
  if(strstr($release,"CMSSW_7_5_0_pre4")) $connstring="frontier://PromptProd/CMS_CONDITIONS";
  if(strstr($release,"CMSSW_9_0_0")) $connstring="frontier://PromptProd/CMS_CONDITIONS";
  $runnumber = $_POST['runnumber'];
  $globaltag = $_POST['globaltag'];
  $tag = $_POST['tag'];
  if(isset($_POST['tag'])) {
    if(strstr($tag,"SiStripNoise"))  $record="SiStripNoisesRcd"; 
    if(strstr($tag,"SiStripPedestal"))  $record="SiStripPedestalsRcd"; 
  }
  if(isset($_POST['noise'])) $condtype = $condtype + $_POST['noise'];
  if(isset($_POST['pedestal'])) $condtype = $condtype + $_POST['pedestal'];
  if(isset($_POST['wantednorm'])) $wantednorm = $_POST['wantednorm'];
  if(isset($_POST['wantedsimnorm'])) $wantedsimnorm = $_POST['wantedsimnorm'];
  $modulelist=$_POST['modulelist'];
  $modulefile="/tmp/modulelist_".$time.".txt";
#  $command="echo '".$modulelist."' > ".$modulefile;
#  echo $command;
#  exec($command);
  $command="touch ".$modulefile;
  exec($command);
  $tok=strtok($modulelist," \n\t");
  while($tok!==false) {
    $command="echo ".$tok." >> ".$modulefile;
    exec($command);
    $tok=strtok(" \n\t");
  }
#echo $runnumber ;
#echo $globaltag ;
#echo $tag ;
#echo $record ;
#echo $condtype ;
#echo $wantednorm; echo "<br>";
#echo $modulelist ;echo "<br>";
#echo $modulefile; echo "<br>";
  $command="cat ".$modulefile;
  exec($command);
  $globaltagstring=$globaltag."::All";

  if(strstr($release,"CMSSW_10_0_4"))       $globaltagstring=$globaltag;
  if(strstr($release,"CMSSW_9_0_0"))        $globaltagstring=$globaltag;
  if(strstr($release,"CMSSW_8_0_10"))       $globaltagstring=$globaltag;
  if(strstr($release,"CMSSW_7_5_0_pre4"))   $globaltagstring=$globaltag;

  // echo $globaltagstring."<br><br>";
  
  $command = "./singleModule.sh $release $runnumber $modulefile $condtype '$globaltagstring' '$connstring' '$tag' '$record' $wantednorm $wantedsimnorm '_$time'";

  if($debug==1) { echo $command; echo "<br>";  system($command); echo "<BR>"; }
  else {    exec($command);  }
#system("ls -ltr /tmp");
}

?>

<form action="singlemodules.php<?php if($debug!=0) {echo '?debug=1';} ?>" method="post" enctype="multipart/form-data">
  Release: 
  <input name="release" value="CMSSW_10_0_4" type="radio" <?php if($release=="CMSSW_10_0_4") {echo "checked";} ?> />CMSSW_10_0_4

  <input name="release" value="CMSSW_9_0_0" type="radio" <?php if($release=="CMSSW_9_0_0") {echo "checked";} ?> />CMSSW_9_0_0 (PLEASE USE THIS FOR 2017 RUNS) 

  <input name="release" value="CMSSW_8_0_10" type="radio" <?php if($release=="CMSSW_8_0_10") {echo "checked";} ?> />CMSSW_8_0_10 (SLC6: conddb V2)

  <input name="release" value="CMSSW_7_5_0_pre4" type="radio" <?php if($release=="CMSSW_7_5_0_pre4") {echo "checked";} ?> />CMSSW_7_5_0_pre4 (SLC6: conddb V2)
  
<br>
<?php
echo "Run Number <input type='text' value='$runnumber' name='runnumber'><br>";
echo "Global Tag <input type='text' value='$globaltag' name='globaltag'> (leave \"DONOTEXIST\" if no GT is provided) or ";
echo "Tag <input type='text' size=40 value='$tag' name='tag'> (much faster if a tag is provided)<br>";
echo "<font color='blue'>A Global Tag compatible with the selected CMSSW release has to be chosen. Be careful that old GlobalTags are not known by 
the release which uses conddb v2. Choose the correct combination of release and GlobalTag</font><br>";
echo "<input type='checkbox' value='1' name='noise'"; if(isset($_POST['noise'])) {echo "checked";};  echo "> Noise";  
echo "<input type='checkbox' value='2' name='pedestal'"; if(isset($_POST['pedestal'])) {echo "checked";} 
echo "> Pedestal (they can be both selected only if Global Tag is provided)<br>"; 
echo "<input type='checkbox' value='True' name='wantednorm'"; if(isset($_POST['wantednorm'])) {echo "checked";};  
echo "> with gain normalization using the SiStripApvGainRcd also known as <em>G1</em> (only for noise, only when Global Tag is provided)<br>";  
echo "<input type='checkbox' value='True' name='wantedsimnorm'"; if(isset($_POST['wantedsimnorm'])) {echo "checked";};  
echo "> with SIM gain normalization using the SiStripApvGainSimRcd also known as <em>Gsim</em> 
(only for noise, only when <strong>MC</strong> Global Tag is provided)<br>";  
echo "Module list <br><textarea name='modulelist' value='$modulelist' rows='10' cols='16'>"; echo $modulelist; echo "</textarea><br>";

?>
<p><input onClick="return true;" name="go" type="submit" value="Select"/></p>
</form>

<?php
if ($_POST['go']) {
  exec ('ls /tmp/*'.$time.".png",$outfiles);
  foreach($outfiles as $plot) {
    echo "<a href='../PrintTrackerMap/plot_from_tmp.php?file=${plot}'><img src='../PrintTrackerMap/plot_from_tmp.php?file=${plot}' width=400></a><br>";
  }
  exec ('ls /tmp/*'.$time.".root",$rootfiles);
  foreach($rootfiles as $rootfile) {
    echo "<a href='root_from_tmp.php?file=${rootfile}'>Root File</a><br>";
  }
}
?>