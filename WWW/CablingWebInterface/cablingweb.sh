#!/bin/bash

# export SCRAM_ARCH=slc6_amd64_gcc491
# #export SCRAM_ARCH=slc5_amd64_gcc481
# source /afs/cern.ch/cms/cmsset_default.sh

# cd /afs/cern.ch/work/j/jmejiagu/public/servcice_work/andresa_trackermap/nuevo_printrackermap/CMSSW_7_5_0_pre2/src
# #cd /afs/cern.ch/work/j/jmejiagu/public/servcice_work/andresa_trackermap/CMSSW_7_0_4/src
# eval `scramv1 runtime -sh`

# cd $OLDPWD

source /cvmfs/cms.cern.ch/cmsset_default.sh
#export SCRAM_ARCH=slc6_amd64_gcc700

export SCRAM_ARCH=slc6_amd64_gcc630
RELEASE_PATH=/data/users/CMSSWWEB/CMSSW_10_0_4

#RELEASE_PATH=/cvmfs/cms.cern.ch/slc6_amd64_gcc700/cms/cmssw/CMSSW_10_1_0

cd $RELEASE_PATH/src
eval `scramv1 runtime -sh`

cd $OLDPWD
echo $PWD

export CMSSW_RELEASE_BASE=$RELEASE_PATH
echo $CMSSW_RELEASE_BASE




./cablingweb.py $1 $2 $3 $4 $5 $6 $7 $8 $9 ${10} ${11} ${12} ${13} ${14} ${15} ${16} ${17} ${18} ${19} ${20} ${21} ${22} ${23} ${24} ${25} ${26} ${27} ${28} ${29} ${30} ${31} ${32} ${33} ${34} ${35} ${36} ${37} ${38} ${39} ${40} ${41} ${42} ${43} ${44} ${45} ${46} ${47} ${48} ${49} 2>&1
