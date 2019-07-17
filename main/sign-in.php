<?php
// initializes session
session_start();
 
// if user is already logged in, redirect to recents page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: recents.php");
    exit;
}
 
require_once "config.php";
 
$username = $password = "";
$username_err = $password_err = "";
 
// When form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // is username empty?
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username."; // error message
    } else{
        $username = trim($_POST["username"]);
    }
    
    // is password empty?
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password."; // error message
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                // stores result
                mysqli_stmt_store_result($stmt);
                
                // if username exists, verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // if password is correct, start a new session
                            session_start();
                            
                            // store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // redirect to recents page
                            header("location: recents.php");
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
        }
        
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- use bootstap and sign-in.css to style page -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/sign-in.css">
    </head>   

    <body>
        <header>
            <h1>Movie & Book Tracker</h1> 
        </header>

        <h2>Sign In</h2>
        <div class="container-signin">
            <!-- Sign in functionality -->
            <form class="signin-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <p class="signin-fieldset <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <input class="input" id="signin-email" type="text" placeholder="Username" name = "username" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </p>
                
                <p class="signin-fieldset <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" >
                    <input class="input" id="signin-password" type="password" placeholder="Password" name = "password" >
                    <span class="help-block"><?php echo $password_err; ?></span>
                </p>
            
                <p class="forgot-message"><a href="#0">Forgot your password?</a></p>
        
                <p class="signin__button"><input type="submit" name="login" value="LOGIN"></p> 

                <div class="container-signup-text">
                    <p class="signup-question"><a>Don't have an account?</a></p>
                    <p class="signup-message"><a href="register.php">Sign up now</a></p>
                </div>
            </form>
        </div>

        <!-- TODO: Forgot password-->
    </body>


</html>