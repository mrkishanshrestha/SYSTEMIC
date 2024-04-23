<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="NOTICE";
    $kali->checkAccess($APPLICATION,'DASH');
?>
<html>
<head>

    <?php
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('JQUERY');
        $kali->link('FONT_AWESOME');
        $kali->link('ICONIC_CARD');
    ?>

</head>
<body>

<style>

      * {
          text-align: left !important;
      }

      body {
        background:#eeeeee;
        overflow: scroll;
      }

      .item-menu {
        flex: 1;
        margin: 40px 80px;
        font-family: "Montserrat", Helvetica, sans-serif;
        font-weight: 200;
        font-size: 22px;
        color: #3A3A3A;
        letter-spacing: 1.5px;
        line-height: 31.37px;
        background: none;
        border: none;
      }

      .btn-pill {
        margin-left: 10px;
        padding: 3px 15px;
        display: inline-block;
        justify-content: center;
        position: relative;
        background: #FF3264;
        font-family: HelveticaNeue-Bold;
        font-size: 18px;
        color: #FFFFFF;
        border-radius: 50px;
      }

      .btn-alert {
        background: rgb(255,50,100)
      }

      .btn-danger {
        background: rgb(252,172,0)
      }

      .btn {
        font-family: "Montserrat", Helvetica, sans-serif;
        background: none;
        border: none;
        font-size: 22px;
        font-weight: 200;
        color: #3A3A3A;
        letter-spacing: 1.5px;
        text-align: center;
        transition: 0.1s;
      }

      .btn:hover {
        border-bottom: 5px solid #888888;
        font-weight: 400;
        cursor: pointer;
      }

      .btn-add {
        flex: 1;
        text-align: right;
        transition: 0.1s;
      }


      .btn-add:hover {
        font-weight: 400;
        cursor: pointer;
      }

      .ntfc-box {
        /*width: 370;*/
        height: auto;
        padding: 10px 20px;
        margin: auto;
        background: rgba(255,255,255,0.6);
        box-shadow: 0 3px 8px 0 rgba(0,0,0,0.2);
        border-radius: 4px;
        margin: 15px;
        position: auto;
      }

      .ntfc-box:hover {
        background: rgba(255,255,255,1);
        box-shadow: 0 3px 16px 0 rgba(0,0,0,0.03);
        transform: scale(1.02, 1.02);
        cursor: pointer;
      }

      .ntfc-alert {
        border-bottom: 3px solid rgba(255,50,100,0.8);
      }

      .ntfc-danger {
        border-bottom: 3px solid rgba(252,172,0,0.8);
      }

      h2 {
        display: inline-block;
        margin-right: 10px;
        font-weight: 500;
        letter-spacing: 2px;
        font-family: "Montserrat", Helvetica, sans-serif;
        font-size: 14px;
        color: #545454;
        letter-spacing: 0;
        line-height: 24px;
      }

      h3 {
        margin-top: 4px;
        display: flex-column;
        opacity: 0.9;
        font-family: "Montserrat", Helvetica, sans-serif;
        font-size: 17px;
        font-weight: 500;
        color: #222629;
        letter-spacing: 0.4px;
        line-height: 18.24px;
      }

      .ntfc-description {
        display: flex-column;
        opacity: 0.9;
        font-family: "Montserrat", Helvetica, sans-serif;
        font-size: 13.22px;
        color: #2D3337;
        letter-spacing: 0;
        line-height: 13.54px;
      }

      .date {
        margin-right: 10px;
      }

      .time {
        padding: 10px 15px;
      }

      .id {
        float: right;
      }

      .notification-list {
        margin: auto;
        width: 100%;
        /*position: relative;*/
        top: 130px;
        border: 4px solid lightgrey;
        box-shadow: 0 3px 16px 0 rgba(0,0,0,0.03);
        margin-top: 5vh;
      }

      @media only screen and (max-width: 1140px) {
          .btn {
            font-size: 18px;
          }
        
          .item-menu {
            font-size: 20px;
          }
      }

      @media only screen and (max-width: 820px) {
          .btn {
            font-size: 14px;
          }
        
          .item-menu {
            font-size: 16px;
          }
      }


      .notice-add-container { 
          width: 100%;
          border: 1px solid red;
          padding: 10px;
      }

      .notice-input-msg {
          width: 90%;
          border: 1px solid black;
          padding: 10px;
      }
      .notice-input-title {
          width: 70%;
          border: 1px solid black;
          padding: 10px;
      }
      .notice-publish-btn{
          padding: 10px;
          1px: s;
          background: #3939c6;
          color: white;
          margin: 1vw;
      }

</style>

<script>
        $(document).ready(function(){

            $(".ntfc-box").dblclick(function(){
                $(this).remove();
                updateLabels();
            });



        });

        function publish(COURSE_REFID){

          var TITLE = $('#notice-input-title').val();
          var MESSAGE = $('#notice-input-msg').val();

          var jackxData = juju.sendJackx({
              URL:'process.php',
              DATA:{'JACKX':'CHECKED','COURSE_REFID':COURSE_REFID,'TITLE':TITLE,'MESSAGE':MESSAGE}
          });
          
          jackxData.done(function(data){  
              data = JSON.parse(data);
              console.log(data);
              if(data.ERROR){
                  juju.alerty({
                      status:'danger',
                      msg:data.MSG,
                      title:'ERROR',
                      position:'top_right'
                  });
              }else{
                  juju.alerty({
                      status:'success',
                      msg:data.MSG,
                      title:'SUCESS',
                      position:'top_right'
                  });
              }
          });

        }

        function updateLabels() {
            var totalAlert = $('.ntfc-alert').length;
            $('#alert').text(totalAlert);
            var totalDanger = $('.ntfc-danger').length;
            $('#danger').text(totalDanger);
        }

        function appendNtfc(datetime,title,description) {
            var ntfc = `
                <div class="ntfc-box ntfc-alert">
                        <div class="ntfc-info">
                            <h2>`+datetime+`</h2>
                            <h2 class="id"></h2>
                        </div>
                        <h3>`+title+`</h3>
                        <p class="ntfc-description">
                        `+description+`
                        </p>
                </div>`;

            $('.notification-list').prepend(ntfc);
         }
</script>

    <?php
        if($kali->checkAccess($APPLICATION,'CREATE',true)){
      ?>
<div class="notice-add-container">
    <input type="text" class="notice-input-title" id="notice-input-title" placeholder="Enter Notice Title"/>
    <input type="text" class="notice-input-msg" id="notice-input-msg" placeholder="Enter Notice Message"/>
    <button class="notice-publish-btn" onclick="publish('<?php echo $_GET['COURSE_REFID'];?>');">Publish<button>
</div>

        <?php }?>

<div class="notification-list">

</div>


<?php
        $sql = 'SELECT  * FROM `notice` WHERE `course_refid`=:course_refid';
        $results = $kali->kaliPulls($sql,['course_refid'=>$_GET['COURSE_REFID']]);
        if($results){
            foreach($results as $data){
              ?>
                <script>
                   appendNtfc('<?php echo $data['datetime']; ?>','<?php echo $data['title']; ?>','<?php echo $data['msg']; ?>');
                </script>
              <?php
            }

        }

?>




</body>
</html>
