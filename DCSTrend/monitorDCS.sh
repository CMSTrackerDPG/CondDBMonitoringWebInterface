#!/bin/sh
source /cvmfs/cms.cern.ch/cmsset_default.sh
##Only update the CMSSW release
CMSSW_REL=CMSSW_14_0_14

PARENT_PATH=/data/users/event_display/dpgtkdqm/cronjobs/DCSTrend
WORK_DIR=$PARENT_PATH/DCSTrend/run
CMSSW_DIR=$PARENT_PATH/$CMSSW_REL/src/
echo "Work dir path:"$WORK_DIR

export SSO_CLIENT_ID=tkhdqm
export SSO_CLIENT_SECRET=hidden

EOS_OUTPUT_DIR=/eos/user/d/dpgtkdqm/www/DCSTrend/last72hr/

#kerberos authentication
kdestroy
kinit -k -t /home/dpgtkdqm/dpgtkdqm.keytab dpgtkdqm
klist
eosfusebind
aklog CERN.CH

cd $CMSSW_DIR
eval `scramv1 ru -sh`

cd $WORK_DIR
echo "Inside work dir:"$WORK_DIR
echo "Executing cmsRun..."
cmsRun dcs_trend_monitor_cfg.py
python3 $WORK_DIR/../autoInspector.py $WORK_DIR

echo "Copy files on eos:"$EOS_OUTPUT_DIR
xrdcp -f *.png root://eosuser.cern.ch//$EOS_OUTPUT_DIR
xrdcp -f *.csv root://eosuser.cern.ch//$EOS_OUTPUT_DIR

cronFile="/data/users/event_display/dpgtkdqm/cronjobs/cronlogs/DCSTrend_cron.log"
xrdcp -f $cronFile root://eosuser.cern.ch//$EOS_OUTPUT_DIR 

