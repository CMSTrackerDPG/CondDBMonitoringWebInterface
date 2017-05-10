#!/usr/bin/env python

import sqlalchemy
import sqlalchemy.ext.declarative
from datetime import datetime
import os
import sys
import argparse
import traceback
import smtplib
from email.mime.text import MIMEText

from CondCore.Utilities.o2olib import O2ORun
sqlalchemy_tpl = 'oracle://%s:%s@%s'


mailfrom = 'trk.o2o@cern.ch'
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

def get_credentials(authFile):
    with open(authFile) as f:
        import ast
        infos = ast.literal_eval(f.read())
    return infos['Prod']

def connect(auth):
    url = sqlalchemy_tpl % (auth['user'], auth['password'], auth['db_name'])
    engine = sqlalchemy.create_engine(url)
    session = sqlalchemy.orm.scoped_session(sqlalchemy.orm.sessionmaker(bind=engine))
    return session

def checkJobs(args):
    auth = get_credentials(args.authFile)
    sess = connect(auth)
    msg = ''
    is_ok = True
    for job_name in args.jobnames.strip().split(','):
        last_time = sess.query(O2ORun.start_time).filter_by(job_name=job_name, status_code=0).order_by(sqlalchemy.desc(O2ORun.start_time)).first()
        msg += job_name + ': ' + str(last_time)
        if last_time:
            delta = datetime.now() - last_time[0]
            if delta.seconds > 7200:
                is_ok = False
                msg += ' -- %d seconds too old!' % delta.seconds
        msg += '\n'
    print msg
    if not is_ok:
        sendMail('[Warning] DCS O2O job check FAILED', msg, sendlogto, mailfrom)


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Check DCS O2O jobs')
    parser.add_argument('-n', '--jobnames',
        default='SiStripDetVOff_1hourDelay,SiStripDetVOff_13hourDelay,SiStripDetVOff_prompt',
        help='O2O job names to check'
    )
    parser.add_argument('--authFile',
        default='/afs/cern.ch/cms/DB/conddb/readOnly.json',
        help='auth file'
    )
    args = parser.parse_args()
    
    try:
        checkJobs(args)
    except Exception:
        tr = traceback.format_exc()
        sendMail(subject='[Warning] DCS O2O job check error',
                        message=traceback.format_exc(),
                        send_to=sendlogto,
                        send_from = mailfrom)
        raise

