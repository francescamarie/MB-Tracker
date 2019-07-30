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

$id=$_REQUEST['id'];
$query = "SELECT * from Entries where id='".$id."'"; 
$result = mysqli_query($link, $query) or die ( mysqli_error());
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/recents.css">
	<p><a href="javascript:history.back()">< Back</a></p>
	<title>Update Entry</title>
</head>
<body>
	<div class="form">
			<h1>Update Entry</h1>
			<?php
			$status = "";
			if(isset($_POST['new']) && $_POST['new']==1)
			{
				$id=$_REQUEST['id'];
				$name =$_REQUEST['title'];
				$year_id =$_REQUEST['year_id'];
				$author =$_REQUEST['author'];
				$rate =$_REQUEST['rate'];
				$review =$_REQUEST['review'];
				$update="update Entries set Name='".$name."',
				Year_ID='".$year_id."', Author='".$author."',
				Rating='".$rate."', Review='".$review."' where id='".$id."'";
				mysqli_query($link, $update) or die(mysqli_error());
				$status = "Record Updated Successfully. </br></br>
				<a href='recents.php'>View Recents</a>";
				echo '<p style="color:#FF0000;">'.$status.'</p>';

			}else {
				?>
				<div class="modal-body">
					<form name="form" method="post" action=""> 
						<input type="hidden" name="new" value="1" />
						<input name="id" type="hidden" value="<?php echo $row['id'];?>" />

						<div id="title-input" class="form-group">
							<label for="title">Title: </label>
							<input type="text" id="title" name="title" placeholder="<?php echo $row['Name'];?>" >
						</div>

						<div id="year-input" class="form-group">
							<label for="year_id">Year: </label>
							<input type="number" id="year_id" name="year_id" min="1000" max="2030" placeholder="<?php echo $row['Year_ID'];?>">
						</div>

                    	<p>If it's a movie, put N/A...</p>
						<div id="author-input" class="form-group">
							<label for="author">Author: </label>
							<input type="text" id="author" name="author" placeholder="<?php echo $row['Author'];?>">
						</div>

						<div id="rating-input">
							<label for="rate">Rating: </label>
							<div class="rate" id="rate">
								<label for="star5" title="text">5 stars</label>
								<input type="radio" id="star5" name="rate" <?php if (isset($rate) && $rate=="5") echo $row['Rating'];?> value="5" />
								<label for="star5" title="text">4 stars</label>
								<input type="radio" id="star4" name="rate" <?php if (isset($rate) && $rate=="4") echo $row['Rating'];?> value="4" />
								<label for="star4" title="text">4 stars</label>
								<input type="radio" id="star3" name="rate" <?php if (isset($rate) && $rate=="3") echo $row['Rating'];?> value="3" />
								<label for="star3" title="text">2 stars</label>
								<input type="radio" id="star2" name="rate" <?php if (isset($rate) && $rate=="2") echo $row['Rating'];?> value="2" />
								<label for="star2" title="text">1 stars</label>
								<input type="radio" id="star1" name="rate" <?php if (isset($rate) && $rate=="1") echo $row['Rating'];?> value="1" />
							</div>
						</div>

						<div id="review-input">
							<label for="review">Review: </label>
							<textarea type="text" id="review" name="review" placeholder="<?php echo $row['Review'];?>" ></textarea>
						</div>

						
								<p><input name="submit" type="submit" value="Update" /></p>
							</form>
						<?php } ?>
					</div>
	</div>
</body>
</html>
