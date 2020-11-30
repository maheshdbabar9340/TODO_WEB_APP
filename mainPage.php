<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html> 
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>Mobiletodo</title>
	<link rel="stylesheet" href="css/jquery.mobile-1.4.2.css" />
	<link rel="stylesheet" href="css/style.css" />
	
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.2.js"></script>
	<script src="js/main.js"></script>
</head> 
<body> 
	
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>

   
	<!-- Home Page -->
	<div data-role="page" id="home">
		<header data-role="header">
			<h1>MobileTodo</h1>
		</header>
		
		<main data-role="content" id="content">
			<p><a href="#add" data-role="button">Add A Todo</a></p>
			<p><a href="mainPage.php" data-ajax="false" id="clear_btn" data-role="button" data-theme="b">Clear All Todos</a></p>
			<ul id="todos" data-role="listview" data-filter="true" data-filter-placeholder="Search Todos..." data-inset="true">			
			</ul>
		</main>
		
		<footer data-role="footer" id="footer">
			<h4>MobileTodo &copy; 2020</h4>
		</footer>
	</div>
	
	
	<!-- Add Page -->
	<div data-role="page" id="add">
		<header data-role="header">
			<a href="index.html" id="cancel_btn" data-icon="delete">Cancel</a>
			<h1>Add A Todo</h1>
			<a href="index.html" data-ajax="false" data-icon="check" data-theme="b" onclick="$('#add_form').submit();">Save</a>
		</header>
		
		<main data-role="content" id="content">
			<form id="add_form">
				<input type="text" name="todo_name" id="todo_name" placeholder="Add Todo Name">
				<input type="date" name="todo_date" id="todo_date">
			</form>
		</main>
		
		<footer data-role="footer" id="footer">
			<h4>MobileTodo &copy; 2020</h4>
		</footer>
	</div>
	
	<!-- Edit Page -->
	<div data-role="page" id="edit">
		<header data-role="header">
			<a href="index.html" id="cancel_btn" data-icon="delete">Cancel</a>
			<h1>Edit Todo</h1>
			<a href="index.html" data-icon="check" data-theme="b" onclick="$('#edit_form').submit();">Save</a>
		</header>
		
		<main data-role="content" id="content">
			<form id="edit_form">
				<input type="text" name="todo_name_edit" id="todo_name_edit" placeholder="Add Todo Name">
				<input type="date" name="todo_date_edit" id="todo_date_edit">
				<a href="#" id="delete" data-role="button">Delete</a>
			</form>
		</main>

		<p>
			<a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
		</p>
		
		<footer data-role="footer" id="footer">
			<h4>MobileTodo &copy; 2020</h4>
		</footer>
	</div>
</body>
</html>