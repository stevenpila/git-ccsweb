<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Breadcrumb
 * 
 * Generates a navigation links - Lets you know where you are in a site
 * 
 * @source  string  http://thephpx.com/2010/05/codeigniter-helper-create-breadcrumb-from-url/
 * @return  links   e.g. Home > Forum > View
 */

if(!function_exists('create_breadcrumb')){
    function create_breadcrumb(){
        $CI = &get_instance();
        $i = 1;
        $breadcrumbs = array();
        $ctr = 0;
        $uri = $CI->uri->segment($i);
        $link = '<ul style="list-style: none"> 
                <li><a href="' . site_url('home') . '">Home</a></li>';
        
        while($uri != ''){
            $prep_link = '';
            
            for($j=1;$j<=$i;$j++){
                $prep_link .= $CI->uri->segment($j).'/';
            }
            
            if($CI->uri->segment( $i + 1 ) == ''){
                $breadcrumbs[$ctr]['link'] = site_url($prep_link);
                $breadcrumbs[$ctr++]['link_name'] = ucwords(str_replace('_', ' ', $CI->uri->segment($i)));
                $link .= '<li><i class="icon-chevron-right"></i> <a href="' . site_url($prep_link) . '"><b>';
                $link .= ucwords(str_replace('_', ' ', $CI->uri->segment($i))).'</b></a></li>';
            }else{
                $breadcrumbs[$ctr]['link'] = site_url($prep_link);
                $breadcrumbs[$ctr++]['link_name'] = ucwords(str_replace('_', ' ', $CI->uri->segment($i)));
                $link .= '<li><i class="icon-chevron-right"></i> <a href="' . site_url($prep_link) . '">';
                $link .= ucwords(str_replace('_', ' ', $CI->uri->segment($i))) . '</a></li>';
            }
            
            $i++;
            $uri = $CI->uri->segment($i);
        }
        
        $link .= '</ul>';
        return $breadcrumbs;
    }
}
