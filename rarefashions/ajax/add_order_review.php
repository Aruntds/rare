<?php 

extract($_REQUEST);

include '../head/jackus.php';

					$arrFields=array('`od_id`','`review_name`','`review_email`','`rating`','`review_type`','`review_discription`','`createdby`','`status`');

					$arrValues=array("$order_ID","$review_name","$review_email","$rating","2","$review_discription","$logged_user_id","1");

					if(sqlACTIONS("INSERT","js_review",$arrFields,$arrValues,'')) {
						
					}
			if($rating < 3){
					$ticket_ref_no = supportTICKET_REFNOGENERATOR();
					$arrFields=array('`ticket_ref_no`','`product_ID`','`ticket_name`','`ticket_email`','`ticket_type`','`ticket_discription`','`status`','`createdby`');

					$arrValues=array("$ticket_ref_no","$product_ID","$review_name","$review_email","$rating","$review_discription","1","$logged_user_id");

					if(sqlACTIONS("INSERT","js_support_ticket",$arrFields,$arrValues,'')) {
						
					}
			}
?>