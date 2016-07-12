<?php 
if(isset($suburbs)){ 			
    if(count($suburbs)>0){
		$j=0;
		echo '[';
		foreach($suburbs as $key=>$sub){
			$j++;
			if($j=='1'){
				echo '"'.$sub.'"';
			}else{
				echo ',"'.$sub.'"';
			}
			
		}
		echo ']';
 		
		/* echo json_encode($suburbs); */ 
	}	  
}else{
	echo 'NO search result Exists';
}  
?>
