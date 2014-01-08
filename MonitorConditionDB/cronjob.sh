#!/bin/bash

if [ -f /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/cronlog/LockFileTmp ]; then
    exit
fi

source /afs/cern.ch/cms/cmsset_default.sh

LOCKFILE=/afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/cronlog/LockFileTmp
JOBDONEFILE=/afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/LastJobDone
ERRORLOCKFILE="/afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/cronlog/ErrorLockFile_`date +%Y%m%d%H%M`"

#touch $LOCKFILE
hostname > $LOCKFILE
touch $ERRORLOCKFILE

trap "rm -f $LOCKFILE" EXIT

export PATH=$PATH:/afs/cern.ch/cms/sw/common/
export CMS_PATH=/afs/cern.ch/cms
export FRONTIER_PROXY=http://cmst0frontier.cern.ch:3128
#export FRONTIER_FORCERELOAD=long # This should not be used anymore!!!
#export SCRAM_ARCH=slc5_ia32_gcc434
export SCRAM_ARCH=slc5_amd64_gcc462

#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_3_4_1/src/
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_3_8_0_pre7/src
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_4_4_3/src
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_5_3_7_patch4/src
cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_5_3_14/src
eval `scramv1 runtime -sh`

afstokenchecker.sh "My Scram Variable $SCRAM_ARCH"

cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB
#./MonitorDB_NewDirStructure_KeepTagLinks.sh cms_orcoff_prod CMS_COND_31X_FROM21X CMS_COND_31X_GLOBALTAG PromptProd
#./MonitorDB_NewDirStructure_KeepTagLinks.sh cms_orcoff_prep CMS_COND_31X_ALL CMS_COND_30X_GLOBALTAG FrontierPrep
#./MonitorDB_NewDirStructure_KeepTagLinks.sh cms_orcoff_prep CMS_COND_30X_STRIP CMS_COND_30X_GLOBALTAG FrontierPrep
MonitorDB_NewDirStructure_KeepTagLinks_generic.sh SiStripBadComponents_Upgrade cms_orcoff_prep CMS_COND_STRIP CMS_COND_GLOBALTAG FrontierPrep
MonitorDB_NewDirStructure_KeepTagLinks_generic.sh SiStripApvGain_Realistic cms_orcoff_prep CMS_COND_STRIP CMS_COND_GLOBALTAG FrontierPrep
MonitorDB_NewDirStructure_KeepTagLinks_generic.sh SiStripNoise_DecoMode cms_orcoff_prep CMS_COND_STRIP CMS_COND_GLOBALTAG FrontierPrep
MonitorDB_NewDirStructure_KeepTagLinks_generic.sh SiStrip cms_orcoff_prod CMS_COND_31X_STRIP CMS_COND_31X_GLOBALTAG PromptProd
MonitorDB_NewDirStructure_KeepTagLinks_generic.sh SiStripBadChannel_PCL cms_orcoff_prep CMS_COND_STRIP CMS_COND_GLOBALTAG FrontierPrep
Monitor_NoiseRatios.sh cms_orcoff_prod CMS_COND_31X_STRIP CMS_COND_31X_GLOBALTAG PromptProd 
##Monitor_RunInfo.sh cms_orcoff_prod CMS_COND_31X_STRIP CMS_COND_31X_GLOBALTAG CMS_COND_31X_RUN_INFO PromptProd

#Not needed anymore, since the 21X tags won't change (they are not in use anymore)
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_2_2_6/src/
#eval `scramv1 runtime -sh`

#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB
#./MonitorDB_NewDirStructure.sh cms_orcoff_prod CMS_COND_21X_STRIP CMS_COND_21X_GLOBALTAG PromptProd

rm -f $LOCKFILE
rm -f $JOBDONEFILE
rm -f $ERRORLOCKFILE
echo `tokens`
afstokenchecker.sh "Execution ended"
afstokenchecker.sh "Execution ended" > $JOBDONEFILE

