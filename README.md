# CondDBMonitoringWebInterface
This repository contains the code, mainly scripts, and the files which are usually under `/afs/cern.ch/cms/tracker/sistrcalib` and are worth being saved and tracked. 

The `MonitorConditionDB` directory contains the scripts which allow the periodic and automatic monitoring of the condition DB content and the production of the summary plots and files. It relies on a CMSSW working area in `/afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB`, which is NOT backed up in this repository

The `WWW` directory contains the code for three different web interfaces: the browser of the DB condition summary plots and files, the web interface to display the single module noise and pedestal values, the web interface to prepare Tracker Maps and the web interface to retrieve the SiStrip Tracker cabling maps. All but the condition browser execute scripts on the web server which requires a CMSSW working area in `/afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB`. Also in this case the content of those areas is NOT backed up in this repository and it relies on the standard CMSSW git(hub) repository. **NOTA BENE** Since the web server does not know the cvmfs file system these areas have to be afs-based this can be achieved by executing `source /afs/cern.ch/cms/cmsset_default.csh` when the CMSSW working area is created.

More details can be found in the specific README files in the subdirectories.

Happy Reading and please, maintain this for us!
