#!/bin/bash

cd /afs/cern.ch/cms/tracker/sistrcalib/MonitorConditionDB/cronlog

for filename in `find . -name "*.log" -mtime +7`
do
  rm -f $filename
done
