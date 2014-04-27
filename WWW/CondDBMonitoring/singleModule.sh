#!/bin/bash

export SCRAM_ARCH=slc5_amd64_gcc481
echo $SCRAM_ARCH

source /afs/cern.ch/cms/cmsset_default.sh
echo $SCRAM_ARCH
echo $HOSTNAME

cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_7_0_4/src
eval `scramv1 runtime -sh`
echo $SCRAM_ARCH
echo $LD_LIBRARY_PATH
cd $OLDPWD

echo $1 $2 $3 $4 $5 $6 $7 $8 $9

makeModulePlots.sh "$1" $2 $3 "$4" "$5" "$6" "$7" $8 $9 2>&1
