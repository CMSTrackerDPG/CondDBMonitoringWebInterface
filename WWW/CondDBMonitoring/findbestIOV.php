<?php
function findbestIOV($runnumber,$tagnum,&$dirname,$rootpath,&$wantediovs,&$wantedtrend) {
  if(strstr($dirname[$tagnum],"SiStripFedCabling")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/CablingLog/";
    $searchpattern="QualityInfoFromCabling_Run%d.txt";
    $lspattern="QualityInfoFromCabling_Run*.txt";
  }
  if(strstr($dirname[$tagnum],"SiStripBadChannel")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/QualityLog/";
    $searchpattern="QualityInfo_Run%d.txt";
    $lspattern="QualityInfo_Run*.txt";
  }
  if(strstr($dirname[$tagnum],"SiStripApvGain")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/plots/TrackerMap/";
    $searchpattern="GainTkMap_Run_%d.png";
    $lspattern="GainTkMap_Run_*.png";
  }
  if(strstr($dirname[$tagnum],"SiStripNoise")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/plots/TrackerMap/";
    $searchpattern="NoiseTkMap_Run_%d.png";
    $lspattern="NoiseTkMap_Run_*.png";
  }
  if(strstr($dirname[$tagnum],"SiStripPedestal")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/plots/TrackerMap/";
    $searchpattern="PedestalTkMap_Run_%d.png";
    $lspattern="PedestalTkMap_Run_*.png";
  }
  if(strstr($dirname[$tagnum],"SiStripLorentzAngle")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/plots/TrackerMap/";
    $searchpattern="LorentzAngleTkMap_Run_%d.png";
    $lspattern="LorentzAngleTkMap_Run_*.png";
  }
  if(strstr($dirname[$tagnum],"SiStripBackPlaneCorrection")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/plots/TrackerMap/";
    $searchpattern="BackPlaneCorrectionTkMap_Run_%d.png";
    $lspattern="BackPlaneCorrectionTkMap_Run_*.png";
  }
  if(strstr($dirname[$tagnum],"SiStripLatency")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/LatencyLog/";
    $searchpattern="LatencyInfo_Run%d.txt";
    $lspattern="LatencyInfo_Run*.txt";
  }
  if(strstr($dirname[$tagnum],"SiStripThreshold")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/plots/TrackerMap/";
    $searchpattern="HighThresholdTkMap_Run_%d.png";
    $lspattern="HighThresholdTkMap_Run_*.png";
  }
  if(strstr($dirname[$tagnum],"SiStripShiftAndCrosstalk")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/ShiftAndCrosstalkLog/";
    $searchpattern="ShiftAndCrosstalkInfo_Run%d.txt";
    $lspattern="ShiftAndCrosstalkInfo_Run*.txt";
  }
  if(strstr($dirname[$tagnum],"SiStripAPVPhaseOffsets")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/APVPhaseOffsetsLog/";
    $searchpattern="APVPhaseOffsetsInfo_Run%d.txt";
    $lspattern="APVPhaseOffsetsInfo_Run*.txt";
  }
  if(strstr($dirname[$tagnum],"SiStripNoise/NoiseRatios")==$dirname[$tagnum]) {
    $directory="$rootpath/$dirname[$tagnum]/plots/";
    $searchpattern="Run_%d_TkMap.png";
    $lspattern="Run_*_TkMap.png";
  }

#  echo "$directory <br>";
#  echo "$searchpattern <br>";
#  echo "$lspattern <br>";

  exec ("ls -F $directory$lspattern",$filelist);

  $runlist=array();
  foreach($filelist as $file) {
#    echo "$file <br>";
    list($runlist[]) = sscanf($file,"${directory}${searchpattern}");
  }
  sort($runlist);
  
  if($runnumber!="") {
#    $wantediovs[$tagnum]=array();
    $wantediovs[$tagnum][0]=0;
    foreach($runlist as $run) {
      if($run!="" && $run <= $runnumber) $wantediovs[$tagnum][0]=$run;
    }
  }

  
  if(count($wantediovs[$tagnum])==0 && $wantedtrend[$tagnum]!= "yes") {
    echo "<br>";
    echo "Select IOVs of tag $dirname[$tagnum]: ";
    echo "<select name='wantediovs${tagnum}[]' multiple size='5'>";
    foreach($runlist as $run) {
      echo "<option value=$run>$run</option>";
    }
    echo "</select> <br>";

    echo "Do you want trend plots of tag $dirname[$tagnum]? ";
    echo "<input type='radio' name='wantedtrend${tagnum}' value='no' checked> No ";
    echo "<input type='radio' name='wantedtrend${tagnum}' value='yes'> Yes ";
    echo "<br>";
   
  }
  
}
?>