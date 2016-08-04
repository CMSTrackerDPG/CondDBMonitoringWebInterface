#!/usr/bin/env python

import csv
import os
import argparse
import traceback
import smtplib
from email.mime.text import MIMEText

hvfilename = 'HVOff_table_last.csv'
lvfilename = 'LVOff_table_last.csv'
mailfrom = 'trk.o2o@cern.ch'
# mailto = ['huilin.qu@cern.ch', 'arun.kumar@cern.ch', 'sandro.di.mattia@cern.ch', 'erik.butz@cern.ch', 'cms-tracker-offline-shiftleader@cern.ch', 'Gaelle.Boudoul@cern.ch', 'Jean-Laurent.Agram@cern.ch']
sendlogto = ['trk.o2o@cern.ch']

def sendMail(subject, message, send_to, send_from):
    '''Send an email. [send_to] needs to be a list.'''
    msg = MIMEText(message)
    msg['Subject'] = subject
    msg['From'] = send_from
    msg['To'] = ', '.join(send_to)
    s = smtplib.SMTP('localhost')
    s.sendmail(send_from, send_to, msg.as_string())
    s.quit()

def diff(A, B):
    a, b = (A, B) if len(A)<=len(B) else (B, A)
    for key in a:
        if key not in b:
            return ' '.join([key, a[key]])
        elif a[key]!='' and b[key]!='' and a[key]!=b[key]:
            return ' '.join([key, a[key], b[key]])
    return None

def checkFile(filename):
    tag1hr = {}
    tag13hr = {}
    tag25hr = {}
    with open(filename, 'rb') as f:
        reader = csv.reader(f)
        firstrow = True
        for row in reader:
            if firstrow: 
                firstrow = False
                continue
            tag1hr[row[0]] = row[2]
            tag13hr[row[0]] = row[3]
            tag25hr[row[0]] = row[4]
    d1 = diff(tag1hr, tag13hr)
    d2 = diff(tag13hr, tag25hr)
    if d1 or d2:
        msg = '\n'.join([filename,str(d1),str(d2)])
        print msg
        sendMail('[Warning] DCS O2O Discrepancy', msg, sendlogto, mailfrom)
    
if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Check DCS O2O')
    parser.add_argument('csvdir',
        metavar='FILEDIR',
        help='Directory of csv files'
    )
    args = parser.parse_args()
    
    try:
        checkFile(os.path.join(args.csvdir, hvfilename))
        checkFile(os.path.join(args.csvdir, lvfilename))
    except Exception:
        tr = traceback.format_exc()
        sendMail(subject='[Warning] DCS O2O Discrepancy', 
                        message=traceback.format_exc(),
                        send_to=sendlogto,
                        send_from = mailfrom)
        raise

