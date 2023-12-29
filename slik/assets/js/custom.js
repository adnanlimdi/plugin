$(document).ready(function () {
    $('.navbar-toggler').click(function () {
        $('body').toggleClass('fixbody');
    })
    jQuery('.overlay').hide();
    new WOW().init();

});

  jQuery(document).ready(function ($) {
    //Myaccount page payment switch Javascript code.



  // Caccel Payment
jQuery(document).on("click",".open-popup-code-payment",function() {
     postid = jQuery(this).data('id');
     jQuery('.payment-value-id').val(postid);
     var title = jQuery(this).parent().parent().children().eq(0).html()
     jQuery('.title-cancel').html('<h2>'+title+'</h2>');
     jQuery('.cancel-payment-button').next('span.error').remove();

});
// jQuery(document).on("click",".cancel-payment-button",function() {
//     postid = jQuery('.payment-value-id').val();
//      $.ajax({
//               url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
//               method:'Post',
//               data: {
//                   'action'          : 'cancel_paypment',
//                   'postid'          : postid ,
//               },
//               success:function(data) {
//                // jQuery('.popup-price-content').html(data);
//                 jQuery('.cancel-payment-button').after('<span class="error">'+ data +'</span>');
//                 setTimeout(function(){ window.location.reload() }, 3000);
//               },
//               error: function(errorThrown){
//                   console.log(errorThrown);
//               }
//             });
// });


    //Joining page edit/save
    jQuery(document).on("click",".edit-button",function() {
      jQuery(this).parent().prev().children('input').attr('type','text');
      jQuery(this).parent().prev().children('span').hide();
      jQuery(this).addClass('save-button'); 
      jQuery(this).html("Save");    
      jQuery(this).removeClass('edit-button');     
    });

   jQuery(document).on("click",".save-button",function() {
      jQuery(this).parent().prev().children('input').attr('type','hidden');
      jQuery(this).parent().prev().children('span').show();
      var value = jQuery(this).parent().prev().children('input').val();
      jQuery(this).parent().prev().children('span').html(value);
      jQuery(this).addClass('edit-button'); 
      jQuery(this).html("Edit");    
      jQuery(this).removeClass('save-button');   
      var whereyouleave   = jQuery('.whereyou-leavekey').val();
      var fullname        = jQuery('.full-name-input').val();
      var email           = jQuery('.email-input').val();
      var streetaddress   = jQuery('.Street-address').val();
      var homedescriptions= jQuery('.homedesc-input').val();
      var subscription    = jQuery('.subscriptionp-type').val();
      var howltp          = jQuery('.howltp').val();
      var whereyouleavek  = jQuery('.whereyou-leavekey').val();
      $.ajax({
                url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
                method:'Post',
                data: {
                    'action'          : 'update_user_filed',
                    'fullname'        : fullname ,
                    'email'           : email ,
                    'address'         : streetaddress ,
                    'homedescriptions': homedescriptions,
                    'subscription'   : subscription ,
                    'howltp'          : howltp ,
                    'whereyouleavek'  : whereyouleavek ,
                },
                success:function(data) {
                  console.log('value updated');
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
      });  
   });

   
   jQuery(document).on("click",".openform",function() {
      $referralcode     = jQuery('.referral-code').val();
      jQuery('.referral-code').next('span.error').remove();
      if($referralcode == ''){
            jQuery('.referral-code').after('<span class="error">This field is required </span>');
       }
      if($referralcode != ''){
            $.ajax({
            url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
            method:'Post',
            data: {
                'action': 'check_referral_code',
                'refferalcode': $referralcode ,
            },
            success:function(data) {
              //window.location.href = 'http://205.134.254.135/~projectdemoserve/homeservice/confirmations/';
              jQuery('.referral-code').next('span.error').remove();
              if(data ==  'error'){
                 jQuery('.referral-code').after('<span class="error">Referral Code is not valid. </span>');
              }else{
                 jQuery('.referral-code').next('span.error').remove();
                 jQuery('.step-form-init').hide();
                 jQuery('.wizzard').show();
                 jQuery('.step-form-one').show();
              }
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
           });
        }    
    });    


    jQuery(document).on("click",".nextbuttonfirst",function() {
          $fullname           = jQuery.trim(jQuery('.first-name').val());
          $email              = jQuery.trim(jQuery('.email-address').val());
          $userpasssword      = jQuery.trim(jQuery('.user-password').val());
           jQuery('.first-name').next('span.error').remove();
           jQuery('.user-password').next('span.error').remove();
           jQuery('.email-address').next('span.error').remove();
          if($fullname == ''){
            jQuery('.first-name').after('<span class="error">This field is required </span>');

          }
          if($userpasssword == ''){
            jQuery('.user-password').after('<span class="error">This field is required </span>');

          }
         if($email == ''){
           jQuery('.email-address').after('<span class="error">This field is required </span>');
          }
          
          if($fullname && $email && $userpasssword){
             jQuery('.first').addClass('complete');
             jQuery('.second').addClass('current');
             jQuery('.form-common').hide(); 
             jQuery('.step-form-two').show(); 
          }
    });
    jQuery(document).on("click",".nextbuttonsecond",function() {
            $postcode           = jQuery.trim(jQuery('.postcode').val());
            $housenumber        = jQuery.trim(jQuery('.house-number').val());
            $streetaddress      = jQuery.trim(jQuery('.street-address').val());
           jQuery('.postcode').next('span.error').remove();
           jQuery('.house-number').next('span.error').remove();
           jQuery('.street-address').next('span.error').remove();
            if($postcode == ''){
              jQuery('.postcode').after('<span class="error">This field is required </span>');
            }
            if($housenumber == ''){
              jQuery('.house-number').after('<span class="error">This field is required </span>');
            }
           if($streetaddress == ''){
              jQuery('.street-address').after('<span class="error">This field is required </span>');
            }

          if($postcode && $housenumber && $streetaddress){
             jQuery('.second').addClass('complete');
             jQuery('.third').addClass('current');
             jQuery('.form-common').hide(); 
             jQuery('.step-form-three').show();
          } 
    });
    jQuery(document).on("click",".nextbuttonthird",function() {
          $bedroomsvalue      = jQuery('.bedrooms-value.nav-link.active').html();
          $bathroomsvalue     = jQuery('.bathrooms-value.nav-link.active').html();
          if($bedroomsvalue == '4+' || $bathroomsvalue == '4+'){
              $firstname          = jQuery('.first-name').val();
              $emailaddress       = jQuery('.email-address').val();
              $userpasssword      = jQuery('.user-password').val();
              $postcode           = jQuery('.postcode').val();
              $housenumber        = jQuery('.house-number').val();
              $streetaddress      = jQuery('.street-address').val();
              $bedroomsvalue      = jQuery('.bedrooms-value.nav-link.active').html();
              $bathroomsvalue     = jQuery('.bathrooms-value.nav-link.active').html();
                $.ajax({
                url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
                method:'Post',
                data: {
                    'action': 'submit_join_process',
                    'firstname': $firstname ,
                    'emailaddress': $emailaddress ,
                    'userpasssword': $userpasssword ,
                    'postcode': $postcode ,
                    'housenumber': $housenumber, 
                    'streetaddress': $streetaddress, 
                    'bedroomsvalue': $bedroomsvalue, 
                    'bathroomsvalue': $bathroomsvalue, 
                },
                success:function(data) {
                  window.location.href = 'http://205.134.254.135/~projectdemoserve/homeservice/confirmations/';
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
              });  
           }else{ 
                $bedroomsvalue      = jQuery('.bedrooms-value.nav-link.active').html();
                $bathroomsvalue     = jQuery('.bathrooms-value.nav-link.active').html();
                  $.ajax({
                  url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
                  method:'Post',
                  data: {
                      'action': 'add_subscription_plan',
                      'bedroomsvalue': $bedroomsvalue, 
                      'bathroomsvalue': $bathroomsvalue, 
                  },
                  success:function(data) {
                      jQuery('.third').addClass('complete');
                      jQuery('.four').addClass('current');
                      jQuery('.form-common').hide(); 
                      jQuery('.step-form-four').html(data)
                      jQuery('.step-form-four').show();
                  },
                  error: function(errorThrown){
                      console.log(errorThrown);
                  }
               });
          }   
    });
    jQuery(document).on("click",".nextbuttonfour",function() {
           jQuery('.four').addClass('complete');
           jQuery('.five').addClass('current');
           jQuery('.form-common').hide(); 
           jQuery('.step-form-five').show(); 
    });

    //Next Button Five  code.
    jQuery(document).on("click",".nextbuttonfive",function() {
         $howltp = jQuery('.how-wltp:checked').data();
         $dataid = jQuery('.how-wltp:checked').data('id');
         if($dataid == 'yes'){
              jQuery('.five').addClass('complete');
              jQuery('.six').addClass('complete');
              jQuery('.seven').addClass('current');
              jQuery('.form-common').hide();
              jQuery('.step-form-seven').show(); 
         }else{
            jQuery('.five').addClass('complete');
            jQuery('.six').addClass('current');
            jQuery('.form-common').hide();
            jQuery('.step-form-six').show(); 
         }
    
    });

    // Next Button Six code.
    jQuery(document).on("click",".nextbuttonsix",function() {
          $whichday           = jQuery('.which-day').val();
          $whattime           = jQuery('.what-time').val();
          jQuery('.which-day').next('span.error').remove();
          jQuery('.what-time').next('span.error').remove();
          if($whichday == ''){
            jQuery('.which-day').after('<span class="error">The field is required. </span>');
          }
          if($whattime == ''){
            jQuery('.what-time').after('<span class="error">The field is required. </span>');
          }
          if($whichday && $whattime){
            jQuery('.five').addClass('complete');
            jQuery('.six').addClass('complete');
            jQuery('.seven').addClass('current');
            jQuery('.form-common').hide();
            jQuery('.step-form-seven').show();
          } 
      
    });
    
    //nextbuttonseven for payment
    jQuery(document).on("click",".nextbuttonseven",function() {
     
        var fullname        = jQuery('.full-name').children().val();
        var emailaddres     = jQuery('.email-input').val();
        jQuery('.stripe-firstname').val(fullname);
        jQuery('.stripe-email').val(emailaddres);
        
        $subscriptionplan   = jQuery('input.subscription-plan.active').val();
        $subscriptionptype  = jQuery('input.subscription-plan.active').data('ptype');
        $paymentmode        = jQuery('input.subscription-plan.active').data('payment');
        jQuery('.price-txt').html("£ "+$subscriptionplan+"/"+$subscriptionptype);
        jQuery('.subscr_plan_name').val('Home Clean Package');
        jQuery('.subscr_plan_amount').val($subscriptionplan);
        jQuery('.subscr_plan_type').val($subscriptionptype);
        jQuery('.subscr_paymentmode').val($paymentmode);

        jQuery('.step-eight').show();
        jQuery('.signup-final-process').hide();
        jQuery('.subscr_frq_name').val(jQuery('.plan-title.active').val());
        jQuery('.eight').addClass('complete');
        jQuery('.nine').addClass('current');
    });

  

    });

    if (jQuery(window).width() > 1024) {
      jQuery(window).scroll(function(){  
         if (jQuery(this).scrollTop() > 150) {
            jQuery('header').addClass("fixed-top");
            jQuery('body').css('padding-top', jQuery('.navbar').outerHeight() + 'px');
          }else{
            jQuery('header').removeClass("fixed-top");
            jQuery('body').css('padding-top', '0');
          }   
      });
    }

$(document).ready(function () {
    $('.navbar-toggler').click(function () {
        $('body').toggleClass('fixbody');
    })
    jQuery('.overlay').hide();
    new WOW().init();

});

var $radioButtons = $('input[type="radio"]');
$radioButtons.click(function() {
    $radioButtons.each(function() {
        $(this).parent().toggleClass('checked', this.checked);
    });
});
var swiper = new Swiper(".mySwiper", {
    autoplayDisableOnInteraction: false,
    slidesPerView: 2.7,
    spaceBetween: 35,
    loop: false,
    speed:2000,
     navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    scrollbar: {
     el: '.swiper-scrollbar',
      draggable: true,
    },
    autoplay: {
      enabled: false,
    },
    breakpoints: {
      320: {
        slidesPerView: 1.2,
        spaceBetween: 20,
      },
      621: {
        slidesPerView: 1.5,
      },
      768: {
        slidesPerView: 1.5,
        spaceBetween: 40,
      },
      992: {
        slidesPerView: 2.7,
      },
    }
  });

  jQuery(document).ready(function ($) {
    setTimeout(function(){    jQuery('.message-notifications').fadeOut(100);}, 3000);
    //Myaccount page payment switch Javascript code.
    jQuery(document).on("click",".payment-method-account",function() {
        var paymentmethod   = jQuery(this).val();
        if(paymentmethod == 'paypal'){
            jQuery('.stripe-form').hide();
            jQuery('.paypal-form').show();
        }else{
            jQuery('.stripe-form').show();
            jQuery('.paypal-form').hide();
          
        }
    });
    //myaccout page edit/save
    jQuery(document).on("click",".edit-button-profile",function() {
      var dataid = jQuery(this).data('id');
      if(dataid == 'home-descriptions'){
        jQuery('.homedesc-dropdown-text').show();  
      }
      if(dataid == 'home-subscriptions'){
        jQuery('.subscriptionptype-box').show();  
      }
      if(dataid == 'whereyouleavekey'){
        jQuery('.whereyouleavekey-box').show();  
      }
      jQuery(this).parent().prev().children('input').attr('type','text');
      jQuery(this).parent().prev().children('span').hide();
      jQuery(this).addClass('save-button-profile'); 
      jQuery(this).html("Save");    
      jQuery(this).removeClass('edit-button-profile');     
    });
  jQuery(document).on("click",".open-popup-code-tow",function() {

        postid = jQuery(this).data('id');
        $.ajax({
                url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
                method:'Post',
                data: {
                    'action'          : 'show_pament_form',
                    'postid'          : postid ,
                },
                success:function(data) {
                  jQuery('.popup-price-content').html(data);
                  jQuery('.open-popup-code').trigger('click');
                  setTimeout(function(){    jQuery('.subscr_plan_name').val(jQuery('.addon-name').val());
                  jQuery('.subscr_plan_amount').val(jQuery('.per-month-price').val());
                  jQuery('.subscr_frq_name').val(jQuery('.change-frequency').val()); }, 3000);
                  var paymentname   = jQuery('.addon-name').val();
                  var permonthprice = jQuery('.per-month-price').val();
                  $.ajax({
                  url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
                  method:'Post',
                  data: {
                  'action'          : 'show_paypal_informations',
                  'postid'          : postid ,
                  'frequencymethod' : 2,
                  'paymentname'     : paymentname,
                  },
                  success:function(data) {
                    jQuery('.demo-button').html(data);
                  },
                  error: function(errorThrown){
                  console.log(errorThrown);
                  }
                 });
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
              });
    });

  // Caccel Payment
jQuery(document).on("click",".open-popup-code-payment",function() {
     postid = jQuery(this).data('id');
     jQuery('.payment-value-id').val(postid);
     var title = jQuery(this).parent().parent().children().eq(0).html()
     jQuery('.title-cancel').html('<h2>'+title+'</h2>');
     jQuery('.cancel-payment-button').next('span.error').remove();

});
jQuery(document).on("click",".cancel-payment-button",function() {
    postid = jQuery('.payment-value-id').val();
     $.ajax({
              url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
              method:'Post',
              data: {
                  'action'          : 'cancel_paypment',
                  'postid'          : postid ,
              },
              success:function(data) {
               // jQuery('.popup-price-content').html(data);
                jQuery('.cancel-payment-button').after('<span class="error">'+ data +'</span>');
                setTimeout(function(){ window.location.reload() }, 3000);
              },
              error: function(errorThrown){
                  console.log(errorThrown);
              }
            });
});
//Change Frquency code coming here.
   jQuery(document).on("change",".change-frequency",function() {
        var postid            = jQuery(this).data('id');
        var frequencymethod   = jQuery(this).val();

        $.ajax({
                url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
                method:'Post',
                data: {
                    'action'          : 'show_pament_form',
                    'postid'          : postid ,
                    'frequencymethod' : frequencymethod
                },
                success:function(data) {
                  jQuery('.popup-price-content').html(data);
                  //jQuery('.open-popup-code').trigger('click');
                   setTimeout(function(){    jQuery('.subscr_plan_name').val(jQuery('.addon-name').val());
                  jQuery('.subscr_plan_amount').val(jQuery('.per-month-price').val());
                  jQuery('.subscr_frq_name').val(jQuery('.frequencymethod').val()); }, 3000);
                  var paymentname   = jQuery('.addon-name').val();
                  var permonthprice = jQuery('.per-month-price').val();
                  $.ajax({
                  url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
                  method:'Post',
                  data: {
                  'action'          : 'show_paypal_informations',
                  'postid'          : postid ,
                  'frequencymethod' : frequencymethod,
                  'paymentname'     : paymentname,
                  },
                  success:function(data) {
                    jQuery('.demo-button').html(data);
                  },
                  error: function(errorThrown){
                  console.log(errorThrown);
                  }

                });

                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
              });
   });
    //Update Myaccount page
    jQuery(document).on("click",".save-button-profile",function() {
    

      var whereyouleave       = jQuery('.whereyou-leavekey').val();
      var fullname            = jQuery('.full-name-input').val();
      var email               = jQuery('.email-input').val();
      var streetaddress       = jQuery('.Street-address').val();
      var homedescriptions    = jQuery('.homedesc-input').val();
      var subscription        = jQuery('.subscriptionp-type').val();
      var howltp              = jQuery('.howltp').val();
      var whereyouleavek      = jQuery('.whereyouleave-key').val();
      var bathroomsvalue      = jQuery('.homedesc-dropdown-input').val();
      var bedroomsvalue       = jQuery('.homedesc-dropdown-input-two').val();
      var subscriptionptype   = jQuery('.subscriptionp-type').val();
    
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;    
        if(!regex.test(email)){ 
           jQuery(this).addClass('error'); 
           alert("Please Enter Valid Email address");
           return false;  
        }
      jQuery(this).parent().prev().children('input').attr('type','hidden');
      jQuery(this).parent().prev().children('span').show();
      var value = jQuery(this).parent().prev().children('input').val();
      jQuery(this).parent().prev().children('span').html(value);
      jQuery(this).addClass('edit-button-profile'); 
      jQuery(this).html("Change");    
      jQuery(this).removeClass('save-button-profile');  
      var dataid = jQuery(this).data('id');
      if(dataid == 'home-descriptions'){
        jQuery('.homedesc-dropdown-text').hide();  
        value = bathroomsvalue+' Bedrooms, '+ bedroomsvalue+' Bathrooms';
        jQuery(this).parent().prev().children('span').html(value);
      }

      if(dataid == 'home-subscriptions'){
        jQuery('.subscriptionptype-box').hide();  
        jQuery(this).parent().prev().children('span').html(subscriptionptype);
      }

      if(dataid == 'whereyouleavekey'){
        jQuery('.whereyouleavekey-box').hide();  
        jQuery(this).parent().prev().children('span').html(whereyouleavek);
      }
       $.ajax({
                url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
                method:'Post',
                data: {
                    'action'          : 'update_user_profile',
                    'fullname'        : fullname ,
                    'email'           : email ,
                    'address'         : streetaddress ,
                    'homedescriptions': homedescriptions,
                    'subscription'    : subscription ,
                    'howltp'          : howltp ,
                    'whereyouleavek'  : whereyouleavek ,
                    'bathroomsvalue'  : bathroomsvalue ,
                    'bedroomsvalue'   : bedroomsvalue ,
                    'subscriptionptype'  : subscriptionptype ,
                },
                success:function(data) {
                  console.log('value updated');
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
              });  
   });

    //Joining page edit/save
    jQuery(document).on("click",".edit-button",function() {
      jQuery(this).parent().prev().children('input').attr('type','text');
      jQuery(this).parent().prev().children('span').hide();
      jQuery(this).addClass('save-button'); 
      jQuery(this).html("Save");    
      jQuery(this).removeClass('edit-button');     
    });

   jQuery(document).on("click",".save-button",function() {
      jQuery(this).parent().prev().children('input').attr('type','hidden');
      jQuery(this).parent().prev().children('span').show();
      var value = jQuery(this).parent().prev().children('input').val();
      jQuery(this).parent().prev().children('span').html(value);
      jQuery(this).addClass('edit-button'); 
      jQuery(this).html("Edit");    
      jQuery(this).removeClass('save-button');   
      var whereyouleave   = jQuery('.whereyou-leavekey').val();
      var fullname        = jQuery('.full-name-input').val();
      var email           = jQuery('.email-input').val();
      var streetaddress   = jQuery('.Street-address').val();
      var homedescriptions= jQuery('.homedesc-input').val();
      var subscription    = jQuery('.subscriptionp-type').val();
      var howltp          = jQuery('.howltp').val();
      var whereyouleavek  = jQuery('.whereyou-leavekey').val();
      $.ajax({
                url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
                method:'Post',
                data: {
                    'action'          : 'update_user_filed',
                    'fullname'        : fullname ,
                    'email'           : email ,
                    'address'         : streetaddress ,
                    'homedescriptions': homedescriptions,
                    'subscription'   : subscription ,
                    'howltp'          : howltp ,
                    'whereyouleavek'  : whereyouleavek ,
                },
                success:function(data) {
                  console.log('value updated');
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
      });  
   });

    //Payment checkbox change button js code.
    jQuery(document).on("click",".payment-method",function() {
        var paymentmethod   = jQuery(this).val();
        if(paymentmethod == 'paypal'){
            $subscriptionplan   = jQuery('input.subscription-plan.active').val();
            $subscriptionptype  = jQuery('input.subscription-plan.active').data('ptype');
            $paymentmode        = jQuery('input.subscription-plan.active').data('payment');
            $planfretitle       = jQuery('.subscription-plan-inner.selected').children().children('.plan-title').val();
            $email              = jQuery.trim(jQuery('.email-address').val());
           
            $.ajax({
                url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
                method:'Post',
                data: {
                    'action': 'show_payment_informations',
                    'subscriptionplan': $subscriptionplan ,
                    'subscriptionptype': $subscriptionptype ,
                    'planfretitle': $planfretitle,
                    'paymentmode': $paymentmode,
                    'email': $email ,
                },
                success:function(data) {
                    console.log(data);
                    jQuery('.demo-button').html(data);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
              });
            jQuery('.stripe-form').hide();
            jQuery('.paypal-form').show();
        
        }else{
            jQuery('.stripe-form').show();
            jQuery('.subscr_frq_name').val(jQuery('.plan-title.active').val());
            jQuery('.paypal-form').hide();
          
        }
    });
    jQuery(document).on("click","#payBtnpayment",function() {
            jQuery('.demo-button').children().children().last().click();
    });
    // Prvious page Jquery code 
    jQuery(document).on("click",".prevfirst",function() {
           jQuery('.first').addClass('current');
           jQuery('.first').removeClass('complete');
           jQuery('.second').removeClass('complete');
           jQuery('.second').removeClass('current');
           jQuery('.form-common').hide(); 
           jQuery('.step-form-one').show(); 
    });

    jQuery(document).on("click",".prevsecond",function() {
           jQuery('.second').addClass('current');
           jQuery('.second').removeClass('complete');
           jQuery('.third').removeClass('complete');
           jQuery('.third').removeClass('current');
           jQuery('.form-common').hide(); 
           jQuery('.step-form-two').show(); 
    });
    jQuery(document).on("click",".prevthird",function() {
           jQuery('.third').addClass('current');
           jQuery('.third').removeClass('complete');
           jQuery('.four').removeClass('complete');
           jQuery('.four').removeClass('current');
           jQuery('.form-common').hide();  
           jQuery('.step-form-three').show(); 
    });
    jQuery(document).on("click",".prevfour",function() {
           jQuery('.four').addClass('current');
           jQuery('.four').removeClass('complete');
           jQuery('.five').removeClass('complete');
           jQuery('.five').removeClass('current');
           jQuery('.form-common').hide();  
           jQuery('.step-form-four').show(); 
    }); 
    jQuery(document).on("click",".prevfive",function() {
           jQuery('.five').addClass('current');
           jQuery('.five').removeClass('complete');
           jQuery('.six').removeClass('complete');
           jQuery('.six').removeClass('current');
           jQuery('.form-common').hide();  
           jQuery('.step-form-five').show(); 
    }); 
    jQuery(document).on("click",".prevsix",function() {
           $howltp = jQuery('.how-wltp:checked').data();
           $dataid = jQuery('.how-wltp:checked').data('id');
           if($dataid == 'yes'){
             jQuery('.five').addClass('current');
             jQuery('.five').removeClass('complete');
             jQuery('.six').removeClass('complete');
             jQuery('.seven').removeClass('current');
             jQuery('.form-common').hide();  
             jQuery('.step-form-five').show();
           }else{
              jQuery('.six').addClass('current');
              jQuery('.six').removeClass('complete');
              jQuery('.seven').removeClass('complete');
              jQuery('.seven').removeClass('current');
              jQuery('.form-common').hide();  
              jQuery('.step-form-six').show(); 
           }
          
    }); 
    jQuery(document).on("click",".plan-select",function() {
         jQuery('.subscription-plan-inner').removeClass('selected');
         jQuery('.plan-select').removeClass('next');
         jQuery('.subscription-plan').removeClass('active');
         jQuery('.plan-title').removeClass('active');
         jQuery('.plan-select').addClass('back');
         jQuery('.plan-select').html("Select");         
         jQuery(this).html("Selected");
         jQuery(this).addClass('next');
         jQuery(this).removeClass('back');
         jQuery('.subscription-plan-inner').removeClass('selected');
         jQuery(this).parent().parent().parent().addClass('selected');
         jQuery(this).parent().parent().children('input').addClass('active');
    }); 
    jQuery(document).on("click",".when-we-are",function() {
        jQuery('.when-we-are').removeClass('active');
        var whware          = jQuery(this).text();
        $fullname           = jQuery('.first-name').val();
        $email              = jQuery('.email-address').val();
        $userpasssword      = jQuery('.user-password').val();
        $postcode           = jQuery('.postcode').val();
       if(whware  == 'Yes'){
         jQuery('.postcode-popup').hide();
          $.ajax({
          url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
          method:'Post',
          data: {
            'action': 'add_postcode',
            'fullname':    $fullname ,
            'emailaddress': $email ,
            'password': $userpasssword ,
            'postcode': $postcode ,
          },
          success:function(data) {
            window.location.href = 'http://205.134.254.135/~projectdemoserve/homeservice/confirmations/';
          },
          error: function(errorThrown){
            console.log(errorThrown);
          }
          });
       }else{
         jQuery('.postcode-popup').hide();
         window.location.href = 'http://205.134.254.135/~projectdemoserve/homeservice/';
       }
       jQuery(this).addClass('active');
     });
    jQuery(document).on("change",".postcode",function() {
       $postcode           = jQuery('.postcode').val();
          $.ajax({
          url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
          method:'Post',
          data: {
            'action': 'check_postcode',
            'postcode': $postcode ,
          },
          success:function(data) {
          jQuery('.nextbuttonsecond').removeAttr('disabled');
          jQuery('.postcode-popup').hide();
          if(data == 'no'){
              jQuery('.postcode-popup').show();
              jQuery('.nextbuttonsecond').attr('disabled','disabled');
           }
          },
          error: function(errorThrown){
            console.log(errorThrown);
          }
          });
     }); 

     //Email Validations JS 
    jQuery(document).on("change",".email-address",function() {
        var inputvalues = $(this).val();  
        jQuery('.nextbuttonfirst').removeAttr('disabled')
        jQuery('.email-address').next('span.error').remove();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;    
        if(!regex.test(inputvalues)){ 
           jQuery(this).addClass('error'); 
           jQuery('.email-address').after('<span class="error email-error">Please enter valid email address </span>');
           jQuery('.nextbuttonfirst').attr('disabled','disabled')
          return regex.test(inputvalues);  
        }else{
            jQuery('.nextbuttonfirst').removeAttr('disabled')
            jQuery('.email-address').next('span.error').remove();
               $.ajax({
                url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
                method:'Post',
                data: {
                    'action': 'check_email_address',
                    'emailaddress': inputvalues ,
                },
                success:function(data) {
                  if(data == '1'){
                      jQuery('.email-address').after('<span class="error email-error">This email address already exist </span>');
                      jQuery('.nextbuttonfirst').attr('disabled','disabled')
                  }
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
             });
          }
     }); 

    // Submit Seven steps using ajax.
      jQuery(document).on("click",".final-submit",function() {
              $firstname          = jQuery('.first-name').val();
              $emailaddress       = jQuery('.email-address').val();
              $userpasssword      = jQuery('.user-password').val();
              $postcode           = jQuery('.postcode').val();
              $housenumber        = jQuery('.house-number').val();
              $streetaddress      = jQuery('.street-address').val();
              $bedroomsvalue      = jQuery('.bedrooms-value.nav-link.active').html();
              $bathroomsvalue     = jQuery('.bathrooms-value.nav-link.active').html();
              $subscriptionplan   = jQuery('input.subscription-plan.active').val();
              $subscriptionptype  = jQuery('.plan-title.active').val();
              $paymentmode        = jQuery('input.subscription-plan.active').data('payment');
              $subscriptionplan   = jQuery('input.subscription-plan.active').val();
              $howltp             = jQuery('.how-wltp:checked').val();
              $whichday           = jQuery('.which-day').val();
              $whattime           = jQuery('.what-time').val();
              $whereyouleavekey   = jQuery('.how-to-access-home:checked').val();
              $.ajax({
              url: slik_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
              method:'Post',
              data: {
                  'action': 'submit_join_process',
                  'firstname': $firstname ,
                  'emailaddress': $emailaddress ,
                  'userpasssword': $userpasssword ,
                  'postcode': $postcode ,
                  'housenumber': $housenumber, 
                  'streetaddress': $streetaddress, 
                  'bedroomsvalue': $bedroomsvalue, 
                  'bathroomsvalue': $bathroomsvalue, 
                  'subscriptionplan': $subscriptionplan, 
                  'subscriptionptype': $subscriptionptype, 
                  'paymentmode': $paymentmode, 
                  'howltp'          : $howltp, 
                  'whichday'          : $whichday, 
                  'whattime'          : $whattime, 
                  'whereyouleavekey': $whereyouleavekey, 
              },
              success:function(data) {
                jQuery('.seven').addClass('complete');
                jQuery('.eight').addClass('complete');
                jQuery('.form-common').hide();  
                jQuery('.signup-final-process').hide(); 
                jQuery('.signup-final-process').html(data);

                var fullname        = jQuery('.full-name').children().val();
                var emailaddres     = jQuery('.email-input').val();

                jQuery('.stripe-firstname').val(fullname);
                jQuery('.stripe-email').val(emailaddres);

                $subscriptionplan   = jQuery('input.subscription-plan.active').val();
                $subscriptionptype  = jQuery('input.subscription-plan.active').data('ptype');
                $paymentmode        = jQuery('input.subscription-plan.active').data('payment');

                jQuery('.price-txt').html("£ "+$subscriptionplan+"/"+$subscriptionptype);
                jQuery('.subscr_plan_amount').val($subscriptionplan);
                jQuery('.subscr_plan_type').val($subscriptionptype);
                jQuery('.subscr_paymentmode').val($paymentmode);
                jQuery('.step-eight').show();
                jQuery('.subscr_plan_name').val('Home Clean Package');
                jQuery('.subscr_frq_name').val(jQuery('.plan-title.active').val());
                jQuery('.signup-final-process').hide();
                jQuery('.eight').addClass('complete');
                jQuery('.nine').addClass('current');
              },
              error: function(errorThrown){
                  console.log(errorThrown);
              }
          }); 
        }); 


    });


    // set header and footer at minimum height
    function MinHeight(){
      var Header_height = jQuery('header').innerHeight();
      var Footer_Height = jQuery('footer').innerHeight();
      var Total_Height = jQuery(window).height() - (Header_height + Footer_Height);
      
      jQuery('#site-content').css("min-height",Total_Height);
    }
    
    jQuery(document).ready(function(){
      MinHeight();
    });
    jQuery(window).on('load',function(){
      MinHeight();
    });
    jQuery(window).resize(function(){
      MinHeight();
    });
