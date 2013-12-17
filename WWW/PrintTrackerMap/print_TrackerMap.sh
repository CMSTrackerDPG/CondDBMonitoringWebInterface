#!/bin/bash

if [ "${1}" == "CMSSW_7_0_X_2013-12-14-1400" ]; then
   export SCRAM_ARCH=slc6_amd64_gcc481
else
   export SCRAM_ARCH=slc5_amd64_gcc462
fi
source /afs/cern.ch/cms/cmsset_default.sh

echo $HOST

#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_5_3_7_patch4/src
cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/${1}/src
eval `scramv1 runtime -sh`
cd $OLDPWD

echo $1 $2 $3 $4 $5 $6 $7 $8 $9

print_TrackerMap $2 "$3" $4 $5 $6 $7 $8 $9 2>&1
