<?php
function drawIOV($rootpath,$dirname,$wantediov) {

  echo "<H4>IOV ${wantediov} </H4>";

  if(strstr($dirname,"SiStripNoise/NoiseRatio")==$dirname) drawNoiseRatioIOV("${rootpath}${dirname}",$wantediov);
  else if(strstr($dirname,"SiStripFedCabling")==$dirname) drawCablingIOV("${rootpath}${dirname}",$wantediov);
  else if(strstr($dirname,"SiStripBadChannel")==$dirname) drawBadChannelIOV("${rootpath}${dirname}",$wantediov);
  else if(strstr($dirname,"SiStripNoise")==$dirname) drawNoiseIOV("${rootpath}${dirname}",$wantediov);
  else if(strstr($dirname,"SiStripPedestal")==$dirname) drawPedestalIOV("${rootpath}${dirname}",$wantediov);
  else if(strstr($dirname,"SiStripApvGain")==$dirname) drawApvGainIOV("${rootpath}${dirname}",$wantediov);
  else if(strstr($dirname,"SiStripLorentzAngle")==$dirname) drawLorentzAngleIOV("${rootpath}${dirname}",$wantediov);
  else if(strstr($dirname,"SiStripLatency")==$dirname) drawLatencyIOV("${rootpath}${dirname}",$wantediov);
  else if(strstr($dirname,"SiStripThreshold")==$dirname) drawThresholdIOV("${rootpath}${dirname}",$wantediov);
  else if(strstr($dirname,"SiStripShiftAndCrosstalk")==$dirname) drawShiftAndCrosstalkIOV("${rootpath}${dirname}",$wantediov);
  else if(strstr($dirname,"SiStripAPVPhaseOffsets")==$dirname) drawAPVPhaseOffsetsIOV("${rootpath}${dirname}",$wantediov);

}

function drawNoiseRatioIOV($directory,$wantediov) {

  $tkmapfile="${directory}/plots/Run_${wantediov}_TkMap.png";
  echo "<a href='${tkmapfile}'><img src='${tkmapfile}' hspace=5 vspace=5 border=0 height=250 width=500 ALT='${tkmapfile}'></a> "; 
  $ratiofile="${directory}/plots/Run_${wantediov}.png";
  echo "<a href='${ratiofile}'><img src='${ratiofile}' hspace=5 vspace=5 border=0 height=250 width=390 ALT='${ratiofile}'></a> <br>"; 

}

function drawCablingIOV($directory,$wantediov) {

  $tkmapfile="${directory}/plots/TrackerMap/CablingTkMap_Run_${wantediov}.png";
  echo "<a href='${tkmapfile}'><img src='${tkmapfile}' hspace=5 vspace=5 border=0 height=250 width=500 ALT='${tkmapfile}'></a> <br> 
    <a href='$directory/CablingLog/QualityInfoFromCabling_Run${wantediov}.txt'> QualityInfoFromCabling</a>
    <a href='$directory/CablingLog/CablingInfo_Run${wantediov}.txt'> Cabling Info</a>
    <a href='$directory/plots/Summary/SummaryOfCabling__Run${wantediov}.png'> Summary Of Cabling </a><br>";
}

function drawBadChannelIOV($directory,$wantediov) {

  $tkmapfile="${directory}/plots/TrackerMap/QualityTkMap_Run_${wantediov}.png";
  echo "<a href='${tkmapfile}'><img src='${tkmapfile}' hspace=5 vspace=5 border=0 height=250 width=500 ALT='${tkmapfile}'></a> <br> 
    <a href='$directory/QualityLog/QualityInfo_Run${wantediov}.txt'> QualityInfo</a>
    <a href='$directory/plots/Summary/BadModules/BadModules_FromCondDB__Run${wantediov}.png'> BadModules</a>
    <a href='$directory/plots/Summary/BadFibers/BadFibers_FromCondDB__Run${wantediov}.png'> BadFibers</a>
    <a href='$directory/plots/Summary/BadAPVs/BadApvs_FromCondDB__Run${wantediov}.png'> BadAPVs</a>
    <a href='$directory/plots/Summary/BadStrips/BadStrips_FromCondDB__Run${wantediov}.png'> BadStrips</a><br>"; 
  echo "TIB ";
  for($i = 1; $i <= 4; $i++) echo "<a href='$directory/plots/TIB/Layer${i}/Profile/layer__${i}__Run${wantediov}.png'> Layer${i} </a>";
  echo "<br>";
  echo "TOB ";
  for($i = 1; $i <= 6; $i++) echo "<a href='$directory/plots/TOB/Layer${i}/Profile/layer__${i}__Run${wantediov}.png'> Layer${i} </a>";
  echo "<br>";
  echo "TID ";
  for($side = 1; $side <=2; $side++) {
    echo "Side ${side} ";
    for($i = 1; $i <= 3; $i++) echo "<a href='$directory/plots/TID/Side${side}/Disk${i}/Profile/side__${side}__wheel__${i}__Run${wantediov}.png'> Disk${i} </a>";
  }
  echo "<br>";
  echo "TEC ";
  for($side = 1; $side <=2; $side++) {
    echo "Side ${side} ";
    for($i = 1; $i <= 9; $i++) echo "<a href='$directory/plots/TEC/Side${side}/Disk${i}/Profile/side__${side}__wheel__${i}__Run${wantediov}.png'> Disk${i} </a>";
  }
  echo "<br>";
}

function drawLatencyIOV($directory,$wantediov) {

  echo "<a href='$directory/LatencyLog/LatencyInfo_Run${wantediov}.txt'> LatencyInfo</a><br>"; 
}

function drawShiftAndCrosstalkIOV($directory,$wantediov) {

  echo "<a href='$directory/ShiftAndCrosstalkLog/ShiftAndCrosstalkInfo_Run${wantediov}.txt'> ShiftAndCrossTalkInfo</a><br>"; 
}

function drawAPVPhaseOffsetsIOV($directory,$wantediov) {

  echo "<a href='$directory/APVPhaseOffsetsLog/APVPhaseOffsetsInfo_Run${wantediov}.txt'> APVPhaseOffsetsInfo</a><br>"; 
}

function drawNoiseIOV($directory,$wantediov) {

  $type =array("Cumulative","Profile");
  $tkmapfile="${directory}/plots/TrackerMap/NoiseTkMap_Run_${wantediov}.png";
  echo "<a href='${tkmapfile}'><img src='${tkmapfile}' hspace=5 vspace=5 border=0 height=250 width=500 ALT='${tkmapfile}'></a> <br>"; 
  for($it=0;$it<2;$it++) {
    echo "$type[$it] <br>";
    echo "TIB ";
    for($i = 1; $i <= 4; $i++) echo "<a href='$directory/plots/TIB/Layer${i}/$type[$it]/layer__${i}__Run${wantediov}.png'> Layer${i} </a>";
    echo "<br>";
    echo "TOB ";
    for($i = 1; $i <= 6; $i++) echo "<a href='$directory/plots/TOB/Layer${i}/$type[$it]/layer__${i}__Run${wantediov}.png'> Layer${i} </a>";
    echo "<br>";
    echo "TID ";
    for($side = 1; $side <=2; $side++) {
      echo "Side ${side} ";
      for($i = 1; $i <= 3; $i++) echo "<a href='$directory/plots/TID/Side${side}/Disk${i}/$type[$it]/side__${side}__wheel__${i}__Run${wantediov}.png'> Disk${i} </a>";
    }
    echo "<br>";
    echo "TEC ";
    for($side = 1; $side <=2; $side++) {
      echo "Side ${side} ";
      for($i = 1; $i <= 9; $i++) echo "<a href='$directory/plots/TEC/Side${side}/Disk${i}/$type[$it]/side__${side}__wheel__${i}__Run${wantediov}.png'> Disk${i} </a>";
    }
    echo "<br>";
  }
}

function drawPedestalIOV($directory,$wantediov) {

  drawGenericIOV("Pedestal",$directory,$wantediov);

}

function drawApvGainIOV($directory,$wantediov) {

  drawGenericIOV("Gain",$directory,$wantediov);

}

function drawLorentzAngleIOV($directory,$wantediov) {

  drawGenericIOV("LorentzAngle",$directory,$wantediov);

}

function drawThresholdIOV($directory,$wantediov) {

  drawGenericIOV("HighThreshold",$directory,$wantediov);
  drawGenericIOV("LowThreshold",$directory,$wantediov);

}

function drawGenericIOV($prefix,$directory,$wantediov) {

  $tkmapfile="${directory}/plots/TrackerMap/${prefix}TkMap_Run_${wantediov}.png";
  echo "<a href='${tkmapfile}'><img src='${tkmapfile}' hspace=5 vspace=5 border=0 height=250 width=500 ALT='${tkmapfile}'></a> <br>"; 
  echo "TIB ";
  for($i = 1; $i <= 4; $i++) echo "<a href='$directory/plots/TIB/Layer${i}/layer__${i}__Run${wantediov}.png'> Layer${i} </a>";
  echo "<br>";
  echo "TOB ";
  for($i = 1; $i <= 6; $i++) echo "<a href='$directory/plots/TOB/Layer${i}/layer__${i}__Run${wantediov}.png'> Layer${i} </a>";
  echo "<br>";
  echo "TID ";
  for($side = 1; $side <=2; $side++) {
    echo "Side ${side} ";
    for($i = 1; $i <= 3; $i++) echo "<a href='$directory/plots/TID/Side${side}/Disk${i}/side__${side}__wheel__${i}__Run${wantediov}.png'> Disk${i} </a>";
  }
  echo "<br>";
  echo "TEC ";
  for($side = 1; $side <=2; $side++) {
    echo "Side ${side} ";
    for($i = 1; $i <= 9; $i++) echo "<a href='$directory/plots/TEC/Side${side}/Disk${i}/side__${side}__wheel__${i}__Run${wantediov}.png'> Disk${i} </a>";
  }
  echo "<br>";
}
?>