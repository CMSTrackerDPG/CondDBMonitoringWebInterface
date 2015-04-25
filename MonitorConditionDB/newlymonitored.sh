#!/bin/bash

echo "*****Newly monitored IOVs******"
echo 
for filename in `grep -l "Execution ended" /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/cronlog/cronjob_*.log`; do
grep -h -E "runNumber|tagName|connectionString|cmsRun|noiseTagName|gainTagName|secondRunNumber|firstRunNumber" $filename | awk '/Executing cmsRun/ {printf "%s %s %s %s %s %s %s ",$1,$2,$3,$4,$5,$6,$7; tag=""; noise=""} /runNumber/ {runnumb=$3} /firstRunNumber/ {firstrunnumb=$3} /secondRunNumber/ {secondrunnumb=$3} /gainTagName/ {gain=$3} /noiseTagName/ {noise=$3} /connectionString/ {conns=$3} /tagName/ {tag=$3} /cmsRun finished/ {if (tag!="") {printf "Monitored IOV %s %s %s",conns,tag,runnumb};if (noise!="") {printf "Monitored IOV pair with NoiseRatio %s %s %s %s %s",conns,noise,gain,firstrunnumb,secondrunnumb}; printf "\n"}';
done 
echo 
echo "*****Newly monitored elements: GlobalTags, Tags, Noise and Gain tag pairs. What follows is the list of newly created directories*******"
echo
for filename in `grep -l "Execution ended" /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/cronlog/cronjob_*.log`; do 
grep -h -E "Creating directory" $filename | awk '{printf "%s %s %s %s %s %s %s %s\n",$1,$2,$3,$4,$5,$6,$7,$10}'
done

