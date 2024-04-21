<?php
class TOROFLIX_Theme
{
	//Sidebar Position
	public function sidebar_position($id) {
		$sidebar = get_option($id);
		if($sidebar == 'right'){
			$sid = '';
		} elseif($sidebar == 'left'){
			$sid = 'TpLCol';
		} elseif($sidebar == 'none'){
			$sid = 'NoSdbr';
		} else {
			$sid = '';
		}
		return $sid;
	}
}