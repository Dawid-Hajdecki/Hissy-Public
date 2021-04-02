<!-- php code -->
<?php
  //takes the users data and inserts it in the profile modal
  //if there is a session (if the user is logged in)
  if(!empty($_SESSION['usersID'])){
    require 'addons/database.php';
    //Find users data and put it in $row
    $sql = "SELECT * FROM users WHERE usersID=".$_SESSION['usersID'];
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
  }
  //calculates score for the quiz
  //if user is logged in
  if(!empty($_SESSION['usersID'])){
    //if user clicked on button
    if(isset($_POST['quiz-submit'])) {
      //asign variables
      $q1 = $_POST['q1'];
      $win = 0;
      $score = $row['usersScore'];
      $maxQuiz = $row['usersMaxQuiz'];
      //if user is correct
      if ($q1 == "Warszawa"){
        //add 10score
        $score += 10;
        $win += 10;
        $maxQuiz += 1;
      }
      //update database
      $sql = "UPDATE users SET usersScore=".$score.", usersMaxQuiz=".$maxQuiz." WHERE usersID=".$_SESSION['usersID'];
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      //exit with correct message for alerts
      if($win == 10){
        header("location: index.php?1");
      }elseif($win == 0){
        header("location: index.php?0");
      }
    }
  }
?>
<!-- Modal that lets the user log-in -->
<div id="modalLogin" class="modal modalLogin">
  <!-- Top of the modal with close button and a heading -->
  <div class="modalSmall top">
    <h1>Login</h1>
    <span onclick="document.getElementById('modalLogin').style.display='none'" class="close"
      title="Close Modal">&times;</span>
  </div>
  <!-- Center of Modal with inputs and a button -->
  <div class="modalCenter modalCenterLogin">
    <form action="addons/login.php" method="post">
      <input type="email" placeholder="Enter Email" name="email" required>
      <input type="password" placeholder="Enter Password" name="psw" required>
      <button type="submit" class="submit" name="login-submit">Submit</button>
    </form>
  </div>
  <!-- Bottom of the modal with a link to the register modal and a forgotted password modal -->
  <div class="modalSmall bot">
    <h1 onclick="document.getElementById('modalLogin').style.display='none'; document.getElementById('modalRegister').style.display='block';"
      class="modalHeading" title="Register">Register</h1>
    <span class="link">Forgot <a onclick="document.getElementById('modalPassword').style.display='block'">password ?</a></span>
  </div>
</div>
<!-- Register modal - possible to go back to the login modal -->
<div id="modalRegister" class="modal modalRegister">
  <div class="modalSmall top">
    <h1>Register</h1>
    <span onclick="document.getElementById('modalRegister').style.display='none'" class="close"
      title="Close Modal">&times;</span>
  </div>
  <div class="modalCenter modalCenterRegister">
  <!-- Register form -->
    <form action="addons/signup.php" method="post">
      <input type="email" placeholder="Enter Email" name="email" required>
      <input type="password" placeholder="Enter Password" name="psw" minlength="8" required>
      <input type="password" placeholder="Repeat Password" name="rpsw" minlength="8" required>
      <input type="text" placeholder="Enter Memorable Word" name="word" maxlength="7" required> 
      <h4 style="padding-left:20px;transform: translatey(-25px);">You will use this word when you forget your password </h4>
      <button type="submit" class="submit" name="register-submit">Submit</button>
    </form>
  </div>
  <div class="modalSmall bot">
    <!-- link to the login modal-->
    <h1 onclick="document.getElementById('modalRegister').style.display='none'; document.getElementById('modalLogin').style.display='block'"
      class="modalHeading" title="Register">Login</h1>
  </div>
</div>
<!-- Contact modal -->
<div id="modalContact" class="modal modalContact">
  <div class="modalSmall top">
    <h1>Contact</h1>
    <span onclick="document.getElementById('modalContact').style.display='none'" class="close" title="Close Modal">&times;</span>
  </div>
  <!-- Contact form-->
  <div class="modalCenter modalCenterContact">
    <form action="addons/contact.php" method="post">
      <input type="email" placeholder="Enter Email" name="email" required><br>
      <input type="text" placeholder="Topic" name="topic" required>
      <textarea name="message" placeholder="Write message.." required></textarea>
      <button type="submit" class="submit" name="contact-submit">Submit</button>
    </form>
  </div>
</div>
<!-- Profile modal -->
<div id="modalProfil" class="modal modalProfil">
  <div class="modalSmall top">
    <h1>Profil</h1>
    <span onclick="document.getElementById('modalProfil').style.display='none'" class="close" title="Close Modal">&times;</span>
  </div>
  <div class="modalCenter modalCenterProfil">
    <!-- This is where I use the php code from the top of this page. -->
    <label>User ID :
    <?php echo $row['usersID'];  ?>
    </label>
    <label>User Email :
    <?php echo $row['usersEmail']; ?>
    </label>
    <label>Memorable Word :
    <?php echo $row['usersMem']; ?>
    </label>
    <label>Score :
    <?php echo $row['usersScore'];  ?>
    </label>
  </div>
  <div class="modalSmall bot">
    <!-- links to 2 different modals -->
  <span class="link top" onclick="document.getElementById('modalDelete').style.display='block'"><a>Delete Account</a></span>
    <span class="link" onclick="document.getElementById('modalPassword').style.display='block'"><a>Change password</a></span>
  </div>
</div>
<!-- Forgoten password modal and change password modal -->
<div id="modalPassword" class="modal modalProfil">
  <div class="modalSmall ">
    <h1>Change</h1>
    <span onclick="document.getElementById('modalPassword').style.display='none'" class="close" title="Close Modal">&times;</span>
  </div>
  <div class="modalCenter modalCenterPassword">
  <?php
    //if user logged in display change password form
    if(isset($_SESSION['usersID'])){
      ?>
      <form action="addons/changepassword.php" method="post">
      <input type="password" placeholder="Enter old password..." name="Opsw" required>
      <input type="password" placeholder="Enter new password..." name="Npsw" required>
      <button type="submit" class="submit" name="password-submit">Submit</button>
    <?php
    }else{
      //else display restore password form
      ?>
      <form action="addons/restorepassword.php" method="post">
      <input type="email" placeholder="Enter Email" name="email" required>
      <input type="text" placeholder="Enter memorable word" name="mWord" required>
      <input type="password" placeholder="Enter new password..." name="Npsw" required>
      <button type="submit" class="submit" name="restore-password-submit">Submit</button>
    <?php
    }
    ?>
  </form>
  </div>
</div>
<!-- Delete account modal -->
<div id="modalDelete" class="modal modalProfil">
  <div class="modalSmall ">
    <h1>Delete</h1>
    <span onclick="document.getElementById('modalDelete').style.display='none'" class="close" title="Close Modal">&times;</span>
  </div>
  <div class="modalCenter modalCenterPassword">
    <!-- delete account form -->
    <form action="addons/deleteacc.php" method="post">
      <input type="text" placeholder="Enter memorable word..." name="mWord" required>
      <input type="password" placeholder="Enter password..." name="psw" required>
      <button type="submit" class="submit" name="delete-account-submit">Submit</button>
    </form>
  </div>
</div>
<!-- About modal -->
<div id="modalAbout" class="modal modalAbout">
  <div class="modalSmall ">
    <h1>About</h1>
    <span onclick="document.getElementById('modalAbout').style.display='none'" class="close" title="Close Modal">&times;</span>
  </div>
  <div class="modalCenter modalCenterAbout" >
  <!-- Some text -->
    <h2>About Me</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi repellat aspernatur at asperiores sed cum officia sunt, quis, quae dolores optio sint soluta obcaecati quos, nihil nobis voluptatibus vitae sequi ipsa unde. Eligendi autem, atque id unde exercitationem soluta quis sequi molestiae hic, velit asperiores tenetur iste quisquam eum distinctio impedit dolorem assumenda recusandae culpa ullam, dolorum repudiandae! Reiciendis repellendus quidem hic ab dignissimos quo! Molestias ratione tempore dolores vel soluta facere illum at repellat earum eos perferendis cupiditate voluptatem excepturi explicabo, sint aliquid quisquam ab cum quos animi doloribus omnis ipsam reprehenderit ullam. Fugit consectetur fuga dolorum facere perspiciatis.</p>
    <h2>About Site</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi repellat aspernatur at asperiores sed cum officia sunt, quis, quae dolores optio sint soluta obcaecati quos, nihil nobis voluptatibus vitae sequi ipsa unde. Eligendi autem, atque id unde exercitationem soluta quis sequi molestiae hic, velit asperiores tenetur iste quisquam eum distinctio impedit dolorem assumenda recusandae culpa ullam, dolorum repudiandae! Reiciendis repellendus quidem hic ab dignissimos quo! Molestias ratione tempore dolores vel soluta facere illum at repellat earum eos perferendis cupiditate voluptatem excepturi explicabo, sint aliquid quisquam ab cum quos animi doloribus omnis ipsam reprehenderit ullam. Fugit consectetur fuga dolorum facere perspiciatis.</p>
  </div>
</div>
<!-- Education modal -->
<div id="modalEducation" class="modal modalEduQuiz">
  <div class="modalSmall ">
    <h1>Education</h1>
    <span onclick="document.getElementById('modalEducation').style.display='none'" class="close" title="Close Modal">&times;</span>
  </div>
  <div class="modalCenter modalCenterEduQuiz">
  <!-- Button for next modal -->
    <button class="box" onclick="document.getElementById('modalEducationPoland').style.display='block'">
      <div class="boxText">Poland</div>
    </button>
  </div>
</div>
<!-- Education modal Poland -->
<div id="modalEducationPoland" class="modal modalEduQuiz">
  <div class="modalSmall ">
    <h1>Education - PL</h1>
    <span onclick="document.getElementById('modalEducationPoland').style.display='none'" class="close" title="Close Modal">&times;</span>
  </div>
  <div class="modalCenter modalCenterEduQuiz">
  <!-- Some text -->
    <h2>About Poland - New</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi repellat aspernatur at asperiores sed cum officia sunt, quis, quae dolores optio sint soluta obcaecati quos, nihil nobis voluptatibus vitae sequi ipsa unde. Eligendi autem, atque id unde exercitationem soluta quis sequi molestiae hic, velit asperiores tenetur iste quisquam eum distinctio impedit dolorem assumenda recusandae culpa ullam, dolorum repudiandae! Reiciendis repellendus quidem hic ab dignissimos quo! Molestias ratione tempore dolores vel soluta facere illum at repellat earum eos perferendis cupiditate voluptatem excepturi explicabo, sint aliquid quisquam ab cum quos animi doloribus omnis ipsam reprehenderit ullam. Fugit consectetur fuga dolorum facere perspiciatis.</p>
    <h2>About Poland - Old</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi repellat aspernatur at asperiores sed cum officia sunt, quis, quae dolores optio sint soluta obcaecati quos, nihil nobis voluptatibus vitae sequi ipsa unde. Eligendi autem, atque id unde exercitationem soluta quis sequi molestiae hic, velit asperiores tenetur iste quisquam eum distinctio impedit dolorem assumenda recusandae culpa ullam, dolorum repudiandae! Reiciendis repellendus quidem hic ab dignissimos quo! Molestias ratione tempore dolores vel soluta facere illum at repellat earum eos perferendis cupiditate voluptatem excepturi explicabo, sint aliquid quisquam ab cum quos animi doloribus omnis ipsam reprehenderit ullam. Fugit consectetur fuga dolorum facere perspiciatis.</p>
  </div>
</div>
<!-- Quizz modal -->
<div id="modalQuizzes" class="modal modalEduQuiz">
  <div class="modalSmall">
    <h1>Quizzes</h1>
    <span onclick="document.getElementById('modalQuizzes').style.display='none'" class="close" title="Close Modal">&times;</span>
  </div>
  <div class="modalCenter modalCenterEduQuiz">
  <!-- Button for next modal -->
  <button class="box" onclick="document.getElementById('modalQuizzesPoland').style.display='block'">
      <div class="boxText">Poland</div>
    </button>
  </div>
</div>
<!-- Quizz modal Poland-->
<div id="modalQuizzesPoland" class="modal modalEduQuiz">
  <div class="modalSmall">
    <h1>Quizzes - PL</h1>
    <span onclick="document.getElementById('modalQuizzesPoland').style.display='none'" class="close" title="Close Modal">&times;</span>
  </div>
  <div class="modalCenter modalCenterEduQuiz">
    <div style="margin-left:10px;">
    <?php
    // if user not logged in, or if he is logged in then make sure he/she did not attempt this quizz more than 3 times
    if(empty($_SESSION['usersID']) || $row['usersMaxQuiz'] <3){?>
      <form id="quiz1" name="quiz1" method="post">
        <h2 style="margin:5px;">Quiz 1</h2>
        <span style="font-weight:bold;">What is the capital of Poland?</span><br>
        <input type="radio" name="q1" value="Warszawa">Warszawa<br>
        <input type="radio" name="q1" value="Krakow">Krakow<br>
        <input type="radio" name="q1" value="Katowice">Katowice<br>
        <input type="radio" name="q1" value="Szczecin">Szczecin<br>
        <input type="submit" value="Submit" name="quiz-submit">
      </form>
      <?php
      //else display message
      }else echo "<h3>You did this quiz 3 times already</h3>";?>
    </div>
  </div>
</div>