#!/bin/bash

if [ "${1}" == "CMSSW_7_4_0_pre9" ]; then
   export SCRAM_ARCH=slc6_amd64_gcc491
elif [ "${1}" == "CMSSW_7_1_15_patch1" ]; then
   export SCRAM_ARCH=slc6_amd64_gcc481
elif [ "${1}" == "CMSSW_7_0_4" ]; then
   export SCRAM_ARCH=slc5_amd64_gcc481
elif [ "${1}" == "CMSSW_8_0_10" ]; then
   export SCRAM_ARCH=slc6_amd64_gcc530
elif [ "${1}" == "CMSSW_9_3_0_pre4" ]; then
   export SCRAM_ARCH=slc6_amd64_gcc700
else
   export SCRAM_ARCH=slc5_amd64_gcc481
fi
echo $SCRAM_ARCH

CMS_PATH=/cvmfs/cms.cern.ch/

# source /afs/cern.ch/cms/cmsset_default.sh
source $CMS_PATH/cmsset_default.sh

echo $SCRAM_ARCH
echo $HOSTNAME

# cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/${1}/src
cd $CMS_PATH/$SCRAM_ARCH/cms/cmssw/${1}/src
eval `scramv1 runtime -sh`
echo $SCRAM_ARCH
echo $LD_LIBRARY_PATH
cd $OLDPWD

echo $1 $2 $3 $4 $5 $6 $7 $8 $9 ${10} ${11}

cat $3

which makeModulePlots.sh

if [ "${1}" == "CMSSW_7_0_4" ]; then
  makeModulePlots.sh "$2" $3 $4 "$5" "$6" "$7" "$8" $9 ${11} 2>&1
else
  makeModulePlots.sh "$2" $3 $4 "$5" "$6" "$7" "$8" $9 ${10} ${11} 2>&1
fi
