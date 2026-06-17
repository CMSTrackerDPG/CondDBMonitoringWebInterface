#!/bin/bash

cd /data/users/event_display/dpgtkdqm/remotescripts/StripCabling/CablingWebInterface
rm ./output/*

partype=$1

if [[ "$partype" == "det" || "$partype" == "Det" ]]
then
  modlist=${2//,/ }  # this will replace all , with a space
  echo $modlist
  #echo "executing ./cablingweb.sh --fu SiStripFedCabling_GR10_v1_hlt/CablingLog/CablingInfo_Run306053.txt -a $modlist --a1 ./output/ourinfomodules.txt --a2 ./output/ourInfoModuleHV.txt --a3 ./output/ourAliasModules.txt --a4 ./output/ouroutDetidsofDetIDtrm.txt --a5 ./output/ourgrafModofdetidtm.png --a6 cualquiercosa"
  #./cablingweb.sh --fu SiStripFedCabling_GR10_v1_hlt/CablingLog/CablingInfo_Run306053.txt -a $modlist --a1 ./output/ourinfomodules.txt --a2 ./output/ourInfoModuleHV.txt --a3 ./output/ourAliasModules.txt --a4 ./output/ouroutDetidsofDetIDtrm.txt --a5 ./output/ourgrafModofdetidtm.png --a6 cualquiercosa
  #option for different colour
  echo "executing ./cablingweb.sh --fu SiStripFedCabling_GR10_v1_hlt/CablingLog/CablingInfo_Run306053.txt -a $modlist --a1 ./output/ourinfomodules.txt --a2 ./output/ourInfoModuleHV.txt --a3 ./output/ourAliasModules.txt --a4 ./output/ouroutDetidsofDetIDtrm.txt --a5 ./output/ourgrafModofdetidtm.png --a6 dc"
  ./cablingweb.sh --fu SiStripFedCabling_GR10_v1_hlt/CablingLog/CablingInfo_Run306053.txt -a $modlist --a1 ./output/ourinfomodules.txt --a2 ./output/ourInfoModuleHV.txt --a3 ./output/ourAliasModules.txt --a4 ./output/ouroutDetidsofDetIDtrm.txt --a5 ./output/ourgrafMod.png --a6 dc
  echo "****************Module Alias************************"
  cat ./output/ourAliasModules.txt

  echo "****************Module HV Info************************"
  cat ./output/ourInfoModuleHV.txt

  echo "****************Cabling Info************************"
  cat ./output/ourinfomodules.txt

  echo ""
  echo "COMPLETED"
  #echo "Cabling map .png shown below!"

  cp ./output/ourgrafMod.png /eos/cms/store/group/tracker-cctrack/www/TrackerMapsReloaded/files/data/users/event_display/StripCablingMaps/CablingMap_DetID.png
  echo "Cabling map .png shown here: https://tkmaps.web.cern.ch/tkmaps/files/data/users/event_display/StripCablingMaps/CablingMap_DetID.png"

elif [[ "$partype" == "fed" || "$partype" == "Fed"  ]]
then
  fedlist=${2//,/ }  # this will replace all , with a space
  echo $fedlist
  echo "executing ./cablingweb.sh --fu SiStripFedCabling_GR10_v1_hlt/CablingLog/CablingInfo_Run306053.txt -b FedId --bi $fedlist --b1 ./output/ourinfofeds.txt --b2 ./output/ourModofCab.txt --b3 ./output/ouroutDetidsofFedstrm.txt --b4 ./output/ourgrafModofCabtm.png --b5 ./output/ourAliasforCabling_.txt --b6 ./output/ourhvofcab.txt --a6 cualquiercosa"
  ./cablingweb.sh --fu SiStripFedCabling_GR10_v1_hlt/CablingLog/CablingInfo_Run306053.txt -b FedId --bi $fedlist --b1 ./output/ourinfofeds.txt --b2 ./output/ourModofCab.txt --b3 ./output/ouroutDetidsofFedstrm.txt --b4 ./output/ourgrafMod.png --b5 ./output/ourAliasforCabling.txt --b6 ./output/ourhvofcab.txt --a6 cualquiercosa
  echo "****************Fed Info************************"
  cat ./output/ourinfofeds.txt
  echo "****************Mod Info************************"
  cat ./output/ourModofCab.txt
  echo "****************Detid Info************************"
  cat ./output/ourModofCab.tx
  echo "****************Det id of Fed Info**************************"
  cat ./output/ouroutDetidsofFedstrm.txt
  echo "****************Alias Info************************"
  cat ./output/ourAliasforCabling.txt
  echo "****************HV Info************************"
  cat ./output/ourhvofcab.txt
  
  echo ""
  echo "COMPLETED"
  #echo "Cabling map .png shown below!"

  cp ./output/ourgrafMod.png /eos/cms/store/group/tracker-cctrack/www/TrackerMapsReloaded/files/data/users/event_display/StripCablingMaps/CablingMap_DetID.png
  echo "Cabling map .png shown here: https://tkmaps.web.cern.ch/tkmaps/files/data/users/event_display/StripCablingMaps/CablingMap_DetID.png"
  
fi
