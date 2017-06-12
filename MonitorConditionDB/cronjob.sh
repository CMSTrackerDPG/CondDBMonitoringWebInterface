#!/bin/bash

source /afs/cern.ch/cms/cmsset_default.sh

#DCS O2O Monitoring
#run this regardless of the lock file
/afs/cern.ch/cms/tracker/sistrcalib/DCSTrend/monitorDCS.sh

if [ -f /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/cronlog/LockFileTmp ]; then
    exit
fi

LOCKFILE=/afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/cronlog/LockFileTmp
JOBDONEFILE=/afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/LastJobDone
NEWLYMONITOREDFILE=/afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/newlymonitored.txt
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
#export SCRAM_ARCH=slc5_amd64_gcc462
#export SCRAM_ARCH=slc5_amd64_gcc481
#export SCRAM_ARCH=slc6_amd64_gcc481
export SCRAM_ARCH=slc6_amd64_gcc491

#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_3_4_1/src/
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_3_8_0_pre7/src
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_4_4_3/src
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_5_3_7_patch4/src
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_5_3_14/src
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_7_0_0_pre11/src
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_7_0_3_patch2/src
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_7_0_4/src
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_7_1_0_pre7/src
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_7_4_0_pre8/src
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_7_5_0_pre2/src
cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_7_5_0_pre4/src
eval `scramv1 runtime -sh`

afstokenchecker.sh "My Scram Variable $SCRAM_ARCH"

WORKDIR="/afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/workdir_`date +%Y%m%d%H%M`"
mkdir $WORKDIR
cd $WORKDIR

#V1 now disabled
#MonitorDB_NewDirStructure_KeepTagLinks_generic.sh SiStripBadComponents_Upgrade cms_orcoff_prep CMS_COND_STRIP CMS_COND_GLOBALTAG FrontierPrep
#MonitorDB_NewDirStructure_KeepTagLinks_generic.sh SiStripApvGain_Realistic cms_orcoff_prep CMS_COND_STRIP CMS_COND_GLOBALTAG FrontierPrep
#MonitorDB_NewDirStructure_KeepTagLinks_generic.sh SiStripNoise_DecoMode cms_orcoff_prep CMS_COND_STRIP CMS_COND_GLOBALTAG FrontierPrep
#MonitorDB_NewDirStructure_KeepTagLinks_generic.sh SiStrip cms_orcoff_prod CMS_COND_31X_STRIP CMS_COND_31X_GLOBALTAG PromptProd
#MonitorDB_NewDirStructure_KeepTagLinks_generic.sh SiStrip cms_orcoff_prod CMS_COND_STRIP_000 CMS_COND_31X_GLOBALTAG PromptProd
#MonitorDB_NewDirStructure_KeepTagLinks_generic.sh SiStripBadChannel_PCL cms_orcoff_prep CMS_COND_STRIP CMS_COND_GLOBALTAG FrontierPrep
#Monitor_GlobalTags.sh SiStrip cms_orcoff_prod CMS_COND_31X_GLOBALTAG PromptProd
#Monitor_NoiseRatios.sh cms_orcoff_prod CMS_COND_31X_STRIP CMS_COND_31X_GLOBALTAG PromptProd 
##Monitor_RunInfo.sh cms_orcoff_prod CMS_COND_31X_STRIP CMS_COND_31X_GLOBALTAG CMS_COND_31X_RUN_INFO PromptProd

#V2
MonitorDB_NewDirStructure_KeepTagLinks_generic_V2.sh SiStripBadComponents_Upgrade dev FrontierPrep
MonitorDB_NewDirStructure_KeepTagLinks_generic_V2.sh SiStripApvGain_Realistic dev FrontierPrep
MonitorDB_NewDirStructure_KeepTagLinks_generic_V2.sh SiStripNoise_DecoMode dev FrontierPrep
MonitorDB_NewDirStructure_KeepTagLinks_generic_V2.sh SiStripBadChannel_PCL dev FrontierPrep
#
MonitorDB_NewDirStructure_KeepTagLinks_generic_V2.sh SiStrip pro PromptProd
Monitor_GlobalTags_V2.sh SiStrip pro
Monitor_NoiseRatios_V2.sh pro PromptProd 

#Not needed anymore, since the 21X tags won't change (they are not in use anymore)
#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/CMSSW_2_2_6/src/
#eval `scramv1 runtime -sh`

#cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB
#./MonitorDB_NewDirStructure.sh cms_orcoff_prod CMS_COND_21X_STRIP CMS_COND_21X_GLOBALTAG PromptProd

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
/afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/newlymonitored.sh > $NEWLYMONITOREDFILE
