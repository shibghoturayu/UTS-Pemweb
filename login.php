<?php  

   // Lampirkan dbconfig 

   require_once "dbconfig.php"; 

   // Cek status login user 

   if($user->isLoggedIn()){ 

     header("location: index.php"); //redirect ke index 

   } 

   //jika ada data yg dikirim 

   if(isset($_POST['kirim'])){ 

     $username = $_POST['username']; 

     $password = $_POST['password']; 

     // Proses login user 

     if($user->login($username, $password)){ 

       header("location: index.php"); 

     }else{ 

       // Jika login gagal, ambil pesan error 

       $error = $user->getLastError(); 

     } 

   } 

  ?> 

 <!DOCTYPE html>  

 <html>  

   <head> 

     <meta charset="utf-8"> 

     <title>Login</title> 

     <link rel="stylesheet" href="style.css" media="screen" title="no title" charset="utf-8"> 

   </head> 

   <body> 

     <div class="login-page"> 

      <div class="form"> 

       <form class="login-form" method="post"> 

        <?php if (isset($error)): ?> 

          <div class="error"> 

            <?php echo $error ?> 

          </div> 

        <?php endif; ?> 

        <input type="username" name="username" placeholder="username" required/> 

        <input type="password" name="password" placeholder="password" required/> 

        <button type="submit" name="kirim">login</button> 

        <p class="message">Not registered? <a href="register.php">Create an account</a></p> 

       </form> 

      </div> 

     </div> 

   </body> 

 </html>  