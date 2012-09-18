<?php

function isMultiArray($multiarray) {
	if (is_array($multiarray)) {  // confirms array
		foreach ($multiarray as $array) {  // goes one level deeper
			if (is_array($array)) {  // is subarray an array
				return true;  // return will stop function
			}  // end 2nd check
		}  // end loop
	}  // end 1st check
	return false;  // not a multiarray if this far
}

function sqThm($src,$dest,$size=220){
   
   list($w,$h) = getimagesize($src);

   if($w > $h){
      exec("convert ".$src." -resize x".$size." -quality 100 ".$dest);
   }else{
      exec("convert ".$src." -resize ".$size." -quality 100 ".$dest);
   }

   exec("convert ".$dest." -gravity Center -crop ".$size."x".$size."+0+0 ".$dest);

}

?>
