<!DOCTYPE html>
<html>
<head>
	<title>AWS attempt</title>
	<!-- todo: move to a separate js file  -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
	<script src='main.js'></script>	
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
    	// todo: currently unable to include inside main.js
    	$(document).ready(function(){
			$.datepicker.setDefaults({
				dateFormat: 'yy-mm-dd'
			});
			$(function(){
				$("#from_date").datepicker();
				$("#to_date").datepicker();
			});
			$("#select_button").click(function(){
				var from_date = $("#from_date").val();
				var to_date = $("#to_date").val();
				if (from_date != '' && to_date != '') {
					$.ajax({
						url: "clause_date.php",
						method:"POST",
						data: {from_date: from_date, to_date:to_date},
						success:function(data)
						{
							console.log(data);
							document.getElementById("selected_clause").innerHTML = data;
						}
					});
				} else {
					alert("You need to select a date!");
				}
			});
		});
    </script>
</head>
<body>
	<h1>Hello Pastperfect</h1>

	<!-- 0. File upload  -->
	<div class = "document_container">
		<h2 style =  "color: red;"> 0. File Upload test</h2>
		<form method="POST" enctype="multipart/form-data" action="file_handler.php">
			<input type="File" name = "file">
			<button type="submit" name="submit">Submit</button>
		</form>
		<button onclick="see_all_files()">See all files</button>
		<p>Files: <span id = "output00"></span></p>
	</div>

	<!-- 1. This is to filter client data by company -->
	<script src='main.js'></script>
	<div class = "document_container">
		<h2 style =  "color: #008CBA;"> 1. Filter by Company</h2>
		<form>
			Searching Company: <input type="text" class = "form-control" onkeyup="company_filter(this.value)">
		</form>
		<p>Suggestions: <span id = "output2"></span></p>
	</div>

	<!-- 2. This is to sort by date in document table -->
	<div class = "document_container">
		<h2 style =  "color: green;"> 2. Sort by date in document table</h2>
		<button  onclick="sort_date_func()">Sort by Date</button>
		<div id = "sorted_doc"></div>
	</div>

	<!-- 3. This is to select by date in clause table -->
	<div class = "document_container">
		<h2 style =  "color: pink;"> 3. Select by date in clause table</h2>
		<div class = "date1">
			<input type="text" name="from" id = "from_date" class= "form-control" placeholder="From Date"/>
			<input type="text" name="to" id = "to_date" class= "form-control" placeholder="To Date"/>
			<button id = "select_button" style = "background-color: #4CAF50; color: white;">Search clause</button>
			<div id = "selected_clause"></div>
		</div>
	</div>

	<h2 style =  "color: orange;"> 4. Display all data </h2>
	<?php
		include 'connect.php';

		#Queries
		$result_client = pg_query($connection, "select * from public.\"Client_Table\"");
		$result_clause = pg_query($connection, "select * from public.\"Clause_Table\"");
		$result_document = pg_query($connection, "select * from public.\"Document_Table\"");
		$unique_titles = pg_query($connection, "select DISTINCT title from public.\"Clause_Table\"");
		if (!$result_client or !$result_clause or !$result_document or !$unique_titles) {
			echo "Unable to view the table\n";
			exit;
		}
		#Output
		echo "<table border='1'>
		<tr>
		<th>Titles</th>
		</tr>";
		echo "<b>0. Unique Titles: </b><br>";
		while ($row = pg_fetch_row($unique_titles))
		{
			echo "<tr>";
			echo "<td>" . $row[0] . "</td>";
		}
		echo "</table>";
		echo "<br><br>";



		echo "<table border='1'>
		<tr>
		<th>unique_id</th>
		<th>unqiue_client_id</th>
		<th>parent_id</th>
		<th>lient_name</th>
		</tr>";
		echo "<b>1. Client Table: </b><br>";
		while ($row = pg_fetch_row($result_client))
		{
			echo "<tr>";
			echo "<td>" . $row[0] . "</td>";
			echo "<td>" . $row[1] . "</td>";
			echo "<td>" . $row[2] . "</td>";
			echo "<td>" . $row[3] . "</td>";
		}
		echo "</table>";
		echo "<br><br>";


		echo "<table border='1'>
		<tr>
		<th>unique_id</th>
		<th>title</th>
		<th>tags</th>
		<th>author</th>
		<th>date</th>
		<th>clause_string</th>
		</tr>";
		echo "<b>2. Clause Table: </b><br>";
		while ($row = pg_fetch_row($result_clause))
		{
			echo "<tr>";
			echo "<td>" . $row[0] . "</td>";
			echo "<td>" . $row[2] . "</td>";
			$string = explode ("||", $row[3]); 
			$temp_tag = $string[0].", ".$string[1];
			echo "<td>$temp_tag</td>";
			echo "<td>" . $row[4] . "</td>";
			echo "<td>" . $row[6] . "</td>";
			echo "<td>" . $row[10] . "</td>";
		}
		echo "</table>";
		echo "<br><br>";


		echo "<table border='1'>
		<tr>
		<th>unique_id</th>
		<th>document type</th>
		<th>author</th>
		<th>date</th>
		</tr>";
		echo "<b>3. Document Table: </b><br>";
		while ($row = pg_fetch_row($result_document))
		{
			echo "<tr>";
			echo "<td>" . $row[0] . "</td>";
			echo "<td>" . $row[2] . "</td>";
			echo "<td>" . $row[3] . "</td>";
			echo "<td>" . $row[5] . "</td>";
		}
		echo "</table>";

		pg_close($connection);
	?>

</body>