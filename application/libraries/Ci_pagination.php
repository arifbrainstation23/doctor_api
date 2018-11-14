<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ci_pagination{
	public function pagination_data($count, $CurrentPosition , $Limit = ""){
		
		$lmtPage = ($Limit != "")? $Limit : 10; // page limit
		$act_pre_post = 4; // hide previous and next button from current active button
		$result = "";
		if(!empty($count) && $count > $lmtPage){
			# condition for hide pre button
			$preStyle = ($CurrentPosition == '0')? ' hide' : '';
			
			$result .= '<ul id="ciPagination" class="pagination">
				<li data-value="0" title="First" class="pre '.$preStyle.'"><a><span class="fa fa-angle-left"></span></a></li>';    
				$cnt = 1;
				$chk = 0; 
				
				for($i=0; $i<$count; $i = $i+$lmtPage){
						# condition for check active class
						if($CurrentPosition == $i){
							$cls = 'active';
							$btn = '<span>'.$cnt.'</span>';
							$check = 1;
						}else{
							$btn = '<a>'.$cnt.'</a>';
							$cls = '';
						}
							# condition for get 1 button after active class
							if(isset($check)){
								if($check == $act_pre_post+1){
									$result .= '<li class="pagin_dot">...</li>';
									$nextActie = '';
								} 
								$check++;
							}
							
							$allNextBtnHide = (isset($nextActie))? ' hide' : '';
							
							# condition for get 1 button before active class
								
							if($CurrentPosition-($lmtPage*$act_pre_post) >= 0 && $i <= $CurrentPosition-($lmtPage*$act_pre_post)){
								
								if($chk == 0){
									$result .= '<li class="pagin_dot">...</li>';
									$chk++;
								}
								$hideClass = ' hide';  
							}else{
								$hideClass = '';
							}
						# generate pagination button 		
						$result .= '<li data-value="'.$i.'" class="'.$cls.$hideClass.$allNextBtnHide.'">'.$btn.'</li>';
						$cnt++;
					}
				# condition for hide next button	
				$nextStyle = ($CurrentPosition == ($i-$lmtPage))?' hide':'';
				
			return  $result .= '<li  data-value="'.($i-$lmtPage).'" title="Last" class="next'.$nextStyle.'"><a><span class="fa fa-angle-right"></span></a></li>
			</ul>';
		}
	} # end function 
	
}	# end class 
 
?>