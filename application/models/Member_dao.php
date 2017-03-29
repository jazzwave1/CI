<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'models/Common_dao.php');

class Member_dao extends Common_dao
{
    public function __construct()
    {
        $this->load->database('membership', TRUE);
        $aQueryInfo = edu_get_config('query', 'query');  
        $this->queryInfoMem = $aQueryInfo['membership'];  
        $this->queryInfoSSO = $aQueryInfo['sso'];  
        $this->queryInfoMemLog = $aQueryInfo['log'];  
    }

    public function setMembershipLog($aParam)
    {
        $aConfig = $this->queryInfoMemLog['setMembershipLog'];
        return $this->actModelFuc($aConfig, $aParam);
    }

    public function getUsageHistory($mb_id)
    {
        $aParam = array('mb_id'=>$mb_id); 
        $aConfig = $this->queryInfoMem['getUsageHistory'];
        return $this->actModelFuc($aConfig, $aParam);
    }
    public function getProductInfo($aParam='')
    {
        $aParam = array('sale_idx'=>1); 
        $aConfig = $this->queryInfoMem['getProductInfo'];
        return $this->actModelFuc($aConfig, $aParam);
    }
    public function getMemberInfo($aParam)
    {
        $aConfig = $this->queryInfoMem['getMemberInfo'];
        return $this->actModelFuc($aConfig, $aParam);
    }
    public function getPurchaseInfo($mb_id)
    {
        $aParam = array('mb_id'=>$mb_id, 'type'=>'act'); 
        $aConfig = $this->queryInfoMem['getPurchaseInfo'];
        return $this->actModelFuc($aConfig, $aParam);
    }
    public function getUseCnt($mb_id, $aPidx)
    {
        $btype = 's';
        $query = 
            'SELECT type, count(*) as cnt, sum(credit) as sum_credit 
               FROM member_service_usage_history
              WHERE mb_id = ? 
                AND p_idx IN (';
        
        foreach($aPidx as $val)
        {
            $query .= '?,' ;
            $btype .= "i";
        }
        $query = substr($query, 0, -1);
        $query .= ') GROUP BY type ';


        $aInputData[] = $mb_id;
        $aInputData = array_merge($aInputData, $aPidx); 
        
        $oResult = $this->db->query($query, $aInputData, true, $btype);
        return $oResult->result();
    }
    public function insertMemberPurchaseList($aParam=array())
    {
        $aConfig = $this->queryInfoMem['insertMemberPurchaseList'];
        return $this->actModelFuc($aConfig, $aParam);
    }
    public function insertMemberServiceUsageHistory($aParam=array())
    {
        $aConfig = $this->queryInfoMem['member_service_usage_history'];
        return $this->actModelFuc($aConfig, $aParam);
    } 
    public function updateCancelMemberPurchaseList($aParam=array())
    {
        $aConfig = $this->queryInfoMem['updateCancelMemberPurchaseList'];
        return $this->actModelFuc($aConfig, $aParam);
    }
    public function updateCancelMemberContent($aParam=array())
    {
        $aConfig = $this->queryInfoMem['updateCancelMemberContent'];
        return $this->actModelFuc($aConfig, $aParam);
    }
    public function deleteCancelMemberContent($aParam=array())
    {
        $aConfig = $this->queryInfoMem['deleteCancelMemberContent'];
        return $this->actModelFuc($aConfig, $aParam);
    }
    public function getSSOInfo($mb_id)
    {
        $aInput = array('e_id'=>$mb_id);
        $aConfig = $this->queryInfoSSO['getSSOInfo'];

        return $this->actModelFuc($aConfig, $aInput);
    }
    public function setSSOInfo($aInput)
    {
        $aConfig = $this->queryInfoSSO['setSSOInfo'];
        return $this->actModelFuc($aConfig, $aInput);
    }
    public function getLoginHistory($mb_id)
    {
        $aInput = array('mb_id'=>$mb_id);
        $aConfig = $this->queryInfoMem['getLoginHistory'];
        return $this->actModelFuc($aConfig, $aInput);
    }

    public function getTraingEduReady($mb_id)
    {
        $query = "
            SELECT a.userid, b.subj, b.year, b.subjseq, b.subjseqgr, b.subjnm, b.propstart, b.propend, b.edustart, b.eduend, b.isonoff, a.chkfinal, a.cancelkind, a.ldate propose_date, 
                DATE_FORMAT(cast(DATE_FORMAT(substring(ifnull(case when chkfinal = 'Y' and b.proposetype = 2 then ifnull(a.ldate, b.propend) else b.propend end,'2000010100'),1,8),'%Y%m%d') as datetime) + ifnull(b.canceldays,0), '%Y%m%d') cancelend , 
                b.edudays , b.proposetype , b.canceldays , a.ldate , 
                ( 
                    select case when method= '1' then tid else '' end tid 
                    from lms_paymentinfo 
                    where subj = a.subj and year = a.year and subjseq = a.subjseq and userid = a.userid 
                ) tid , 
                b.txgisu , 
                case b.yunsugubun when '012101' then '원격직무' 
                                  when '012102' then '원격자율' 
                                  when '012103' then '현장직무' 
                                  when '012104' then '현장자율' 
                end as txapygubun , a.grseq, a.txgrpnum, a.grtitle 
            FROM lms_propose a inner join lms_scsubjseq b on a.subj = b.subj and a.year = b.year and a.subjseq = b.subjseq 
            WHERE 1=1 and a.userid = ? 
            AND b.isblended = 'N' 
            AND b.isexpert = 'N' 
            AND a.chkfinal != 'Y' 
            AND b.course = '000000' 
            AND b.grcode in  ('N000001','N000002') 
            ORDER BY b.scupperclass, b.scmiddleclass, b.subjnm, b.edustart desc ";

        $aInputData[] = $mb_id;
        $btype = "s";

        $oResult = $this->db->query($query, $aInputData, true, $btype);
        $result = $oResult->result();
        return $result;
    }
    public function getTraingEduPlay($mb_id)
    {
         $query = " select x.*, x.subj as xsubj, y.subj 
         from (
         select tsj.contenttype, tst.subj, tst.year, tst.subjseq, tst.isgraduated, tst.branch, tst.edustart, tst.eduend, tst.edustart studystart, tst.eduend studyend,  
         tsj.isonoff, tsj.subjnm, tsj.subjclass, tsj.upperclass, tsj.middleclass, tsj.lowerclass, tsa.classname cname, tsj.cpsubj, tss.cpsubjseq, 
         CASE WHEN substring(DATE_FORMAT(now(),'%Y%m%d%H%i%s'), 1, 12) BETWEEN CONCAT(tst.EduStart,'00')  
         AND CONCAT(tst.EduEnd , (case when  substring(ifnull( tst.eduend, '2007080800'), 9,2) = '23' then '59' else '00' end)) THEN 'E' WHEN substring(DATE_FORMAT(now(),'%Y%m%d%H%i%s'), 1, 10) < tst.EduStart THEN 'R' ELSE 'T' END ProcEduFlag, 
         tss.isattendchk , tsj.isoutsourcing , tsa.classname , tst.userid , tss.isgoyong , tss.grcode , tss.txgisu , 
         case tsj.yunsugubun when '012101' then '원격직무' when '012102' then '원격자율' when '012103' then '현장직무' when '012104' then '현장자율' end as txapygubun , 
        #  ( select grseq from lms_propose p where p.subj=tst.subj and p.subjseq=tst.subjseq and p.year=tst.year and p.userid=tst.userid ) as grseq 
         p.grseq, p.outmember
         from lms_student tst, lms_subjseq tss, lms_subj tsj, lms_subjatt tsa , lms_propose p
         where 1=1 
         and tst.userid = ? 
         and tst.subj = tss.subj and tst.year = tss.year and tst.subjseq = tss.subjseq and tst.subj = tsj.subj 
         and tst.year = p.year and tst.subjseq = p.subjseq and tst.subj = p.subj and tst.userid = p.userid  
         and tsj.upperclass  = tsa.upperclass 
         and tsa.middleclass = '000' and tsa.lowerclass  = '000' and CONCAT(tst.eduend, 
         (case when  substring(ifnull( tst.eduend, '2007080800'), 9,2) = '23' then '59' else '00' end))  >= substring(DATE_FORMAT(now(),'%Y%m%d%H%i%s'), 1, 12) and course = '000000' and tsj.ALLFREE = 'N'   #  자유이용권 과정은 안보여줌
         ) x 
         left outer join lms_stold y on x.subj = y.subj and x.year = y.year and x.subjseq = y.subjseq and x.userid = y.userid 
         where y.subj is null and x.grcode in ('N000001','N000002')
         order by x.edustart, x.classname, x.subjnm ";
         
        $aInputData[] = $mb_id;
        $btype = "s";

        $oResult = $this->db->query($query, $aInputData, true, $btype);
        $result = $oResult->result();
        return $result;
    }
    public function getTraingEduComplete($mb_id)
    {
        $query = "select tss.contenttype , tss.subj , tss.year , tss.subjseq , tst.userid , tst.edustart , tst.eduend , tst.isrestudy , tst.isgraduated , 
        (case when tst.isgraduated = 'Y' then '수료' else '미수료' end) isgraduated_value , 
        DATE_FORMAT(DATE_ADD(cast((case when LENGTH(tst.eduend) > 8 then substring(tst.eduend, 1, 8) else tst.eduend end) as datetime), INTERVAL 1 day), '%Y%m%d') studystart , 
        DATE_FORMAT(DATE_ADD(cast((case when LENGTH(tst.eduend) > 8 then substring(tst.eduend, 1, 8) else tst.eduend end) as datetime), INTERVAL (ifnull(reviewperiod, 0) * 30) day), '%Y%m%d') studyend , tst.branch , 
        (case when (DATEDIFF(now(), CONVERT((case when LENGTH(tst.eduend) > 8 then substring(tst.eduend, 1, 8) else tst.eduend end) , datetime)) ) <= (ifnull(reviewperiod, 0) * 30) then 'Y' else 'N' end) isreview , 
        tss.subjnm , tss.scsubjclass subjclass , tss.scupperclass upperclass , tss.scmiddleclass middleclass , tss.sclowerclass lowerclass , tss.isonoff , tsa.classname cname , tsd.score , tss.cpsubj , tss.cpsubjseq , 
        tsd.userid gubun , tss.subjseqisablereview , tss.isoutsourcing , tss.iscertificate , tss.txgisu , 
        case tss.yunsugubun when '012101' then '원격직무' when '012102' then '원격자율' when '012103' then '현장직무' when '012104' then '현장자율' end as txapygubun 
        from lms_student tst inner join edu_member c on tst.userid = c.mb_id inner join lms_scsubjseq tss on tst.subj = tss.subj and tst.year = tss.year and tst.subjseq = tss.subjseq 
        inner join lms_subjatt tsa on tss.scupperclass  = tsa.upperclass and tsa.middleclass = '000' and tsa.lowerclass  = '000' 
        left outer join lms_stold tsd on tss.subj = tsd.subj and tss.year = tsd.year and tss.subjseq = tsd.subjseq and tst.userid = tsd.userid and tsd.subj = tss.subj and tsd.year = tss.year and tsd.subjseq = tss.subjseq 
        where tst.userid = ? 
        and tss.isblended = 'N' 
        and tss.isexpert = 'N' 
        and tss.course = '000000' 
        and ( DATE_FORMAT(now(), '%Y%m%d%H') > tst.eduend  ) 
        and tss.allfree in ('N') 

        and CONCAT(tst.eduend , (case when  substring(ifnull( tst.eduend, '2007080800'), 9,2) = '23' then '59' else '00' end)) >=  DATE_FORMAT(DATE_ADD(now(), INTERVAL -365 day), '%Y%m%d%H%i') 
        and tss.grcode in   ('N000001','N000002')  
        order by tst.edustart desc, tsa.classname, tss.scsubjnm  ";

        $aInputData[] = $mb_id;
        $btype = "s";

        $oResult = $this->db->query($query, $aInputData, true, $btype);
        $result = $oResult->result();
        return $result;
    }
}
