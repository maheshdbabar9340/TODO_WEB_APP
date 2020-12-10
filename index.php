<?php
// Initialize the session
session_start();
 

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 

include('database_connection.php');
 

$username = $password = "";
$username_err = $password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
  
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
  
    if(empty($username_err) && empty($password_err)){

        
         $query = "SELECT id, username, password FROM users WHERE username = :username";
        

        if($stmt = $connect->prepare($query)){
            
            if($stmt->execute( 
                array(  
                'username'     =>     $_POST["username"]
                )  
            )  
           )
           {
           
                $result = $stmt->fetch();

                $count = $stmt->rowCount();  
                
               
                if($count > 0){                    
                   
                    $stmt->bindColumn('id', $id);
                    $stmt->bindColumn('username', $username);
                    $stmt->bindColumn('password',  $hashed_password);
                    
                    
                    if($result){

                        if(password_verify($password, $result['password'])){
                           
                            session_start();
                            
                           
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                         
                            header("location: welcome.php");

                        } else{
                            
                            $password_err = "The password you entered was not valid.";
                        }
                    }

                } else{
               
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            $connect=null;
        };
    }
    
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
       
        
        body{   
            font: 14px sans-serif;
            background: linear-gradient(to right, #9b9a9c, #403f41);
            }


        .wrapper{ 
                background-color: lightgrey;
                width: 100%;
                border: 2px solid black;
                padding: 40px;
                margin: 20px;
            }

        .box{
            padding: 5% 20% 5% 20%;
        }

        .buttons{
            text-align :center;
            padding:3px;
        }
        .login{
            text-align:center;
        }
        
           
    </style>
</head>
<body>

   <div class="box">
    <div class="wrapper">
            <h2 class="login">Login</h2>
            <p>Please fill in your credentials to login.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <div class="buttons">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                </div>
                <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            </form>
        </div>  
   </div>
</body>
</html>