
<H1>Create your own TrackerMap</H1>
Select a file with two columns: each row must contain a detid and a value. <br><br>

<?php
$inpfile=NULL;
$title="";
$size="2400";
$plotwidth="600";
  if(isset($_POST["withpixel"]) && ($_POST["withpixel"]=="Only")) $plotwidth="300";
$min="";
$max="";
$logscale="False";
$withpixel="False";
$cmsprel="False";
$release="CMSSW_5_3_14";
if(isset($_POST["go"])) {
  $inpfile=$_FILES['userfile']['name'];
  $title=$_POST["title"];
  $release=$_POST["release"];
  $size=$_POST["size"];
  $min=$_POST["min"];
  $max=$_POST["max"];
  if(isset($_POST["logscale"])) $logscale=$_POST["logscale"];
  if(isset($_POST["withpixel"])) $withpixel=$_POST["withpixel"];
  if(isset($_POST["cmsprel"])) $cmsprel=$_POST["cmsprel"];
 }
$debug=0;
if(isset($_GET["debug"])) $debug=$_GET["debug"];
?>

<form enctype="multipart/form-data" action="print_TrackerMap.php<?php if($debug!=0) {echo '?debug=1';} ?>" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
    <input type="hidden" name="outfile" value="/tmp/outmap_<?php echo time(); ?>.png" />
    Input file: <input name="userfile" value="<?php echo $inpfile; ?>" type="file" /><br>
    Map Title: <input name="title" value="<?php echo $title; ?>" type="text" />  CMS preliminary: <input name="cmsprel" value="True" type="checkbox" <?php if($cmsprel=="True") {echo "checked";} ?> /><br>
    Map Size: <input name="size" value="<?php echo $size; ?>" min="0" max="10000" type="number"/>
  Min Value: <input name="min" value="<?php echo $min; ?>" size="5" type="text"/>
  Max Value: <input name="max" value="<?php echo $max; ?>" size="5" type="text"/><br>
  LogScale: <input name="logscale" value="True" type="checkbox" <?php if($logscale=="True") {echo "checked";} ?> /><br>
  <input name="withpixel" value="Only" type="radio" <?php if($withpixel=="Only") {echo "checked";} ?> />Pixel, 
  <input name="withpixel" value="True" type="radio" <?php if($withpixel=="True") {echo "checked";} ?> />Pixel+Strip,
  <input name="withpixel" value="False" type="radio" <?php if($withpixel=="False") {echo "checked";} ?> />Strip
  <br>
  Release (please use dev from time to time and report anomalies): 
  <input name="release" value="CMSSW_5_3_14" type="radio" <?php if($release=="CMSSW_5_3_14") {echo "checked";} ?> />CMSSW_5_3_14 (prod),
  <input name="release" value="CMSSW_7_0_4" type="radio" <?php if($release=="CMSSW_7_0_4") {echo "checked";} ?> />CMSSW_7_0_4 (dev)
<br>
    <input type="submit" name="go" value="Send" />
</form>

<?php
	       //   include 'plot_from_tmp.php';
	       //   ini_set('display_errors', 'On');
	       //   error_reporting(E_ALL);
  if(isset($_POST["go"])) {
     $tmpfile=$_FILES['userfile']['tmp_name'];
     if($tmpfile!=NULL) {
       $outfile=$_POST["outfile"];
       $fulltitle="";
       if($cmsprel=="True") {
	 $fulltitle = "CMS preliminary      " . $title;
       } else {
	 $fulltitle = $title;
       }
       $command = "./print_TrackerMap.sh $release $tmpfile '$fulltitle' '$outfile' $size $logscale $withpixel $min $max";
//       echo $command,"<br>";
       if($debug!=0){
	 system($command);
       } else {
	 exec($command);
       }
       // write log
       $logFile = "log/print_TrackerMap.log";
       $fh=fopen($logFile,'a');
       $date = date('d/m/Y H:i:s', time());
       $logstring = $date." ".$_SERVER["REMOTE_ADDR"]." ".$inpfile." ".$command."\n";
       fwrite($fh,$logstring);
       fclose($fh);

       echo "<a href='plot_from_tmp.php?file=${outfile}'><img src='plot_from_tmp.php?file=${outfile}' width=${plotwidth}></a>";
     }
     else { echo "You have to provide an input file";}
  }
   
?>