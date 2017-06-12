<!DOCTYPE html>
<html>
<head>
<title>SiStrip DCS Monitoring</title>
</head>

<body>
<H1>SiStrip Voltage States Monitoring</H1>
This page shows the HV/LV status of the tracker in the last 72 hours. The percentage of modules <font color="#FF0000">OFF</font> is shown here.<br>
For HV/LV status older than 72 hours, please use the <a href="https://cms-conddb.cern.ch/cmsDbBrowser/payload_inspector/Prod">Payload Inspector</a> tool.<br>

<br>
<?php
$filename = 'last72hr/HVOff_last.png';
if (file_exists($filename)) {
    echo "Last update: " . date ("D d M Y H:i:s T.", filemtime($filename));
}
?>
<br>

<H2>Tracker HV</H2>
<a href="last72hr/HVOff_last.png" target="_blank">
  <img src="last72hr/HVOff_last.png" alt="HV_Off" style="width:600px;height:400px;">
</a>
<br>
<a href="hvtable.php">HV Table</a>

<H2>Tracker LV</H2>
<a href="last72hr/LVOff_last.png" target="_blank">
  <img src="last72hr/LVOff_last.png" alt="LV_Off" style="width:600px;height:400px;">
</a>
<br>
<a href="lvtable.php">LV Table</a>
</body>
</html>
