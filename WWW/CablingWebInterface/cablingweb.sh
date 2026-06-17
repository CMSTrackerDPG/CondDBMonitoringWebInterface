#!/bin/bash

echo $(whoami)
EXEC_PATH=/data/users/event_display/dpgtkdqm/remotescripts/StripCabling/CondDBMonitoringWebInterface/WWW/CablingWebInterface/

source /cvmfs/cms.cern.ch/cmsset_default.sh
RELEASE_PATH=/data/users/event_display/dpgtkdqm/remotescripts/StripCabling/CMSSW_14_0_14
cd $RELEASE_PATH/src
eval `scramv1 runtime -sh`
cd $EXEC_PATH

python3 cablingweb-py3.py $1 $2 $3 $4 $5 $6 $7 $8 $9 ${10} ${11} ${12} ${13} ${14} ${15} ${16} ${17} ${18} ${19} ${20} ${21} ${22} ${23} ${24} ${25} ${26} ${27} ${28} ${29} ${30} ${31} ${32} ${33} ${34} ${35} ${36} ${37} ${38} ${39} ${40} ${41} ${42} ${43} ${44} ${45} ${46} ${47} ${48} ${49} 2>&1
