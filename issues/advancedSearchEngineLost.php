<?php
$connect = mysqli_connect("localhost", "root", "", "a");
if(isset($_POST['submit'])) {
    // define the list of fields
    $fields = array('name', 'father', 'mother', 'age', 'height', 'color', 'wearing', 'lostlocation');
    $conditions = array();

    // loop through the defined fields
    foreach($fields as $field){
        // if the field is set and not empty
        if(isset($_POST[$field]) && $_POST[$field] != '') {
            // create a new condition while escaping the value inputed by the user (SQL Injection)
            $conditions[] = "`$field` LIKE '%" . mysqli_real_escape_string($connect, $_POST[$field]) . "%'";
        }
    }

    // builds the query
    $query = "SELECT * FROM lost ";
    // if there are conditions defined
    if(count($conditions) > 0) {
        // append the conditions
        $query .= "WHERE " . implode (' AND ', $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
    }

  /* $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_array($result)) {
        echo $row['name'] . "<br />";
    }*/
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Search Engine</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="css/style.css">

   <script src="jquery.js"></script>
   <script>
   $(function(){
     $("#includedContent").load("../header/header.html");
   });
   </script>


	</head>

	<body>

		<div class="wrapper" style="background-image: url('images/p4.jpg');">
        <div id="includedContent"></div>
			<div class="inner">
				<div class="image-holder">
					<img src="images/px.png" alt="">
				</div>
				<form action="advancedSearchEngineLost.php" method="POST">
					<h3>FLO Advanced Search Engine<br>Search For Lost People</h3>
           <span style="color:green"><b>The more the field input, the narrower the results, the less the inputs the more possibility to find the results.</b> </span>
					<div class="form-wrapper">
						<input type="text" name="name" placeholder="Full Name" class="form-control">
					</div>
					<div class="form-group">
						<input type="text" name="father" placeholder="Father's Name" class="form-control">
            <input type="text" name="mother" placeholder="Mother's Name" class="form-control">
					</div>
          <div class="form-group">
						<input type="text" name="age" placeholder="Age" class="form-control">
            <input type="text" name="height" placeholder="Height" class="form-control">
					</div>
          <div class="form-wrapper">
            <input type="text" name="lostlocation" placeholder="Lost Location" class="form-control">
					</div>
          <div class="form-group">
						<input type="text" name="color" placeholder="Skin-Tone" class="form-control">
            <input type="text" name="wearing" placeholder="Dress" class="form-control">
					</div>


					<button type="submit" name="submit">Search..</button><br>
          <!--<a href="../home.php"><button>Home Page<i class="zmdi zmdi-arrow-left"></i>
          </button></a>-->
          Search Result:
          <?php
          error_reporting(0);
          $result = mysqli_query($connect, $query);
           while($row = mysqli_fetch_array($result)) {
               echo "<a href='lost_details_alt.php?ID={$row['LostId']}'>{$row['name']}</a>";
           } ?>
				</form>
			</div>
		</div>

	</body>
</html>
