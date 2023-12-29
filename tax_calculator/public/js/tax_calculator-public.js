(function( $ ) {
	'use strict';
	jQuery(document).on("change",".door-no",function() {
       	var value = jQuery(this).val();
       	if (value.length == 0) {
			jQuery('.postcode').attr('disabled','disabled')
		}else{
			jQuery('.postcode').removeAttr('disabled');
		} 
 	});

 	jQuery(".door-no").keyup(function(){
 		var value = jQuery(this).val();
 		if (value.length == 0) {
			jQuery('.postcode').attr('disabled','disabled')
		}else{
			jQuery('.postcode').removeAttr('disabled');
		} 
  	});
	jQuery(document).ready(function($) {

			var  band 	     = tax_object.council_tax_band;
			var htype 		 = tax_object.housetypes;
			var ptype 		 =  tax_object.property_type;
			var savingvalue =tax_object.saving_values;
			jQuery('#wpforms-11-field_10').val(htype);
			jQuery('#wpforms-11-field_11').val(ptype);
			jQuery('.tax-band').children().val(band);
			jQuery('.annual-saving').children().val(savingvalue);
			jQuery('.Property-type').children().val(ptype);
			jQuery('.owner-renter').children().val(htype);
			function formatSelect (color) {
				if (!color.id) { return color.text; }
				jQuery('#color').children().eq(1).data()
				var $color = jQuery(
				    '<span>'+color.element.index+'<span class="colorBox"></span> ' + color.text + '</span><span><b class="left">A</b></span>'
				 );
				return $color;
				};

				function formatSelectOption (color) {
				if (!color.id) { return color.text; }
				// this next line prevents the currently selected option from showing up in the dropdown list
				if (jQuery('#color').find(':selected').val() == color.element.value) { 
					return null; 
				}
				return formatSelect(color);
				};


				// jQuery('#color').select2({
				// 	placeholder: "SELECT YOUR ADDRESS",
				//     minimumResultsForSearch: Infinity, //removes the search box
				//     dropdownAutoWidth:false,
				//     width: 'resolve',
				// 	templateResult: formatSelectOption,
				// 	templateSelection: formatSelect,
				// 		tags: true,
				// 	/* the next 2 lines make sure the user can click away after typing and not lose the new tag */
				// 	selectOnClose: true, 
				// 	closeOnSelect: true
				// });
				/*
				jQuery(document).on('keypress keyup blur', '.propertyvalue', function (e) {
					jQuery(this).val(jQuery(this).val().replace(/[^0-9\.]/g,''));
            			if ((event.which != 46 || jQuery(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                		event.preventDefault();
            		}
				});	
				 jQuery(".propertyvalue").on("keypress keyup blur",function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
      			jQuery(this).val(jQuery(this).val().replace(/[^0-9\.]/g,''));
            			if ((event.which != 46 || jQuery(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                	event.preventDefault();
            		}
        		});
				*/
				jQuery(document).on('click', '.click-button-save', function (e) {
					var ipstatus 	 = jQuery("input[name='block-status']").val();
					var recaptcha_response = jQuery("input[name='recaptcha_response']").val();
					jQuery('.loading-class').show();
					jQuery('.error-msg-show').hide();
					if(ipstatus == 'blocked'){
						setTimeout(function(){ jQuery('.error-msg-show').show();
						jQuery('.loading-class').hide(); }, 500);
						return false;
					} 
					var htype 		 = jQuery("input[name='type']:checked").val();
					var ptype 		 = jQuery("input[name='property']:checked").val();
					var postcode     = jQuery('.postcode-value').val();
					var addressvalue = jQuery('#color').val();
					if(addressvalue == undefined){
						var addressvalue = '';
					}

					var propertytxt  = jQuery('.property-council-tax').val();
					if(propertytxt != '' && propertytxt !=undefined ){
						var addressvalue = 'no';
					}
					var band         = jQuery('#color').find(':selected').data('band');
					var taxvalue     = jQuery('#color').find(':selected').data('tax');
					jQuery('#wpforms-11-field_10').val(htype);
					jQuery('#wpforms-11-field_11').val(ptype);
					jQuery('#wpforms-11-field_8').val(band);
					 //jQuery('.custom-link').addClass('disabled');
					 if( addressvalue !='' && htype != 'undefined' && ptype != 'undefined'){
					 	//jQuery('.custom-link').removeClass('disabled');
							jQuery.ajax({
							type : "post",
							url : tax_object.ajax_url,
							data : {action: "get_select_third_steps",propertytxt:propertytxt,recaptcha_response:recaptcha_response,postcode:postcode,band:band,taxvalue:taxvalue,htype:htype,ptype:ptype,addressvalue:addressvalue},
								success: function(response) {
									//alert(response);
									jQuery('.search-text').hide();
									jQuery('.tax-box-calculatore').html(response);
									var $document = jQuery(document);
									var selector = '[data-rangeslider]';
									var $element = jQuery(selector);

									// For ie8 support
									var textContent = ('textContent' in document) ? 'textContent' : 'innerText';

									// Example functionality to demonstrate a value feedback
									function valueOutput(element) {
									var value = element.value;
									var output = element.parentNode.getElementsByTagName('output')[0] || element.parentNode.parentNode.getElementsByTagName('output')[0];
									output[textContent] = '£'+value;
									}

									$document.on('input', 'input[type="range"], ' + selector, function(e) {
									valueOutput(e.target);
									});


									// Basic rangeslider initialization
									$element.rangeslider({

									// Deactivate the feature detection
									polyfill: false,

									// Callback function
									onInit: function() {
									valueOutput(this.$element[0]);
									},

									// Callback function
									onSlide: function(position, value) {
									//console.log('onSlide');
									//console.log('position: ' + position, 'value: ' + value);
									},

									// Callback function
									onSlideEnd: function(position, value) {
									//console.log('onSlideEnd');
									//console.log('position: ' + position, 'value: ' + value);
									}
									});
									new AutoNumeric('.propertyvalue', {
									 
									});
									jQuery('.loading-class').hide();
							}
						})	
					 }		
				});
				jQuery(document).on('change', '.property-select', function (e) {
					var htype 		 = jQuery("input[name='house-type']:checked").val();
					var ptype 		 = jQuery("input[name='property']:checked").val();
					var addressvalue = jQuery('#color').val();
					var propertytxt  = jQuery('.property-council-tax').val();
					if(addressvalue == undefined){
						var addressvalue = '';
					}
					if(propertytxt == undefined){
						var propertytxt = '';
						console.log('testing');
					}

					var band         = jQuery('#color').find(':selected').data('band');
					var taxvalue     = jQuery('#color').find(':selected').data('tax');
					 jQuery('.custom-link').addClass('disabled');
					 if( addressvalue !='' && htype !='' && ptype !=''){
					 	jQuery('.custom-link').removeClass('disabled');
					}
					if( propertytxt !='' && htype !='' && ptype !=''){
					 	jQuery('.custom-link').removeClass('disabled');
					}		
				});	

			 // Back to First Jquery Functions code here.		
			 jQuery(document).on('click', '.submit-back-first', function (e) {
			    jQuery('.submit-pincode').children('i').removeClass('fa fa-circle-o-notch fa-spin');
				jQuery('.submit-pincode').children('i').addClass('fa fa-search3');
			 	jQuery('.search-text').html(jQuery('.search-text-first').html());
			 	jQuery('.click-button-save').addClass('disabled');
			 	jQuery('.error-msg-show').hide();
			 });

			 // Select On change JQuery code here.
			  jQuery(document).on('change', '.property-address', function (e) {
				    var htype 		 = jQuery("input[name='type']:checked").val();
					var ptype 		 = jQuery("input[name='property']:checked").val();
					var addressvalue = jQuery('#color').val();
					if(addressvalue == undefined){
						var addressvalue = '';
					}else{
						jQuery('#color').select2("close");
					}
					var band         = jQuery('#color').find(':selected').data('band');
					var taxvalue     = jQuery('#color').find(':selected').data('tax');
					 jQuery('.custom-link').addClass('disabled');
					 if( addressvalue !='' && htype != 'undefined'  && ptype != 'undefined'){
					 	jQuery('.custom-link').removeClass('disabled');
					 }
			 });	
			  // Select On change JQuery code here.
			  jQuery(document).on('change keypress keyup blur', '.property-council-tax', function (e) {
				    var htype 		 = jQuery("input[name='type']:checked").val();
					var ptype 		 = jQuery("input[name='property']:checked").val();
					var propertytxt  = jQuery('.property-council-tax').val();
					if(propertytxt == undefined){
						var propertytxt = '';
					}else{
						jQuery('#color').select2("close");
					}
					var band         = jQuery('#color').find(':selected').data('band');
					var taxvalue     = jQuery('#color').find(':selected').data('tax');
					 jQuery('.custom-link').addClass('disabled');
					 if( propertytxt !='' && htype != 'undefined'  && ptype != 'undefined'){
					 	jQuery('.custom-link').removeClass('disabled');
					 }
			 });	

			  
			jQuery('.postcode').keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                   jQuery( ".submit-pincode" ).trigger( "click" );  
                }
                //Stop the event from propogation to other handlers
                //If this line will be removed, then keypress event handler attached 
                //at document level will also be triggered
                event.stopPropagation();
            });
			 //Submit Pincode Jquery actions Code Coming Here.
			 jQuery(document).on('click', '.submit-pincode', function (e) {
			 	var postcode = jQuery('.postcode').val();
			 	var doorno   = jQuery('.door-no').val();
			 	jQuery('.submit-pincode').children('i').removeClass('fa fa-search3');
			   	jQuery('.submit-pincode').children('i').addClass('fa fa-circle-o-notch fa-spin');
				var postcodevalue = jQuery('.postcode').val();
				var postcodevalue = postcodevalue.replace(' ','');
				var doorno        = doorno.replace(' ','');
				jQuery('.door-no').removeClass('require');
				jQuery('.postcode').removeClass('require');
			 	if(postcodevalue.length >= 4 && doorno.length >=2 ) {
			 	jQuery('.error-msg').text('');	
			 	jQuery.ajax({
				type : "post",
				url : tax_object.ajax_url,
				data : {action: "get_select_address_dropdown",postcode:postcodevalue,doorno:doorno},
					success: function(response) {
						jQuery('.search-text').html(response);
						var lensgth = jQuery('.property-address').children().length;
						if(lensgth == 1){
							jQuery('.custom-link').removeClass('disabled');
						}
							function formatSelect (color) {
								if (!color.id) { return color.text; }
								var band = jQuery('#color').children().eq(color.element.index).data('band')
								var $color = jQuery(
								'<span class="address-text"> ' + color.text + '</span><span><b class="left">'+ band +'</b></span>'
								);
								return $color;
							};

							function formatSelectOption (color) {
								if (!color.id) { return color.text; }
								// this next line prevents the currently selected option from showing up in the dropdown list
								if (jQuery('#color').find(':selected').val() == color.element.value) { 
									return null; 
								}
								return formatSelect(color);
							};
							jQuery('#color').select2({
								placeholder: "SELECT YOUR ADDRESS",
							    minimumResultsForSearch: Infinity, //removes the search box
								templateResult: formatSelectOption,
								templateSelection: formatSelect,
								width: 'resolve',
								dropdownAutoWidth:false,
									tags: true,
								/* the next 2 lines make sure the user can click away after typing and not lose the new tag */
								selectOnClose: true, 
								closeOnSelect: false
							});
							new AutoNumeric('.property-council-tax', {
								
								
							});			
			
					}
				}) }else{
					if(postcodevalue.length <= 4 && doorno.length <=2 ){
					 jQuery('.error-msg').text('Please enter a valid door number and postcode.');
					 jQuery('.door-no').addClass('require');
					 jQuery('.postcode').addClass('require');
					}else{
					  if(doorno.length <=2){	
 					    jQuery('.error-msg').text('Door No./name is required!');
 					    jQuery('.door-no').addClass('require');
 					    jQuery('.postcode').removeClass('require');
					   }else{
					   	jQuery('.error-msg').text('Postcode is not valid!');
					   	jQuery('.postcode').addClass('require');
					   	jQuery('.door-no').removeClass('require');
					   }
					}
			   		jQuery('.submit-pincode').children('i').removeClass('fa fa-circle-o-notch fa-spin');
					jQuery('.submit-pincode').children('i').addClass('fa fa-search3');
				}
			   });

			 // Calculate Button JQuery code coming here.
			  jQuery(document).on('click', '.btn-calculate', function (e) {
			  		jQuery('.loading-class').show();
			  		var ipstatus 	 = jQuery("input[name='block-status']").val();
					jQuery('.error-msg-show').hide();
					if(ipstatus == 'blocked'){
							setTimeout(function(){ jQuery('.error-msg-show').show();
						jQuery('.loading-class').hide();; }, 500)
							return false;
					} 
			  	    var htype 		  = jQuery(".house-type").val();
					var ptype 		  = jQuery("input[name='property']:checked").val();
					var postcode      = jQuery('.postcode-value').val();
					var addressvalue  = jQuery('#color').val();
					var band          = jQuery('#color').find(':selected').data('band');
					var taxvalue      = jQuery('#color').find(':selected').data('tax');
					var propertyvalue = jQuery('.propertyvalue').val();
					var lastinsertid  = jQuery(".entry-id").val();
					var propertytxt   = jQuery('.property-council-tax').val();
					if(propertytxt != '' && propertytxt !=undefined ){
						var addressvalue = 'no';
					}
					jQuery('#wpforms-11-field_10').val(htype);
					jQuery('#wpforms-11-field_11').val(ptype);
					jQuery('#wpforms-11-field_8').val(band);
					jQuery('.error-msg').text('');
					if(propertyvalue.length >4 ){
					jQuery.ajax({
					type : "post",
					url : tax_object.ajax_url,
					data : {action: "get_select_forth_steps",propertytxt:propertytxt,lastinsertid:lastinsertid,postcode:postcode,propertyvalue:propertyvalue,band:band,taxvalue:taxvalue,htype:htype,ptype:ptype,addressvalue:addressvalue},
						success: function(response) {
							jQuery('.search-text').hide();
							jQuery('.tax-box-calculatore').html(response);
							//var savingvalue = jQuery('.saving-values').val();
							setTimeout(function(){ 
								var savingvalue = jQuery('.saving-values').val();
								jQuery('#wpforms-11-field_9').val(savingvalue);
							 }, 500)
							jQuery('.loading-class').hide();
						}
					})
					}else{
						jQuery('.error-msg').text('Property Value Is Not Valid!');
						jQuery('.loading-class').hide();
					}
			  });	

			  // Back Second Steps JQuery code coming Here.
			  jQuery(document).on('click', '.back-2-steps', function (e) {
				var htype 		  = jQuery(".house-type").val();
				var ptype 		  = jQuery("input[name='property']:checked").val();
				jQuery.ajax({
				type : "post",
				url : tax_object.ajax_url,
				data : {action: "back_to_second_steps_html",htype:htype,ptype:ptype},
					success: function(response) {
						jQuery('.search-text').show();
						jQuery('.tax-box-calculatore').html(response);
						jQuery('.custom-link').removeClass('disabled');
					}
				})
			  });

			 jQuery(document).on('click', '.back-3-steps', function (e) {
			 	var propertyvalue = jQuery('.property-values').val();
			 	var ptype    	  = jQuery('.c_type_val').text();
			 	var htype    	  = jQuery('.house-type').val();
			 	var addressvalue  = jQuery('#color').val();
		 		var band          = jQuery('#color').find(':selected').data('band');
				var taxvalue      = jQuery('#color').find(':selected').data('tax');
				var propertytxt  = jQuery('.property-council-tax').val();
				if(propertytxt != '' && propertytxt !=undefined ){
						var addressvalue = 'no';
				}
				jQuery('.loading-class').show();
				jQuery.ajax({
				type : "post",
				url : tax_object.ajax_url,
				data : {action: "back_to_third_steps_html",propertytxt:propertytxt,band:band,addressvalue:addressvalue,htype:htype,propertyvalue:propertyvalue,ptype:ptype},
					success: function(response) {
						jQuery('.search-text').hide();
						jQuery('.tax-box-calculatore').html(response);
						//Range slider call back functions during ajax time
						var $document = jQuery(document);
						var selector = '[data-rangeslider]';
						var $element = jQuery(selector);

						// For ie8 support
						var textContent = ('textContent' in document) ? 'textContent' : 'innerText';

						// Example functionality to demonstrate a value feedback
						function valueOutput(element) {
						var value = element.value;
						var output = element.parentNode.getElementsByTagName('output')[0] || element.parentNode.parentNode.getElementsByTagName('output')[0];
						output[textContent] = '£'+value;
						}

						$document.on('input', 'input[type="range"], ' + selector, function(e) {
						valueOutput(e.target);
						});


						// Basic rangeslider initialization
						$element.rangeslider({

						// Deactivate the feature detection
						polyfill: false,

						// Callback function
						onInit: function() {
						valueOutput(this.$element[0]);
						},

						// Callback function
						onSlide: function(position, value) {
						//console.log('onSlide');
						//console.log('position: ' + position, 'value: ' + value);
						},

						// Callback function
						onSlideEnd: function(position, value) {
						//console.log('onSlideEnd');
						//console.log('position: ' + position, 'value: ' + value);
						}
						});
						
                        new AutoNumeric('.propertyvalue', {
									 
						});
						jQuery('.loading-class').hide();
					}
				})
			  });	
			  



});


})( jQuery );
