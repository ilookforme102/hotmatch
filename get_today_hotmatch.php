<?php 
function my_custom_shortcode() {
    $base_url = "https://api2.asiasport.com/match/getMatchListv2";
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $todayDate = date('Y-m-d');
    $params = array(
        'matchDate' => $todayDate,
        'liveOnly' => 'false',
        'lang' => 'vi',
        'timeZone'=> 'Asia'.'%'.'2FHo_Chi_Minh'
    );

    // Build query string
    // Manually build the query string
    $query_string = '';
    foreach ($params as $key => $value) {
        // Note: Use rawurlencode() for keys and values, except where you want to preserve '%'
        $query_string .= $key . '=' .$value. '&';
    }
    // Remove the trailing '&'
    $query_string = rtrim($query_string, '&');

    // Full URL with query string
    $url = $base_url . '?' . $query_string;


    // Fetch data from the API
    $response = file_get_contents($url);

    // Check if the request was successful
    if ($response === FALSE) {
        die('Error occurred while fetching data');
    }

    // Decode the JSON response
    $data = json_decode($response, false);
    if (!empty($data )) {
    $odd_data = $data->result->oddsListMatchMap;
    $league_match_data  = $data->result->leagueMatchList;

    ob_start();
    echo "<div class='shang-carousel-container slider-container'>";
    echo "<div class='shang-carousel-set slider'>";
    $root_url = "https://asset.asiasport.com/";
    foreach ($league_match_data as $league_data) {
        $league_name = $league_data->leagueName;
        $league_match_list = $league_data->matchList;
        
        foreach ($league_match_list as $match) {
            echo "<div class='shang-match-container slide'>";
            
            $match_id = $match->matchId;
            $match_time = $match->matchTime;
            $match_date = $match->matchDate;
            $match_teams = $match->opponents;
            $match_team1 = $match_teams[0];
            $match_team2 = $match_teams[1];
            $team1_logo_src = $root_url . $match_team1->logo;
            $team2_logo_src = $root_url . $match_team2->logo;
            
            // Header
            echo "<div class='shang-match-header'>
                    <p>$league_name | $match_time | $match_date</p>
                  </div>";
            
            // Odds
            echo "<div class='shang-match-odds-block-container'>";
            
            // Home team logo and name
            echo "<div class='shang-match-team-container shang-match-column-item '>
                    <div class='shang-match-team-logo-container'>
                        <img class='shang-match-team-logo' src='$team1_logo_src'>
                    </div>
                    <div class='shang-match-team-name-container'>
                        <p>".$match_team1->name."</p>
                    </div>
                  </div>";
            
            if (count(get_object_vars($odd_data)) == 0) {
                echo "<div class='shang-match-odds-details shang-match-column-item'>
                        <div class='shang-match-odds-handicap shang-match-odds-data'>
                            <p>Đang cập nhật</p>
                            <p>(Châu Á)</p>
                        </div>
                        <div class='shang-match-odds-europe shang-match-odds-data'>
                            <p>Đang cập nhật</p>
                            <p>(Châu Âu)</p>
                        </div>
                        <div class='shang-match-odds-handicap shang-match-odds-data'>
                            <p>Đang cập nhật</p>
                            <p>(Tài Xỉu)</p>
                        </div>
                      </div>";
            } else {
                if (!empty($odd_data->$match_id)) {
                    echo "<div class='shang-match-odds-details shang-match-column-item'>
                            <div class='shang-match-odds-handicap shang-match-odds-data'>
                                <p>".$odd_data->$match_id->handicap->latest->odds1Value."</p>
                                <p>(Châu Á)</p>
                            </div>
                            <div class='shang-match-odds-europe shang-match-odds-data'>
                                <p>".$odd_data->$match_id->europeOdds->latest->odds1Value."</p>
                                <p>(Châu Âu)</p>
                            </div>
                            <div class='shang-match-odds-handicap shang-match-odds-data'>
                                <p>".$odd_data->$match_id->overUnder->latest->odds1Value."</p>
                                <p>(Tài Xỉu)</p>
                            </div>
                          </div>";
                } else {
                    echo "<div class='shang-match-odds-details shang-match-column-item'>
                            <div class='shang-match-odds-handicap shang-match-odds-data'>
                                <p>Đang cập nhật</p>
                                <p>(Châu Á)</p>
                            </div>
                            <div class='shang-match-odds-europe shang-match-odds-data'>
                                <p>Đang cập nhật</p>
                                <p>(Châu Âu)</p>
                            </div>
                            <div class='shang-match-odds-handicap shang-match-odds-data'>
                                <p>Đang cập nhật</p>
                                <p>(Tài Xỉu)</p>
                            </div>
                          </div>";
                }
            }
            // Away team logo and name
            echo "<div class='shang-match-team-container shang-match-column-item'>
                    <div class='shang-match-team-logo-container'>
                        <img class='shang-match-team-logo' src='$team2_logo_src'>
                    </div>
                    <div class='shang-match-team-name-container'>
                        <p>".$match_team2->name."</p>
                    </div>
                  </div>";

            echo "</div>"; // end of odds block container
            echo "</div>"; // end of match container
        }
    }
    echo "</div>"; // end of carousel set
    echo "<button class='shang-prev shang-button'>
    </button>";
    echo "<button class='shang-next shang-button'>
    </button>";
    
    echo "</div>"; // end of carousel container
}
//    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-arrow-left h-4 w-4'><path d='m12 19-7-7 7-7'></path><path d='M19 12H5'></path></svg>
//    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-arrow-right h-4 w-4'><path d='M5 12h14'></path><path d='m12 5 7 7-7 7'></path></svg>

else{
    echo "<b>Đang cập nhật</b>";
}
    return ob_get_clean();
}

// Register the shortcode with WordPress
add_shortcode('hot_match', 'my_custom_shortcode');
?>
