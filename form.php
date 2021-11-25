<?php

/**
 * Create api variable connercted with the json data
 */
// $api = json_decode(file_get_contents('./Api/live/api-v-1-person-1.json'));
// $api->person_id;

/**
 * Declare empty variables where storing form inputs if
 * they exists
 */ 
$member_id;
$environment = "";

/**
 * Create an array where store form error if
 * they exists
 */
$error = array();

/**
 * Create an emty variable $output where storing
 * the output after submitted form
 */
$output = "";

/**
 * Checks if the form has been sumbitted
 */
if (isset($_POST['submit'])) {

    /**
     * Check which environment has been seclted by the
     * user and return an error if no one has been selected
     */
    if (isset($_POST['environment'])) {
        $environment = trim($_POST['environment']);

        /**
         * Get member id by the form
         * if that exists and return api data
         * if the member_id and person_id are equal
         */
        if (isset($_POST['member_id'])) {
            $member_id = trim($_POST['member_id']);

            $live = json_decode(file_get_contents('./Api/live/api-v-1-person-1.json'));
            $uat = json_decode(file_get_contents('./Api/live/api-v-1-person-1.json'));
            $api = "";

            if ($environment === "uat") {
                $api = $uat;
            } else if ($environment === "live") {
                $api = $live;
            }

            if (intval($member_id) === $api->person_id) {
                $output = "JSON data for member ID " . $api->person_id . "<br>";
                $output .= "Environment: " . $api->env . "<br>";
                $output .= "Name: " . $api->name_first . "<br>";
                $output .= "Last name: " . $api->name_last . "<br>";
                $output .= "Phone: " . $api->phone . "<br>";
                $output .= "Email: " . $api->email . "<br>";
            } else {
                $output = "Member ID " . $member_id . " does not match with any member";
            }

        }


    } else {
        $error['environment'] = "Please, select one environment";
    }

} 

?>

<h1>IMI Lookup Module</h1>

<form action="form.php" method="post">
    <label for="member_id">Member ID</label>
    <br>
    <input id="member_id" name="member_id" type="text" value="">
    <br>
    <p>Select the environment</p>
    <input id="uat" name="environment" type="radio" value="uat">
    <label for="uat">UAT</label>
    <br>
    <input id="live" name="environment" type="radio" value="live">
    <label for="live">LIVE</label>
    <br>
    <input name="submit" type="submit" value="Get a formatted JSON">
</form>

<!-- Output -->
<section>
    <p><?= $output ?></p>
</section>

<!-- Display errors if they exists -->
<section>
    <ul>
        <?php
            if (count($error) > 0) {

                foreach ($error as $err) {
        ?>
            <li><?= $err ?></li>
        <?php
                }

            }
        ?>
    </ul>
</section>