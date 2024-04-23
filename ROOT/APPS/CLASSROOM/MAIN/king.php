<?php
    include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION = "CLASSROOM";
    $RIGHTS = "DASH";
?>
<html>
<head>

    <?php
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('JQUERY');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('FONT_AWESOME');
        $kali->link('ICONIC_CARD');
        $kali->link('BOOTSTRAP');
    ?>

</head>
<body>

<style>
    .main-board>.iconic-card-conatiner {
    flex-wrap: wrap !important;
    display: flex !important;
}
    </style>

<?php

    $assigned_teacher;
 if($kali->checkMyAutho('TEACHER')){
    $SQL ="SELECT user.id,user.college_refid,user.branch_refid, course.faculty_period,course.faculty_id,
    course.id as course_refid,
    (SELECT short_name FROM faculty WHERE id=course.faculty_id) as faculty_shortname,
    (SELECT based_on FROM faculty WHERE id=course.faculty_id) as faculty_basedon,
    ca.course_refid, course.course_name, course.course_code
    FROM `user` user
    INNER JOIN course_assigned ca ON ca.user_refid = user.id
    INNER JOIN course course ON course.id = ca.course_refid
    WHERE user.id = :value ";
    $BIND = ['value'=>$_SESSION['KOHOMAH']];
    $results = $kali->kaliPulls($SQL,$BIND);
    if(!$results){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'You Have Not Been Assigned With Any Courses Yet !']);
        die;
    }
}else{

    $SQL = "SELECT course.id as course_refid,course.course_name,course.course_code,course.id,
    (SELECT CONCAT(`first_name`, ' ', `middle_name`, ' ', `last_name`) FROM `user` WHERE `id` = (SELECT `user_refid` FROM `course_assigned` WHERE `course_refid`= course.id )) as assigned_teacher_name
    FROM `user` user
    INNER JOIN `student_data` student_data ON student_data.user_refid = user.id
    INNER JOIN `course` course on course.faculty_id = student_data.faculty_refid AND course.faculty_period = student_data.faculty_period
    WHERE user.id = :user_refid ";
    $BIND = ['user_refid'=>$_SESSION['KOHOMAH']];
    $results = $kali->kaliPulls($SQL,$BIND);
    if(!$results){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'You Have Not Been Assigned With Any Courses Yet !']);
        die;
    }



}
    

?>

<section class="main-board" id="main-board">

    <div class="iconic-card-conatiner">

        <?php if($kali->checkMyAutho('TEACHER')){?>
            <?php foreach($results as $result){?>
                <div class="iconic-card kali-glow" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/CLASSROOM/SEARCH/king.php?COURSE_REFID=<?php echo $result['course_refid'];?>');">
                    <div><i class="fa-solid fa-user-plus iconic-card-icon"></i></div>
                    <span class="iconic-card-title">
                        <?php echo $result['course_name']?>
                        <br>
                        ( <?php echo $result['course_code']?> )
                        <br>
                        ( <?php echo $result['faculty_shortname'].' '.$result['faculty_period'].' '.$result['faculty_basedon']?> )

                    </span>
                </div>
            <?php } ?>
        <?php } ?>

        <?php if($kali->checkMyAutho('STUDENT')){?>
            <?php foreach($results as $result){
                    if($result['assigned_teacher_name']==NULL){
                        $assigned_teacher = "Lecturer Not Assigned";
                    }
                    $assigned_teacher = $result['assigned_teacher_name'];
                ?>
                <div class="iconic-card kali-glow" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/CLASSROOM/SEARCH/king.php?COURSE_REFID=<?php echo $result['course_refid'];?>');">
                    <div><i class="fa-solid fa-user-plus iconic-card-icon"></i></div>
                    <span class="iconic-card-title">
                        <?php echo $result['course_name']?>
                        <br>
                        ( <?php echo $result['course_code']?> )
                        <br>
                        ( <?php echo $assigned_teacher?> )
                    </span>
                </div>
            <?php } ?>
        <?php } ?>

    </div>

</section>

</body>
</html>
