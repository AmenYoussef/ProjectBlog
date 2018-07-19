<?php
	function lang($phrase) {
        
		static $lang = array(
            
			// Navbar Links
			'HOME_ADMIN' 	=> 'Home',
			'CATEGORIES' 	=> 'Categories'
            
		);
        
		return $lang[$phrase];
        
	}