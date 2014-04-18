<?php
function drawTrend($rootpath,$dirname) {

  echo "<H4>Trend Plots </H4>";

  if(strstr($dirname,"SiStripNoise/NoiseRatios")==$dirname) drawNoiseRatioTrend("${rootpath}${dirname}");
  else if(strstr($dirname,"RunInfo")==$dirname) drawBadChannelTrend("${rootpath}${dirname}");
  else if(strstr($dirname,"SiStripFedCabling")==$dirname) drawCablingTrend("${rootpath}${dirname}");
  else if(strstr($dirname,"SiStripBadChannel")==$dirname) drawBadChannelTrend("${rootpath}${dirname}");
  else if(strstr($dirname,"SiStripNoise")==$dirname) drawNoiseTrend("${rootpath}${dirname}");
  else if(strstr($dirname,"SiStripPedestal")==$dirname) drawPedestalTrend("${rootpath}${dirname}");
  else if(strstr($dirname,"SiStripApvGain")==$dirname) drawApvGainTrend("${rootpath}${dirname}");
  else if(strstr($dirname,"SiStripLorentzAngle")==$dirname) drawLorentzAngleTrend("${rootpath}${dirname}");
  else if(strstr($dirname,"SiStripBackPlaneCorrection")==$dirname) drawBackPlaneCorrectionTrend("${rootpath}${dirname}");
  else if(strstr($dirname,"SiStripLatency")==$dirname) drawLatencyTrend("${rootpath}${dirname}");
  else if(strstr($dirname,"SiStripShiftAndCrosstalk")==$dirname) drawShiftAndCrosstalkTrend("${rootpath}${dirname}");
  else if(strstr($dirname,"SiStripAPVPhaseOffsets")==$dirname) drawAPVPhaseOffsetsTrend("${rootpath}${dirname}");

}

function drawNoiseRatioTrend($directory) {

  drawGenericTrend("NoiseRatio",$directory);

}

function drawCablingTrend($directory) {

  echo " Tracker: 
    <a href='$directory/plots/Trends/BadModulesTracker.png'> Bad Modules</a>
    <a href='$directory/plots/Trends/BadFibersTracker.png'> Bad Fibers</a>
    <a href='$directory/plots/Trends/BadAPVsTracker.png'> Bad APVs</a>
    <a href='$directory/plots/Trends/BadStripsFromAPVsTracker.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/Trends/BadStripsTracker.png'> Bad Strips</a>
    <a href='$directory/plots/Trends/AllBadStripsTracker.png'> All Bad Strips</a>
    <br>";

  echo "TIB: 
    <a href='$directory/plots/TIB/Trends/BadModulesTIB.png'> Bad Modules</a>
    <a href='$directory/plots/TIB/Trends/BadFibersTIB.png'> Bad Fibers</a>
    <a href='$directory/plots/TIB/Trends/BadAPVsTIB.png'> Bad APVs</a>
    <a href='$directory/plots/TIB/Trends/BadStripsFromAPVsTIB.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TIB/Trends/BadStripsTIB.png'> Bad Strips</a>
    <a href='$directory/plots/TIB/Trends/AllBadStripsTIB.png'> All Bad Strips</a>
    <br>";
  echo "TID+:
    <a href='$directory/plots/TID/Side2/Trends/BadModulesTID+.png'> Bad Modules</a>
    <a href='$directory/plots/TID/Side2/Trends/BadFibersTID+.png'> Bad Fibers</a>
    <a href='$directory/plots/TID/Side2/Trends/BadAPVsTID+.png'> Bad APVs</a>
    <a href='$directory/plots/TID/Side2/Trends/BadStripsFromAPVsTID+.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TID/Side2/Trends/BadStripsTID+.png'> Bad Strips</a>
    <a href='$directory/plots/TID/Side2/Trends/AllBadStripsTID+.png'> All Bad Strips</a>
    <br>";
  echo "TID-:
    <a href='$directory/plots/TID/Side1/Trends/BadModulesTID-.png'> Bad Modules</a>
    <a href='$directory/plots/TID/Side1/Trends/BadFibersTID-.png'> Bad Fibers</a>
    <a href='$directory/plots/TID/Side1/Trends/BadAPVsTID-.png'> Bad APVs</a>
    <a href='$directory/plots/TID/Side1/Trends/BadStripsFromAPVsTID-.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TID/Side1/Trends/BadStripsTID-.png'> Bad Strips</a>
    <a href='$directory/plots/TID/Side1/Trends/AllBadStripsTID-.png'> All Bad Strips</a>
    <br>";
  echo "TOB: 
    <a href='$directory/plots/TOB/Trends/BadModulesTOB.png'> Bad Modules</a>
    <a href='$directory/plots/TOB/Trends/BadFibersTOB.png'> Bad Fibers</a>
    <a href='$directory/plots/TOB/Trends/BadAPVsTOB.png'> Bad APVs</a>
    <a href='$directory/plots/TOB/Trends/BadStripsFromAPVsTOB.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TOB/Trends/BadStripsTOB.png'> Bad Strips</a>
    <a href='$directory/plots/TOB/Trends/AllBadStripsTOB.png'> All Bad Strips</a>
    <br>";
  echo "TEC+:
    <a href='$directory/plots/TEC/Side2/Trends/BadModulesTEC+.png'> Bad Modules</a>
    <a href='$directory/plots/TEC/Side2/Trends/BadFibersTEC+.png'> Bad Fibers</a>
    <a href='$directory/plots/TEC/Side2/Trends/BadAPVsTEC+.png'> Bad APVs</a>
    <a href='$directory/plots/TEC/Side2/Trends/BadStripsFromAPVsTEC+.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TEC/Side2/Trends/BadStripsTEC+.png'> Bad Strips</a>
    <a href='$directory/plots/TEC/Side2/Trends/AllBadStripsTEC+.png'> All Bad Strips</a>
    <br>";
  echo "TEC-:
    <a href='$directory/plots/TEC/Side1/Trends/BadModulesTEC-.png'> Bad Modules</a>
    <a href='$directory/plots/TEC/Side1/Trends/BadFibersTEC-.png'> Bad Fibers</a>
    <a href='$directory/plots/TEC/Side1/Trends/BadAPVsTEC-.png'> Bad APVs</a>
    <a href='$directory/plots/TEC/Side1/Trends/BadStripsFromAPVsTEC-.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TEC/Side1/Trends/BadStripsTEC-.png'> Bad Strips</a>
    <a href='$directory/plots/TEC/Side1/Trends/AllBadStripsTEC-.png'> All Bad Strips</a>
    <br>";

}

function drawBadChannelTrend($directory) {

  echo " Tracker: 
    <a href='$directory/plots/Trends/BadModulesTracker.png'> Bad Modules</a>
    <a href='$directory/plots/Trends/BadFibersTracker.png'> Bad Fibers</a>
    <a href='$directory/plots/Trends/BadAPVsTracker.png'> Bad APVs</a>
    <a href='$directory/plots/Trends/BadStripsFromAPVsTracker.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/Trends/BadStripsTracker.png'> Bad Strips</a>
    <a href='$directory/plots/Trends/AllBadStripsTracker.png'> All Bad Strips</a>
    <br>";

  echo "TIB: 
    <a href='$directory/plots/TIB/Trends/BadModulesTIB.png'> Bad Modules</a>
    <a href='$directory/plots/TIB/Trends/BadFibersTIB.png'> Bad Fibers</a>
    <a href='$directory/plots/TIB/Trends/BadAPVsTIB.png'> Bad APVs</a>
    <a href='$directory/plots/TIB/Trends/BadStripsFromAPVsTIB.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TIB/Trends/BadStripsTIB.png'> Bad Strips</a>
    <a href='$directory/plots/TIB/Trends/AllBadStripsTIB.png'> All Bad Strips</a>
    <br>";
  echo "TID+:
    <a href='$directory/plots/TID/Side2/Trends/BadModulesTID+.png'> Bad Modules</a>
    <a href='$directory/plots/TID/Side2/Trends/BadFibersTID+.png'> Bad Fibers</a>
    <a href='$directory/plots/TID/Side2/Trends/BadAPVsTID+.png'> Bad APVs</a>
    <a href='$directory/plots/TID/Side2/Trends/BadStripsFromAPVsTID+.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TID/Side2/Trends/BadStripsTID+.png'> Bad Strips</a>
    <a href='$directory/plots/TID/Side2/Trends/AllBadStripsTID+.png'> All Bad Strips</a>
    <br>";
  echo "TID-:
    <a href='$directory/plots/TID/Side1/Trends/BadModulesTID-.png'> Bad Modules</a>
    <a href='$directory/plots/TID/Side1/Trends/BadFibersTID-.png'> Bad Fibers</a>
    <a href='$directory/plots/TID/Side1/Trends/BadAPVsTID-.png'> Bad APVs</a>
    <a href='$directory/plots/TID/Side1/Trends/BadStripsFromAPVsTID-.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TID/Side1/Trends/BadStripsTID-.png'> Bad Strips</a>
    <a href='$directory/plots/TID/Side1/Trends/AllBadStripsTID-.png'> All Bad Strips</a>
    <br>";
  echo "TOB: 
    <a href='$directory/plots/TOB/Trends/BadModulesTOB.png'> Bad Modules</a>
    <a href='$directory/plots/TOB/Trends/BadFibersTOB.png'> Bad Fibers</a>
    <a href='$directory/plots/TOB/Trends/BadAPVsTOB.png'> Bad APVs</a>
    <a href='$directory/plots/TOB/Trends/BadStripsFromAPVsTOB.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TOB/Trends/BadStripsTOB.png'> Bad Strips</a>
    <a href='$directory/plots/TOB/Trends/AllBadStripsTOB.png'> All Bad Strips</a>
    <br>";
  echo "TEC+:
    <a href='$directory/plots/TEC/Side2/Trends/BadModulesTEC+.png'> Bad Modules</a>
    <a href='$directory/plots/TEC/Side2/Trends/BadFibersTEC+.png'> Bad Fibers</a>
    <a href='$directory/plots/TEC/Side2/Trends/BadAPVsTEC+.png'> Bad APVs</a>
    <a href='$directory/plots/TEC/Side2/Trends/BadStripsFromAPVsTEC+.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TEC/Side2/Trends/BadStripsTEC+.png'> Bad Strips</a>
    <a href='$directory/plots/TEC/Side2/Trends/AllBadStripsTEC+.png'> All Bad Strips</a>
    <br>";
  echo "TEC-:
    <a href='$directory/plots/TEC/Side1/Trends/BadModulesTEC-.png'> Bad Modules</a>
    <a href='$directory/plots/TEC/Side1/Trends/BadFibersTEC-.png'> Bad Fibers</a>
    <a href='$directory/plots/TEC/Side1/Trends/BadAPVsTEC-.png'> Bad APVs</a>
    <a href='$directory/plots/TEC/Side1/Trends/BadStripsFromAPVsTEC-.png'> Bad Strips from APVs</a>
    <a href='$directory/plots/TEC/Side1/Trends/BadStripsTEC-.png'> Bad Strips</a>
    <a href='$directory/plots/TEC/Side1/Trends/AllBadStripsTEC-.png'> All Bad Strips</a>
    <br>";
  echo "root file: <a href='$directory/rootfiles/TrackerSummary.root'>TrackerSummary.root</a><br>";
}

function drawLatencyTrend($directory) {

  drawGenericTrend("Latency",$directory);

}

function drawShiftAndCrosstalkTrend($directory) {

  drawGenericTrend("ShiftAndCrosstalk",$directory);

}

function drawAPVPhaseOffsetsTrend($directory) {

  drawGenericTrend("APVPhaseOffsets",$directory);

}

function drawNoiseTrend($directory) {

  drawGenericTrend("Noise",$directory);

}

function drawPedestalTrend($directory) {

  drawGenericTrend("Pedestal",$directory);

}

function drawApvGainTrend($directory) {

  drawGenericTrend("Gain",$directory);

}

function drawLorentzAngleTrend($directory) {

  drawGenericTrend("LorentzAngle",$directory);

}

function drawBackPlaneCorrectionTrend($directory) {

  drawGenericTrend("BackPlaneCorrection",$directory);

}

function drawGenericTrend($prefix,$directory) {

  echo "No trend plot for this condition object <br>";

}
?>