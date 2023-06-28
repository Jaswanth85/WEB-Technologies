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
				$to = "gdarapaneni@mail.bradley.edu";
			   
				 if(isset($_POST['addwine']))
				{
					

					$sql="INSERT INTO wine (wine_id, wine_name, year, wine_type, winery_id) VALUES (".$_POST['wine_id'].",'".$_POST['wine_name']."',".$_POST['wine_year'].",".$_POST['wine_type'].",".$_POST['winery_id'].")";
					$test= $_POST['wine_id'] ;
					try{
					$result=mysqli_query($link,$sql);
					if(!$result){
						throw new Exception(mysqli_error($link));
					}
					
					$sql = "INSERT INTO inventory (wine_id, on_hand, cost,inventory_id) VALUES (".$_POST['wine_id'].",".rand(1,1000).",".rand(1,200)*1.56.",1)";
					$result=mysqli_query($link,$sql);
					if(!$result){
						throw new Exception(mysqli_error($link));
					}

					$sql2="SELECT w.wine_id,wine_name,w.winery_id,winery_name,year,w.wine_type,wt.wine_type wine_type_name  FROM wine w,winery wn,wine_type wt where w.winery_id=wn.winery_id and w.wine_type=wt.wine_type_id and w.wine_id= ".$_POST['wine_id']." ;";
					$result=mysqli_query($link,$sql2);
					if(!$result){
						throw new Exception(mysqli_error($link));
					}
					echo "<h3> Created Wine Details</h3>";
					echo "<table>";
					echo"<tr>";
					// These are the column lables that will be displayed
					echo"<th>Wine ID</th>";
					echo"<th>Wine Name</th>";
					echo"<th>Winery ID</th>";
					echo"<th>Winery Name</th>";
					echo"<th>Wine Year</th>";
					echo"<th>Wine Type</th>";
					echo"<th>Wine Type Name</th>";
					echo"</tr>";
					while($info = mysqli_fetch_array($result))
						{
							echo"<tr><td>".$info['wine_id'] . "</td>";
							echo"<td>".$info['wine_name'] . "</td>";
							echo"<td>".$info['winery_id'] . "</td>";
							echo"<td>".$info['winery_name'] . "</td>";
							echo"<td>".$info['year'] . "</td>";
							echo"<td>".$info['wine_type'] . "</td>";
							echo"<td>".$info['wine_type_name'] . "</td></tr>";

						}
					echo "</table>";
					}
					catch(Exception $ex){
						$test = NULL;
						echo "<h3>Got an exception and it is handled in catch block</h3>";
					}
				}
				else if(isset($_POST['submit2']))
				{
				
					$sql="UPDATE inventory set cost = ".$_POST['price']." WHERE wine_id = ".$_POST['wine_id']." ";
					try{
					$result=mysqli_query($link,$sql);
					if(!$result){
						throw new Exception(mysqli_error($link));
					}
					$test= $_POST['wine_id'] ;
					$sql2="SELECT w.wine_id,wine_name,w.winery_id,winery_name,year,cost,on_hand FROM wine w,winery wn,inventory i where w.winery_id=wn.winery_id and i.wine_id=w.wine_id and w.wine_id= ".$_POST['wine_id']." ;";
					$result=mysqli_query($link,$sql2) or die(mysqli_error($link));
					echo "<h3> Modified Wine Details</h3>";
					echo "<table>";
					echo"<tr>";
					// These are the column lables that will be displayed
					echo"<th>Wine ID</th>";
					echo"<th>Wine Name</th>";
					echo"<th>Winery ID</th>";
					echo"<th>Winery Name</th>";
					echo"<th>Wine Year</th>";
					echo"<th>Wine Price</th>";
					echo"<th>Wine Quantity Available</th>";
					echo"</tr>";

					while($info = mysqli_fetch_array($result))
						{
							echo"<tr><td>".$info['wine_id'] . "</td>";
							echo"<td>".$info['wine_name'] . "</td>";
							echo"<td>".$info['winery_id'] . "</td>";
							echo"<td>".$info['winery_name'] . "</td>";
							echo"<td>".$info['year'] . "</td>";
							echo"<td>".$info['cost'] . "</td>";
							echo"<td>".$info['on_hand'] . "</td></tr>";

						}
					echo "</table>";
					}
					catch(Exception $ex){
						$test = NULL;
						echo "<h3>Got an exception and it is handled in catch block</h3>";
					}
				}
				else if(isset($_POST['submit3']))
				{
				
					$sql="DELETE FROM wine WHERE wine_id = ".$_POST['wine_id']." AND winery_id = ".$_POST['winery_id']." ";
					try{
					$result=mysqli_query($link,$sql);
					if(!$result){
						throw new Exception(mysqli_error($link));
					}
					echo "<p><b>Wine record with Wine ID: ".$_POST['wine_id']." and Winery ID: ".$_POST['winery_id']." has been deleted from database</b><p>";
					$test= $_POST['wine_id'] ;
					}
					catch(Exception $ex){
						$test = NULL;
						echo "<h3>Got an exception and it is handled in catch block</h3>";
					}
				}
				if(!empty($test))
				{
					$query = "SELECT w.wine_id,wine_name,wt.wine_type,year,wn.winery_name,description FROM wine w,winery wn,wine_type wt where w.winery_id=wn.winery_id and wt.wine_type_id=w.wine_type";

					 if ( !( $result = mysqli_query(  $link, $query ) ) ) 
					 {
						print( "<p>Could not execute query!</p>" );
						die( mysqli_error()  );
					 } 
					$body = '
						<p>Hello admin ,<br><br>There are few modifications done on database recently for wine ID: '. $test . '<br> so please have a look on all wine details below :- </p>
						<table width="500" border="1" cellpadding="0" bordercolor="#CCCCCC" >
						<tr>
						<th>ID</th>
						<th>Wine Name </th>
						<th>Wine Type</th>
						<th>Year</th>
						<th>Winery Name</th>
						<th>Description</th>
						</tr>';
					for ( $counter = 0; $row = mysqli_fetch_row( $result ); ++$counter )
						{
						 
						 $body .=  '<tr>';

						   foreach ( $row as $key => $value ) 
							  $body .=  '<td>'.$value.'</td>' ;

						   $body .=  '</tr>' ;
						} // end for

						mysqli_close( $link );
					$body .= '</table>';
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
    <script src="main.js"></script>
  </body>
</html>
