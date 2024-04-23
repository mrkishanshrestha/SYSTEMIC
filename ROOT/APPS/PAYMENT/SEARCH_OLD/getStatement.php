<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

 
        if(isset($_POST['SEARCH'])){


            $domain = $kali->getSite();
            $TOTAL_CREDIT_AMO = "";
            $TOTAL_DEBIT_AMO = "";
            $sql = 'SELECT `id`, `student_id`, `college_id`, `debit_amount`, `credit_amount`, `description`, `entry_date` FROM `student_financial_record` WHERE `student_id`=:student_id';
            $data = $kali->kaliPulls($sql,['student_id'=>$_POST['DB_TUPLE_ID']]);
            if($data){

                $counter = 0;
                $currentDate = date("Y-m-d");
                foreach($data as $rows){

                    $SQL2 = 'SELECT sum(`debit_amount`) as totalDebit FROM `student_financial_record` WHERE `student_id`=:student_id';
                    $data2 = $kali->kaliPull($SQL2,['student_id'=>$_POST['DB_TUPLE_ID']]);
                    if($data2){
                        $TOTAL_DEBIT_AMO = $data2['totalDebit'];
                        $data[$counter]['TOTAL_DEBIT'] = $data2['totalDebit'];
                    }

                    $SQL2 = 'SELECT sum(`credit_amount`) as tatalCredit FROM `student_financial_record` WHERE `student_id`=:student_id';
                    $data2 = $kali->kaliPull($SQL2,['student_id'=>$_POST['DB_TUPLE_ID']]);
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





