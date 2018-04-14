This script give information on the cabling of the detector, it takes a s input a run number (or an IOV), a DB tag, plus a list of objects (which can be detId, FEDid, aliases, etc.) and give in output a TkMap with the selected objects and a collection of txt files with detailed information on detId connected to those objects.

The web interface collects the input arguments for the cablingweb.sh script which setup a CMSSW release and run the cablingweb.py script.
If any problem appear in the output (i.e missing logs,and/or TkMap). Most probably is needed to update the CMSSW release "behind the scene". The first try is to create a new release in /data/users/CMSSWWEB/ adding the package CalibTracker/SiStripDCS (compile with scam b). At the moment the release name is to be changed in any occurrence inside the cablingweb.sh and cablingweb.py scripts.

If this doesn't solve the problem, please run python cablingweb.py and look to the error message you get there.