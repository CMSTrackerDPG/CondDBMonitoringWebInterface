#!/bin/bash

if [ "${1}" == "CMSSW_7_0_0_pre11" ]; then
   export SCRAM_ARCH=slc6_amd64_gcc481
elif [ "${1}" == "CMSSW_6_2_7" ]; then
   export SCRAM_ARCH=slc6_amd64_gcc472
else
   export SCRAM_ARCH=slc5_amd64_gcc462
fi
echo $SCRAM_ARCH

source /afs/cern.ch/cms/cmsset_default.sh
echo $SCRAM_ARCH

echo $HOST

#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_5_3_7_patch4/src
cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/${1}/src
eval `scramv1 runtime -sh`
echo $SCRAM_ARCH
cd $OLDPWD

echo $1 $2 $3 $4 $5 $6 $7 $8 $9

print_TrackerMap $2 "$3" $4 $5 $6 $7 $8 $9 2>&1
