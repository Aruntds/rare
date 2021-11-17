<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark Descience Private Limited. 
* https://touchmarkdes.com
* Version 4.0.1
* Copyright (c) 2018-2020 Touchmark De`Science
*
*/
extract($_REQUEST);
include_once('jackus.php');

reguser_protect();
include_once('check_restricted.php');
//update query
if ($action == "delete" && $id != '') {
	//Insert query
	$arrFields=array('`deleted`');

	$arrValues=array("1");

	$sqlWhere= "promobannerID=$id";

	if(sqlACTIONS("UPDATE","js_promobanner",$arrFields,$arrValues, $sqlWhere)) {
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		echo "<script type='text/javascript'>window.location = 'promobanner1.php?code=1'; </script>";
	}
}

//Generating dynamic file names to view/add/edit/delete O/P:  r_{module-name}.php
$generateINCLUDE = viewGENERATOR($currentpage, $route);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title><?php include publicpath('__pagetitle.php'); ?> | <?php echo $_SITETITLE; ?></title>
    <?php 
    //$use_datable = 'N';
    include publicpath('__commonscripts.php'); 
    ?>

  </head>
  <body>

	  <!-- main header -->
	  <?php include publicpath('__header.php'); ?>
	  <!-- main header ends -->
  
    <div class="content content-fixed bd-b">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
          
            <?php include publicpath('__breadcrumb.php'); ?>

          <div class="mg-t-20 mg-sm-t-0">

            <?php
			if(!in_array($route,array('add', 'edit'))){ ?>
              <a href="?route=add" class="btn btn-xs btn-success btn-icon"><i data-feather="plus"></i> Add</a>
            <?php } ?>

            <?php pageREFRESH(curPageURL(), $__refresh); ?>

          </div>

        </div>
      </div>
    </div>

    <!-- container -->
    <?php include ($generateINCLUDE); ?>

    <!-- Footer -->
    <?php include publicpath('__footer.php'); ?>
    <!-- End of Footer -->

    <div class="modal fade" id="deleteDATA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-14">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel2">Please confirm your action</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body receiving-delete-data"></div>
        </div>
      </div>
    </div>
	
	 <!--Starts Promo banner -->
	 <div class="modal fade"  id="bannerIMG"  tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">

        <div class="modal-dialog center-block" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h4 class="modal-title">Promo Banner Details</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>

                <div class="modal-body receiving-delete-data"></div>

            </div>

        </div>

      </div>
	   <!--End Promo banner -->
	  
	<!-- onclick spinner -->
    <div class="modal fade effect-scale show" id="pleasewait-loader" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered wd-150" role="document">
        <div class="modal-content">
          <div class="modal-body text-center">
            <div class="spinner-border wd-80 ht-80" role="status">
              <span class="sr-only">Loading...</span>
            </div>     
          	<p>working on it...</p>
          </div>
        </div>
      </div>
    </div>

    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
    <script src="<?php echo BASEPATH; ?>/public/integration/select2/js/select2.min.js"></script>
    
    <!--<script src="<?php echo BASEPATH; ?>/public/integration/tiny_mce/tiny_mce.js"></script>-->
    <script src="<?php echo BASEPATH; ?>/public/integration/parsleyjs/parsley.min.js"></script>
    
    <script>
      $(function(){
        'use strict'
        <?php if($route == '') {  ?>
	
        $('#promobanner1_LIST').DataTable({
          //responsive: true,
          'ajax': 'engine/json/JSONpromobanner1.php',
           "columns": [
            { "data": "count" },
            { "data": "promobanner_title" },
            { "data": "display_order" }, 
           // { "data": "display_imagesize" }, 
			{data: "promobanner_image",

						"searchable": false,

						"orderable":false,

						"data": "modify",

						"render": function (data, type, row) {

				 

						if ( row.promobanner_image === '')  {

							return 'N/A';}

							else {

								return '<a href="javascript:void(0);" data-toggle="modal" onClick ="promoBANNERIMAGE('+data+');" class="btn btn-xs btn-success"><?php echo $__viewimage; ?></a>';

					}

						}

					} ,     //6             	
					
            { "data": "status" },
            { "data": "modify" }
          ],
		  "columnDefs": [{
			  	"targets": 0,
				"data": "count",
				"searchable": false
		  }, {
			  	"targets": 4,
				"data": "status",
				"searchable": false,
				"render": function ( data, type, row ) {
				  switch(data) {
					   case '1' : return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" name="categorystatus-'+row.modify+'" id="categorystatus'+row.modify+'" checked="" onChange="togglestatusITEM('+row.modify+', '+data+');"> <label class="custom-control-label" for="categorystatus'+row.modify+'">Yes</label></div>'; break;
					   case '0' : return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" name="categorystatus--'+row.modify+'" id="categorystatus'+row.modify+'" onChange="togglestatusITEM('+row.modify+', '+data+');"> <label class="custom-control-label" for="categorystatus'+row.modify+'">Yes</label></div>'; break;
					}
				}
			 }, {
			  	"targets": 5,
				"data": "modify",
				"searchable": false,
				"render": function ( data, type, full, meta ) {
					return '<a title="Click to edit" href="<?php echo $currentpage; ?>?route=edit&id='+data+'" class="btn btn-light btn-icon"><i class="fa fa-pencil-alt"></i></a> <a href="javascript:void(0);" onClick ="deleteITEM('+data+');" title="Click to delete" class="btn btn-dark btn-icon"><i class="fa fa-trash"></i></a>';
					//return '';
				}
			 } 
		  ],
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
	
    <?php }  
//////////////////////////////////      
      if($route == 'add' || $route == 'edit') {  ?>
 
        /*tinyMCE.init({
            mode : "textareas",
            theme : "advanced"
        });*/
		//Banner image
        function uploadImage(input){
            if (input.files && input.files[0]) {
              var url = URL.createObjectURL(input.files[0]);
              $('#imagePreview').attr('style', 'background-image:url(' + url + ')');
              $('#imagePreview').hide();
              $('#imagePreview').fadeIn(650);
            }
        }

        //document.querySelector("input").onchange = function(){uploadImage(this)};

        $("#banner_image").change(function() {
        
            uploadImage(this);         
        });

         // offer banner image
        function uploadImage1(input){
            if (input.files && input.files[0]) {
              var url1 = URL.createObjectURL(input.files[0]);
              $('#imagePreview1').attr('style', 'background-image:url(' + url1 + ')');
              $('#imagePreview1').hide();
              $('#imagePreview1').fadeIn(650);
            }
        }

        //document.querySelector("input").onchange = function(){uploadImage(this)};

        $("#offer_image").change(function() {
            uploadImage1(this);         
        });

   // Expired banner image

   function uploadImage2(input){
            if (input.files && input.files[0]) {
              var url2 = URL.createObjectURL(input.files[0]);
              $('#imagePreview2').attr('style', 'background-image:url(' + url2 + ')');
              $('#imagePreview2').hide();
              $('#imagePreview2').fadeIn(650);
            }
        }

        //document.querySelector("input").onchange = function(){uploadImage(this)};

        $("#exprie_image").change(function() {
        
          uploadImage2(this);         
        });

		
/////////////////////////////////
        //fix submit buttons to top on scroll
        function sticktothetop() {
            var window_top = $(window).scrollTop();
            var top = $('#stick-here').offset().top;
            if (window_top > top) {
                $('#stickThis').addClass('stick');
                $('#stick-here').height($('#stickThis').outerHeight());
            } else {
                $('#stickThis').removeClass('stick');
                $('#stick-here').height(0);
            }
        }

        $(window).scroll(sticktothetop);
        sticktothetop();

<?php } ?>

      });
	

	function  deleteITEM(deleting_id) { 
		var SELECTED_ID = deleting_id;
		//87alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__promobanner1.php?type=delete&delete_id='+SELECTED_ID+'',function(){
			$('#pleasewait-loader').hide();
			$('#deleteDATA').modal({show:true});
		});
	}
	
	function  promoBANNERIMAGE(get_staff_id) { 

		var SELECTED_ID = get_staff_id;

		//alert(SELECTED_ID);

		$('.receiving-delete-data').load('engine/ajax/ajax_promobanner1.php?type=promobanner_img_one&promobannerone_id='+SELECTED_ID+'',function(){

			$('#bannerIMG').modal({show:true});

		});

	}

	
	function  togglestatusITEM(promobanner1_id, status) { 
		var SELECTED_ID = promobanner1_id;
		var SELECTED_STATUS = status;
		//alert(SELECTED_ID);
		$('#pleasewait-loader').show();
		$('.receiving-delete-data').load('view/x__promobanner1.php?type=changestatus&promobannerID='+SELECTED_ID+'&oldstatus='+SELECTED_STATUS+'',function(){
			$('#pleasewait-loader').hide();
			location.reload();
		});
	}
	  $('#banner_link_type').on('click', function() {
            var type = $(this).val();
  
             if (type == 1) {
                $("#offer_div").show();
                $("#offer_div_image").show();
                $("#exprie_div_image").show();
                $("#banner_link").val('');
             }else{
			 $("#offer_div").hide();
       $("#offer_div_image").hide();
       $("#exprie_div_image").hide();
			 $("#banner_link").val('<?php echo $banner_link ; ?>');
			 }			 
        });
			$('#banner_offertype').on('click', function() {
            var offer_id = $(this).val();
			   $.ajax({
				   type: 'post', url: 'engine/ajax/ajax_return_offertype.php',
				   data: { offer_id:offer_id },
				  success: function (data) {
					  $("#banner_link").val('<?php echo SEOURL; ?>offers.php?type='+data+'&offerID='+offer_id); 
				  }
			  });
              			 
        });
		
  <?php
    if($code == '1') { 
      $displayMSG_globalclass->displayMSG($code, "Success", 'Record created Successfully', 'success');
    }
  
    if($code == '0') {
      $displayMSG_globalclass->displayMSG($code, "Error", 'Unable to Add Category.', 'error');  
    }

    if(!empty($err))  {
  ?>
      toastr.error('Error', '<?php foreach ($err as $e) { echo "$e <br>"; } ?>', {timeOut: 6000})
  <?php } ?>
    </script>
  </body>
</html>	