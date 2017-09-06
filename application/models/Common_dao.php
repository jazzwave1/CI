<?php
class Common_dao extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function chkParam( $aConfig , $aParam, $aNull=array() )
    {
        $chkParam = true;
        $aData = array();
        if($aParam)
        {
            foreach($aConfig as $key=>$val)
            {
                if( $aParam[$val]=='' && !in_array($val, $aNull) )
                {
                    //echo $val;
                    $chkParam = false;
                    break;
                }
                if($aParam[$val] == '')
                    $aParam[$val] = NULL;
                $aData[] = $aParam[$val];
            }
        } 

        if($chkParam)
        {
            if(!$aData) 
                return true; 
            
            return $aData;
        }
        else
            return $chkParam;
    }
    public function runQueryFromDB($query , $aInputData, $bType, $dbname, $rType='object')
    {
        //echo "<pre>";
        //echo "Query : ".$query."<br>" ;
        //echo "bTtype : ".$bType."<br>" ;
        //echo "Array Input : ";
        //print_r($aInputData);

        if ($oResult = $dbname->query($query, $aInputData, true, $bType))
        {
            if(strstr(strtoupper( $query ),"SELECT") && !(strstr(strtoupper( $query ),"DELETE") || strstr(strtoupper( $query ),"INSERT") || strstr(strtoupper( $query ),"UPDATE")))
            {
                if($rType == 'object')
                    $result = $oResult->result();
                else
                    $result = $oResult->result_array();

                return $result;
            }
            else
                return true;
        }
        else
        {
            print_r($this->db);
        }
        return false;
    }
    public function runQuery($query , $aInputData, $bType, $rType='object')
    {
        //echo "<pre>";
        //echo "Query : ".$query."<br>" ;
        //echo "bTtype : ".$bType."<br>" ;
        //echo "Array Input : ";
        //print_r($aInputData);

        if ($oResult = $this->db->query($query, $aInputData, true, $bType))
        {
            if(strstr(strtoupper( $query ),"SELECT") && !(strstr(strtoupper( $query ),"DELETE") || strstr(strtoupper( $query ),"INSERT") || strstr(strtoupper( $query ),"UPDATE")))
            {
                if($rType == 'object')
                    $result = $oResult->result();
                else
                    $result = $oResult->result_array();

                return $result;
            }
            else
                return true;
        }
        else
        {
            print_r($this->db);
        }
        return false;
    }
    public function setStepQuery($aParam='')
    {
        $cnt = 0;
        $aConfig = $this->getQuery("step");
        foreach($aConfig[$aParam['stepName']] as $key=>$val)
        {
            $aData = $val['data'];
            if ( ! $this->chkParam($aData, $aParam['param'][$cnt]) )
                return false;
            $cnt++;
        }
        $cnt = 0;
        $ret = true;
        foreach($aConfig[$aParam['stepName']] as $key=>$val)
        {
            $query = $val['query'];
            $aData = $val['data'];
            $bType = $val['btype'];
            $aInputData = array();
            $aInputData = $this->chkParam($aData, $aParam['param'][$cnt]) ;
            if (! $this->runQuery($query , $aInputData, $bType))
                $ret = false;
            $aLog['ival_str_temp'][] = implode('|',$aInputData);
            $cnt++;
        }
        $aLog['menu'] = $aParam['stepName'] ;
        $aLog['ival_str'] = implode(',',$aLog['ival_str_temp']);
        $this->setLog($aLog);
        return $ret;
    }
    public function actModelFuc($aConfig, $aParam, $rType='object', $rPK=false)
    {
        if(!$aConfig) return false;

        $query = $aConfig['query'];
        $aData = $aConfig['data'];
        $bType = $aConfig['btype'];
        $aNull = $aConfig['null'];

        if ( ! $aInputData = $this->chkParam($aData, $aParam, $aNull) )
        {
            return false;
        }
        if ($result = $this->runQuery($query , $aInputData, $bType, $rType))
        {
            if($rPK)
            {
                return $this->db->insert_id();
            }
            else
            {
                return $result;
            }
        }
        else
            return false;
    }
    public function actModelFucFromDB($aConfig, $aParam, $dbname, $rType='object', $rPK=false)
    {
        if(!$aConfig || !$aParam) return false;

        $query = $aConfig['query'];
        $aData = $aConfig['data'];
        $bType = $aConfig['btype'];
        $aNull = $aConfig['null'];

        if ( ! $aInputData = $this->chkParam($aData, $aParam, $aNull) )
        {
            return false;
        }
        if ($result = $this->runQueryFromDB($query , $aInputData, $bType, $dbname, $rType))
        {
            if($rPK)
            {
                return $dbname->insert_id(); 
            }
            else
            {
                return $result;
            } 
        }    
        else
            return false;
    }
}
?>
