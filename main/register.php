<?php
require_once "config.php";
 
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = trim($_POST["username"]);
            
            if(mysqli_stmt_execute($stmt)){
                // stores the results
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    // password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){ // 6 character correction
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){ 
            $confirm_password_err = "Password did not match."; // password matching correction
        }
    }
    
    // checks input errors before writing to database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // creates a password hash
            
            if(mysqli_stmt_execute($stmt)){
                header("location: sign-in.php"); // redirect to sign-in page
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
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

        <h2>Sign Up</h2>
        <div class="container-signin">
            <!-- TODO: sign in functionality -->
            <form class="signin-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <p class="signin-fieldset <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <input class="input" id="signup-email" type="text" placeholder="Username" name = "username" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </p>
                
                <p class="signin-fieldset <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <input class="input" id="signup-password" type="password" placeholder="Password" name = "password" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </p>

                <p class="signin-fieldset <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <input class="input" id="signup-password" type="password" placeholder="Confirm Password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </p>
        
                <p class="signin__button"><input type="submit" name="login" value="SUBMIT"></p> 

                <div class="container-signup-text">
                    <p class="signup-question"><a>Already have an account?</a></p>
                    <p class="signup-message"><a href="sign-in.php">Login here.</a></p>
                </div>
            </form>
        </div>

    </body>


</html>