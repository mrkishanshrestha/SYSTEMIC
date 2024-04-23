<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

$result='';

    if($_POST['SEARCH_DATA']!=''){

        $College_Array = [];
        $SQL = 'SELECT * FROM `college` WHERE `user_refid`= (SELECT `id` FROM `user` WHERE `id`=:id) ';
        $BIND = ['id'=>$_SESSION['KOHOMAH']];
        $result = $kali->kaliPulls($SQL,$BIND);
        if($result){

            /*'name'=>'%'.$_POST['SEARCH_DATA'].'%',*/
                foreach($result as $rows){
                    array_push($College_Array,$rows['id']);
                }

                $College_Array = implode(',',$College_Array);
                $SQL = 'SELECT `id`, `authority_refid`,(SELECT `name` FROM `authority` WHERE `id`=user.authority_refid) as AUTHORITY, `username`, `first_name`, `middle_name`, `last_name`, `contact_number`, `phone_number`, `address`, `email`, `document_id`, `profile_picture_id`, `edate` FROM `user`user  WHERE 
                `college_refid` IN (:collegeArray)';
                /*  && (`first_name` LIKE :name || `username` LIKE :name || `email` LIKE :name || `contact_number` LIKE :name || `phone_number` LIKE :name) limit 10 */
                $BIND = ['collegeArray'=>$College_Array];
                $result = $kali->kaliPulls($SQL,$BIND);
                if($result){
                    $kali->kaliReply($result);
                }
                
        }else{
            $SQL = 'SELECT * FROM `user` WHERE `id`=:id';
            $BIND = ['id'=>$_SESSION['KOHOMAH']];
            $result = $kali->kaliPull($SQL,$BIND);
            if($result){

                $SQL = 'SELECT *,(SELECT `name` FROM `authority` WHERE `id`=user.authority_refid) as AUTHORITY FROM `user` user 
                WHERE `college_refid`=:college_refid && `branch_refid`=:branch_refid
                && (`first_name` LIKE :name || `username` LIKE :name || `email` LIKE :name || `contact_number` LIKE :name || `phone_number` LIKE :name)
                && `id`!=:myid
                ';
                $BIND = [
                    'name'=>'%'.$_POST['SEARCH_DATA'].'%',
                    'myid'=>$_SESSION['KOHOMAH'],
                    'branch_refid'=>$result['branch_refid'],'college_refid'=>$result['college_refid']
                ];
                $result = $kali->kaliPulls($SQL,$BIND);
                if($result){
                    $kali->kaliReply($result);
                }

            }
        }
            
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Data Found']);
            die;

        }

?>


