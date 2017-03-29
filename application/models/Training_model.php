<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Training_model extends CI_model
{
    public function __construct()
    {
        $this->training_dao = edu_get_instance('training_dao', 'model'); 
        
        $this->today = date('Y-m-d H:i:s');
        $this->aRtn = array('et'=>0, 't'=>0, 'b'=>0, 'tv'=>0);
    
        $this->c_config = array('et'=>'e_training', 't'=>'training', 'b'=>'book', 'tv'=>'tv');
    
    }
    
    public function setTrainingBUY($aParam)
    {
        $oTrainingInfo = $this->training_dao->getTriningInfo($aParam['subj'], $aParam['year'], $aParam['subjseq']);
        
        if( $this->isTraingInfo($aParam['subj'],$aParam['year'],$aParam['subjseq'],$aParam['mb_id']) )   
        {
            return false;
        }
        else
        {
            // 실제 프로세스 진행 
            $this->setLmsPropose($aParam);
            $this->setLmsPayment($aParam);
            $this->setLmsStudent($aParam, $oTrainingInfo);
            $this->updateMember($aParam);
            return true;
        }
    }
    private function setLmsPropose($aParam)
    {
        return $this->training_dao->setLmsPropose($aParam);
    } 
    private function setLmsPayment($aParam)
    {
        return $this->training_dao->setLmsPayment($aParam);
    }
    private function setLmsStudent($aParam,$oTrainingInfo)
    {
        return $this->training_dao->setLmsStudent($aParam, $oTrainingInfo);
    }
    private function updateMember($aParam)
    {
        return $this->training_dao->updateMember($aParam);
    }
    public function isTraingInfo($subj, $year, $subjseq, $mb_id)
    {
        $isCnt = $this->training_dao->isTraingInfo($subj, $year, $subjseq, $mb_id);
        
        if( $isCnt->cnt >=1 )
            return true;
        else
            return false;
    }
}
