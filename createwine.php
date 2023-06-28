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
        <li ><a href="/Assignment2/index.html">Back to Club</a></li>
          <li ><a href="index.php">Search Wine</a></li>
		  <li class="active"><a href="createwine.php">Create Wine</a></li>
		  <li ><a href="modifywine.html">Modify Wine</a></li>
		  <li ><a href="deletewine.html">Delete Wine</a></li>
        </ul>
      </nav>
      <div id="main">
	  <form method="post" action="write.php">
        <?php
        include "config.php";
       
        $count = "select max(wine_id) from wine";
        $result = mysqli_query($link,$count) or die(mysqli_error($link));
        $row = mysqli_fetch_array($result);
        $count = $row[0];
        $count = $count + 1;
        echo "Enter Wine ID : <input type='text' size='10' name='wine_id' autocomplete='off'  placeholder='Wine ID' value='$count'>"
        ?>

				Enter Wine Name : <input type="text" size="50" name="wine_name" autocomplete="off"  placeholder= "Wine Name" required>
				Enter Wine Year : <input type="number" size="10" name="wine_year" autocomplete="off"  placeholder="Year" required>
				Select Wine Type : <select name="wine_type" required>
				<option name="" value="">--SELECT--</option>
				<?php
						include "config.php";

						$showTable="SELECT DISTINCT wine_type_id, wine_type FROM wine_type";
						$result=mysqli_query($link,$showTable) or die(mysqli_error($link));

						while($info = mysqli_fetch_array($result))
							{
								echo "<option value=".$info['wine_type_id'].">".$info['wine_type']."</option>" ;
							}
				?>
				</select>
				Select Winery Name :
				<select name="winery_id" required>
				<option name="" value="">--SELECT--</option>
				<?php
						include "config.php";

						$showTable="SELECT DISTINCT winery_id, winery_name FROM winery";
						$result=mysqli_query($link,$showTable) or die(mysqli_error($link));

						while($info = mysqli_fetch_array($result))
							{
								echo "<option value=".$info['winery_id'].">".$info['winery_name']."</option>" ;
							}
				?>
				</select>
        <br><br>
				
				<input type="submit" name="addwine" value="Add Wine" class="primary" />
			</form>
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
  </body>
</html>
