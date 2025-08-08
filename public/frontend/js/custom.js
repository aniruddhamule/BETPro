(function($) {
  'use strict';
    $(function() {
      
      $('[data-countdown]').each(function() {
          var $this = $(this), finalDate = $(this).data('countdown');
          $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('%D days %H:%M:%S'));
          });
      });

      $(".file-input").change(function () {
        var curElement = $(this).parent().parent().find(".image");
        console.log(curElement);
        var reader = new FileReader();

        reader.onload = function (e) {
          // get loaded data and render thumbnail.
          curElement.attr("src", e.target.result);
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
      });

      $(document).on('click', '.myrefButtonFunction', function() {
        var copyText = document.getElementById("myInputref");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Copied referral link : " + copyText.value);
      });

      //Goauth
      $('.copytext').on('click',function(){
        var copyText = document.getElementById("referralURL");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
    });

    //Stripe
    $('.hide').css('display','none');
      var $form         = $(".strip-validation");
      $('form.strip-validation').bind('submit', function(e) {
          var $form         = $(".strip-validation"),
              inputSelector = ['input[type=email]', 'input[type=password]',
                  'input[type=text]', 'input[type=file]',
                  'textarea'].join(', '),
              $inputs       = $form.find('.required').find(inputSelector),
              $errorMessage = $form.find('div.error'),
              valid         = true;
          $errorMessage.addClass('hide');
          $('.has-error').removeClass('has-error');
          $inputs.each(function(i, el) {
              var $input = $(el);
              if ($input.val() === '') {
                  $input.parent().addClass('has-error');
                  $errorMessage.removeClass('hide');
                  e.preventDefault();
              }
          });
          if (!$form.data('cc-on-file')) {
              e.preventDefault();
              Stripe.setPublishableKey($form.data('stripe-publishable-key'));
              Stripe.createToken({
                  number: $('.card-number').val(),
                  cvc: $('.card-cvc').val(),
                  exp_month: $('.card-expiry-month').val(),
                  exp_year: $('.card-expiry-year').val()
              }, stripeResponseHandler);
          }
      });
      function stripeResponseHandler(status, response) {
          if (response.error) {
              $('.error')
                  .removeClass('hide')
                  .find('.alert')
                  .text(response.error.message);
          } else {
              // token contains id, last4, and card type
              var token = response['id'];
              // insert the token into the form so it gets submitted to the server
              $form.find('input[type=text]').empty();
              $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
              $form.get(0).submit();
          }
      }

      //All predict, Details match page
      $(document).ready(function () {
        $(document).on('click', '.bet_button', function () {
            var id = $(this).data('id');
            var minamo = $(this).data('minamo');
            var macthid = $(this).data('macthid');
            var ratioone = $(this).data('ratioone');
            var ratiotwo = $(this).data('ratiotwo');
            var questionid = $(this).data('questionid');
            var betlimit = $(this).data('betlimit');

            console.log(betlimit);

            $('#betoption_id').val(id);
            $("#match_id").val(macthid);
            $("#ratioOne").val(ratioone);
            $("#ratioTwo").val(ratiotwo);
            $("#questionid").val(questionid);

            $(".get_amount_for_ratio").val(minamo);
            $('.minamo').text(minamo);
            $('.betlimit').text(betlimit);
            $('.ctrl_counter-input').attr('value', minamo)
            $('.ctrl_counter-input').attr('min', minamo)
            $('.ctrl_counter-num').text(minamo)
            $('.ctrl_counter-input').attr('max', betlimit)
            
            var amount = $('.get_amount_for_ratio').val();
            var ratio1 = $('.ratio1').val();
            var ratio2 = $('.ratio2').val();
            var finalRation = parseFloat((amount * ratio2) / ratio1).toFixed(2);
            $('.subro_ratio').val(finalRation);
        });

        $('.get_amount_for_ratio').on('keyup',function () {
          var amt = this.value;
          var ratio1 = $('.ratio1').val();
          var ratio2 = $('.ratio2').val();

          if (($.isNumeric(amt)) && (parseFloat(amt) > 0)){
              var total = parseFloat((amt * ratio2) / ratio1).toFixed(2);
              msg(''+parseFloat(total)+'');
          } else {
              msg('0');
          }

      });
      function msg(msg) {
          $('.wining-rate').text(msg);
      }
    });


    

  });
})(jQuery);

var leftArrowbtbj = '<i class="fa fa-angle-left"></i>';
var rightArrowbtbj = '<i class="fa fa-angle-right"></i>';
/******** slider-services *******/
$('.btbj-category-slider').owlCarousel({
    loop: true,
    nav: false,
    dots: false,
    smartSpeed: 2000,
    autoplay: false,
    center: true,
    items: 1,
    animateOut: 'slideOutDown',
    animateIn: 'flipInX',
    navText: [leftArrowbtbj,rightArrowbtbj],
});
