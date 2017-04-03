<?php
/*
    * data : ? bind data
    * btype : bind data type
    * null : null check data list (null을 허용하는값)
*/
$config['query'] = array(
    'membership' => array(
        'getProductInfo' => array( 
            'query' => 'SELECT sale_idx, name, grade, type, period, price, sale_s_date, sale_e_date, contents, e_training, training, book, tv,regdate 
                          FROM member_product_list 
                         WHERE sale_idx >= ?'
            ,'data' => array('sale_idx')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        ,'getMemberInfo' => array( 
            'query' => 'SELECT mb_id, mb_name, mb_email 
                          FROM edu_member
                         WHERE trim(mb_id) = ? '
            ,'data' => array('mb_id')
            ,'btype'=> 's'
            ,'null' => array() 
        )
        ,'getPurchaseInfo' => array( 
            'query' => 'SELECT pu.p_idx, pu.mb_id, pu.sale_idx, pu.regdate , pu.exp_s_date, pu.exp_e_date,
                               pl.name, pl.grade, pl.type, pl.period, pl.price, pl.sale_s_date, pl.sale_e_date, pl.contents, pl.e_training, pl.training, pl.book, pl.tv
                          FROM member_purchase_list pu LEFT JOIN member_product_list pl
                            ON pu.sale_idx = pl.sale_idx
                         WHERE pu.mb_id = ? 
                           AND pu.type = ?  
                           AND pu.exp_s_date <= now()  
                           AND pu.exp_e_date >= now()
                         ORDER BY regdate asc'
            ,'data' => array('mb_id','type')
            ,'btype'=> 'ss'
            ,'null' => array() 
        )
        ,'getUsageHistory' => array( 
            'query' => 'SELECT mb_id, p_idx, type, content_idx, regdate 
                          from member_service_usage_history 
                         where mb_id=?'
            ,'data' => array('mb_id')
            ,'btype'=> 's'
            ,'null' => array() 
        )
        ,'insertMemberPurchaseList' => array( 
            'query' => 'INSERT INTO member_purchase_list (mb_id, sale_idx, type, usedate, regdate, exp_s_date, exp_e_date,oid)
                        VALUES (?,?,?,?,?,?,?,?)'
            ,'data' => array('mb_id', 'sale_idx', 'type', 'usedate', 'regdate', 'exp_s_date', 'exp_e_date', 'oid')
            ,'btype'=> 'sissssss'
            ,'null' => array('usedate', 'exp_s_date', 'exp_e_date') 
        )
        ,'member_service_usage_history' => array( 
            'query' => 'INSERT INTO member_service_usage_history ( mb_id, p_idx, type, content_idx, regdate, credit  )
                        VALUES (?,?,?,?,?,?)'
            ,'data' => array( 'mb_id', 'p_idx', 'type', 'content_idx', 'regdate', 'credit')
            ,'btype'=> 'sissssi'
            ,'null' => array() 
        )
        ,'updateCancelMemberPurchaseList' => array( 
            'query' => 'UPDATE member_purchase_list
                           SET type = ? 
                         WHERE mb_id = ?
                           AND p_idx = ?'
            ,'data' => array('type', 'mb_id', 'p_idx')
            ,'btype'=> 'ssi'
            ,'null' => array() 
        )
        ,'updateCancelMemberContent' => array( 
            'query' => 
               "INSERT INTO member_log(mb_id, type, sale_type, sale_idx, regdate, user_id , msg)
                    SELECT mb_id, 'del' as type ,type as sale_type , content_idx as sale_idx, now() as regdate,  mb_id as user_id, concat('p_idx:',p_idx) as msg
                      FROM member_service_usage_history 
                     WHERE h_idx=?"
            ,'data' => array('h_idx')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        ,'deleteCancelMemberContent' => array( 
            'query' => 
                "DELETE  
                   FROM member_service_usage_history 
                  WHERE h_idx = ?"
            ,'data' => array('h_idx')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        ,'getLoginHistory' => array( 
            'query' => 'SELECT login_date 
                          FROM edu_member_login_history 
                         WHERE mb_id=?
                         ORDER by login_date desc
                         LIMIT 5'
            ,'data' => array('mb_id')
            ,'btype'=> 's'
            ,'null' => array() 
        )

    )
    ,'friend' => array(
        'getFriendList' => array( 
            'query' => '
                 SELECT mb_id, friend_id, action, regdate 
                   FROM member_friend     
                  WHERE mb_id = ?
                    AND action = ?'
            ,'data' => array('mb_id','action')
            ,'btype'=> 'ss'
            ,'null' => array() 
        )
        , 'setFriend' => array( 
            'query' => "
                INSERT INTO member_friend (mb_id, friend_id, action, regdate)
                VALUES (?,?,?,?) 
            "
            ,'data' => array('mb_id','friend_id','action','regdate')
            ,'btype'=> 'ssss'
            ,'null' => array() 
        )
        , 'deleteFriend' => array( 
            'query' => "
                update member_friend 
                   set  action = ?
                       ,regdate = ? 
                 where mb_id = ?
                   and friend_id = ? 
            "
            ,'data' => array('action','regdate','mb_id','friend_id')
            ,'btype'=> 'ssss'
            ,'null' => array() 
        )
    )
    ,'training' => array(
        'getTrainingInfo' => array( 
            'query' => '
                 SELECT q.subjnm, q.subj, q.year, q.subjseq, q.txgisu,  q.propstart, q.propend, q.edustart, q.eduend, q.biyong 
                   FROM lms_subj s, lms_subjseq q     
                  WHERE s.subj=q.subj  
                    AND s.isonoff = ? 
                    AND s.hakjum = ? 
                    AND s.isuse = ? 
                    AND s.yunsugubun = ? 
                    AND q.grcode = ?  
                    AND q.isvisible = ? 
                    AND q.year = ? 
                    AND ( convert( q.txgisu, unsigned ) between ? and ? )  
                  ORDER BY convert( q.txgisu, unsigned ) desc '
            ,'data' => array('isonoff','hakjum','isuse','yunsugubun','grcode','isvisible','year', 'txgisu1', 'txgisu2')
            ,'btype'=> 'sssssssii'
            ,'null' => array() 
        )
        ,'isTraingInfo' => array( 
            'query' => "
                 SELECT count(userid) as cnt 
                   FROM lms_paymentinfo     
                  WHERE status in ('B','C')  
                    AND subj = ? 
                    AND year = ? 
                    AND subjseq = ? 
                    AND userid = ? 
             " 
            ,'data' => array('subj','year','subjseq','userid')
            ,'btype'=> 'ssss'
            ,'null' => array() 
        )
        ,'setLmsPropose' => array( 
            'query' => 'INSERT INTO lms_propose( subj, year, subjseq, userid, appdate, luserid, TxSchoolJiCd, chkfirst, chkfinal, resno, TxSchoolNm, txSchoolGubun, txSchoolSulGubun, txSchoolTel, Outmember , TxSchoolChung ) 
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
            ,'data' => array( 'subj','year', 'subjseq', 'userid', 'appdate', 'luserid', 'TxSchoolJiCd', 'chkfirst', 'chkfinal', 'resno' ,'TxSchoolNm', 'txSchoolGubun', 'txSchoolSulGubun', 'txSchoolTel', 'Outmember', 'TxSchoolChung')
            ,'btype'=> 'ssssssssssssssss'
            ,'null' => array('luserid', 'TxSchoolJiCd', 'chkfirst', 'chkfinal', 'resno','TxSchoolNm', 'txSchoolGubun', 'txSchoolSulGubun', 'txSchoolTel', 'Outmember', 'TxSchoolChung') 
        )
        ,'setLmsStudent' => array( 
            'query' => 'INSERT INTO lms_student( subj, year, subjseq, userid, class, comp, isdinsert, score, tstep, mtest, ftest, report, act, etc1, etc2, avtstep, avmtest, avftest, avreport, avact, avetc1, avetc2, isgraduated, isrestudy, isb2c, edustart, eduend, branch, confirmdate, eduno, luserid, ldate, stustatus, grseq, Outmember) 
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
            ,'data' => array('subj', 'year', 'subjseq', 'userid', 'class', 'comp', 'isdinsert', 'score', 'tstep', 'mtest', 'ftest', 'report', 'act', 'etc1', 'etc2', 'avtstep', 'avmtest', 'avftest', 'avreport', 'avact', 'avetc1', 'avetc2', 'isgraduated', 'isrestudy', 'isb2c', 'edustart', 'eduend', 'branch', 'confirmdate', 'eduno', 'luserid', 'ldate', 'stustatus', 'grseq','Outmember')
            ,'btype'=> 'sssssssiiiiiiiiiiiiiiisssssisisssss'
            ,'null' => array('userid', 'class', 'comp', 'isdinsert', 'score', 'tstep', 'mtest', 'ftest', 'report', 'act', 'etc1', 'etc2', 'avtstep', 'avmtest', 'avftest', 'avreport', 'avact', 'avetc1', 'avetc2', 'isgraduated', 'isrestudy', 'isb2c', 'edustart', 'eduend', 'branch', 'confirmdate', 'eduno', 'luserid', 'ldate', 'stustatus', 'grseq', 'Outmember') 
        )
        ,'getOrderSeq' => array( 
            'query' => "
                SELECT max(orderSeq) as cnt 
                  FROM lms_paymentinfo
            " 
            ,'data' => array('orderSeq')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        ,'setLmsPaymentInfo' => array( 
            'query' => 'INSERT INTO lms_paymentinfo( subj, year, subjseq, userid, name, handphone, email, appdate, orderSeq ,Outmember , status, yunsu_price, BIYONG, method) 
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
            ,'data' => array( 'subj','year', 'subjseq', 'userid', 'name', 'handphone', 'email', 'appdate', 'orderSeq', 'Outmember', 'status', 'yunsu_price', 'biyong', 'method')
            ,'btype'=> 'ssssssssissiis'
            ,'null' => array('luserid', 'TxSchoolJiCd', 'chkfirst', 'chkfinal', 'resno', 'handphone', 'email', 'yunsu_price', 'biyong', 'method') 
        )
        ,'getTrainInto' => array( 
            'query' => "
            select a.subjnm, 
            case when b.yunsugubun='012101' then '원격직무' 
                 when b.yunsugubun='012102' then '원격자율' 
                 when b.yunsugubun='012103' then '현장직무' 
                 when b.yunsugubun='012104' then '현장자율' 
            END as yunsugubunStr ,
            TxGisu as gisu,  b.hakjum, b.edudays, b.edutimes ,
            CONCAT(SUBSTRING(LTRIM(a.propstart),1,4), '-', SUBSTRING(LTRIM(a.propstart),5,2), '-', SUBSTRING(LTRIM(a.propstart),7,2)) As  propstart ,
            CONCAT(SUBSTRING(LTRIM(a.propend),1,4  ), '-', SUBSTRING(LTRIM(a.propend),5,2  ), '-', SUBSTRING(LTRIM(a.propend),7,2)  ) As  propend , 
            case when b.proposetype='1' 
            then CONCAT(SUBSTRING(LTRIM(a.edustart),1,4), '-', SUBSTRING(LTRIM(a.edustart),5,2), '-', SUBSTRING(LTRIM(a.edustart),7,2)) when b.proposetype='2' 
            then CONCAT(SUBSTRING(DATE_FORMAT(now(),'%Y%m%d'),1,4), '-', SUBSTRING(DATE_FORMAT(now(),'%Y%m%d'),5,2), '-',SUBSTRING(DATE_FORMAT(now(),'%Y%m%d'),7,2)) end as edustart , 
            case when b.proposetype='1' 
            then CONCAT(SUBSTRING(LTRIM(a.eduend),1,4), '-', SUBSTRING(LTRIM(a.eduend),5,2), '-', SUBSTRING(LTRIM(a.eduend),7,2)) when b.proposetype='2' 
            then CONCAT(SUBSTRING(DATE_FORMAT(DATE_ADD(now(), INTERVAL 2 month),'%Y%m%d'),1,4), '-', SUBSTRING(DATE_FORMAT(DATE_ADD(now(), INTERVAL 2 month),'%Y%m%d'),5,2), '-', SUBSTRING(DATE_FORMAT(DATE_ADD(now(), INTERVAL 2 month),'%Y%m%d'),7,2)) end as eduend ,a.biyong,  
            (select name from lms_tutor where USERID=b.tutor) as tutornm ,b.bookname, b.bookprice, b.usebook, b.bookurl,  b.yunsugubun , b.introducefilenamenew2, b.eduoutline,
            a.biyong_notmembership as biyong2, b.isonoff  
            from 
                lms_subjseq as a , lms_subj as b 
            where a.SUBJ=b.SUBJ 
              and a.subj = ?
              and a.year = ? 
              and a.subjseq = ?
            " 
            ,'data' => array('subj','year','subjseq')
            ,'btype'=> 'sss'
            ,'null' => array() 
        )
        ,'updateMember' => array( 
            'query' => 'UPDATE edu_member 
                           SET txschoolnm  = ?
                              ,neis = ?  
                              ,txschooladdr1 = ?  
                              ,txschooladdr2 = ?  
                         WHERE mb_id = ?'
            ,'data' => array('txschoolnm','neis','address1','address2','mb_id')
            ,'btype'=> 'sssss'
            ,'null' => array('txschoolnm','neis','address1','address2') 
        )
        ,'getSchoolInfo' => array( 
            'query' => 'select schoolName, Address1, Address2, school_gubun, make_gubun, s_tel, sosok_chung 
                          from lms_school
                         WHERE trim(schoolName) = ?'
            ,'data' => array('sSchoolName')
            ,'btype'=> 's'
            ,'null' => array() 
        )
 
    )
    ,'mypage' => array(
        'getADETraining' => array( 
            'query' => '
                 SELECT q.subjnm, q.subj, q.year, q.subjseq, q.txgisu,  q.propstart, q.propend, q.edustart, q.eduend, q.biyong 
                   FROM lms_subj s, lms_subjseq q     
                  WHERE s.subj=q.subj  
                    AND s.isonoff = ? 
                    AND s.hakjum = ? 
                    AND s.isuse = ? 
                    AND s.yunsugubun = ? 
                    AND q.grcode = ?  
                    AND q.isvisible = ? 
                    AND q.year = ? 
                    AND ( convert( q.txgisu, unsigned ) between ? and ? )  
                  ORDER BY convert( q.txgisu, unsigned ) desc '
            ,'data' => array('isonoff','hakjum','isuse','yunsugubun','grcode','isvisible','year', 'txgisu1', 'txgisu2')
            ,'btype'=> 'sssssssii'
            ,'null' => array() 
        )
        ,'getAllTraining' => array( 
            'query' => '
                SELECT lp.subj, ls.subjnm, lp.chkfinal ,ls.isonoff  
                  FROM lms_propose lp, lms_subj ls
                 WHERE lp.userid = ?
                   AND lp.subj = ls.subj'
            ,'data' => array('userid')
            ,'btype'=> 's'
            ,'null' => array() 
        )
        ,'getEndTraining' => array( 
            'query' => '
                SELECT ls.subj, ls.subjnm ,ls.isonoff , lst.edustart, lst.eduend
                  FROM lms_student lst, lms_subj ls
                 WHERE lst.SUBJ = ls.SUBJ
                   AND lst.userid = ?'
            ,'data' => array('userid')
            ,'btype'=> 's'
            ,'null' => array() 
        )
        ,'getNewContentInfo' => array( 
            'query' => "
                select *, count(*) as content_cnt
                  from ( 
                        select a.idx, a.`subject`, left(b.cat_code,3) as groupcat, c.cat_name as groupcat_name, b.cat_code as cat, b.cat_name, b.is_menu, if(left(a.cat1,3)='006','004',left(a.cat1,3)) as groupby
                          from tv_content as a inner join tv_category as b on ( a.cat1 = b.cat_code )
                         inner join tv_category as c on ( concat(left(b.cat_code,3),'000000000000') = c.cat_code )
                         where a.is_use = ? and ceil(TIME_TO_SEC(timediff(sysdate(), a.reg_date))/60/60/24) < ? 
                         order by a.idx desc
                       ) as tb
                 group by groupby"
            ,'data' => array('is_use', 'getDate')
            ,'btype'=> 'si'
            ,'null' => array() 
        )
        ,'getTest' => array( 
            'query' => '
                SELECT admin_name 
                  FROM admin_login 
                 WHERE admin_list = ?'
            ,'data' => array('admin_list')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        
    )
    ,'log' => array(
        'setMembershipLog' => array( 
            'query' => 'INSERT INTO member_log ( mb_id, type, sale_type, sale_idx, regdate, user_id, msg )
                        VALUES (?,?,?,?,?,?,?)'
            ,'data' => array( 'mb_id', 'type', 'sale_type', 'sale_idx' , 'regdate', 'user_id', 'msg')
            ,'btype'=> 'sssisss'
            ,'null' => array('msg') 
        )
        
    )
    ,'sso' => array(
        'getSSOInfo' => array( 
            'query' => "
                SELECT t_id, t_usn, t_name, e_id, e_name
                  FROM member_sso
                 WHERE trim(e_id) = ?"
            ,'data' => array('e_id')
            ,'btype'=> 's'
            ,'null' => array() 
        )
        ,'setSSOInfo' => array( 
            'query' => 'INSERT INTO member_sso ( t_id, t_name, t_usn, e_id, e_name )
                        VALUES (?,?,?,?,?)'
            ,'data' => array( 't_email', 't_name', 't_usn','e_mb_id' , 'e_name')
            ,'btype'=> 'ssiss'
            ,'null' => array() 
        )
    )
    ,'eBook' => array(
        'getBestBook' => array( 
            'query' => "
                SELECT A.*, B.*, C.* 
                FROM `titanbooks`.`goods` AS A JOIN `titanbooks`.`goods_category_relation` AS B on A.g_num = B.g_num JOIN `goods_content` AS C on A.g_num = C.g_num 
                WHERE ( (A.`g_show_div` != 'hidden') 
                        OR (A.`g_show_div` = 'date' 
                        AND (A.`g_show_sdate` <= ? AND A.`g_show_edate` >= ?))
                      ) 
                  AND (A.`my_library` != 'only') 
                  AND (B.`gcr_type` = 'origin') 
                ORDER BY A.`g_click_hit` DESC LIMIT 0, 6"
            ,'data' => array('sDate','eDate')
            ,'btype'=> 'ss'
            ,'null' => array() 
        )
        ,'getNewBook' => array( 
            'query' => "
                SELECT A.*, B.*, C.* 
                FROM `titanbooks`.`goods` AS A JOIN `titanbooks`.`goods_category_relation` AS B on A.g_num = B.g_num JOIN `goods_content` AS C on A.g_num = C.g_num 
                WHERE ( (A.`g_show_div` != 'hidden') 
                        OR (A.`g_show_div` = 'date' 
                        AND (A.`g_show_sdate` <= ? AND A.`g_show_edate` >= ?))
                      ) 
                  AND (A.`my_library` != 'only') 
                  AND (B.`gcr_type` = 'origin') 
                ORDER BY A.`date` DESC LIMIT 0, 6"
            ,'data' => array('sDate','eDate')
            ,'btype'=> 'ss'
            ,'null' => array() 
        )
        ,'getBookList' => array( 
            'query' => "
                SELECT A.*, B.*, C.* 
                FROM `titanbooks`.`goods` AS A JOIN `titanbooks`.`goods_category_relation` AS B on A.g_num = B.g_num JOIN `goods_content` AS C on A.g_num = C.g_num 
                WHERE (A.`g_show_div` != 'hidden') 
                  AND (A.`my_library` != 'only') 
                  AND (B.`gcr_type` = 'origin')
                  AND A.g_num >= ?"
            ,'data' => array('g_num')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        ,'getBookListFromCategory' => array( 
            'query' => "
                SELECT A.*, B.*, C.* 
                FROM `titanbooks`.`goods` AS A JOIN `titanbooks`.`goods_category_relation` AS B on A.g_num = B.g_num JOIN `goods_content` AS C on A.g_num = C.g_num 
                WHERE ( (A.`g_show_div` != 'hidden') 
                        OR (A.`g_show_div` = 'date' 
                        AND (A.`g_show_sdate` <= ? AND A.`g_show_edate` >= ?))
                      ) 
                  AND (A.`my_library` != 'only') 
                  AND (B.`gcr_type` = 'origin')
                  AND (B.`gc_num` = ?)"
            ,'data' => array('sDate','eDate','gc_num')
            ,'btype'=> 'ssi'
            ,'null' => array() 
        )
        ,'getBookImgInfo' => array( 
            'query' => "
                SELECT gf_num, g_num, gf_filename_org, gf_filename_new, gf_type, gf_img_size, date 
                  FROM goods_fileimage 
                 WHERE gf_type = ? 
                   AND g_num = ?"
            ,'data' => array('gf_type','g_num')
            ,'btype'=> 'si'
            ,'null' => array() 
        )
        ,'getBookDetailInfo' => array( 
            'query' => "
                SELECT * 
                  FROM goods 
                 WHERE g_num = ?"
            ,'data' => array('g_num')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        ,'getBookDetailInfo_Content' => array( 
            'query' => "
                SELECT A.* , B.gcr_gccode as gccode
                  FROM goods_content A , goods_category_relation B 
                 WHERE A.g_num = ?
                   AND A.g_num = B.g_num"
            ,'data' => array('g_num')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        ,'getMyBookList' => array(
 /*           'query' => "
                SELECT A.*, C.* 
                  FROM `titanbooks`.`goods` AS A JOIN `goods_content` AS C on A.g_num = C.g_num 
                 WHERE A.g_num in (
                     SELECT g_num 
                       FROM `titanbooks`.`shop_order_list` 
                      WHERE `member_no` = ? 
                        AND `del_yn` != 'del' 
                      ORDER BY `list_no` DESC
                  )"*/ 
             'query' => "
             SELECT A.*, B.* 
               FROM goods AS A, shop_order_list AS B
              WHERE A.g_num = B.g_num 
                AND B.member_no = ? 
                AND B.del_yn != 'del' 
              ORDER BY list_no DESC 
             " 
            
            ,'data' => array('member_no')
            ,'btype'=> 'i'
            ,'null' => array()
        )
        ,'getShopMember' => array(
            'query' => "
                SELECT member_no, email, name 
                FROM `shop_member` 
                WHERE `member_no` = ?" 
            ,'data' => array('member_no')
            ,'btype'=> 'i'
            ,'null' => array()
        )
        ,'getShopMemberEmail' => array(
            'query' => "
                SELECT member_no, email, name 
                FROM `shop_member` 
                WHERE `email` = ?" 
            ,'data' => array('email')
            ,'btype'=> 's'
            ,'null' => array()
        )
        ,'setShopMember' => array(
            'query' => 'INSERT INTO shop_member( name, password, email, cyber_point, is_issue, login_str, reg_date )
                        VALUES (?,?,?,?,?,?,?)'
            ,'data' => array( 'name', 'password', 'email', 'cyber_point', 'is_issue', 'login_str', 'reg_date')
            ,'btype'=> 'sssisss'
            ,'null' => array() 
        )
        ,'chkMyCartInfo' => array(
            'query' => "
                SELECT idx 
                FROM goods_extralist 
                WHERE ex_case = 'cart'
                AND member_no = ?
                AND g_num = ?" 
            ,'data' => array('member_no','g_num')
            ,'btype'=> 'ii'
            ,'null' => array()
        )
        ,'updateMyCartHit' => array( 
            'query' => 'UPDATE goods 
                           SET g_cart_hit = g_cart_hit + 1 
                         WHERE g_num = ?'
            ,'data' => array('g_num')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        ,'getGoodsExtralist' => array( 
            'query' => 'SELECT idx 
                          FROM goods_extralist 
                         WHERE g_num = ?
                           AND member_no = ?
                           AND ex_case = ?' 
            ,'data' => array('g_num','member_no', 'ex_case')
            ,'btype'=> 'iis'
            ,'null' => array() 
        )
        ,'deleteGoodsExtralist' => array( 
            'query' => 'DELETE 
                          FROM goods_extralist 
                         WHERE idx = ?'
            ,'data' => array('idx')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        ,'deleteTodayGoods' => array( 
            'query' => 'DELETE 
                          FROM today_goods  
                         WHERE date < ?'
            ,'data' => array('today')
            ,'btype'=> 's'
            ,'null' => array() 
        )
        ,'insertTodayGoods' => array( 
            'query' => 'insert into today_goods (date, datetime, ip, g_num, gccode, img_name, mem_no) 
                         values (?,?,?,?,?,?,?)'
            ,'data' => array('date', 'datetime', 'ip', 'g_num', 'gccode', 'img_name', 'mem_no')
            ,'btype'=> 'sssiisi'
            ,'null' => array() 
        )
        ,'setGoodsExtralist' => array(
            'query' => 'INSERT INTO goods_extralist( g_num, gccode, member_no, g_name, g_price, g_price_street, g_point, g_point_div, point_val, author_name, book_com, date_val, ex_case, ip, regdate  )
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
            ,'data' => array( 'g_num', 'gccode', 'member_no', 'g_name', 'g_price', 'g_price_street', 'g_point', 'g_point_div', 'point_val', 'author_name', 'book_com', 'date_val', 'ex_case', 'ip', 'regdate' )
            ,'btype'=> 'isisiiisissssss'
            ,'null' => array('g_point_div','point_val','g_price','g_price_street','g_point','book_com', 'author_name', 'book_com', 'date_val') 
        )
        ,'getBuyBookInfo' => array(
            'query' => "
                SELECT * 
                FROM goods_extralist 
                WHERE ex_case = 'cart'
                AND member_no = ?
                AND idx = ?" 
            ,'data' => array('member_no','idx')
            ,'btype'=> 'ii'
            ,'null' => array()
        )
        ,'getMyCartInfo' => array(
            'query' => "
                SELECT * 
                  FROM goods_extralist 
                 WHERE ex_case = 'cart' 
                   AND member_no = ? 
                 ORDER BY idx DESC LIMIT 0, 999999999 " 
            ,'data' => array('member_no')
            ,'btype'=> 'i'
            ,'null' => array()
        )
        ,'chkBuyBook' => array(
            'query' => "
               SELECT COUNT(*) AS order_Count 
                 FROM shop_order_list
                WHERE g_num = ?
                  AND member_no = ? 
                  AND (ea_order_step = '2' OR del_yn != 'del')"
            ,'data' => array('g_num','member_no')
            ,'btype'=> 'ii'
            ,'null' => array()
        )

        // buy process 
        ,'setMileage' => array(
            'query' => "
                INSERT INTO shop_member_mileage ( member_no, order_code, mileage, mileage_memo, plus_minus, ret_yn, regdate )
                VALUES ( ?,?,?,?,?,?,? )"
            ,'data' => array('member_no','order_code', 'mileage', 'mileage_memo', 'plus_minus', 'ret_yn', 'regdate')
            ,'btype'=> 'isissss'
            ,'null' => array('order_code','regdate')
        )
        ,'updateCyberPoint' => array(
            'query' => 
                "UPDATE shop_member
                    SET cyber_point = cyber_point - ?
                  WHERE member_no = ?
                "
            ,'data' => array('cyber_point','member_no')
            ,'btype'=> 'ii'
            ,'null' => array('cyber_point')
        )
        ,'updateCoupon' => array(
            'query' => 
                "UPDATE shop_coupon_user 
                    SET 
                         scu_usediv = 1
                       , scu_order = ? 
                  WHERE 
                       coupon_list_no = ?
                "
            ,'data' => array('order_code','coupon_list_no')
            ,'btype'=> 'si'
            ,'null' => array()
        )
        ,'setShopOrder' => array(
            'query' => "
                INSERT INTO shop_order (order_code, member_no, user_name, user_email, u_ip, order_Price_SUM, mileage_set, mileage_get, mileage_flag, sca_code, sca_price, 
                             bank_name ,payment_div, order_step, regdate) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"

                ,'data' => array('order_code', 'member_no', 'user_name', 'user_email', 'u_ip',
                                 'order_Price_SUM', 'mileage_set', 'mileage_get', 'mileage_flag', 'sca_code', 'sca_price', 
                                 'bank_name', 'payment_div', 'order_step', 'regdate')
            ,'btype'=> 'sisssiiississss'
            ,'null' => array('order_code', 'user_name', 'user_email', 'u_ip',
                             'order_Price_SUM', 'mileage_set', 'mileage_get', 'mileage_flag', 'sca_code', 'sca_price', 
                             'bank_name', 'payment_div', 'order_step', 'regdate')
        )        
        ,'getBookInfoFromMyCart' => array(
            'query' => "
                SELECT * 
                  FROM goods_extralist 
                 WHERE idx = ? 
                   AND member_no = ? "
            ,'data' => array('idx','member_no')
            ,'btype'=> 'ii'
            ,'null' => array()
        )
        ,'setShopOrderList' => array(
            'query' => "
                INSERT INTO shop_order_list (order_code, g_num, gc_code, g_name, order_price, point_val, member_no, ea_order_step ) 
                VALUES (?,?,?,?,?,?,?,?)"

                ,'data' => array('order_code', 'g_num', 'gc_code', 'g_name', 'order_price', 'point_val', 'member_no', 'ea_order_step')
            ,'btype'=> 'iissiiis'
            ,'null' => array('order_code', 'g_num', 'gc_code', 'g_name', 'order_price', 'point_val', 'member_no', 'ea_order_step')
        )
        ,'deleteCartBook' => array( 
            'query' => 'DELETE 
                          FROM goods_extralist 
                         WHERE idx = ?
                           AND member_no = ?
                           AND ex_case = ?'
            ,'data' => array('idx', 'member_no','ex_case')
            ,'btype'=> 'iis'
            ,'null' => array() 
        )
        ,'updateSellHit' => array( 
            'query' => 'UPDATE goods
                           SET g_sell_hit = g_sell_hit + 1
                         WHERE g_num = ?'
            ,'data' => array('g_num')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        
        ,'getShopOrder' => array( 
            'query' => 'SELECT * 
                          FROM shop_order 
                         WHERE member_no = ?'
            ,'data' => array('member_no')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        ,'getShopOrderList' => array( 
            'query' => 'SELECT * 
                          FROM shop_order_list 
                         WHERE order_code = ?'
            ,'data' => array('order_code')
            ,'btype'=> 'i'
            ,'null' => array() 
        )
        ,'updateShopOrderList' => array( 
            'query' => "UPDATE shop_order_list 
                           SET del_yn = 'del' 
                         WHERE g_num = ?
                           AND list_no = ?
                           AND member_no = ?"
            ,'data' => array('g_num', 'list_no', 'member_no')
            ,'btype'=> 'iii'
            ,'null' => array() 
        )

    )
    ,'admin' => array(
        'getBookCount' => array(
            'query' => "
                SELECT A.g_num, A.g_name, count(*) as CNT
                FROM (
                  SELECT so.order_code, so.user_name , so.regdate, sol.g_name, sol.g_num
                  FROM titanbooks.shop_order so , titanbooks.shop_order_list sol
                  where so.order_code = sol.order_code
                  AND so.regdate >= ?
                  AND so.regdate <= ?
                ) as A
                GROUP BY g_num"
            ,'data' => array('sDate','eDate')
            ,'btype'=> 'ss'
            ,'null' => array()
        )
        ,'getBookCountMeta' => array(
            'query' => "
                SELECT so.order_code, so.user_name , so.regdate, sol.g_name, sol.g_num
                  FROM titanbooks.shop_order so , titanbooks.shop_order_list sol
                  where so.order_code = sol.order_code
                  AND so.regdate >= ?
                  AND so.regdate <= ?"
        ,'data' => array('sDate','eDate')
        ,'btype'=> 'ss'
        ,'null' => array()
        )
    )
);
