<!DOCTYPE html>
<html>

<table width ='100%' border='1'>

<th><a href="music.php?sort=track_id">TrackID:</a></th>
<th><a href="music.php?sort=title">Title:</a></th>
<th><a href="music.php?sort=song_id">Song:</a></th>
<th><a href="music.php?sort=release_date">Release Date:</a></th>
<th><a href="music.php?sort=artist_id">Artist ID:</a></th>
<th><a href="music.php?sort=artist_mbid">Artist mbid:</a></th>
<th><a href="music.php?sort=artist_name">Artist Name:</a></th>
<th><a href="music.php?sort=duration_seconds">Duration Seconds:</a></th>
<th><a href="music.php?sort=artist_familiarity">Artist Familiarityk:</a></th>
<th><a href="music.php?sort=artist_hottness">Artist Hottness:</a></th>
<th><a href="music.php?sort=year">Year:</a></th>
<th><a href="music.php?sort=track_7digitalid">track 7 digital ID:</a></th>
<th><a href="music.php?sort=shs_perf">shs perf:</a></th>
<th><a href="music.php?sort=shs_work">shs work:</a></th>

<?php
//make a DB connection
$DBConnect = mysqli_connect("127.0.0.1", "KIRVING", "P@ssword1", "kirving");


//if there isnt a DB connection, you need to let the admin know

if($DBConnect == false)
	print"Unable to connect to the database:" .mysqli_errno();
	else {
		//set up the table name 
		$TableName = "music";		
		//this is a wild card selection for everything in the DB
		$SQLstring = "Select * from $TableName";
		$sortby = isset($_GET['sort']) ? $_GET['sort'] : '';
        $sortOrder = isset($_GET['order']) ? $_GET['order'] : 'ASC';


$QueryResult = mysqli_query($DBConnect, "SELECT COUNT(*) AS `track_id` FROM `music`");
$Row = mysqli_fetch_array($QueryResult);
$count = $Row['track_id'];
print"<h1>Songs: $count</h1>";

		$QueryResult = mysqli_query($DBConnect, $SQLstring);
		//check to see if ther are records in table?
		if(mysqli_num_rows($QueryResult)>0)
		{//output all of the results in a dynamic table 
	
	
		while($Row = mysqli_fetch_assoc($QueryResult))
		{
			//this is the dynamic part of our table
	
			print"<tr><td><a href='music.php?track_id={$Row['track_id']}' target='_blank'>{$Row['track_id']}</a></td><td>{$Row['title']}</td><td>{$Row['song_id']}</td><td>{$Row['release_date']}</td>
			<td>{$Row['artist_id']}</td><td>{$Row['artist_mbid']}</td><td>{$Row['artist_name']}</td><td>{$Row['duration_seconds']}</td><td>{$Row['artist_familiarity']}</td>
            <td>{$Row['artist_hottness']}</td><td>{$Row['year']}</td><td>{$Row['track_7digitalid']}</td><td>{$Row['shs_perf']}</td><td>{$Row['shs_work']}</td></tr>";
			
			
		}//end while statement
		
		
		}//end num row test
		
		else
			print"There are no results to display";
		
		mysqli_free_result($QueryResult);
	
		//close the else for connection
		}
		
	
	mysqli_close($DBConnect);

		
	
?>
</body>
</html>
