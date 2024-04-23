
<?php     
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION = "PAYMENT";
    $RIGHTS = "DASH";
   /* $kali->checkAccess($APPLICATION,$RIGHTS);*/
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $kali->link('FONT_AWESOME');
        $kali->link('ASSETS');
        $kali->link('JQUERY');
        $kali->link('CIRCLE_BAR');
        $kali->link('SPEED_BAR');
        $kali->link('BAR_GRAPH');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
    ?>

</head>

<body>

<?php 
    $Attendance_data = $kali->getStudentInfo(['CASE'=>'CLASSES_ATTENDED','ID'=>$_GET['USER_REFID']]);
    $performancePercentage = $kali->performanceEvulator($_GET['USER_REFID']);
    $pData = $kali->processPerformance($_GET['USER_REFID']);
    $weightedPerformanceScore = calculateWeightedPerformance($pData['TEST_SCORE'], $pData['ATTENDANCE'], $pData['ASSIGNMENT_MARKS']);
    

?>

<h1> Perfomance Overview</h1>

    <div id="main-container">

        <div id="speed-bar"></div>

        <div id="barchart-main"></div>

        <div id="attendance-circle-bar"></div>

        <iframe style="height: 230px;width: 100%;" src="https://www.systemic.com/ROOT/APPS/PERFORMANCE_EVALUATOR/MAIN/weightedPerformance.php?USER_REFID=<?php echo $_GET['USER_REFID'];?>"></iframe>

        <script>
                    document.addEventListener("DOMContentLoaded", function(event) { 
                        
                        createSpeedBar("speed-bar",'Your Predicted Performance For Finals',<?php echo $performancePercentage;?>);
            
                        juju.createCircleBar('attendance-bar',"Classes -- Attended : ",<?php echo $Attendance_data;?>,'attendance-circle-bar');
                 
                        function getStudentDatas(USER_REFID) {

                            var jackxData = juju.postJackx('getPerformanceData.php',{USER_REFID: USER_REFID});

                            jackxData.done(function(data){

                                if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

                                jsonData=JSON.parse(data);
                                console.log(jsonData);
                                createBarGraph(jsonData,"barchart-main",'');
                      

                            });

                        }

                        getStudentDatas('<?php echo $_GET['USER_REFID']; ?>');

                    });
        </script>

    </div>





</body>
</html>


