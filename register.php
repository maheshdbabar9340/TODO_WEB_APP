<?php

include('database_connection.php');


$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Process when form submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
     
        $query = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $connect->prepare($query)){
            
           if($stmt->execute( 
                array(  
                'username'     =>     $_POST["username"]
                )  
            ) 
           ){ $result = $stmt->fetch();

            $count = $stmt->rowCount();  
            
                
                if($count > 0){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

         // close connection 
        }
    }
    

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
  
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
       
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
       
         
        if($stmt = $connect->prepare($query)){
         
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
           
            $stmt->bindValue(':password', $param_password, PDO::PARAM_STR);
          
            
            echo $param_password;
          
            if($stmt->execute(
                array(  
                    'username'     =>     $_POST["username"],
                    'password'     =>     $param_password
                    )  
            )){
             
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

          // close statement
        }
    }
    
  // close connection
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
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
                padding: 25px 40px;
                margin: 20px;
            }
        h2.Signup{
            text-align: center;
        }
        
        .box{
            padding: 5% 20% 5% 20%;
        }
        
        .buttons{
            text-align :center;
            padding:3px;
        }
      
    </style>
</head>
<body>
    <div class="box">
        <div class="wrapper">
            <h2 class="Signup">Sign Up</h2>
            <p>Please fill this form to create an account.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <div class="buttons">
                            <input type="submit" class="btn btn-primary" value="Submit">

                            <input type="reset" class="btn btn-default" value="Reset">
                    </div>
                </div>
                <p>Already have an account? <a href="index.php">Login here</a>.</p>
            </form>
        </div>    
    </div>
</body>
</html>