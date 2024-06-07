<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Date
 *
 * @author rajesh
 */
class Date{
       public function __construct()
        {
           date_default_timezone_set("Asia/Calcutta");  
        }
    public function dateView2Sql($date) {

        $array=explode('/', $date);
        if(!is_array($array))
        {
            return date('Y-m-d');
        }
        if(count($array)!=3)        {
            return date('Y-m-d');
        }
        return $array[2].'-'.$array[1].'-'.$array[0];
    }
    public function dateSql2View($date) {
      return date('d/m/Y', strtotime($date));
    }
}
