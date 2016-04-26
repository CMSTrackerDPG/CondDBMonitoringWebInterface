#!/bin/sh
#

CMSSW_DIR=/afs/cern.ch/cms/tracker/sistrcalib/DCSTrend/CMSSW_8_0_5_patch1/src
WORK_DIR=/afs/cern.ch/cms/tracker/sistrcalib/DCSTrend/run
OUTPUT_DIR=/afs/cern.ch/cms/tracker/sistrcalib/WWW/DCSTrend/last72hr

cd $CMSSW_DIR
eval `scramv1 ru -sh`

cd $WORK_DIR
cmsRun dcs_trend_monitor_cfg.py
mv *.png *.csv $OUTPUT_DIR
