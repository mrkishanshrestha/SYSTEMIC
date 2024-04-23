<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

        if(isset($_POST['SEARCH'])){

            $TOTAL_CREDIT_AMO = "";
            $TOTAL_DEBIT_AMO = "";
            $sql = 'SELECT `id`, `user_refid`, `debit_amount`, `credit_amount`, `description`, `entry_date`,
            (SELECT CONCAT(`first_name`," ",`last_name`) FROM `user` WHERE `id`=:user_refid) as fullname
             FROM `financial_statement` WHERE `user_refid`=:user_refid ORDER BY `entry_date` ASC';
            $data = $kali->kaliPulls($sql,['user_refid'=>$_POST['DB_TUPLE_ID']]);
            if($data){

                $counter = 0;

                foreach($data as $rows){

                    $SQL2 = 'SELECT sum(`debit_amount`) as totalDebit FROM `financial_statement` WHERE `user_refid`=:user_refid';
                    $data2 = $kali->kaliPull($SQL2,['user_refid'=>$_POST['DB_TUPLE_ID']]);
                    if($data2){
                        $TOTAL_DEBIT_AMO = $data2['totalDebit'];
                        $data[$counter]['TOTAL_DEBIT'] = $data2['totalDebit'];
                    }

                    $SQL2 = 'SELECT sum(`credit_amount`) as tatalCredit FROM `financial_statement` WHERE `user_refid`=:user_refid';
                    $data2 = $kali->kaliPull($SQL2,['user_refid'=>$_POST['DB_TUPLE_ID']]);
                    if($data2){
                        $TOTAL_CREDIT_AMO = $data2['tatalCredit'];
                        $data[$counter]['TOTAL_CREDIT'] = $data2['tatalCredit'];
                    }

                    $data[$counter]['TOTAL_BALANCE'] = $TOTAL_CREDIT_AMO-$TOTAL_DEBIT_AMO;

                    $counter++;
                }

                $kali->kaliReply($data);
            }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found ','TARGET'=>['FACULTY']]);
            }
        }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>





