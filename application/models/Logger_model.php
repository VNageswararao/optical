<?php
/**
 * Description of Logger_model
 *
 * @author Rajesh @19/12/2020
 */
class Logger_model extends CI_Model
{
      function save($db) {
        $filepath = APPPATH . 'logs/Query-log-' . date('Y-m-d') . '.php'; // Creating Query Log file with today's date in application/logs folder
                $handle = fopen($filepath, "a+");                 // Opening file with pointer at the end of the file
        $times = $db->query_times;                   // Get execution time of all the queries executed by controller
                foreach ($db->queries as $key => $query) { 
                    $sql = $query . " \n Execution Time:" . $times[$key]; // Generating SQL file alongwith execution time
                    fwrite($handle, $sql . "\n\n");              // Writing it in the log file
                }
        fclose($handle);      // Close the file
    }
}