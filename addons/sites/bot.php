  <!-- button for logout and for login-->
  <form action="addons/logout.php" method="post">
    <button id="logout" type="submit" class="button" style="width:auto;">Logout</button>
  </form>
  <button id="login" onclick="document.getElementById('modalLogin').style.display='block'" class="button" style="width:auto;">Login</button>

  <?php 
    //include modal.php code here
    include "modal.php";
  ?>
  <!-- alerts that are displayed -->
  <div id="alert" class="alert alertS">
    <span class="alertText">Success</span>
    <span onclick="document.getElementById('alert').style.top='-50px'" class="close alertClose" title="Close Modal">&times;</span>
  </div>
  <div id="alert2" class="alert alertW">
    <span class="alertText">Fail</span>
    <span onclick="document.getElementById('alert2').style.top='-50px'" class="close alertClose" title="Close Modal">&times;</span>
  </div>
  <div id="alert3" class="alert alertQ1">
    <span class="alertText">1 Correct - 10 Points</span>
    <span onclick="document.getElementById('alert2').style.top='-50px'" class="close alertClose" title="Close Modal">&times;</span>
  </div>
  <div id="alert4" class="alert alertQ0">
    <span class="alertText">0 Correct - 0 Points</span>
    <span onclick="document.getElementById('alert2').style.top='-50px'" class="close alertClose" title="Close Modal">&times;</span>
  </div>
  <!-- 2 buttons that have JS code for changing the color of the background and the boxes -->
  <button id="buttonBlue" class="button" style="width:auto;margin-top: 60px;display:block" onclick="
  document.getElementById('buttonBlue').style.display='none'; 
  document.getElementById('buttonRed').style.display='block';
  document.getElementById('box1').style.backgroundColor='#58d';
  document.getElementById('box2').style.backgroundColor='#58d';
  document.getElementById('box3').style.backgroundColor='#58d';
  document.getElementById('box4').style.backgroundColor='#58d';
  document.getElementById('box5').style.backgroundColor='#58d';
  document.getElementById('body').style.background='radial-gradient(ellipse at bottom, #1b2735, #090a0f)'">Blue!</button>
  <!-- Display:none so it hidden until the button above is clicked -->
  <button id="buttonRed" class="button" style="width:auto;display:none; margin-top: 60px;display:none" onclick="
  document.getElementById('buttonRed').style.display='none'; 
  document.getElementById('buttonBlue').style.display='block';
  document.getElementById('box1').style.backgroundColor='#f2d16d';
  document.getElementById('box2').style.backgroundColor='#f2d16d';
  document.getElementById('box3').style.backgroundColor='#f2d16d';
  document.getElementById('box4').style.backgroundColor='#f2d16d';
  document.getElementById('box5').style.backgroundColor='#f2d16d';
  document.getElementById('body').style.background='#4d1f31'">Red!</button>
  <?php
  //set the url to this variable
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
    //changing what is in the url so that the correct alert is displayed
    //if any of there: display alert2
    if(strpos($url, "emptyfields") == true || strpos($url, "invalidinput") == true || strpos($url, "wrongpassword") == true || strpos($url, "sqlerror") == true || strpos($url, "usertaken") == true){
      ?>
      <script language="javascript">    
        document.getElementById("alert2").style.display = "block";
      </script>
      <?php
      //if success: display alert
    }elseif(strpos($url, "signup=success") == true){
      ?>
      <script language="javascript">    
        document.getElementById("alert").style.display = "block";
      </script>
      <?php
      //if user got 1 correct: display alert3
    }elseif(strpos($url, "1") == true){
      ?>
      <script language="javascript">    
        document.getElementById("alert3").style.display = "block";
      </script>
      <?php
      //if user got 0 correct: display alert4
    }elseif(strpos($url, "0") == true){
      ?>
      <script language="javascript">    
        document.getElementById("alert4").style.display = "block";
      </script>
      <?php
    }
  ?>
  <?php 
    //depending on the session display the right button 
    //if user logged in display logout
    if(isset($_SESSION['usersID'])){
      ?>
      <script language="javascript">    
        document.getElementById("logout").style.display = "block";
      </script>
      <?php
    }else{
      //else display login button
      ?>
      <script language="javascript">    
        document.getElementById("login").style.display = "block";
      </script>
      <?php
    }
  ?>
</body>
</html>