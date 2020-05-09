<?php

class Auth 

   { 

     private $db; //Menyimpan Koneksi database 

     private $error; //Menyimpan Error Message 

     ## Contructor untuk class Auth, membutuhkan satu parameter yaitu koneksi ke database ## 

     function __construct($db_conn) 

     { 

       $this->db = $db_conn; 

       // Mulai session  

       session_start(); 

     } 
	public function register($first_name, $last_name, $username, $email, $password){
		try{
			$hashPassword = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $this->db->prepare("INSERT INTO tbAuth(first_name, last_name, username, email, password)VALUES(:first_name, :last_name, :username, :email, :password)");
			$stmt->bindParam(":first_name", $first_name);
			$stmt->bindParam(":last_name", $last_name);
      $stmt->bindParam(":username", $username);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":password", $hashPassword);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e){
			if($e->errorInfo[0] == 23000){
				$this->error = "Email sudah digunakan, mohon masukkan email yang tepat";
				return false;
			}else{
				echo $e->getMessage();
				return false;
			}
		}
	}
	public function login($username, $password){ 
       try{ 

         $stmt = $this->db->prepare("SELECT * FROM tbAuth WHERE username = :username"); 
         $stmt->bindParam(":username", $username); 
         $stmt->execute(); 
         $data = $stmt->fetch(); 
         if($stmt->rowCount() > 0){ 
         	if(password_verify($password, $data['password'])){
         		$_SESSION['user_session'] = $data['id'];
         		return true;
         	}
          else
          {
         	  	$this->error = "username atau Password Salah";
            	return false; 
            }
       }else{
       		$this->error = "username atau Password Salah";
       		return false;
       }
   } catch (PDOException $e){
   		echo $e->getMessage(); 
   		return false;
   } 
} 
     public function isLoggedIn(){
     	if(isset($_SESSION['user_session']))
     	{ 
     		return true; 
     	} 
    } 
    public function getUser(){ 
        if(!$this->isLoggedIn()){ 
           	return false; 
        }try { 
            $stmt = $this->db->prepare("SELECT * FROM tbAuth WHERE id = :id"); 
            $stmt->bindParam(":id", $_SESSION['user_session']); 
            $stmt->execute(); 
            return $stmt->fetch(); 
        } 
        catch (PDOException $e){
            echo $e->getMessage(); 
            return false;
        } 
    }
    public function logout(){ 
        session_destroy(); 
        unset($_SESSION['user_session']); 
        return true;
    }
    public function getLastError(){
      	return $this->error; 
    } 
} 
?> 