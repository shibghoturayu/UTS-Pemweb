<?php  

   // Lampirkan dbconfig 

   require_once "dbconfig.php"; 

   // Cek status login user 

   if($user->isLoggedIn()){ 

     header("location: index.php"); //Redirect ke index 

   } 

   //Cek adanya data yang dikirim 

   if(isset($_POST['kirim'])){ 
   	$first_name = $_POST['first_name']; 


     $last_name = $_POST['last_name']; 

     $email = $_POST['email'];
     $username = $_POST['username'];

     $password = $_POST['password']; 

     // Registrasi user baru 

     if($user->register($first_name, $last_name, $email, $username, $password)){ 

       // Jika berhasil set variable success ke true 

       $success = true; 

     }else{ 

       // Jika gagal, ambil pesan error 

       $error = $user->getLastError(); 

     } 

   } 

  ?> 

 <!DOCTYPE html>  

 <html>  

   <head> 

     <meta charset="utf-8"> 

     <title>Register</title> 

     <link rel="stylesheet" href="style.css" media="screen" title="no title" charset="utf-8"> 

   </head> 

   <body> 

     <div class="login-page"> 

      <div class="form"> 

        <form class="register-form" method="post"> 

        <?php if (isset($error)): ?> 

          <div class="error"> 

            <?php echo $error ?> 

          </div> 

        <?php endif; ?> 

        <?php if (isset($success)): ?> 

          <div class="success"> 

            Berhasil mendaftar. Silakan <a href="login.php">login</a>. 

          </div> 

        <?php endif; ?> 

         <input type="text" name="first_name" placeholder="first_name" required/> 
         <input type="text" name="last_name" placeholder="last_name" required/> 

         <input type="email" name="email" placeholder="email address" required/>
         <input type="text" name="username" placeholder="username" required/>  

         <input type="password" name="password" placeholder="password" required/> 

         <button type="submit" name="kirim">create</button> 

         <p class="message">Already registered? <a href="login.php">Sign In</a></p> 

        </form> 

      </div> 

     </div> 

   </body> 

 </html>  