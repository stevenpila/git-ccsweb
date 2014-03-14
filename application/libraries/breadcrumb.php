<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Breadcrumb{
    public function __construct() {}
    
    public function generate($array){
        $breadcrumb = ""; $array_length = 1;
        
        foreach($array as $subarray){
            if($array_length == count($array))
                $breadcrumb .= "<a href=" . $subarray['link'] . ">" . $subarray['link_name'] . "</a>";
            else
                $breadcrumb .= "<a href=" . $subarray['link'] . ">" . $subarray['link_name'] . "</a> / ";
            $array_length++;
        }
        
        echo $breadcrumb;
    }
}
?>
