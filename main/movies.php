<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: sign-in.php");
    exit;
}

// Include config file
require_once "config.php";

// define variables and set to empty values
$titleErr = $yearErr = $authorErr = $rateErr = $reviewErr = $typeErr = "";
$title = $year_id = $author = $rate = $review = $type = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

     // Validate title
   if(empty(trim($_POST["title"]))){
        $titleErr = "Please enter a title.";
    } else{
        $title = trim($_POST["title"]);
    }

    // Validate year
    if(empty(trim($_POST["year_id"]))){
        $yearErr = "Please enter a year.";
    } else{
        $year_id = trim($_POST["year_id"]);
    }

    // Validate author
    if(empty(trim($_POST["author"]))){
        $authorErr = "Please enter a director.";
    } else{
        $author = trim($_POST["author"]);
    }

    // Validate rate
    if(empty(trim($_POST["rate"]))){
        $rateErr = "Please enter a rating.";
    } else{
        $rate = trim($_POST["rate"]);
    }

    // Validate review
    if(empty(trim($_POST["review"]))){
        $reviewErr = "Please enter a review.";
    } else{
        $review = trim($_POST["review"]);
    }

    // Validate year
    if(empty(trim($_POST["type"]))){
        $typeErr = "Please enter a type.";
    } else{
        $type = trim($_POST["type"]);
    }

    // Check input errors before inserting in database
    if(empty($titleErr) && empty($yearErr) && empty($authorErr) && empty($rateErr) && empty($reviewErr) && empty($typeErr)) {

        // Prepare an insert statement
        $sql = "INSERT INTO `Entries` (`Name`, `Year_ID`, `Author`, `Rating`, `Review`, `Type`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);

        if($stmt = mysqli_prepare($link, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sisiss", $param_title, $param_year, $param_author, $param_rate, $param_review, $param_type);

            // Set parameters
            $param_title = $title;
            $param_year = $year_id;
            $param_author = $author;
            $param_rate = $rate;
            $param_review = $review;
            $param_type = $type;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // WORKS
                echo "it worked!!!";
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
            
    }
    // Close connection
    // mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<head>
    <link rel="stylesheet" href="css/recents.css">

</head>   

<body>
    <div class="sidenav">
        <h3>Movie & Book Tracker</h3>
        <h4>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</h4>
        <a href="recents.php" id="recents">User's Feed</a>
        <a href="movies.php" style="font-weight: bold; background-color:gray;">Your Movies</a>
        <a href="books.php">Your Books</a>
        <a href="logout.php" id="settings">Sign Out</a>
    </div>
    <div class ="main">
        <header>
            <h2>Movies</h2> 
            <div class="no-entry">
                <p class="btn btn-add" id="add-entry-btn" onclick="addentry()"><input type="submit" name="add" value="Add Entry +"></p>
            </div>
        </header>
    </div>

    <div id="add-entry-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span style="float: right; margin: 15px;" class="add-close">&times;</span>
                <h2 class="add_txt">Add Entry</h2>
            </div>

            <div class="modal-body">
                <form id="movie_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 

                    <div id="type-input">
                        <label for="book">Book</label>
                        <input type="radio" id="book" name="type"  <?php if (isset($type) && $rate=="Book") echo "checked";?> value="Book"/>
                     
                        <label for="movie">Movie</label>
                        <input type="radio" id="movie" name="type" <?php if (isset($type) && $rate=="Movie") echo "checked";?> value="Movie" checked/>

                        <span class="help-block"><?php echo $typeErr; ?></span>
                    </div>

                    <div id="title-input" class="form-group <?php echo (!empty($titleErr)) ? 'has-error' : ''; ?>">
                        <label for="title">Title: </label>
                        <input type="text" id="title" name="title" placeholder="Title" value="<?php echo $title; ?>">
                        <span class="help-block"><?php echo $titleErr; ?></span>
                    </div>

                    <div id="year-input" class="form-group <?php echo (!empty($yearErr)) ? 'has-error' : ''; ?>">
                        <label for="year_id">Year: </label>
                        <input type="number" id="year_id" name="year_id" min="1888" max="2030" value="<?php echo $year_id; ?>">
                        <span class="help-block"><?php echo $yearErr; ?></span>
                    </div>

                    <div id="author-input" class="form-group <?php echo (!empty($authorErr)) ? 'has-error' : ''; ?>">
                        <label for="author">Director: </label>
                        <input type="text" id="author" name="author" placeholder="Director" value="<?php echo $author; ?>">
                        <span class="help-block"><?php echo $authorErr; ?></span>
                    </div>

                    <div id="rating-input">
                        <label for="rate">Rating: </label>
                        <div class="rate" id="rate">
                            <input type="radio" id="star5" name="rate" <?php if (isset($rate) && $rate=="5") echo "checked";?> value="5" />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="rate" <?php if (isset($rate) && $rate=="4") echo "checked";?> value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="rate" <?php if (isset($rate) && $rate=="3") echo "checked";?> value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="rate" <?php if (isset($rate) && $rate=="2") echo "checked";?> value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="rate" <?php if (isset($rate) && $rate=="1") echo "checked";?> value="1" />
                            <label for="star1" title="text">1 star</label>

                            <span class="help-block"><?php echo $rateErr; ?></span>
                        </div>
                    </div>

                    <div id="review-input">
                        <label for="review">Review: </label>
                        <textarea type="text" id="review" name="review" placeholder="Write a review..."><?php echo $review;?></textarea>
                        <span class="help-block"><?php echo $reviewErr; ?></span>
                    </div>

                    <div class="submit">
                        <input class="submit_btn" type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    // printing image and title data
    $sql = "SELECT * FROM Entries WHERE Type = 'Movie'";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
    //output data of each row
        while($row = $result->fetch_assoc()) { 
            echo "<table align='center';>
                    <tr>
                        <td><img src='img/script.png'/></td>
                    </tr>
                    <tr>
                        
                        <td><p style='text-align:center;'>Title: ".$row["Name"]."</p></td>
                        <td align='center'>
                            <a style='font-size: 18px;' href='view.php?id=".$row["id"]."'>View</a>
                        </td>
                        <td align='center'>
                            <a style='font-size: 18px;' href='edit.php?id=".$row["id"]."'>Edit</a>
                        </td>
                        <td align='center'>
                            <a style='font-size: 18px;' href='delete.php?id=".$row["id"]."'>Delete</a>
                        </td>
                    </tr>
                 </table>";
        }
    } else {
        echo "0 results";
    }
    $link->close();
    ?>   

<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/add-entry.js"></script>
</body>
</html>
