<?php

$txt = "This is some silly text.";

$filters = array();

function removeSilly($input) { // set filter function 

  $input = str_replace(' silly', '', $input);
	return $input;
}

add_filter('myFuncFilter', 'removeSilly'); // hook function to global filter list

function add_filter($filterName, $filterFunction) {
	global $filters; 

	$filters[$filterName][] = $filterFunction; // add array element with the name of the function 

}


function filter($filterName,$params) {

	global $filters; // Get global filter list
	
	foreach($filters[$filterName] as $k => $filterFunction) { // Foreach function hooked to original function 
		if(is_callable($filterFunction)){ // check if hooked function exists 
			$params = call_user_func($filterFunction,$params); // apply function 
		} else {
		echo "Filter \" $filterFunction \" not defined! \n";
		}
	} 
	return $params; // return
}


// This is the core function 
function myFunc($input) {
	$output = $input; // Do something

	$output = filter('myFuncFilter',$output); // Call filter function for the any filters hooked to myFuncFilter 
	
	return $output; // Return
}

echo myFunc($txt);

?>
