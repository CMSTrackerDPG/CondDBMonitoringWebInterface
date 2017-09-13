#!/bin/sh
#

parent_path=$( cd "$(dirname "${BASH_SOURCE[0]}")" ; pwd -P )
echo $parent_path
cd $parent_path

WORK_DIR=$parent_path/run
CMSSW_DIR=/cvmfs/cms.cern.ch/slc6_amd64_gcc700/cms/cmssw/CMSSW_9_3_0_pre4/src
OUTPUT_DIR=$parent_path/../WWW/DCSTrend/last72hr

cd $CMSSW_DIR
eval `scramv1 ru -sh`

cd $WORK_DIR
# echo $WORK_DIR
cmsRun dcs_trend_monitor_cfg.py
mv *.png *.csv $OUTPUT_DIR
python $WORK_DIR/../autoInspector.py $OUTPUT_DIR
