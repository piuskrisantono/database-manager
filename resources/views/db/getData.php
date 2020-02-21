<?php
	$conn = pg_connect("host=172.22.127.2 port=5432 dbname=monitoring_db user=piuskw77 password=piuskw77");
	$newstat = pg_query($conn, "select * from monitoring_table where servicename = '" . $_POST['servicename'] .  "' order by time_collected limit 1 ");
        $data = pg_fetch_row($newstat);
	echo "<input type="text" id=\"cpu-new\"> val=\"" . $data[1] . "\">;
?>
