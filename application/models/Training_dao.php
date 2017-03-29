<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'models/Common_dao.php');

class Training_dao extends Common_dao
{
    public function __construct()
    {
        $this->load->database('membership', TRUE);
        $aQueryInfo = edu_get_config('query', 'query');  
        $this->queryInfoTraing = $aQueryInfo['training'];  
    }
      
    public function isTraingInfo($subj, $year, $subjseq, $mb_id)
    {
        $aInput['subj']    = $subj;
        $aInput['year']    = $year;
        $aInput['subjseq'] = $subjseq;
        $aInput['userid']  = $mb_id;
         
        $aConfig = $this->queryInfoTraing['isTraingInfo'];
        $aRtn = $this->actModelFuc($aConfig, $aInput);
        
        return $aRtn[0];
    }
    public function setLmsPropose($aParam)
    {
        $aInput = $aParam;
        $aInput['userid']  = $aParam['mb_id'];
        $aInput['luserid'] = $aParam['mb_id'];
        $aInput['appdate'] = date("YmdHis");
        $aInput['TxSchoolJiCd'] = trim($aParam['jimyung_0']).'-'.trim($aParam['jimyung_1']).'-'.trim($aParam['jimyung_2']).'-'.trim($aParam['jimyung_3']);
        
        $aInput['chkfirst'] = 'Y';
        $aInput['chkfinal'] = 'Y';
        $aInput['Outmember'] = 'membership';
        
        $sResno = trim($aParam['neis_1'])
                 .trim($aParam['neis_2'])
                 .trim($aParam['neis_3'])
                 .trim($aParam['neis_4'])
                 .trim($aParam['neis_5'])
                 .trim($aParam['neis_6'])
                 .trim($aParam['neis_7']);
        if($sResno)
            $aInput['resno'] =  base64_encode($sResno);
        else
            $aInput['resno'] =  "";

        $oSchoolInfo = $this->getSchoolInfo($aParam['TxSchoolNm']);
        
        $aInput['txSchoolGubun']    = ""; 
        $aInput['txSchoolSulGubun'] = ""; 
        $aInput['txSchoolTel']      = ""; 
     
        if($oSchoolInfo && isset($aInput['TxSchoolNm'])) 
        {
            $aInput['TxSchoolNm']       = $oSchoolInfo->schoolName; 
            $aInput['txSchoolGubun']    = $oSchoolInfo->school_gubun; 
            $aInput['txSchoolGubun']    = $oSchoolInfo->school_gubun; 
            $aInput['txSchoolSulGubun'] = $oSchoolInfo->make_gubun; 
            $aInput['txSchoolTel']      = $oSchoolInfo->s_tel; 
            $aInput['TxSchoolChung']    = $oSchoolInfo->sosok_chung; 
        }

        $aConfig = $this->queryInfoTraing['setLmsPropose'];
        return $this->actModelFuc($aConfig, $aInput);
    }
    public function setLmsPayment($aParam)
    {
        $nOrderSeq = $this->getNextOrderSeq(); 
        
        $aInput = $aParam;
        $aInput['userid']  = $aParam['mb_id'];
        $aInput['luserid'] = $aParam['mb_id'];
        $aInput['Outmember'] = "membership";
        $aInput['status'] = "C";
        $aInput['yunsu_price'] = '0';
        $aInput['biyong'] = '0';
        $aInput['appdate'] = date("YmdHis");
        $aInput['orderSeq'] = $nOrderSeq;
        $aInput['method'] = '2';

        $aInput['TxSchoolJiCd'] = trim($aParam['jimyung_0']).'-'.trim($aParam['jimyung_1']).'-'.trim($aParam['jimyung_2']).'-'.trim($aParam['jimyung_3']);
        
        $aInput['chkfirst'] = 'Y';
        $aInput['chkfinal'] = 'Y';
        
        $sResno = trim($aParam['neis_1'])
                 .trim($aParam['neis_2'])
                 .trim($aParam['neis_3'])
                 .trim($aParam['neis_4'])
                 .trim($aParam['neis_5'])
                 .trim($aParam['neis_6'])
                 .trim($aParam['neis_7']);
        if($sResno)
            $aInput['resno'] =  base64_encode($sResno);
        else
            $aInput['resno'] =  "";
        
        $aConfig = $this->queryInfoTraing['setLmsPaymentInfo'];
        return $this->actModelFuc($aConfig, $aInput);
    }
    public function setLmsStudent($aParam, $oTrainingInfo)
    {
        $aInput = $aParam;
        $aInput['userid']  = $aParam['mb_id'];
        $aInput['luserid'] = $aParam['mb_id'];
	
        $aInput['class']= "0001" ;
        $aInput['comp']= "" ;
        $aInput['isdinsert']= "Y" ;
        $aInput['score']= '0' ;
        
        $aInput['tstep']= '0' ;
        $aInput['mtest']= '0' ;
        $aInput['ftest']= '0' ;
        $aInput['report']= '0' ;
        
        $aInput['act']= '0' ;
        $aInput['etc1']= '0' ;
        $aInput['etc2']= '0' ;
        $aInput['avtstep']= '0' ;
        
        $aInput['avmtest']= '0' ;
        $aInput['avftest']= '0' ;
        $aInput['avreport']= '0' ;
        $aInput['avact']= '0' ;
        
        $aInput['avetc1']= '0' ;
        $aInput['avetc2']= '0' ;
        $aInput['isgraduated']= "N" ;
        $aInput['isrestudy']= "N" ;
        
        $aInput['isb2c']= "N" ;
        $aInput['edustart']= str_replace("-", "", $oTrainingInfo->edustart)."00" ;
        $aInput['eduend']= str_replace("-", "", $oTrainingInfo->eduend)."23" ;
        $aInput['branch']= 99 ;
        
        $aInput['confirmdate']= "" ;
        $aInput['eduno']= '0' ;
        $aInput['luserid']= $aParam['mb_id'] ;
        $aInput['ldate']= date('YmdHis') ;
        
        $aInput['stustatus']= "Y" ;
        $aInput['grseq']= "" ;
        $aInput['Outmember']= "membership" ;

        $aConfig = $this->queryInfoTraing['setLmsStudent'];
        return $this->actModelFuc($aConfig, $aInput);
    }
    public function updateMember($aParam)
    {
        $aInput = $aParam;
        $sResno = trim($aParam['neis_1'])
                 .trim($aParam['neis_2'])
                 .trim($aParam['neis_3'])
                 .trim($aParam['neis_4'])
                 .trim($aParam['neis_5'])
                 .trim($aParam['neis_6'])
                 .trim($aParam['neis_7']);
        if($sResno)
            $aInput['neis'] =  base64_encode($sResno);
        else
            $aInput['neis'] =  "";

        $aSchoolInfo = $this->getSchoolInfo($aInput['TxSchoolNm']);
        
        $aSInput['address1']   = ""; 
        $aSInput['address2']   = ""; 
        $aSInput['txschoolnm'] = ""; 
     
        if($aSchoolInfo && isset($aInput['TxSchoolNm'])) 
        {
            $aSInput['address1']= $aSchoolInfo->Address1; 
            $aSInput['address2']= $aSchoolInfo->Address2; 
            $aSInput['txschoolnm']= $aSchoolInfo->schoolName; 
        }
                
        $aSInput['mb_id'] = $aInput['mb_id']; 
        $aSInput['neis'] = $aInput['neis']; 
        
        $aConfig = $this->queryInfoTraing['updateMember'];
        return $this->actModelFuc($aConfig, $aSInput);
    } 
    public function getSchoolInfo($sSchoolName)
    {
        $aRtn = array(
            'sSchoolName' => ''
            ,'address1' => ''
            ,'address2' => ''
        );
        if(!$sSchoolName)
            return $aRtn;

        $aInput = array('sSchoolName' => $sSchoolName);
        $aConfig = $this->queryInfoTraing['getSchoolInfo'];
        $aRtn = $this->actModelFuc($aConfig, $aInput);
        return $aRtn[0];
    }
    public function getTriningInfo($subj, $year, $subjseq)
    {
        $aInput = array('subj'=>$subj, 'year'=>$year, 'subjseq'=>$subjseq);
        $aConfig = $this->queryInfoTraing['getTrainInto'];
        $aRtn = $this->actModelFuc($aConfig, $aInput);
        return $aRtn[0];
    }
    private function getNextOrderSeq()
    {
        $aInput = array('orderSeq' => 1); 
        $aConfig = $this->queryInfoTraing['getOrderSeq'];
        $aCnt = $this->actModelFuc($aConfig, $aInput);
        return $aCnt[0]->cnt + 1;
    }


}
