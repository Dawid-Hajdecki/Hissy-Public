<?php 
  include "addons/sites/top.php";
?>
<body id="body">
  <!-- Header -->
  <Header>
  <!-- Hissy word -->
    <div class="logo"><a href="../hissy"> HISSY</a></div>
  </Header>
  <!-- Section -->
  <section>
    <div class="all">
      <?php 
      //if user logged-in display profile button normally
      if(isset($_SESSION['usersID'])){
        ?>
        <div id="box1" class="box leftleft" onclick="document.getElementById('modalProfil').style.display='block'">
          <div class="boxText">Profile</div>
        </div>
      <?php
      }else{
        //else display the button but add style boxDisable (unables the user from clicking on it)
        ?>
        <div id="box1" class="box leftleft boxDisable">
          <div class="boxText">Profile - Login First</div>
        </div>
      <?php
      }
      //Display the other 4 boxes
      ?>
      <div id="box2" class="box left" onclick="document.getElementById('modalEducation').style.display='block'">
        <div class="boxText">Education</div>
      </div>
      <div id="box3" class="box center" onclick="document.getElementById('modalQuizzes').style.display='block'">
        <div class="boxText">Quizzes</div>
      </div>
      <div id="box4" class="box right" onclick="document.getElementById('modalAbout').style.display='block'">
        <div class="boxText">About</div>
      </div>
      <div id="box5" class="box rightright" onclick="document.getElementById('modalContact').style.display='block'">
        <div class="boxText">Contact</div>
      </div>
    </div>
  </section>
  <footer>
    <div class="fText">Website By Dawid Hajdecki</div>
  </footer>
  <?php
    include "addons/sites/bot.php";
  ?>