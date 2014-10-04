#!/bin/bash
#
# this script delete a few root files and an few txt files related to one IOV of one tag 
# for each kind of strip condition objects in order to test the machinery to produce the monitoring
# plots and files
#

#SiStripAPVPhaseOffsets
cp /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripAPVPhaseOffsets/SiStripAPVPhaseOffsets_v1_offline/APVPhaseOffsetsLog/APVPhaseOffsetsInfo_Run206510.txt /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/test/.
#
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripAPVPhaseOffsets/SiStripAPVPhaseOffsets_v1_offline/APVPhaseOffsetsLog/APVPhaseOffsetsInfo_Run206510.txt
#SiStripBackPlaneCorrection
cp /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_STRIP_000/DBTagCollection/SiStripBackPlaneCorrection/SiStripBackPlaneCorrection_deco_GR10_v3_offline/plots/TrackerMap/BackPlaneCorrectionTkMap_Run_185189.png /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/test/.
#
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_STRIP_000/DBTagCollection/SiStripBackPlaneCorrection/SiStripBackPlaneCorrection_deco_GR10_v3_offline/rootfiles/SiStripBackPlaneCorrection_deco_GR10_v3_offline_Run_185189.root
# SiStripFedCabling
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripFedCabling/SiStripFedCabling_GR10_v1_hlt/rootfiles/SiStripFedCabling_GR10_v1_hlt_Run_209457.root
# SiStripLatency
cp /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripLatency/SiStripLatency_GR10_v2_hlt/LatencyLog/LatencyInfo_Run211197.txt /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/test/.
#
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripLatency/SiStripLatency_GR10_v2_hlt/LatencyLog/LatencyInfo_Run211197.txt
# SiStripLorentzAngle
cp /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripLorentzAngle/SiStripLorentzAngleDeco_GR10_v2_offline/plots/TrackerMap/LorentzAngleTkMap_Run_185189.png /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/test/.
#
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripLorentzAngle/SiStripLorentzAngleDeco_GR10_v2_offline/rootfiles/SiStripLorentzAngleDeco_GR10_v2_offline_Run_185189.root
# SiStripNoise
cp /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripNoise/SiStripNoise_GR10_v1_hlt/plots/TrackerMap/NoiseTkMap_Run_211725.png /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/test/.
#
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripNoise/SiStripNoise_GR10_v1_hlt/rootfiles/SiStripNoise_GR10_v1_hlt_Run_211725.root
# SiStripPedestal
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripPedestal/SiStripPedestals_GR10_v2_hlt/rootfiles/SiStripPedestals_GR10_v2_hlt_Run_211725.root
# SiStripShitsAndCrosstalk
cp /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripShiftAndCrosstalk/SiStripShiftAndCrosstalk_GR10_v3_offline/ShiftAndCrosstalkLog/ShiftAndCrosstalkInfo_Run185189.txt /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/test/.
#
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripShiftAndCrosstalk/SiStripShiftAndCrosstalk_GR10_v3_offline/ShiftAndCrosstalkLog/ShiftAndCrosstalkInfo_Run185189.txt
# SiStripThreshold
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripThreshold/SiStripThreshold_GR10_v1_hlt/rootfiles/SiStripThreshold_GR10_v1_hlt_Run_211725.root
# SiStripApvGain
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripApvGain/SiStripApvGain_GR10_v1_hlt/rootfiles/SiStripApvGain_GR10_v1_hlt_Run_128408.root
# SiStripBadChannel
cp /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripBadChannel/SiStripBadChannel_FromOfflineCalibration_GR10_v6_offline/plots/TrackerMap/QualityTkMap_Run_209303.png /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/test/.
#
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripBadChannel/SiStripBadChannel_FromOfflineCalibration_GR10_v6_offline/rootfiles/SiStripBadChannel_FromOfflineCalibration_GR10_v6_offline_Run_209303.root
#
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prep/CMS_COND_STRIP/DBTagCollection/SiStripBadChannel/SiStripBadChannel_PCL_v0_prompt/rootfiles/SiStripBadChannel_PCL_v0_prompt_Run_166512.root
# NoiseRatio
cp /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripNoise/NoiseRatios/SiStripNoise_GR10_v1_hlt_SiStripApvGain_GR10_v1_hlt/plots/Run_211725.png /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/test/.
#
rm /afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripNoise/NoiseRatios/SiStripNoise_GR10_v1_hlt_SiStripApvGain_GR10_v1_hlt/rootfiles/SiStripNoise_GR10_v1_hlt_SiStripApvGain_GR10_v1_hlt_Run_211725.root

