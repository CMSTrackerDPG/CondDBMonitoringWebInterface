## cronjob to monitor the SiStrip DB tags
The script cronjob.sh is executed every hour on lxplus. It executes the scripts `MonitorDB_NewDirStructure_KeepTagLinks_generic_V2.sh` both for the pro and dev database (only for the SiStripBadChannel_PCL_* tags and the tags related to the aging studies), `Monitor_GlobalTags_V2.sh` and `Monitor_NoiseRatios_V2.sh`. All those scripts are in the CMSSW package DQM/SiStripMonitorSummary. The output of the cron job is written to a log file in the directory `/afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/cronlog`. During the execution of the script the working directory is `/afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/workingdir_...` and it is cleaned and removed at the end of the execution.
Each instance of the cron writes a lock file to avoid other instances to start in parallel. To check how old is the last update check in the first row of the web interface page or how old the current lock file is by doing (from a lxplus window):
`ls -l /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/cronlog/LockFileTmp`
This lock file contains also the name of the lxplus host where the update is running so that it is possible to check the not yet closed log file. To restart it, simply delete the lock file:
`rm /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/cronlog/LockFileTmp`
Usually the analysis of an IOV in a tag is not redone is the scripts detects that the IOV has already been analyzed previously. To force a fresh analysis (in case, for example, of crashes or missing output files) the root file corresponding to the IOV of the tag has to be deleted by hand. It can be found in:
`/afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/<database>/<db account>/DBTagCollection/<condition type>/<tag name>/rootfiles`
Exceptions are the following condition types:
SiStripLatency for which the LatencyLog/LatencyInfo_Run....txt file has to be deleted
SiStripShiftAndCrosstalk for which the ShiftAndCrosstalkLog/ShiftAndCrosstalkInfo_Run....txt file has to be deleted.
SiStripAPVPhaseOffsets for which the APVPhaseOffsetsLog/APVPhaseOffsetsInfo_Run....txt file has to be deleted.
If the links between a Global Tag and the tags have to be rebuild, it is enough to delete the corresponding Global Tag subdirectory:
`/afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/<database>/GlobalTags/<globaltagname>`

Similar instructions can be found in this twiki page:
https://twiki.cern.ch/twiki/bin/view/CMS/StripTrackerMonitoringCondDb

### `newlymonitored.sh`
It is the script which is executed at the end of each monitoring job. It collects from the log files the information about the newly monitored IOVs, tags and GlobalTags and publish such a list in the web interface site.

