<?php
App::uses('AppHelper', 'View/Helper');

class MenuHelper extends AppHelper {
    public $helpers = array('Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'));

    public function menuList($menu) {
    	$result = '';
    	$current_url = '/'.$this->params->url;

    	$current_url_array = explode('/', $current_url);

    	
    	foreach ($menu as $url => $params) {
    		$url_array = explode('/', $url);

    		if($current_url == $url)
    			$active = ' class="active"';
    		elseif(in_array($url_array[1], $current_url_array) && empty($params['exact']))
    			$active = ' class="active"';
    		else
    			$active = '';

    		$result .= '<li'.$active.'>'. $this->Html->link($params['title'],$url).'</li>';
       	}
    	return $result;
    }
}
