#!/bin/bash
parent_path=$( cd "$(dirname "${BASH_SOURCE[0]}")" ; pwd -P )
echo $parent_path
cd $parent_path

source /cvmfs/cms.cern.ch/cmsset_default.sh

#DCS O2O Monitoring
#run this regardless of the lock file

../DCSTrend/monitorDCS.sh

if [ -f ./MonitorConditionDB/cronlog/LockFileTmp ]; then
    exit
fi

LOCKFILE=$parent_path/cronlog/LockFileTmp
JOBDONEFILE=$parent_path/../WWW/CondDBMonitoring/LastJobDone
NEWLYMONITOREDFILE=$parent_path/../WWW/CondDBMonitoring/newlymonitored.txt
ERRORLOCKFILE="./cronlog/ErrorLockFile_`date +%Y%m%d%H%M`"

#touch $LOCKFILE
hostname > $LOCKFILE
touch $ERRORLOCKFILE

trap "rm -f $LOCKFILE" EXIT


# export PATH=$PATH:$/cvmfs/cms.cern.ch/common/
# export CMS_PATH=/cvmfs/cms.cern.ch
export FRONTIER_PROXY=http://cmst0frontier.cern.ch:3128
# export SCRAM_ARCH=slc6_amd64_gcc700

# CVMFS
# cd /cvmfs/cms.cern.ch/slc6_amd64_gcc700/cms/cmssw/CMSSW_9_2_0/src
cd /cvmfs/cms.cern.ch/slc6_amd64_gcc700/cms/cmssw/CMSSW_9_3_0_pre4/src
# cd /afs/cern.ch/cms/slc7_amd64_gcc530/cms/cmssw/CMSSW_9_0_0_pre1/src

eval `scramv1 runtime -sh`
#eval `cmsenv`
# cmsenv


afstokenchecker.sh "My Scram Variable $SCRAM_ARCH"

cd $parent_path
WORKDIR="workdir_`date +%Y%m%d%H%M`"
mkdir $WORKDIR
cd $WORKDIR


#V2
# MonitorDB_NewDirStructure_KeepTagLinks_generic_V2.sh SiStripBadComponents_Upgrade dev FrontierPrep
# MonitorDB_NewDirStructure_KeepTagLinks_generic_V2.sh SiStripApvGain_Realistic dev FrontierPrep
# MonitorDB_NewDirStructure_KeepTagLinks_generic_V2.sh SiStripNoise_DecoMode dev FrontierPrep
# MonitorDB_NewDirStructure_KeepTagLinks_generic_V2.sh SiStripBadChannel_PCL dev FrontierPrep

# MonitorDB_NewDirStructure_KeepTagLinks_generic_V2.sh SiStrip pro PromptProd
# Monitor_GlobalTags_V2.sh SiStrip pro
# Monitor_NoiseRatios_V2.sh pro PromptProd 

#V3
PATHTOSCRIPT="/data/users/event_display/CondDBMonitoringWebInterface/CondDBMonitoringWebInterface/MonitorConditionDB"
bash $PATHTOSCRIPT/MonitorDB_NewDirStructure_KeepTagLinks_generic_V3.sh SiStripBadComponents_Upgrade dev FrontierPrep
bash $PATHTOSCRIPT/MonitorDB_NewDirStructure_KeepTagLinks_generic_V3.sh SiStripApvGain_Realistic dev FrontierPrep
bash $PATHTOSCRIPT/MonitorDB_NewDirStructure_KeepTagLinks_generic_V3.sh SiStripNoise_DecoMode dev FrontierPrep
bash $PATHTOSCRIPT/MonitorDB_NewDirStructure_KeepTagLinks_generic_V3.sh SiStripBadChannel_PCL dev FrontierPrep

bash $PATHTOSCRIPT/MonitorDB_NewDirStructure_KeepTagLinks_generic_V3.sh SiStrip pro PromptProd
bash $PATHTOSCRIPT/Monitor_GlobalTags_V3.sh SiStrip pro

bash $PATHTOSCRIPT/Monitor_NoiseRatios_V3.sh pro PromptProd 


rm -f *.txt
rm -f *.html
cd ..
rmdir $WORKDIR

rm -f $LOCKFILE
rm -f $JOBDONEFILE
rm -f $ERRORLOCKFILE
echo `tokens`
afstokenchecker.sh "Execution ended"
afstokenchecker.sh "Execution ended" > $JOBDONEFILE

cd $parent_path
./newlymonitored.sh > $NEWLYMONITOREDFILE

echo "done with all"
