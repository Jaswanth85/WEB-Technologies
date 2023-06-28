<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Wine store</title>
    <meta charset="utf-8" />
    <meta name="description" content="Project About Photography Club" />
    <meta name="keywords" content="HTML, CSS, JavaScript, perl" />
    <meta name="author" content="Likhitha Karasani" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="main.css" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://table-sortable.now.sh/table-sortable.js"></script>
  </head>
  <body>
    <div id="wrapper" class="fade-in">
      <div id="intro">
        <h1>Wine Store Details</h1>
        <p>
          This is a website where we can search different Wine details and perform several operations on wine details like create, update and delete.
        </p>
      </div>
      <nav id="nav">
        <ul class="links">
		<li ><a href="../Assignment2/index.html">Back to Club</a></li>
          <li ><a href="index.php">Search Wine</a></li>
		  <li ><a href="createwine.php">Create Wine</a></li>
		  <li ><a href="modifywine.html">Modify Wine</a></li>
		  <li ><a href="deletewine.html">Delete Wine</a></li>
        </ul>
      </nav>
      <div id="main">
		<?php
				if($_SERVER['REQUEST_METHOD'] != "POST")
				exit();
				include "config.php";
				include "consolelog.php";
				$test = NULL;
				$query = "SELECT distinct w.wine_id, wi.winery_name, 
				w.year,
				w.wine_name,
				w.wine_id,
				i.cost,
				i.on_hand,
				r.region_name,
				wt.wine_type,
				wi.winery_name
				FROM wine w, winery wi, inventory i, region r, wine_type wt
				WHERE w.winery_id = wi.winery_id
				AND w.wine_id = i.wine_id
				AND r.region_id = wi.region_id
				AND wt.wine_type_id = w.wine_type";
				//adding restrictions only when they are not null
				if (!empty($_POST['wine_price_min'])){
				$query .= " AND i.cost >= ".$_POST['wine_price_min'];	
				}
				if (!empty($_POST['wine_price_max'])){
					$query .= " AND i.cost <= ".$_POST['wine_price_max'];	
				}
				if (!empty($_POST['wine_year'])){
					$query .= " AND w.year >= ".$_POST['wine_year'];
				}
				if (!empty($_POST['winery_id'])){
					$query .= " AND wi.winery_id = ".$_POST['winery_id'];
				}
				// Add region_name restriction if they've selected anything
				if ($_POST['region_id'] != 1 and !empty($_POST['region_id'])){
				$query .= " AND r.region_id = ".$_POST['region_id']."";}
				// Add wine type restriction if they've selected anything
				if ($_POST['wine_type'] != 1 and !empty($_POST['wine_type'])){
				$query .= " AND wt.wine_type_id = ".$_POST['wine_type']."";}
				
				// Add sorting criteria
				$query .= " ORDER BY wi.winery_name, w.wine_name";
				try{
					
				
					if(!($result = mysqli_query($link,$query)))
					{
						console_log("Retrieving records failed.");

						echo "Retrieving records failed.".mysqli_error($link);
						die(mysqli_error($link));
						throw new Exception(mysqli_error($link));
					}

					

					if(mysqli_num_rows($result)==0){
						console_log("Retrieving records failed.");
						throw new Exception(mysqli_error($link));
					}


					$body = '
						<p>Hello ,<br><br>There is data retrieving done on wine data <br> so please have a look on searched wine details below :- </p>
						<table width="500" border="1" cellpadding="0" bordercolor="#CCCCCC" >
						<tr>
						<th>Wine Id</th>
						<th>Wine Name</th>
						<th>Winery Name</th>
						<th>Wine Year</th>
						<th>Wine Type Name</th>
						<th>Region Name</th>
						<th>Wine Price</th>
						<th>Wine Availability</th>
						</tr>';
				    echo "<div class='row'>";
					echo "<div class='col-6 col-12-xsmall'><h3>Searched Wine Details</h3></div>";
					echo "<div class='col-6 col-12-xsmall'><input type='text' placeholder='Search in table...' id='searchField'></div>";
				  	echo "</div><div id='table-sortable'></div>";
					$results = array();

					
					while($info = mysqli_fetch_array($result))
						{
							array_push($results, $info);
							$body .= '<tr>';
							$body .=  '<td>'.$info['wine_id'] .'</td>' ;
							$body .=  '<td>'.$info['wine_name'] .'</td>' ;
							$body .=  '<td>'.$info['winery_name'] .'</td>' ;
							$body .=  '<td>'.$info['year'] .'</td>' ;
							$body .=  '<td>'.$info['wine_type'] .'</td>' ;
							$body .=  '<td>'.$info['region_name'] .'</td>' ;
							$body .=  '<td>'.$info['cost'] .'</td>' ;
							$body .=  '<td>'.$info['on_hand'] .'</td>' ;
							$body .= '</tr>';

						}
					$body .= '</table>';
					$test = 2;
					}
					catch(Exception $ex){
						console_log($ex->getMessage());
						$test = NULL;
						echo "<h3>No Data is present for the selected search criteria please change it.</h3>";
					}
					finally{
						
						mysqli_close($link);
					}
				if(!empty($test))
				{
					
					$to = "gdarapaneni@mail.bradley.edu";
					$subject = "Database retrieving alert!";
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					if (mail($to, $subject, $body, $headers)) 
					{
					echo("<p><b>Email has been sent successfully to admin for verification!</b></p>");
					} 
					else 
					{
					echo("<p>Email delivery failed.</p>");
					}
				}
			?>
      </div>
      <footer id="footer">
        <section>
          <h3>Phone</h3>
          <p><a href="tel:+13099895095">(309) 000-0000</a></p>
        </section>
        <section>
          <h3>Email</h3>
          <p>
            <a href="mailto:natureclicks001@gmail.com"
              >natureclicks001@gmail.com</a
            >
          </p>
        </section>
        <section>
          <h3>Address</h3>
          <p>Peoria, USA</p>
        </section>
      </footer>
      <div id="copyright">
        <ul>
          <li>&copy; Project</li>
        </ul>
      </div>
      <div class="bg fixed" style="transform: none"></div>
    </div>
    <script>
		<?php echo "var data = ".json_encode($results).";" ?>
		var columns = {
			wine_name: 'Wine Name',
			winery_name: 'Winery Name',
			wine_id: 'Wine ID',
			year: 'Wine Year',
			wine_type: 'Wine Type Name',
			region_name: 'Region Name',
			cost: 'Wine Price',
			on_hand: 'Wine Availability',
		};

		var table = $('#table-sortable').tableSortable({
			data: data,
			columns: columns,
			rowsPerPage: 10,
			sorting:true,
			searchField: "#searchField",
			pagination: true,
		});
	</script>
  </body>
</html>
