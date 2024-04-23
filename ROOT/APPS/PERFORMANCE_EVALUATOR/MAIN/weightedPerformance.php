
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
    $pData = $kali->processPerformance($_GET['USER_REFID']);
    $weightedPerformanceScore = calculateWeightedPerformance($pData['TEST_SCORE'], $pData['ATTENDANCE'], $pData['ASSIGNMENT_MARKS']);
   
?>

    <div id="main-container">

        <div id="speed-bar"></div>

        <script>
                    document.addEventListener("DOMContentLoaded", function(event) { 
                        
                        createSpeedBar("speed-bar",'Your Predicted Weighted Performance For Finals',<?php echo $weightedPerformanceScore;?>);
            
                       
                    });
        </script>

    </div>





</body>
</html>


