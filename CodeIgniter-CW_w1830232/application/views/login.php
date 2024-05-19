<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<style>
/* Universal box model */
* {
  box-sizing: border-box;
}

/* Body styles */
body {
  background-image: url('../imgs/new5.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  color: #a63557;
  height: 100%
}
html, body {
  height: 90%
}
 
input[type=text], input[type=password], select, textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
  background-color: #f2f2f2;
  color: black;
}

input.error, input.error[type=password], select.error, textarea.error {
  border-color: red;
}
 
label {
  padding: 13px 13px 13px 0;
  display: inline-block;
  font-weight: bold;
}

input[type=submit] {
  background-color: #5a2b5c;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

 
input[type=submit]:hover {
  background-color: #490b57;
}

 
.container {
  border-radius: 10px; 
  padding: 50px;
  margin: 90px auto;
  max-width: 40%;
  height: 50%;
  box-shadow: 0px 0px 20px 0px Red; 
  backdrop-filter: blur(10px);
}
 
h1 {
  text-align: center;
  font-weight: bold;
  font-size: 40px;
}
 
.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

 
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}

/* Alert styles */
.alert {
  color: red;
  padding: 15px;
  border-radius: 4px;
}

</style>
</head>
<body>
<div class="container">
<h1>LOGIN</h1>
  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
  <?php endif; ?>
  <form method="post" action="<?=base_url('auth/submitLogin')?>">
    <!-- Username input field -->
    <div class="row">
      <div class="col-25">
        <label for="username">Username</label>
      </div>
      <div class="col-75">
        <input type="text" id="username" name="username" placeholder="Your Username" class="<?= form_error('username') ? 'error' : '' ?>">
        <?php if(form_error('username')) echo '<div style="color:red">'.form_error('username').'</div>'; ?>
      </div>
    </div>
    <!-- Password input field -->
    <div class="row">
      <div class="col-25">
        <label for="password">Password</label>
      </div>
      <div class="col-75">
        <input type="password" id="password" name="password" placeholder="Your Password" class="<?= form_error('password') ? 'error' : '' ?>">
        <?php if(form_error('password')) echo '<div style="color:red">'.form_error('password').'</div>'; ?>
      </div>
    </div>
    <!-- Submit button -->
    <div class="row">
      <input type="submit" value="Submit">
    </div>
  </form>
  <!-- Link to signup page -->
  <div>
    <p style="font-size: 16px; font-weight: bold; color: #000; text-stroke: 3px #fff;">
        Don't have an account? Click <a href="<?=base_url('auth/register')?>">here</a>
    </p>
</div>

</div>
</body>
</html>
