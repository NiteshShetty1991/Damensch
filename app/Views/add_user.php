<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <div class="title">Registration</div>
    <div class="content">
        <?php
          if(session()->has('message'))
          {
          ?>
              <div class="alert alert-danger">
                  <?php
                  echo session('message');
                  ?>
              </div>
          <?php
          }

          if(session()->has('success_message'))
          {
          ?>
              <div class="alert alert-success">
                  <?php
                  echo session('success_message');
                  ?>
              </div>
          <?php
          }
        ?>
      <form method="post" action="<?= site_url('/submit-form') ?>">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Full Name</span>
            <input type="text" name="fullname" placeholder="Enter your full name" required>
          </div>
          <div class="input-box">
            <span class="details">Username</span>
            <input type="text" name="username" placeholder="Enter your username" required>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" name="email" placeholder="Enter your email" required>
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" name="password" id="PassEntry" placeholder="Enter your password" class="passwordInput" required>
            <br>
            <span id="StrengthDisp" class="badge displayBadge">Weak</span>
            <br>
          </div>
          <div class="input-box">
            <div class="g-recaptcha" data-sitekey="6Lf4CtEcAAAAAFn5iTUO3KRMqAHN1vX8sof0l_st"></div>
          </div>
        </div>
        <div class="button">
          <input type="submit" value="Register">
        </div>
      </form>
    </div>
  </div>
<script type="text/javascript">
DeBounce_APIKEY = 'public_OGtSdFM2aXk0VnFVNlVTSXcyTlRYdz09';
DeBounce_BlockFreeEmails = 'false'; //Set this value true to block free emails like Gmail.

  // timeout before a callback is called

    let timeout;

    // traversing the DOM and getting the input and span using their IDs

    let password = document.getElementById('PassEntry')
    let strengthBadge = document.getElementById('StrengthDisp')

    strengthBadge.style.display = 'none'

    // The strong and weak password Regex pattern checker

    let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})')
    let mediumPassword = new RegExp('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))')
    
    function StrengthChecker(PasswordParameter){
        // We then change the badge's color and text based on the password strength

        if(strongPassword.test(PasswordParameter)) {
            strengthBadge.style.backgroundColor = "green"
            strengthBadge.textContent = 'Strong'
        } else if(mediumPassword.test(PasswordParameter)){
            strengthBadge.style.backgroundColor = 'blue'
            strengthBadge.textContent = 'Medium'
        } else{
            strengthBadge.style.backgroundColor = 'red'
            strengthBadge.textContent = 'Weak'
        }
    }

    // Adding an input event listener when a user types to the  password input 

    password.addEventListener("input", () => {

        //The badge is hidden by default, so we show it

        strengthBadge.style.display= 'block'
        clearTimeout(timeout);

        //We then call the StrengChecker function as a callback then pass the typed password to it

        timeout = setTimeout(() => StrengthChecker(password.value), 500);

        //Incase a user clears the text, the badge is hidden again

        if(password.value.length !== 0){
            strengthBadge.style.display != 'block'
        } else{
            strengthBadge.style.display = 'none'
        }
    });
</script>
<script async type="text/javascript" src="https://cdn.debounce.io/widget/DeBounce.js"></script>
</body>
</html>
