<H1>First</H1>

<form action="first_test.php" method="post" enctype="multipart/form-data">
<select name=selectedfile>
<?php
exec ("ls /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripFedCabling/SiStripFedCabling_GR10_v1_hlt/CablingLog/CablingInfo_Run*.txt",$filelist);

foreach ( $filelist as $file) {
  echo "<option value=$file>$file</option>";
}
?>
</select>
<input name="detid" type="text" /><br> 
<input name="Go" type="submit" value="Select"/>
</form>
<?php
if($_POST["selectedfile"]!="") {
  $selectedfile= $_POST['selectedfile'];
  $selecteddetid= $_POST['detid'];
  exec ("grep $selecteddetid $selectedfile",$output);
  foreach( $output as $line) {
    echo $line;
  }
   }

?>