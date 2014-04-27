<H1>SiStrip Modules Pedestal and Noise Monitoring</H1>


<?php
#parameters<
$debug=0;
if(isset($_GET['debug'])) $debug=$_GET['debug'];
$connstring="frontier://PromptProd/CMS_COND_31X_STRIP";
$runnumber=0;
$globaltag="DONOTEXIST";
$tag="";
$record="";
$condtype=0;
$wantednorm="False";
$modulelist="";
$modulefile="";
$time=0;
if ($_POST['go']) {
  $time=time();
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
#echo $command;
  exec($command);
  $command = "./singleModule.sh $runnumber $modulefile $condtype '$globaltag::All' '$connstring' '$tag' '$record' $wantednorm '_$time'";
  if($debug==1) { echo $command; echo "<br>";  system($command); echo "<BR>"; }
  else {    exec($command);  }
#system("ls -ltr /tmp");
}

?>

<form action="singlemodules.php<?php if($debug!=0) {echo '?debug=1';} ?>" method="post" enctype="multipart/form-data">
<?php
echo "Run Number <input type='text' value='$runnumber' name='runnumber'><br>";
echo "Global Tag <input type='text' value='$globaltag' name='globaltag'> (leave \"DONOTEXIST\" if no GT is provided) or ";
echo "Tag <input type='text' size=40 value='$tag' name='tag'> (much faster if a tag is provided)<br>";
echo "<input type='checkbox' value='1' name='noise'"; if(isset($_POST['noise'])) {echo "checked";};  echo "> Noise";  
echo "<input type='checkbox' value='2' name='pedestal'"; if(isset($_POST['pedestal'])) {echo "checked";} 
echo "> Pedestal (they can be both selected only if Global Tag is provided)<br>"; 
echo "<input type='checkbox' value='True' name='wantednorm'"; if(isset($_POST['wantednorm'])) {echo "checked";};  
echo "> with gain normalization (only for noise, only when Global Tag is provided)<br>";  
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