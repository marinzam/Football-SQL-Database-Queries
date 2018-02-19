<?php
$server = 'classroom.cs.unc.edu';
$user = 'marinzam';
$pass = 'pass1212';
$database = 'marinzamdb';


// Make and check connection
$conn = new mysqli($server, $user, $pass, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo 'Connection was successful!' . "\r\n";
    echo 'Please wait as database populates...' . "\r\n";
    // Read data, line by line, until end of text file
    $file = @fopen("a3-data.txt", "r");
    $count = 0;
    $max_length = 6002;

    while ($count < $max_length) {
        $buffer = fgets($file);
        if($buffer != NULL) {
            $count +=1;
            $line = explode(" ", $buffer);
            $firstName = $line[0];
            $lastName = $line[1];
            $homeTeam = $line[2];
            $awayTeam = $line[3];
            $date = $line[4];
            $eventType = $line[5];
	    $eventType = preg_replace( "/\r|\n/", "", $eventType);
            if(count($line) > 6) {
                $qb_first = $line[6];
                $qb_last = $line[7];
		$qb_last = preg_replace( "/\r|\n/", "", $qb_last);
            }

            $home_team_id = NULL;
            $away_team_id = NULL;
            $player_id = NULL;
            $event_type_id = NULL;
            $qb_id = NULL;
            $game_id = NULL;
            $points = 0;
            $winner_id = NULL;
	    $loser_id = NULL;
            //Inserting event_types into EventTypes table
            $event_type_result = mysqli_query($conn, "SELECT * FROM EventTypes WHERE event_type ='$eventType'");
            if (mysqli_num_rows($event_type_result) == 0) { // Create new row
                $event_type_query = "INSERT INTO EventTypes (event_type) VALUES ('$eventType')";
                if ($conn->query($event_type_query) == TRUE) {
                    //                    echo "Event type query was successful \r\n";
                    $event_type_id = $conn->insert_id;
                } else {
                    echo "Error updating event type record: " . $conn->error . "\r\n";
                }
            } else { // Get ID of matching query
                $event_type_id = mysqli_fetch_array($event_type_result)['id'];
            }

            // Inserting home team into Teams table
            $home_team_result = mysqli_query($conn, "SELECT * FROM Teams WHERE team_name ='$homeTeam'");
            if (mysqli_num_rows($home_team_result) == 0) { // Create new row
                $home_team_query = "INSERT INTO Teams (team_name) VALUES ('$homeTeam')";
                if ($conn->query($home_team_query) == TRUE) {
                    //                    echo "Home team query was successful \r\n";
                    $home_team_id = $conn->insert_id;
                } else {
                    echo "Error updating home team record: " . $conn->error . "\r\n";
                }
            } else { // Get ID of matching query
                $home_team_id = mysqli_fetch_array($home_team_result)['id'];
            }

            // Inserting away team into Teams table
            $away_team_result = mysqli_query($conn, "SELECT * FROM Teams WHERE team_name ='$awayTeam'");
            if (mysqli_num_rows($away_team_result) == 0) { // Create new row
                $away_team_query = "INSERT INTO Teams (team_name) VALUES ('$awayTeam')";
                if ($conn->query($away_team_query) == TRUE) {
                    //                    echo "Away team query was successful \r\n";
                    $away_team_id = $conn->insert_id;
                } else {
                    echo "Error updating away team record: " . $conn->error . "\r\n";
                }
            } else { // Get ID of matching query
                $away_team_id = mysqli_fetch_array($away_team_result)['id'];
            }

            // Inserting main player name and team into Players table
            $player_result = mysqli_query($conn, "SELECT * FROM Players WHERE first_name ='$firstName' AND last_name ='$lastName' AND team_id ='$home_team_id'");
            if (mysqli_num_rows($player_result) == 0) { // Create new row
                $player_query = "INSERT INTO Players (first_name, last_name, team_id) VALUES ('$firstName','$lastName','$home_team_id')";
                if ($conn->query($player_query) == TRUE) {
                    //                    echo "Player query was successful \r\n";
                    $player_id = $conn->insert_id;
                } else {
                    echo "Error updating player record: " . $conn->error . "\r\n";
                }
            } else { // Get ID of matching query
                $player_id = mysqli_fetch_array($player_result)['id'];
            }

            if($eventType == 'passing') {
                // Inserting quarterback name and team into Players table
                $qb_result = mysqli_query($conn, "SELECT * FROM Players WHERE first_name ='$qb_first' AND last_name = '$qb_last' AND team_id ='$home_team_id'");
                if (mysqli_num_rows($qb_result) == 0) {
                    $qb_query = "INSERT INTO Players (first_name, last_name, team_id) VALUES ('$qb_first','$qb_last','$home_team_id')";
                    if ($conn->query($qb_query) == TRUE) {
                        //                        echo "Quarterback query was successful \r\n";
                        $qb_id = $conn->insert_id;
                    } else {
                        echo "Error updating qb player record: " . $conn->error . "\r\n";
                    }
                } else {
                    $qb_id = mysqli_fetch_array($qb_result)['id'];
                }
            }

            // Inserting teams and date into Games table
            $game_result = mysqli_query($conn, "SELECT * FROM Games WHERE (home_id ='$home_team_id' AND away_id ='$away_team_id' AND game_date ='$date') OR (home_id ='$away_team_id' AND away_id ='$home_team_id') AND game_date ='$date'");
            if (mysqli_num_rows($game_result) == 0) {
                $game_query = "INSERT INTO Games (home_id, away_id, game_date) VALUES ('$home_team_id','$away_team_id','$date')";
                if ($conn->query($game_query) == TRUE) {
                    //                    echo "Game query was successful \r\n";
                    $game_id = $conn->insert_id;
                } else {
                    echo "Error updating game record: " . $conn->error . "\r\n";
                }
            } else {
                $game_id = mysqli_fetch_array($game_result)['id'];
            }


            // Inserting teams and date into Stats table
            $points = ($eventType == 'rushing' || $eventType == 'passing') ? 7 : 3;

            if($eventType == 'passing') {
                $stats_query = "INSERT INTO Stats (game_id, player_id, team_id, event_id, points, qb_id) VALUES ('$game_id','$player_id','$home_team_id','$event_type_id','$points','$qb_id')";
            } else {
                $stats_query = "INSERT INTO Stats (game_id, player_id, team_id, event_id, points) VALUES ('$game_id','$player_id','$home_team_id','$event_type_id','$points')";
            }

            if ($conn->query($stats_query) == TRUE) {
                //            echo "Stats query was successful \r\n";
            } else {
                echo "Error updating stats record: " . $conn->error . "\r\n";
            }
        }
    }

    // After populating tables, get all game_ids to populate points won in each game
    $all_games_query = "SELECT id FROM Games";
    if ($conn->query($all_games_query) == TRUE) {
        $all_games = mysqli_query($conn, $all_games_query);
    } else {
        echo "Error getting all games record: " . $conn->error . "\r\n";
    }
    // Iterate through all game_ids to get home and away teams
    while($row = mysqli_fetch_assoc($all_games)) {
        $curr_game = $row['id'];
        $curr_home_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM Games WHERE id = '$curr_game'"))['home_id'];
        $curr_away_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM Games WHERE id = '$curr_game'"))['away_id'];
	$curr_game_date = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM Games WHERE id = '$curr_game'"))['game_date'];

        $home_sum_query = "SELECT SUM(Stats.points) FROM Stats, Games, Teams WHERE (Games.game_date = '$curr_game_date') AND (Games.id = Stats.game_id) AND ((Teams.id = Stats.team_id) AND (Stats.team_id = $curr_home_id))";
	$away_sum_query = "SELECT SUM(Stats.points) FROM Stats, Games, Teams WHERE (Games.game_date = '$curr_game_date') AND (Games.id = Stats.game_id) AND ((Teams.id = Stats.team_id) AND (Stats.team_id = $curr_away_id))";

	if (($conn->query($home_sum_query) == TRUE) && ($conn->query($away_sum_query) == TRUE)) {
            $total_home = mysqli_query($conn, $home_sum_query);
            $total_away = mysqli_query($conn, $away_sum_query);

	$total_home_pts = mysqli_fetch_array($total_home)[0];
      	$total_away_pts = mysqli_fetch_array($total_away)[0];

            $winner_id = ($total_home_pts > $total_away_pts) ? $curr_home_id : $curr_away_id; //assuming no ties
	    $loser_id = ($total_home_pts > $total_away_pts) ? $curr_away_id : $curr_home_id;
	// Update Games to reflect total points and who won
            $update_game_pts = mysqli_query($conn, "UPDATE Games SET pts_home ='$total_home_pts', pts_away ='$total_away_pts', winner_id ='$winner_id', loser_id = '$loser_id' WHERE id = '$curr_game'");
        } else {
            echo "Error getting curr home or away record: " . $conn->error . "\r\n";
        }
    }
    echo "Database successfully populated! \r\n";
}
mysqli_close($conn);
?>
