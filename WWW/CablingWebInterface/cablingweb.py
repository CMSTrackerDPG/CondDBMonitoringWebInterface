#!/usr/bin/env python
import re
import urllib
import urllib2
import pickle
import os
import sys
from optparse import OptionParser
import random


#this function implemets callback to make the optpars able to take several arguments for each option##
def cb(option, opt_str, value, parser):
    args=[]
    for arg in parser.rargs:
        if arg[0] != "-":
            args.append(arg)
        else:
            del parser.rargs[:len(args)]
            break
    if getattr(parser.values, option.dest):
        args.extend(getattr(parser.values, option.dest))
    setattr(parser.values, option.dest, args)

def getLatestCabling():
   cabfile = ""
   url = "https://test-stripdbmonitor.web.cern.ch/"
   path = "test-stripdbmonitor/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripFedCabling/SiStripFedCabling_GR10_v1_hlt/CablingLog/"
   pattern = '<a href="CablingInfo_Run.*?">(.*?)</a>'
   response = urllib2.urlopen(url+path).read()
   for filename in re.findall(pattern, response):
      cabfile = filename
   print cabfile
   return cabfile


#def filenameF(name):
#    suffix='CablingInfo_Run'
#    filenameX=suffix+name+'.txt'
#    url="https://test-stripdbmonitor.web.cern.ch/test-stripdbmonitor/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripFedCabling/SiStripFedCabling_GR10_v1_hlt/CablingLog/"
#    urllib.urlretrieve(url+filenameX,filenameX)
#    return filenameX


def filenameF(name):
    suffix='CablingInfo_Run'
    filenameX=suffix+name+'.txt'
    location = '/afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/pro/CMS_CONDITIONS/DBTagCollection/SiStripFedCabling/SiStripFedCabling_GR10_v1_hlt/CablingLog/'
    #location = '/afs/cern.ch/user/j/jmejiagu/www/cablingfiles-bak/'
    #complete_route = location + filenameX
    #os.system (('cp %s .') % (complete_route))
    return location + filenameX 



#def semilinkF(namelink):
#
#    pattern=re.split('/',namelink)
#    filelink=pattern[-1]

#    url="https://test-stripdbmonitor.web.cern.ch/test-stripdbmonitor/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripFedCabling/"
#    urllib.urlretrieve(url+namelink,filelink)
#    return filelink

def semilinkF(namelink):
#        pattern = re.split('/', namelink)
#        filenameX = pattern[-1]
        location ='/afs/cern.ch/cms/tracker/sistrcalib/WWW/CondDBMonitoring/pro/CMS_CONDITIONS/DBTagCollection/SiStripFedCabling/'
        #location = '/afs/cern.ch/user/j/jmejiagu/www/cablingfiles-bak/'
        #complete_route = location + filenameX
        #os.system (('cp %s .') % (complete_route))
#        return location + filenameX 
        return location + namelink                                                                                                                                             
def filepsu():
       filepsu.fname=str('file'+str(random.randrange(1,10**6))+'.txt')
       return filepsu.fname
###this function makes a dictionary of Detids(with pairnumber as secondkey) and a dictionary of FEDs (with FecCH as second key) for the cabling file 
def DictionaryCab(filenameC,options):
    """This function takes a filename as input and looks for it in the URL, then makes a dictionary with DetId as key and pairnumber as key2 or FEDid as key1 and FedCh as key2"""
    FiletxtFEDs = open(filenameC,'r')

    Fd = "FedCrate/FedSlot/FedId/FeUnit/FeChan/FedCh"
    Fc = "FecCrate/FecSlot/FecRing/CcuAddr/CcuChan"
    D = "DcuId/DetId"
    Ll = "LldChan/APV0/APV1"
    pair = "pairNumber/nPairs/nStrips"
    DC = "DCU/MUX/PLL/LLD"
 
    DictionaryCab.CablingInfoDict={}		
    CablingInfoDictF={}
    # Creating lists
    FedCrateList = []
    FedSlotList = []
    FedIdList=[]
    FeUnitList=[]
    FeChanList=[]
    FedChList=[]
		
    FecCrateList=[]
    FecSlotList=[]
    FecRingList=[]
    CcuAddrList=[]
    CcuChanList=[]
		
    DcuIdList=[]
    DetIdList=[]
		
    LldChanList=[]
    APV0List=[]
    APV1List=[]
    pairNumberList=[]
    nPairsList=[]
    nStripsList=[]
		
    DCUList=[]
    MUXList=[]
    PLLList=[]
    LLDList=[]


    for line in FiletxtFEDs:
        if Fd in line:
            pattern = re.split('\W+',line)
            FedCrateList.append(pattern[7])
            FedSlotList.append(pattern[8])
            FedIdList.append(pattern[9])
            FeUnitList.append(pattern[10])
            FeChanList.append(pattern[11])
            FedChList.append(pattern[12])
        if Fc in line:
            pattern = re.split('\W+',line)
            FecCrateList.append(pattern[6])
            FecSlotList.append(pattern[7])
            FecRingList.append(pattern[8])
            CcuAddrList.append(pattern[9])
            CcuChanList.append(pattern[10])
        if D in line:
            pattern = re.split('\W+',line)
            DcuIdList.append(str(int(pattern[3],16)))
            DetIdList.append(str(int(pattern[4],16)))
        if Ll in line:
            pattern = re.split('\W+',line)
            LldChanList.append(pattern[4])
            APV0List.append(pattern[5])
            APV1List.append(pattern[6])
        if pair in line:
            pattern = re.split('\W+',line)
            pairNumberList.append(pattern[4])
            nPairsList.append(pattern[5])
            nStripsList.append(pattern[6])
        if DC in line:
            pattern = re.split('\W+',line)
            DCUList.append(pattern[6])
            MUXList.append(pattern[7])
            PLLList.append(pattern[8])
            LLDList.append(pattern[9])
        		
    
    for fedcrate,fedslot,fedid,feunit,fechan,fedch,feccrate,fecslot,fecring,ccuaddr,ccuchan,dcuid,detid,lldchan,apv0,apv1,pairnumber,npairs,nstrips,dcu,mux,pll,lld  in zip(FedCrateList,FedSlotList,FedIdList,FeUnitList,FeChanList,FedChList,FecCrateList,FecSlotList,FecRingList,CcuAddrList,CcuChanList,DcuIdList,DetIdList,LldChanList,APV0List,APV1List,pairNumberList,nPairsList,nStripsList,DCUList,MUXList,PLLList,LLDList):

        if detid in DictionaryCab.CablingInfoDict.keys(): 
            DictionaryCab.CablingInfoDict[detid].update({pairnumber:{"FedCrate": fedcrate,"FedSlot":fedslot,"FedId":fedid,"FeUnit":feunit,"FeChan":fechan,"FedCh":fedch,"FecCrate":feccrate,"FecSlot":fecslot,"FecRing":fecring,"CcuAddr":ccuaddr,"CcuChan":ccuchan,"DcuId":dcuid,"DetId":detid,"pairNumber":pairnumber,"LldChan":lldchan,"APV0":apv0,"APV1":apv1,"nPairs":npairs,"nStrips":nstrips,"DCU":dcu,"MUX":mux,"PLL":pll,"LLD":lld}})
		
        else:
            DictionaryCab.CablingInfoDict.update({detid:{pairnumber:{"FedCrate": fedcrate,"FedSlot":fedslot,"FedId":fedid,"FeUnit":feunit,"FeChan":fechan,"FedCh":fedch,"FecCrate":feccrate,"FecSlot":fecslot,"FecRing":fecring,"CcuAddr":ccuaddr,"CcuChan":ccuchan,"DcuId":dcuid,"DetId":detid,"pairNumber":pairnumber,"LldChan":lldchan,"APV0":apv0,"APV1":apv1,"nPairs":npairs,"nStrips":nstrips,"DCU":dcu,"MUX":mux,"PLL":pll,"LLD":lld}}})
       
      
    for fedcrate, fedslot, fedid, feunit, fechan, fedch, feccrate, fecslot, fecring, ccuaddr, ccuchan, dcuid, detid, lldchan, apv0, apv1, pairnumber, npairs, nstrips, dcu, mux, pll, lld in zip(FedCrateList, FedSlotList, FedIdList, FeUnitList, FeChanList, FedChList, FecCrateList, FecSlotList, FecRingList, CcuAddrList, CcuChanList, DcuIdList, DetIdList, LldChanList, APV0List, APV1List, pairNumberList, nPairsList, nStripsList, DCUList, MUXList, PLLList, LLDList): 
  
                        
        if fedid in CablingInfoDictF.keys(): 
            CablingInfoDictF[fedid].update({fedch:{"FedCrate": fedcrate,"FedSlot":fedslot,"FedId":fedid,"FeUnit":feunit,"FeChan":fechan,"FedCh":fedch,"FecCrate":feccrate,"FecSlot":fecslot,"FecRing":fecring,"CcuAddr":ccuaddr,"CcuChan":ccuchan,"DcuId":dcuid,"DetId":detid,"pairNumber":pairnumber,"LldChan":lldchan,"APV0":apv0,"APV1":apv1,"nPairs":npairs,"nStrips":nstrips,"DCU":dcu,"MUX":mux,"PLL":pll,"LLD":lld}})
               
        else:
            CablingInfoDictF.update({fedid:{fedch:{"FedCrate": fedcrate,"FedSlot":fedslot,"FedId":fedid,"FeUnit":feunit,"FeChan":fechan,"FedCh":fedch,"FecCrate":feccrate,"FecSlot":fecslot,"FecRing":fecring,"CcuAddr":ccuaddr,"CcuChan":ccuchan,"DcuId":dcuid,"DetId":detid,"pairNumber":pairnumber,"LldChan":lldchan,"APV0":apv0,"APV1":apv1,"nPairs":npairs,"nStrips":nstrips,"DCU":dcu,"MUX":mux,"PLL":pll,"LLD":lld}}})
    
    


############THESE INSTRUCTIONS ARE FOR GETTING THE INFO OF THE DICTIONARY FOR THE CABLING FILE#############################3

    #dump the detids of the cabling file in a txt file and a trackermap of the modules of the cabling
    
    if options.aldet1:
        archi1=open(options.aldet1,'w')
        archi2=open(options.aldet2,'w')
         
        archi2.write('For file %s \n\n'%filenameC)
        [archi1.write(p+" "+"0"+" "+ "250"+" "+"0"+"\n") for p in DictionaryCab.CablingInfoDict]
        archi2.write("DetIds\n")
        [archi2.write(p+"\n") for p in DictionaryCab.CablingInfoDict]
        archi1.close()
        archi2.close()
        os.system(('print_TrackerMap %s "TrackerMap" %s 2400 False False 999 -999 True')%(options.aldet1,options.aldet3))
        print "a file named %s and a tracker map %s named  have been created" % (options.aldet2,options.aldet3)
    
   
    
    #Info about a (set of) module(s)
    if  options.lismod:
        li1=options.lismod
        txtmod=open(options.det1,'w')
        dculist=[]
        cb=DictionaryCab.CablingInfoDict
        for i in li1:
            if i in cb:
                txtmod.write("\n\n For DetID : %s \n" %i) 
                for j in cb[i]:
                    cbp=cb[i][j]
                    if  (cbp["DcuId"]) not in dculist:
                        dculist.append(cbp["DcuId"])
                        txtmod.write("\n"+"DcuId"+cbp["DcuId"]+"/DetId"+cbp["DetId"]+"/nPairs"+cbp["nPairs"]+"/nStrips"+cbp["nStrips"]+"/FecCrate"+cbp["FecCrate"]+"/FecSlot"+cbp["FecSlot"]+"/FecRing"+cbp["FecRing"]+"/CcuAddr"+cbp["CcuAddr"]+"/CcuCh"+cbp["CcuChan"])
                
                    txtmod.write("\n"+"/FedCrate"+cbp["FedCrate"]+"/FedSlot"+cbp["FedSlot"]+"/FedId"+cbp["FedId"]+"/FeUnit"+cbp["FeUnit"]+"/FeChan"+cbp["FeChan"]+"/FedCh"+cbp["FedCh"]+"/LldChan"+cbp["LldChan"]+"/APV0-"+cbp["APV0"]+"/APV1-"+cbp["APV1"])
            
        print("A file named %s  has been created"%options.det1)



###Tracker map of some modules
    if options.lismod:
        li5=options.lismod
        archim=open(options.det4,'w')
        
        color_list=[" 0 255 0"," 0 0 255"," 255 0 0"," 255 255 0"," 255 0 255"," 0 255 255"," 0 102 0"," 102 0 102"," 47 79 79"," 255 140 0"]
        if options.det6=="dc":
            for p in li5:
                if p in DictionaryCab.CablingInfoDict:
                    archim.write(p+" "+color_list[li5.index(p)]+"\n")
                else:
                    archim.write(p+" "+" 255 153 255"+"\n")
        else:
            for p in li5:
                if p in  DictionaryCab.CablingInfoDict:
                    archim.write(p+" "+" 0 0 255"+"\n") 
                else:
                    archim.write(p+" "+" 255 153 255"+"\n")
        archim.close()
        
        os.system(('print_TrackerMap %s  "TrackerMap" %s 2400 False False 999 -999 True')%(options.det4,options.det5))
        print "A trackermap named %s has been created" %options.det5    
        #archim.close 



    #info about a (set of) Fed(s)
    if options.lisfetrc1:
        cf=CablingInfoDictF
        lif1=options.lisfetrc2
        txtfe=open(options.fe1,'w')
       
        is_slash= True 
    
        diclisc1={}
        diclisc2={}
        lichan=[]
        cb=DictionaryCab.CablingInfoDict
        if options.lisfetrc1=="FedId":
            for sin in lif1:
                patt =re.split("/",sin)
                if (len(patt)==2):
                     
                    diclisc1["FedId"]=patt[0]
                    diclisc1["FeUnit"]=patt[1]
                    txtfe.write("\n---------For FedId%s/FeUnit%s:---------\n\n"%(patt[0],patt[1]))
                    for l in cb:
                        flag=True
                        for x in cb[l].keys():
                            cbi=cb[l][x]
                            dit="FedCrate"+cbi["FedCrate"]+"/FedSlot"+cbi["FedSlot"]+"/FeUnit"+cbi["FeUnit"]+"/FeChan"+cbi["FeChan"]+"/FecCrate"+cbi["FecCrate"]+"/FecSlot"+cbi["FecSlot"]+"/FecRing"+cbi["FecRing"]+"/CcuAddr"+cbi["CcuAddr"]+"/CcuChan"+cbi["CcuChan"]+"/DcuId"+cbi["DcuId"]+"/DetId"+cbi["DetId"]+"/LldChan"+cbi["LldChan"]+"/APV0-"+cbi["APV0"]+"/APV1"+cbi["APV1"]+"\n"
                            for j,k in zip(diclisc1.keys(),diclisc1.values()):
                                if cb[l][x][j]!=k:
                                    flag=False
                            if flag:
                                #lichan.append(dit)
                                #print lichan
                                txtfe.write(dit)               
        
                if (len(patt)>2):
                    diclisc2["FedId"]=patt[0]
                    diclisc2["FeUnit"]=patt[1]
                    diclisc2["FeChan"]=patt[2]
                    txtfe.write("\n---------For FedId%s/FeUnit%s/FeChan%s:---------\n\n"%(patt[0],patt[1],patt[2]))
                    for l in cb:
                        for x in cb[l]:
                            cbi=cb[l][x]
                            if (cb[l][x]["FedId"]==patt[0] and cb[l][x]["FeUnit"]==patt[1]) and cb[l][x]["FeChan"]==patt[2]:
                                txtfe.write("FedCrate"+cbi["FedCrate"]+"/FedSlot"+cbi["FedSlot"]+"/FeUnit"+cbi["FeUnit"]+"/FeChan"+cbi["FeChan"]+"/FecCrate"+cbi["FecCrate"]+"/FecSlot"+cbi["FecSlot"]+"/FecRing"+cbi["FecRing"]+"/CcuAddr"+cbi["CcuAddr"]+"/CcuChan"+cbi["CcuChan"]+"/DcuId"+cbi["DcuId"]+"/DetId"+cbi["DetId"]+"/LldChan"+cbi["LldChan"]+"/APV0-"+cbi["APV0"]+"/APV1"+cbi["APV1"]+"\n")         
            

                if (len(patt) ==1 ):
                
                    patt=re.split("_",sin)
                    if len(patt)==2:
                        is_slash =False
                        txtfe.write("\n---------For FedId:%s/FedCh%s:---------\n\n"%(patt[0],patt[1]))
                        for l in cb:
	                    for x in cb[l]:
			        cfb=cb[l][x]
		                if cfb["FedId"]==patt[0] and cfb["FedCh"]==patt[1]:
						
                                    txtfe.write("FedCrate"+cfb["FedCrate"]+"/FedSlot"+cfb["FedSlot"]+"/FeUnit"+cfb["FeUnit"]+"/FeChan"+cfb["FeChan"]+"/FecCrate"+cfb["FecCrate"]+"/FecSlot"+cfb["FecSlot"]+"/FecRing"+cfb["FecRing"]+"/CcuAddr"+cfb["CcuAddr"]+"/CcuChan"+cfb["CcuChan"]+"/DcuId"+cfb["DcuId"]+"/DetId"+cfb["DetId"]+"/LldChan"+cfb["LldChan"]+"/APV0-"+cfb["APV0"]+"/APV1"+cfb["APV1"]+"\n")


                    if len(patt)==1:
                        txtfe.write("\n--------For FedId:%s--------\n\n"%(patt[0]))
                        for l in cb:
                            for x in cb[l]:
                                cfb=cb[l][x]
			        if cfb["FedId"]==patt[0]:
                                    txtfe.write("FedCrate"+cfb["FedCrate"]+"/FedSlot"+cfb["FedSlot"]+"/FeUnit"+cfb["FeUnit"]+"/FeChan"+cfb["FeChan"]+"/FecCrate"+cfb["FecCrate"]+"/FecSlot"+cfb["FecSlot"]+"/FecRing"+cfb["FecRing"]+"/CcuAddr"+cfb["CcuAddr"]+"/CcuChan"+cfb["CcuChan"]+"/DcuId"+cfb["DcuId"]+"/DetId"+cfb["DetId"]+"/LldChan"+cfb["LldChan"]+"/APV0-"+cfb["APV0"]+"/APV1"+cfb["APV1"]+"\n")
                                     
                   

        if options.lisfetrc1=="FecCrate":
            for son in lif1:
                patt=re.split("/",son)
                dcuset1=[]
                if (len(patt)==1):
                    txtfe.write("---------For DetIds with FecCrate %s:---------\n"%patt[0])
                    for i in cb:
                        for j in cb[i]:
                            cbp=cb[i][j]
                            if cbp["FecCrate"]==patt[0] and cbp["DcuId"] not in dcuset1:
                         
                                dcuset1.append(cbp["DcuId"])
                                txtfe.write("\n\n"+"DcuId"+cbp["DcuId"]+"/DetId"+cbp["DetId"]+"/nPairs"+cbp["nPairs"]+"/nStrips"+cbp["nStrips"]+"/FecCrate"+cbp["FecCrate"]+"/FecSlot"+cbp["FecSlot"]+"/FecRing"+cbp["FecRing"]+"/CcuAddr"+cbp["CcuAddr"]+"/CcuCh"+cbp["CcuChan"]+"\n")
                
                            txtfe.write("/FedCrate"+cbp["FedCrate"]+"/FedSlot"+cbp["FedSlot"]+"/FedId"+cbp["FedId"]+"/FeUnit"+cbp["FeUnit"]+"/FeChan"+cbp["FeChan"]+"/FedCh"+cbp["FedCh"]+"/LldChan"+cbp["LldChan"]+"/APV0-"+cbp["APV0"]+"/APV1-"+cbp["APV1"]+"\n")

                if (len(patt)==2):
                    #diclisc1["FecCrate"]=patt[0]
                    #diclisc1["FecSlot"]=patt[1]
	            dcuset2=[]
                    txtfe.write("---------For FecCrate %s/FecSlot %s:---------\n"%(patt[0],patt[1]))
                    for i in cb:
                        for j in cb[i]:
                            cbp=cb[i][j]
                            if (cbp["FecCrate"]==patt[0] and cbp["FecSlot"]==patt[1]):# and cbp["DcuId"] not in dcuset2):
                              #  dcuset2.append(cbp["DcuId"])
                              #  dcuset2.append(prom)
                                txtfe.write("\n\n"+"DcuId"+cbp["DcuId"]+"/DetId"+cbp["DetId"]+"/nPairs"+cbp["nPairs"]+"/nStrips"+cbp["nStrips"]+"/FecCrate"+cbp["FecCrate"]+"/FecSlot"+cbp["FecSlot"]+"/FecRing"+cbp["FecRing"]+"/CcuAddr"+cbp["CcuAddr"]+"/CcuCh"+cbp["CcuChan"]+"\n")
                                txtfe.write("/FedCrate"+cbp["FedCrate"]+"/FedSlot"+cbp["FedSlot"]+"/FedId"+cbp["FedId"]+"/FeUnit"+cbp["FeUnit"]+"/FeChan"+cbp["FeChan"]+"/FedCh"+cbp["FedCh"]+"/LldChan"+cbp["LldChan"]+"/APV0-"+cbp["APV0"]+"/APV1-"+cbp["APV1"]+"\n")
                                    #for alg in dcuset2:
                                    #txtfe.write()
                if (len(patt)==3):
	            
                    txtfe.write("---------For FecCrate %s/FecSlot %s/FecRing %s:---------\n"%(patt[0],patt[1],patt[2]))
                    for i in cb:
                        for j in cb[i]:
                            cbp=cb[i][j]
                            if (cbp["FecCrate"]==patt[0] and cbp["FecSlot"]==patt[1] and cbp["FecRing"]==patt[2]  ):
                                txtfe.write("\n\n"+"DcuId"+cbp["DcuId"]+"/DetId"+cbp["DetId"]+"/nPairs"+cbp["nPairs"]+"/nStrips"+cbp["nStrips"]+"/FecCrate"+cbp["FecCrate"]+"/FecSlot"+cbp["FecSlot"]+"/FecRing"+cbp["FecRing"]+"/CcuAddr"+cbp["CcuAddr"]+"/CcuCh"+cbp["CcuChan"]+"\n")
                                txtfe.write("/FedCrate"+cbp["FedCrate"]+"/FedSlot"+cbp["FedSlot"]+"/FedId"+cbp["FedId"]+"/FeUnit"+cbp["FeUnit"]+"/FeChan"+cbp["FeChan"]+"/FedCh"+cbp["FedCh"]+"/LldChan"+cbp["LldChan"]+"/APV0-"+cbp["APV0"]+"/APV1-"+cbp["APV1"]+"\n")
                if (len(patt)==4):
	         
                    txtfe.write("---------For FecCrate %s/FecSlot %s/FecRing %s/CcuAddr %s:---------\n"%(patt[0],patt[1],patt[2],patt[3]))
                    for i in cb:
                        for j in cb[i]:
                            cbp=cb[i][j]
                            if (cbp["FecCrate"]==patt[0] and cbp["FecSlot"]==patt[1] and cbp["FecRing"]==patt[2] and cbp["CcuAddr"]==patt[3]):
                                txtfe.write("\n\n"+"DcuId"+cbp["DcuId"]+"/DetId"+cbp["DetId"]+"/nPairs"+cbp["nPairs"]+"/nStrips"+cbp["nStrips"]+"/FecCrate"+cbp["FecCrate"]+"/FecSlot"+cbp["FecSlot"]+"/FecRing"+cbp["FecRing"]+"/CcuAddr"+cbp["CcuAddr"]+"/CcuCh"+cbp["CcuChan"]+"\n")
                                txtfe.write("/FedCrate"+cbp["FedCrate"]+"/FedSlot"+cbp["FedSlot"]+"/FedId"+cbp["FedId"]+"/FeUnit"+cbp["FeUnit"]+"/FeChan"+cbp["FeChan"]+"/FedCh"+cbp["FedCh"]+"/LldChan"+cbp["LldChan"]+"/APV0-"+cbp["APV0"]+"/APV1-"+cbp["APV1"]+"\n")
                                                    
                if (len(patt)==5):
	         
                    txtfe.write("---------For FecCrate %s/FecSlot %s/FecRing %s/CcuAddr %s/CcuChan %s:---------\n"%(patt[0],patt[1],patt[2],patt[3],patt[4]))
                    for i in cb:
                        for j in cb[i]:
                            cbp=cb[i][j]
                            if (cbp["FecCrate"]==patt[0] and cbp["FecSlot"]==patt[1] and cbp["FecRing"]==patt[2] and cbp["CcuAddr"]==patt[3] and cbp["CcuChan"]==patt[4]):
                                txtfe.write("\n\n"+"DcuId"+cbp["DcuId"]+"/DetId"+cbp["DetId"]+"/nPairs"+cbp["nPairs"]+"/nStrips"+cbp["nStrips"]+"/FecCrate"+cbp["FecCrate"]+"/FecSlot"+cbp["FecSlot"]+"/FecRing"+cbp["FecRing"]+"/CcuAddr"+cbp["CcuAddr"]+"/CcuCh"+cbp["CcuChan"]+"\n")
                                txtfe.write("/FedCrate"+cbp["FedCrate"]+"/FedSlot"+cbp["FedSlot"]+"/FedId"+cbp["FedId"]+"/FeUnit"+cbp["FeUnit"]+"/FeChan"+cbp["FeChan"]+"/FedCh"+cbp["FedCh"]+"/LldChan"+cbp["LldChan"]+"/APV0-"+cbp["APV0"]+"/APV1-"+cbp["APV1"]+"\n")
                                                    
                                                          
        print("A file named %s has been created"%options.fe1)
        
    
   #modules associated to something and a trkm
    if options.lisfetrc1:
        lif2=options.lisfetrc1
        lif3=options.lisfetrc2
        txtc3=open(options.fe2,'w')
        txtc1=open(options.fe3,'w')
        txtc2=open(options.fe4,'w')

      #  lisc1=[list() for x in range(len(lif3))]
        lisf1=[]
        lisf2=[]
      
        is_slash= True 
        color_list=[" 0 255 0"," 0 0 255"," 255 0 0"," 255 255 0"," 255 0 255"," 0 255 255"," 0 102 0"," 102 0 102"," 47 79 79"," 255 140 0"]

        diclisc1={}
        diclisc2={}
        cb=DictionaryCab.CablingInfoDict

        if options.lisfetrc1=="FedId":
            for sin in lif3:
               
                patt =re.split("/",sin)
                if (len(patt)==2):
                     
                    diclisc1["FedId"]=patt[0]
                    diclisc1["FeUnit"]=patt[1]
                    for l in cb:
                        flag=True
                        for x in cb[l].keys():
                            cbi=cb[l][x]
                            dit=cbi["DetId"]+"\n"
                            for j,k in zip(diclisc1.keys(),diclisc1.values()):
                                if cb[l][x][j]!=k:
                                    flag=False
                        if flag:
                                 
                                lisf1.append(cb[l][x]["DetId"]+color_list[lif3.index(sin)])
                                lisf2.append(cb[l][x]["DetId"]+" FedId:"+cb[l][x]["FedId"]+" FeUnit:"+cb[l][x]["FeUnit"])

        
                if (len(patt)>2):
                    diclisc2["FedId"]=patt[0]
                    diclisc2["FeUnit"]=patt[1]
                    diclisc2["FeChan"]=patt[2]
                    for l in cb:
                        for x in cb[l]:
                            cbi=cb[l][x]
                            if (cb[l][x]["FedId"]==patt[0] and cb[l][x]["FeUnit"]==patt[1] and cb[l][x]["FeChan"]==patt[2]):
                                lisf1.append(cbi["DetId"]+color_list[lif3.index(sin)])

                                lisf2.append(cbi["DetId"]+" FedId:"+cb[l][x]["FedId"]+" FeUnit"+cb[l][x]["FeUnit"]+" FeChan"+cb[l][x]["FeChan"])


                if (len(patt) ==1 ):
                
                    pot=re.split("_",sin)
                    if len(pot)==2:
                        is_slash =False
                        for l in cb:
	                    for x in cb[l]:
			        cfb=cb[l][x]
		                if cfb["FedId"]==pot[0] and cfb["FedCh"]==pot[1]:
                                        lisf1.append(cfb["DetId"]+color_list[lif3.index(sin)])
                                        lisf2.append(cfb["DetId"]+" FedId:"+cb[l][x]["FedId"]+" FedCh:"+cb[l][x]["FedCh"])



                    if len(pot)==1:
                        for l in cb:
                            for x in cb[l]:
                                cfb=cb[l][x]
			        if  cfb["FedId"]==pot[0] :
                                    lisf1.append(cfb["DetId"]+color_list[lif3.index(sin)])
                                    lisf2.append(cfb["DetId"]+" FedId:"+cb[l][x]["FedId"])
            lisf1n=[]
            lisf2n=[]
            
            for y in lisf2:
                if y not in lisf2n:
                    lisf2n.append(y)
                    txtc3.write(y+"\n")
            txtc3.close()

            for x in lisf1:
                if x not in lisf1n:
                    lisf1n.append(x)
                    txtc1.write(x+"\n")
            txtc1.close()
            os.system(('print_TrackerMap %s  "TrackerMap" %s 2400 False False 999 -999 True')%(options.fe3,options.fe4))
          

        if options.lisfetrc1=="FecCrate":
            dculis1=[]
            dculis2=[]
	    for sun in lif3:
                patt2=re.split("/",sun)
                if (len(patt2)==1):
                    for i in cb:
                        for j in cb[i]:
                            cbp=cb[i][j]
                            if cbp["FecCrate"]==patt2[0] :
                         
                                dculis1.append(cbp["DetId"]+color_list[lif3.index(sun)])
                                dculis2.append(cbp["DetId"]+"  FecCrate:"+cb[i][j]["FecCrate"])

                if (len(patt2)==2):
                    for i in cb:
                        for j in cb[i]:
                            cbp=cb[i][j]
                            if cbp["FecCrate"]==patt2[0] and cbp["FecSlot"]==patt2[1]:
                                dculis1.append(cbp["DetId"]+color_list[lif3.index(sun)])
                                dculis2.append(cbp["DetId"]+"  FecCrate:"+cb[i][j]["FecCrate"]+"  FecSlot:"+cb[i][j]["FecSlot"]) 

                if (len(patt2)==3):
                    for i in cb:
                        for j in cb[i]:
                            cbp=cb[i][j]
                            if cbp["FecCrate"]==patt2[0] and cbp["FecSlot"]==patt2[1] and cbp["FecRing"]==patt2[2]:
                                dculis1.append(cbp["DetId"]+color_list[lif3.index(sun)])
                                dculis2.append(cbp["DetId"]+"  FecCrate:"+cb[i][j]["FecCrate"]+"  FecSlot:"+cb[i][j]["FecSlot"]+ " FecRing:"+cb[i][j]["FecRing"])
 
                if (len(patt2)==4):
                    for i in cb:
                        for j in cb[i]:
                            cbp=cb[i][j]
                            if cbp["FecCrate"]==patt2[0] and cbp["FecSlot"]==patt2[1] and cbp["FecRing"]==patt2[2] and cbp["CcuAddr"]==patt2[3] :
                                dculis1.append(cbp["DetId"]+color_list[lif3.index(sun)])                                                                                                               
                                dculis2.append(cbp["DetId"]+"  FecCrate:"+cb[i][j]["FecCrate"]+"  FecSlot:"+cb[i][j]["FecSlot"]+" FecRing:"+cb[i][j]["FecRing"]+"  CcuAddr:"+cb[i][j]["CcuAddr"])

                if (len(patt2)==5):
                    for i in cb:
                        for j in cb[i]:
                            cbp=cb[i][j]
                            if cbp["FecCrate"]==patt2[0] and cbp["FecSlot"]==patt2[1] and cbp["FecRing"]==patt2[2] and cbp["CcuAddr"]==patt2[3] and cbp["CcuChan"]==patt2[4]:
                                dculis1.append(cbp["DetId"]+color_list[lif3.index(sun)])
                    
                                dculis2.append(cbp["DetId"]+"  FecCrate:"+cb[i][j]["FecCrate"]+"  FecSlot:"+cb[i][j]["FecSlot"]+" FecRing:"+cb[i][j]["FecRing"]+"  CcuAddr:"+cb[i][j]["CcuAddr"]+"  CcuChan:"+cb[i][j]["CcuChan"])
                                
            dculis1n=[] 
            dculis2n=[]
            for am in dculis2:
                if am not in dculis1n:
                    dculis1n.append(am)
                    txtc3.write(am+"\n")
            txtc3.close()

            
            for ad in dculis1:
                if ad not in dculis2n:
                    dculis2n.append(ad)
                    txtc1.write(ad+"\n")
            txtc1.close()
            os.system(('print_TrackerMap %s  "TrackerMap" %s 2400 False False 999 -999 True')%(options.fe3,options.fe4))

                
                      
       
        print("A trackermap named %s has been created and a file named %s"%(options.fe4,options.fe2))
        
        """
        lisc1=[set() for x in range(len(lif3))]
        #setl=set([])
        listl=[]


        for sin in lif3:
            patt=re.split('/' ,sin)
            if (len(patt)==1 and patt[0] not in listl):
                patt=re.split("_",sin)
                listl.append(patt[0])
                #setl.add(patt[0])
           # setl.add(patt[0])
            if patt[0] not in listl:
                listl.append(patt[0])

        for i,y in zip(listl,lisc1):
            for l in DictionaryCab.CablingInfoDict:
                for m in DictionaryCab.CablingInfoDict[l]:
                    if DictionaryCab.CablingInfoDict[l][m][lif2]==i:
                        y.add(l)
        
    
        color_list=[" 0 255 0"," 0 0 255"," 255 0 0"," 255 255 0"," 255 0  255"," 0 255 255"," 0 102 0"," 102 0 102"," 47 79 79"," 255 140 0"]
        for i,x in zip(listl,lisc1):
            txtc1.write("The modules with %s:%s are:\n"%(lif2,i))
            for y in x:
                txtc1.write(y+"\n")
                txtc2.write(y+color_list[listl.index(i)]+"\n")
        txtc1.close()
        txtc2.close()
        variable =""
        color_list = ["green","blue","red","yellow","magenta","light blue","dark green","purple","grey","orange"]
        for i,j in zip (listl,color_list):
            variable+='%s=%s  ' % (i,j)
        os.system('print_TrackerMap %s "Trackermap" %s  2400 False False 999 -999 True' % (options.fe3,options.fe4))
      
        print "A file named %s and a trackermap named %s with the info have been created"%(options.fe2,options.fe4)
        """
        
    
    
   ###Properties of cabling with modules in common and a trkm 
      

    return DictionaryCab
####################3THESE INSTRUCTIONS ARE FOR GETTING THE INFO OF THE ALIAS ######################
def AliasFun(filenameC,options,AliasDict):
    FileAliasD=open(filenameC,'r')
    D="DcuId/DetId"
    DetIdAlList=[]
    for line1 in FileAliasD:
        if D in line1:
            pattern1 = re.split('\W+',line1)
            if (int(pattern1[4],16)) not in DetIdAlList:
                DetIdAlList.append(int(pattern1[4],16))
    AliasFun.SAliasDict={}
    for detID in DetIdAlList:
        beta1 = AliasDict[int(detID)] 
        AliasFun.SAliasDict.update({int(detID):beta1})
    
  
  
####THE NEXT FUNCTIONS ARE FOR GETTING THE INFO OF THE HV#########


#function to extract the Detids of the cabling file in a txt file
def DetIdCabL(filenameC,verbose=True):                                                 
    """This function takes a filename as input and looks for it in URL ... ,
    it parses all detIDs and dumps them in a local file named detIdCab.txt""" 
    FileCabList = open(filenameC,'r')
    D = "DcuId/DetId" 
    DetIdCabList = []
    for line1 in FileCabList:                                                                                                           
        if D in line1:
            pattern1 = re.split('\W+',line1)
            if (int(pattern1[4],16)) not in DetIdCabList:
                DetIdCabList.append(int(pattern1[4],16))  
    
    return DetIdCabList
 
#function to make a PSUName file of the cabling file

def CabHVFiles(fileCab,fileHV,verbose=True):
    sep = " "
    d = {}
    for line in  open(fileHV, "r"):
        key, val = line.strip().split(sep)
        d[key] = val

    OutFile=open('/tmp/'+filepsu.fname,'w')
    for detID in fileCab:
        OutFile.write("%s %s\n" % (detID,d[str(detID)]))

#function to make the dictionary of the psuname file of the cabling file

def HVInfoDictF(filenameC,filename, options):
    FiletxtHV = open(filename,'r')
    HVInfoDictF.HVInfoDict = {}
    DetIdList = []
    PSUList = []
    CmstrkList = []
    TrackerSyList= []
    BranchList = []
    CrateList = []
    BoardList = []
    ChannelList = []
    for line2 in FiletxtHV:
        if "cms_trk" in line2 :
            pattern1 = re.split(' ',line2)
            DetIdList.append(pattern1[0])
            PSUList.append(pattern1[1].split("\n")[0])
            pattern2 = re.split('/',pattern1[1])
            CmstrkList.append(pattern2[0])
            TrackerSyList.append(pattern2[1])
            BranchList.append(pattern2[2])
            CrateList.append(pattern2[3])
            BoardList.append(pattern2[4])     
            ChannelList.append(pattern2[5].split("\n")[0])
    for xc in range(len(ChannelList)):
        
        if ChannelList[xc]=="channel003":
            ChannelList[xc]="HV1"
        else:
            ChannelList[xc]="HV0"
    
    for detid,psu,cmstrk,trackersy,branch,crate,board,channel in zip(DetIdList,PSUList,CmstrkList,TrackerSyList,BranchList,CrateList,BoardList,ChannelList):
        HVInfoDictF.HVInfoDict.update({detid:{'PSUName':psu,'Cmstrk':cmstrk,'TrackerSY':trackersy,'Branch':branch,'Crate':crate,'Board':board,'Channel':channel}})
    
   
    ###here are the stuff that the code provides
    #Info for all modules of cabling file
    if options.aldet1:
        txtps=open(options.aldet5,'w')
	txtps.write("PsuName of all DetIDs for file %s\n"%filenameC)
	for x in DetIdList:
	    txtps.write(x+" "+HVInfoDictF.HVInfoDict[x]["PSUName"]+"("+HVInfoDictF.HVInfoDict[x]["Channel"]+")"+"\n")
        print "A file named %s has been created"%options.aldet5  


    #info about a module
    if options.lismod: 
        li1=options.lismod 
        txtmhv=open(options.det2,'w')
        for i in li1:
            if i in HVInfoDictF.HVInfoDict:
                txtmhv.write("For DetId %s:\n" %i)
                txtmhv.write(" PSUName is: %s(%s) \n" % (HVInfoDictF.HVInfoDict[i]["PSUName"],HVInfoDictF.HVInfoDict[i]["Channel"]))
           
        print "A file named %s has been created"%options.det2

   #######A file with the modules associated to some values and a tracker map
  
    #a file with the modules associated to some values simmultaneously and a trkm 
    if options.vatrcm:
        txthvcomtkm = open(options.ps1,'w')
        txthvcom = open(options.ps2,'w')
        lihv2=options.vatrcm
    
        txthvcom.write("The modules in common for values: ")
        [txthvcom.write("%s, "%x) for x in lihv2]
    
        foundKeys = set()
        HV = HVInfoDictF.HVInfoDict
        for key in HV:
            flag = True
            for property in lihv2:
                if property not in HV[key].values():
                    flag = False
            if flag:
                foundKeys.add(key)

        for x in foundKeys:
            txthvcom.write("\n"+x)
            txthvcomtkm.write(x+" "+ "0"+" "+"255"+" "+"0"+"\n")
        txthvcom.close() 
        txthvcomtkm.close() 
        
        variable =""
        for i in lihv2:
            variable+='%s  ' % (i)
        os.system('print_TrackerMap %s "Trackermap" %s 2400 False False 999 -999 True'%(options.ps1,options.ps3))
        print "A file named %s with the modules in common for the hv info introduced has been created and a trackermap named %s have been created" %(options.ps2,options.ps3)
      
##########HERE WE INTRODUCE THE OPTIONS FOR THE INFO#######################33
if __name__ == "__main__":
    verbose = True
    usage = "useage: %prog [options] "
    parser = OptionParser(usage)
    parser.set_defaults(mode="advanced")
    parser.add_option("-f", "--file", type="string", dest="filenameC", help="Write the run of the cabling file")
    parser.add_option("--fu", "--fileu", type="string", dest="fileurl", help="write the link to the cabling file beggining with: SiStripFedCabling_...CablingInfoRun_X.txt")

    #############these options are fot getting the info of the cabling file####################################
 

    #################options#################
    parser.add_option("-a","--modul",action="callback", callback=cb, dest="lismod", help="Information about a(some) module(s),write the modules")

    parser.add_option("--a1","--dets1",type="string", dest="det1", help="name of file: cabling info of detids")
    parser.add_option("--a2","--dets2",type="string", dest="det2", help="name of file:  psuname of detids")
    parser.add_option("--a3","--dets3",type="string", dest="det3", help="name of file: alias of detids")
    parser.add_option("--a4","--dets4",type="string", dest="det4", help="name of file: txt for trackermap")
    parser.add_option("--a5","--dets5",type="string", dest="det5", help="name of file: trackermap png")
    parser.add_option("--a6","--dets6",type="string", dest="det6", help="same color for detids if -sc- ")

    #----------------------------------
    parser.add_option("-b","--data1",type="string", dest="lisfetrc1", help="Info for Fed or Fecs")
    parser.add_option("--bi","--data2",action="callback", callback=cb, dest="lisfetrc2", help="Write the numbers of Fec or Fed")

    parser.add_option("--b1","--fed1",type="string", dest="fe1", help=" name of file with info of Feds/Fecs")
    parser.add_option("--b2","--fed2",type="string", dest="fe2", help=" name of file with modules of Feds/Fecs") 
    parser.add_option("--b3","--fed3",type="string", dest="fe3", help=" name of file for trackermap")
    parser.add_option("--b4","--fed4",type="string", dest="fe4", help=" name of png trackermap") 
    parser.add_option("--b5","--fed5",type="string", dest="fe5", help=" name of file with alias of feds/fecs modules")
    parser.add_option("--b6","--fed6",type="string", dest="fe6", help=" name of file with psunames of feds/fecs modules")
    #--------------------------
    parser.add_option("-y","--altk",action="callback",callback=cb,dest="alitkm",help="write the alias where of you want a trackermap of detids associated to those alias")
    parser.add_option("--y1","--als1",type="string", dest="al1", help="name of file for trackermap")
    parser.add_option("--y2","--als2",type="string", dest="al2", help="name of file with modules")
    parser.add_option("--y3","--als3",type="string", dest="al3", help="name of png trackermap ")
    parser.add_option("--y4","--als4",type="string", dest="al4", help="name of file with cabling info of alias modules")
    parser.add_option("--y5","--als5",type="string", dest="al5", help="name of file with psuname of alias modules ")
                  
    #----------------------------------
    parser.add_option("-v","--trvac",action="callback",callback=cb,dest="vatrcm",help="Trackermap of the modules of certain values")
    parser.add_option("--v1","--psu1",type="string", dest="ps1", help="name of file for trackerma")
    parser.add_option("--v2","--psu2",type="string", dest="ps2", help="name of file with modules")
    parser.add_option("--v3","--psu3",type="string", dest="ps3", help="name of png trakermap ")
    parser.add_option("--v4","--psu4",type="string", dest="ps4", help="name of file with alias of psuname modules ")
    parser.add_option("--v5","--psu5",type="string", dest="ps5", help="name of file with cabling info of psuname modules ")
    #--------------------------
    parser.add_option("--c1","--ald1",type="string", dest="aldet1", help="name of file for trackermap")
    parser.add_option("--c2","--ald2",type="string", dest="aldet2", help="name of file of all detids")
    parser.add_option("--c3","--ald3",type="string", dest="aldet3", help="name of trackermap")
    parser.add_option("--c4","--ald4",type="string", dest="aldet4", help="name of the file of all detids alias")
    parser.add_option("--c5","--ald5",type="string", dest="aldet5", help="name of the file of all detids psuname")
 
     
     
     
    


    
    
    

    (options, args) = parser.parse_args()



    if (options.filenameC is None and options.fileurl is None):
        url = "https://test-stripdbmonitor.web.cern.ch/"
        path = "test-stripdbmonitor/CondDBMonitoring/cms_orcoff_prod/CMS_COND_31X_STRIP/DBTagCollection/SiStripFedCabling/SiStripFedCabling_GR10_v1_hlt/CablingLog/"
        cablingfile = getLatestCabling()
        urllib.urlretrieve(url+path+cablingfile,cablingfile)
        
        ourdictionary=DictionaryCab(cablingfile,options)
        #options.filenameC = cablingfile

#FF        StripDetIDAliasDict=pickle.load(open(os.getenv("CMSSW_RELEASE_BASE")+"/src/CalibTracker/SiStripDCS/data/StripDetIDAlias.pkl"))
        StripDetIDAliasDict=pickle.load(open("/data/users/CMSSWWEB/CMSSW_10_0_4/src/CalibTracker/SiStripDCS/data/StripDetIDAlias.pkl"))
        MyAlias=AliasFun(cablingfile,options,StripDetIDAliasDict)

        MyCabList=DetIdCabL(cablingfile)

        fileHV1='/data/users/CMSSWWEB/CMSSW_10_0_4/src/CalibTracker/SiStripDCS/data/StripPSUDetIDMap_BeforeJan132010.dat'
#FF        fileHV1='/afs/cern.ch/cms/slc6_amd64_gcc481/cms/cmssw/CMSSW_7_0_4/src/CalibTracker/SiStripDCS/data/StripPSUDetIDMap_BeforeJan132010.dat' 
        Myfilepsu=filepsu()

        MyCabHV=CabHVFiles(MyCabList,fileHV1,Myfilepsu)
        input5='/tmp/'+filepsu.fname
        MyHVDict = HVInfoDictF(cablingfile,input5, options)

    

    #########HERE ALL THE FUNCTIONS ARE CALLED 
    if options.filenameC:
        MyFilename=filenameF(options.filenameC)
    
    ## for the alias
#FF        StripDetIDAliasDict=pickle.load(open(os.getenv("CMSSW_RELEASE_BASE")+"/src/CalibTracker/SiStripDCS/data/StripDetIDAlias.pkl"))
        StripDetIDAliasDict=pickle.load(open("/data/users/CMSSWWEB/CMSSW_10_0_4/src/CalibTracker/SiStripDCS/data/StripDetIDAlias.pkl"))
        MyAlias=AliasFun(MyFilename,options,StripDetIDAliasDict)

  
    ##for the dictionary of the cabling file
        ourdictionary=DictionaryCab(MyFilename,options)
     ##for the HV
        MyCabList=DetIdCabL(MyFilename)
        fileHV1='/data/users/CMSSWWEB/CMSSW_10_0_4/src/CalibTracker/SiStripDCS/data/StripPSUDetIDMap_BeforeJan132010.dat'
#FF        fileHV1='/afs/cern.ch/cms/slc6_amd64_gcc481/cms/cmssw/CMSSW_7_0_4/src/CalibTracker/SiStripDCS/data/StripPSUDetIDMap_BeforeJan132010.dat' 
        Myfilepsu=filepsu()
        MyCabHV=CabHVFiles(MyCabList,fileHV1,Myfilepsu)
        input5='/tmp/'+filepsu.fname
        MyHVDict = HVInfoDictF(MyFilename,input5, options)
   

    if options.fileurl:

        Mylink=semilinkF(options.fileurl)
            
    ## for the alias
#FF        StripDetIDAliasDict=pickle.load(open(os.getenv("CMSSW_RELEASE_BASE")+"/src/CalibTracker/SiStripDCS/data/StripDetIDAlias.pkl"))
        StripDetIDAliasDict=pickle.load(open("/data/users/CMSSWWEB/CMSSW_10_0_4/src/CalibTracker/SiStripDCS/data/StripDetIDAlias.pkl"))

        MyAlias=AliasFun(Mylink,options,StripDetIDAliasDict)

  
    ##for the dictionary of the cabling file
        ourdictionary=DictionaryCab(Mylink,options)
     ##for the HV
        MyCabList=DetIdCabL(Mylink)
        fileHV1='/data/users/CMSSWWEB/CMSSW_10_0_4/src/CalibTracker/SiStripDCS/data/StripPSUDetIDMap_BeforeJan132010.dat'     
#FF        fileHV1='/afs/cern.ch/cms/slc6_amd64_gcc481/cms/cmssw/CMSSW_7_0_4/src/CalibTracker/SiStripDCS/data/StripPSUDetIDMap_BeforeJan132010.dat'
        Myfilepsu=filepsu()
        MyCabHV=CabHVFiles(MyCabList,fileHV1,Myfilepsu)
        input5='/tmp/'+filepsu.fname
        MyHVDict = HVInfoDictF(Mylink,input5, options)
   

####These options are to get information from one source to another ###########
    #A file with the alias of the detids of the cabling file   
    if options.aldet1:
        beta1=""
        txtalscab=open(options.aldet4,'w')
        for detID in AliasFun.SAliasDict.keys():
            beta1 = str(AliasFun.SAliasDict[int(detID)])
            txtalscab.write("%s  %s %s \n"  %(detID,beta1.split("'")[1],HVInfoDictF.HVInfoDict[str(detID)]["Channel"]))
        print "A file named %s with the alias of all cabling file modules has been created"%options.aldet4   
   



    #A tracker map of the modules associated to some alias
    if options.alitkm:
        txtalstkm=open(options.al1,'w')
        txtals=open(options.al2,'w')
        lials=options.alitkm
        color_list=[" 0 255 0"," 0 0 255"," 255 0 0"," 255 255 0"," 255 0  255"," 0 255 255"," 0 102 0"," 102 0 102"," 47 79 79"]
        for k in lials:
            txtals.write("For Alias %s, the DetIds associated are:\n" % k)
            for detid in  AliasFun.SAliasDict.keys():
                beta=str(AliasFun.SAliasDict[detid])
                if k in beta:
                    txtalstkm.write(str(detid)+color_list[lials.index(k)]+"\n")
                    txtals.write(str(detid)+"  "+beta.split("'")[1]+"  "+HVInfoDictF.HVInfoDict[str(detid)]["Channel"]+"\n")
        
        txtalstkm.close()
        color_list = ["green","blue","red","yellow","magenta","light blue","dark green","purple","grey"]
        variable =""

        
        for i,j in zip (lials,color_list):
            variable+='%s=%s  ' % (i,j)
        os.system('print_TrackerMap %s "Tracker map" %s 2400 False False 999 -999 True' % (options.al1,options.al3))
        print "A file and a trackermap named %s and %s have been created"%(options.al2,options.al3)
  
    #the alias of a (set of) module(s)     
    if options.lismod:
        txtmals=open(options.det3,'w')      
        for i in options.lismod:
            if i in str( AliasFun.SAliasDict):
                beta2= str(AliasFun.SAliasDict[int(i)])
                txtmals.write("%s  %s %s\n" %(i,beta2.split("'")[1],HVInfoDictF.HVInfoDict[i]["Channel"]))
        print "A file named %s has been created"%options.det3
    


           #####To know the alias of modules with certain info of the cabling file  
    if options.lisfetrc1: 
        lif4=options.lisfetrc1
        lif5=options.lisfetrc2
        txtfals=open(options.fe5,'w')
        
        is_slash= True 
        diclist1={}
	diclist2={}
   
        cb=DictionaryCab.CablingInfoDict
        if options.lisfetrc1=="FedId":
            for sin in lif5:
                patt =re.split("/",sin)
                if (len(patt)==2):
                    set1=set([])
                    diclist1["FedId"]=patt[0]
                    diclist1["FeUnit"]=patt[1]
                    txtfals.write("\n---------For FedId%s/FeUnit%s:---------\n\n"%(patt[0],patt[1]))
                    for l in cb:
                        flag=True
                        for x in cb[l].keys():
                            cbi=cb[l][x]
                            if (cbi["FedId"]==patt[0] and cbi["FeUnit"]==patt[1]):
			        set1.add(l)
		    for x in set1:
	                beta=str(AliasFun.SAliasDict[int(x)]).split("'")[1]
                        txtfals.write(x+"  "+beta+" "+HVInfoDictF.HVInfoDict[x]["Channel"]+"\n")
                   
                            
                 
        
                if (len(patt)>2):
		    set2=set([])
                    diclist2["FedId"]=patt[0]
                    diclist2["FeUnit"]=patt[1]
                    diclist2["FeChan"]=patt[2]
                    txtfals.write("\n---------For FedId%s/FeUnit%s/FeChan%s:---------\n\n"%(patt[0],patt[1],patt[2]))
                    for l in cb:
                        for x in cb[l]:
                            cbi=cb[l][x]
                            if ((cb[l][x]["FedId"]==patt[0] and cb[l][x]["FeUnit"]==patt[1]) and cb[l][x]["FeChan"]==patt[2]):
			        set2.add(l)
                    for x in set2:
                        beta=str(AliasFun.SAliasDict[int(x)]).split("'")[1]
                        txtfals.write(x+"  "+beta+" "+HVInfoDictF.HVInfoDict[x]["Channel"]+"\n")
                           
            

                if (len(patt) ==1 ):
                    set3=set([])
                    patt=re.split("_",sin)
                    if len(patt)==1:
                        txtfals.write("\n--------For FedId:%s--------\n\n"%(patt[0]))
                        for l in cb:
                            for x in cb[l]:
                                cfb=cb[l][x]
	                        if cfb["FedId"]==patt[0]:
	                            set3.add(l)
                        for x in set3:
                            beta=str(AliasFun.SAliasDict[int(x)]).split("'")[1]
                            txtfals.write(x+"  "+beta+" "+HVInfoDictF.HVInfoDict[x]["Channel"]+"\n")
                         
                           
                                     
                    if len(patt)==2:
                        set4=set([])
                        is_slash =False
                        txtfals.write("\n---------For FedId:%s/FedCh%s:---------\n\n"%(patt[0],patt[1]))
                        for l in cb:
	                    for x in cb[l]:
			        cbf=cb[l][x]
	                        if cbf["FedId"]==patt[0] and cbf["FedCh"]==patt[1]:
	                            set4.add(l)
                        for x in set4:
                    
                            beta=str(AliasFun.SAliasDict[int(x)]).split("'")[1]
                            txtfals.write(x+"  "+beta+" "+HVInfoDictF.HVInfoDict[x]["Channel"]+"\n")

        if options.lisfetrc1=="FecCrate":
            
            for san in lif5:
                pat=re.split("/",san)
                if (len(pat)==1):
                    sel1=set([])    
                    txtfals.write("---------For DetIds with FecCrate %s:---------\n"%(pat[0]))
                    for i in cb:
	                for j in cb[i]:
                            cbf=cb[i][j]
                            if cbf["FecCrate"]==pat[0]:
	                        sel1.add(i)
                    for x in sel1:	
	                    
                        beta=str(AliasFun.SAliasDict[int(x)]).split("'")[1]
                        txtfals.write(x+"  "+beta+" "+HVInfoDictF.HVInfoDict[x]["Channel"]+"\n")  
  
                if (len(pat)==2):
                    sel2=set([])    
                    txtfals.write("---------For DetIds with FecCrate %s/FecSlot %s:---------\n"%(pat[0],pat[1]))
                    for i in cb:
	                for j in cb[i]:
                            cbf=cb[i][j]
                            if (cbf["FecCrate"]==pat[0] and  cbf["FecSlot"]==pat[1]):
	                        sel2.add(i)
                    for x in sel2:	
	                    
                        beta=str(AliasFun.SAliasDict[int(x)]).split("'")[1]
                        txtfals.write(x+"  "+beta+" "+HVInfoDictF.HVInfoDict[x]["Channel"]+"\n")    
                if (len(pat)==3):
                    sel3=set([])    
                    txtfals.write("---------For DetIds with FecCrate %s/FecSlot %s/FecRing %s:---------\n"%(pat[0],pat[1],pat[2]))
                    for i in cb:
	                for j in cb[i]:
                            cbf=cb[i][j]
                            if (cbf["FecCrate"]==pat[0] and  cbf["FecSlot"]==pat[1] and cbf["FecRing"]==pat[2]):
	                        sel3.add(i)
                    for x in sel3:	
	                    
                        beta=str(AliasFun.SAliasDict[int(x)]).split("'")[1]
                        txtfals.write(x+"  "+beta+" "+HVInfoDictF.HVInfoDict[x]["Channel"]+"\n") 
                if (len(pat)==4):
                    sel4=set([])    
                    txtfals.write("---------For DetIds with FecCrate %s/FecSlot %s/FecRing %s/CcuAddr %s:---------\n"%(pat[0],pat[1],pat[2],pat[3]))
                    for i in cb:
	                for j in cb[i]:
                            cbf=cb[i][j]
                            if (cbf["FecCrate"]==pat[0] and  cbf["FecSlot"]==pat[1] and cbf["FecRing"]==pat[2] and cbf["CcuAddr"]==pat[3]):
	                        sel4.add(i)
                    for x in sel4:	
	                    
                        beta=str(AliasFun.SAliasDict[int(x)]).split("'")[1]
                        txtfals.write(x+"  "+beta+" "+HVInfoDictF.HVInfoDict[x]["Channel"]+"\n")
                if (len(pat)==5):
                    sel5=set([])    
                    txtfals.write("---------For DetIds with FecCrate %s/FecSlot %s/FecRing %s/CcuAddr %s/CchChan %s:---------\n"%(pat[0],pat[1],pat[2],pat[3],pat[4]))
                    for i in cb:
	                for j in cb[i]:
                            cbf=cb[i][j]
                            if (cbf["FecCrate"]==pat[0] and  cbf["FecSlot"]==pat[1] and cbf["FecRing"]==pat[2] and cbf["CcuAddr"]==pat[3] and cbf["CcuChan"]==pat[4]):
	                        sel5.add(i)
                    for x in sel5:	
	                    
                        beta=str(AliasFun.SAliasDict[int(x)]).split("'")[1]
                        txtfals.write(x+"  "+beta+" "+HVInfoDictF.HVInfoDict[x]["Channel"]+"\n")          
                                          
        print "A txt file named %s has been created"%options.fe5
    
    
   ########To know the alias of modulos with certain info of the HV######
    if options.vatrcm:
        lihv3=options.vatrcm
        txthvals=open(options.ps4,'w')

        ale = set()
        HV = HVInfoDictF.HVInfoDict
        for key in HV:
            flag = True
            for property in lihv3:
                if property not in HV[key].values():
                    flag = False
            if flag:
                ale.add(key)
        txthvals.write("For modules with ")
        for property in lihv3:
            txthvals.write(property+"/")
        for k in ale:
            
            beta=str(AliasFun.SAliasDict[int(k)]) 
            txthvals.write( "\n%s  %s  %s " %(k,beta.split("'")[1],HVInfoDictF.HVInfoDict[k]["Channel"]))
                    
        print "A file named %s with the alias of modules with hv info introduced has been created" %options.ps4
    

    
           ################To know the cabling info of modules with certain alias
    if options.alitkm:
        lials1=options.alitkm
        
        txt=open(options.al4,'w') 
        beta3=""
        listx=[list() for x in range(len(lials1))]
        listals=[set() for y in range(len(lials1))]
        listc=[list() for y in range(len(lials1))]
        for i,kset in zip(lials1,listals):
            for j in AliasFun.SAliasDict:
                beta3 = str(AliasFun.SAliasDict[j])
                if i in beta3:
                    kset.add(j)
            
        for k,xset,lset,lset2 in zip(lials1,listals,listx,listc):
            txt.write("\n For DetIds with Alias %s:\n\n"%k)
            for key in xset:
                for m in DictionaryCab.CablingInfoDict[str(key)]:
                    for l in DictionaryCab.CablingInfoDict[str(key)][m]:
                        cbm=DictionaryCab.CablingInfoDict[str(key)][m]
                        if (str(key)) not in lset:
                            lset.append(str(key))
                            txt.write("\n\n"+cbm["DetId"]+"    DcuId"+cbm["DcuId"]+"/nPairs"+cbm["nPairs"]+"/nStrips"+cbm["nStrips"]+"/FecCrate"+cbm["FecCrate"]+"/FecSlot"+cbm["FecSlot"]+"/FecRing"+cbm["FecRing"]+"/CcuAddr"+cbm["CcuAddr"]+"/CcuCh"+cbm["CcuChan"])
           
                        ins="\n"+"/FedCrate"+cbm["FedCrate"]+"/FedSlot"+cbm["FedSlot"]+"/FedId"+cbm["FedId"]+"/FeUnit"+cbm["FeUnit"]+"/FeChan"+cbm["FeChan"]+"/FedCh"+cbm["FedCh"]+"/LldChan"+cbm["LldChan"]+"/APV0-"+cbm["APV0"]+"/APV1-"+cbm["APV1"]
                        if (ins not in lset2):
                            lset2.append(ins)
                            txt.write(ins)
         
        print "A file named %s has been created"%options.al4
    
    
         ########### to know hv info of modules with certain alias##########################
    if options.alitkm:

        lials2=options.alitkm
        txtalshv=open(options.al5,'w') 
        beta=""
        list1=[]
        for i in lials2:
            txtalshv.write("For modules with Alias %s: \n"%i)
            for k in AliasFun.SAliasDict:
                beta = str(AliasFun.SAliasDict[k])
                if i in beta:
                    list1.append(k)
                    txtalshv.write("%s %s(%s)\n"%(str(k),HVInfoDictF.HVInfoDict[str(k)]["PSUName"],HVInfoDictF.HVInfoDict[str(k)]["Channel"]))
        print "A txt file %s with the psuname of DetIds has been created"%options.al5

    
         ################# to know hv info of modules with certain cabling info
    
    
    if options.lisfetrc1:
        lif6=options.lisfetrc1
        lif7=options.lisfetrc2

        txtfhv=open(options.fe6,'w') 
        diclisp1={}
	diclisp2={}
        cb=DictionaryCab.CablingInfoDict
        if options.lisfetrc1=="FedId":
            for sin in lif7:
                patt =re.split("/",sin)
                if (len(patt)==2):
                    set1=set([])
                    diclisp1["FedId"]=patt[0]
                    diclisp1["FeUnit"]=patt[1]
                    txtfhv.write("\n---------For FedId%s/FeUnit%s:---------\n\n"%(patt[0],patt[1]))
                    for l in cb:
                        flag=True
                        for x in cb[l].keys():
                            cbi=cb[l][x]
                            if (cbi["FedId"]==patt[0] and cbi["FeUnit"]==patt[1]):
			        set1.add(l)
		    for x in set1:
	           
                        txtfhv.write(x+" "+HVInfoDictF.HVInfoDict[str(x)]["PSUName"]+"("+HVInfoDictF.HVInfoDict[str(x)]["Channel"]+")"+"\n")

                            
                 
        
                if (len(patt)>2):
		    set2=set([])
                    diclisp2["FedId"]=patt[0]
                    diclisp2["FeUnit"]=patt[1]
                    diclisp2["FeChan"]=patt[2]
                    txtfhv.write("\n---------For FedId%s/FeUnit%s/FeChan%s:---------\n\n"%(patt[0],patt[1],patt[2]))
                    for l in cb:
                        for x in cb[l]:
                            cbi=cb[l][x]
                            if (cb[l][x]["FedId"]==patt[0] and cb[l][x]["FeUnit"]==patt[1]) and cb[l][x]["FeChan"]==patt[2]:
			        set2.add(l)
                    for x in set2:
                        txtfhv.write(x+" "+HVInfoDictF.HVInfoDict[str(x)]["PSUName"]+"("+HVInfoDictF.HVInfoDict[str(x)]["Channel"]+")"+"\n")

            

                if (len(patt) ==1 ):
                    set3=set([])
                    patt=re.split("_",sin)
                    if len(patt)==1:
                        txtfhv.write("\n--------For FedId:%s--------\n\n"%(patt[0]))
                        for l in cb:
                            for x in cb[l]:
                                cfb=cb[l][x]
	                        if cfb["FedId"]==patt[0]:
	                            set3.add(l)
                        for x in set3:
                       
                            txtfhv.write(x+" "+HVInfoDictF.HVInfoDict[str(x)]["PSUName"]+"("+HVInfoDictF.HVInfoDict[str(x)]["Channel"]+")"+"\n")

                           
                                     
                    if len(patt)==2:
                        set4=set([])
                        is_slash =False
                        txtfhv.write("\n---------For FedId:%s/FedCh%s:---------\n\n"%(patt[0],patt[1]))
                        for l in cb:
	                    for x in cb[l]:
			        cbf=cb[l][x]
	                        if (cbf["FedId"]==patt[0] and cbf["FedCh"]==patt[1]):
	                            set4.add(l)
                        for x in set4:
                             txtfhv.write(x+" "+HVInfoDictF.HVInfoDict[str(x)]["PSUName"]+"("+HVInfoDictF.HVInfoDict[str(x)]["Channel"]+")"+"\n")


        if options.lisfetrc1=="FecCrate":
            for sen in lif7:
                pin=re.split("/",sen)
                if len(pin)==1:
                    ser1=set([])
	            txtfhv.write("---------For DetIds with FecCrate %s:---------\n"%pin[0])
                    for i in cb:
	                for j in cb[i]:
                            cbf=cb[i][j]
                            if cbf["FecCrate"]==pin[0]:
	                        ser1.add(i)
                    for y in ser1:
                        txtfhv.write(y+" "+HVInfoDictF.HVInfoDict[str(y)]["PSUName"]+"("+HVInfoDictF.HVInfoDict[str(y)]["Channel"]+")"+"\n")

                if len(pin)==2:
                    ser2=set([])
	            txtfhv.write("---------For DetIds with FecCrate %s/FecSlot %s:---------\n"%(pin[0],pin[1]))
                    for i in cb:
	                for j in cb[i]:
                            cbf=cb[i][j]
                            if cbf["FecCrate"]==pin[0] and cbf["FecSlot"]==pin[1]:
	                        ser2.add(i)
                    for y in ser2:
                        txtfhv.write(y+" "+HVInfoDictF.HVInfoDict[str(y)]["PSUName"]+"("+HVInfoDictF.HVInfoDict[str(y)]["Channel"]+")"+"\n")

                if len(pin)==3:
                    ser3=set([])
	            txtfhv.write("---------For DetIds with FecCrate %s/FecSlot %s/FecRing %s:---------\n"%(pin[0],pin[1],pin[2]))
                    for i in cb:
	                for j in cb[i]:
                            cbf=cb[i][j]
                            if cbf["FecCrate"]==pin[0] and cbf["FecSlot"]==pin[1] and cbf["FecRing"]==pin[2]:
	                        ser3.add(i)
                    for y in ser3:
                        txtfhv.write(y+" "+HVInfoDictF.HVInfoDict[str(y)]["PSUName"]+"("+HVInfoDictF.HVInfoDict[str(y)]["Channel"]+")""\n")

                if len(pin)==4:
                    ser4=set([])
	            txtfhv.write("---------For DetIds with FecCrate %s/FecSlot %s/FecRing %s/CcuAddr %s:---------\n"%(pin[0],pin[1],pin[2],pin[3]))
                    for i in cb:
	                for j in cb[i]:
                            cbf=cb[i][j]
                            if cbf["FecCrate"]==pin[0] and cbf["FecSlot"]==pin[1] and cbf["FecRing"]==pin[2] and cbf["CcuAddr"]==pin[3]:
	                        ser4.add(i)
                    for y in ser4:
                        txtfhv.write(y+" "+HVInfoDictF.HVInfoDict[str(y)]["PSUName"]+"("+HVInfoDictF.HVInfoDict[str(y)]["Channel"]+")"+"\n")

                if len(pin)==5:
                    ser5=set([])
	            txtfhv.write("---------For DetIds with FecCrate %s/FecSlot %s/FecRing %s/CcuAddr %s:---------\n"%(pin[0],pin[1],pin[2],pin[3]))
                    for i in cb:
	                for j in cb[i]:
                            cbf=cb[i][j]
                            if cbf["FecCrate"]==pin[0] and cbf["FecSlot"]==pin[1] and cbf["FecRing"]==pin[2] and cbf["CcuAddr"]==pin[3] and cbf["CcuChan"]==pin[4]:
	                        ser5.add(i)
                    for y in ser5:
                        txtfhv.write(y+" "+HVInfoDictF.HVInfoDict[str(y)]["PSUName"]+"("+HVInfoDictF.HVInfoDict[str(y)]["Channel"]+")"+"\n")
        print "A file named %s with has been created "%options.fe6
      

    
 ################To know the cabling info of modules with certain hv

    if options.vatrcm:
        lihv4=options.vatrcm
       
        txthvcab=open(options.ps5,'w')
        listhv=[set() for y in range(len(lihv4))]
        listcab=[]
        listm=[]
        HV=HVInfoDictF.HVInfoDict
        fke = set()
        HV = HVInfoDictF.HVInfoDict
        for key in HV:
            flag = True
            for property in lihv4:
                if property not in HV[key].values():
                    flag = False
            if flag:
                fke.add(key)
        txthvcab.write("For modules with ")
        for property in lihv4:
            txthvcab.write(property+"/")
        cb=DictionaryCab.CablingInfoDict
        for ikey in fke:
                for m in cb[ikey]:
                    for l in cb[ikey][m]:
                        cbi=cb[ikey][m]
                        if (str(ikey)) not in listcab:
                            listcab.append(str(ikey))
                            txthvcab.write("\n\n"+cbi["DetId"]+"    DcuId"+cbi["DcuId"]+"/nPairs"+cbi["nPairs"]+"/nStrips"+cbi["nStrips"]+"/FecCrate"+cbi["FecCrate"]+"/FecSlot"+cbi["FecSlot"]+"/FecRing"+cbi["FecRing"]+"/CcuAddr"+cbi["CcuAddr"]+"/CcuCh"+cbi["CcuChan"])
           
                        ins="\n"+"/FedCrate"+cbi["FedCrate"]+"/FedSlot"+cbi["FedSlot"]+"/FedId"+cbi["FedId"]+"/FeUnit"+cbi["FeUnit"]+"/FeChan"+cbi["FeChan"]+"/FedCh"+cbi["FedCh"]+"/LldChan"+cbi["LldChan"]+"/APV0-"+cbi["APV0"]+"/APV1-"+cbi["APV1"]

                        if (ins not in listm):
                            listm.append(ins)
                            txthvcab.write(ins)
 
        print ("A txt file %s with the modules and cabling info has been created")%options.ps5

####################Now info between two and a third info######################33
######################################################################
