<?php
require_once('init.php');
require_once('config.php');
 
if ($_POST) {
  \Stripe\Stripe::setApiKey($STRIPE_SECRET_KEY);
  $error = '';
  $success = '';
  try {
    if (!isset($_POST['stripe_token']))
      throw new Exception("The Stripe Token was not generated correctly");
    
    \Stripe\Charge::create(array("amount" => $_POST['amount'],
                                "currency" => "usd",
                                "card" => $_POST['stripe_token'],
                                "description" => "Shea Silverman Campaign Donation",
                                "metadata" => array("occupation" => $_POST['occupation'], "employer" => $_POST['employer']),
                               ));
    $success = '<div class="alert alert-success">
                <strong>Success!</strong> Your payment was successful.
                </div>';
  }
  catch (Exception $e) {
    $error = '<div class="alert alert-danger">
              <strong>Error!</strong> '.$e->getMessage().'
              </div>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Donate | Shea Silverman for Florida House of Representatives District 49</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
 		<header>
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                
                    <div class="navbar-header">
                        <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="fa fa-bars"></span>
                        </button>
                        <a class="navbar-brand" href="#"><?php echo $header; ?></a>
                    </div>

                </div>
            </div>
        </header>

		<h2 class="text-left">Donate</h2>
		<div class="row">
		  <div class="col-md-6">
				<div class="well">
					<div class="row text-center">
					  <div class="col-md-4"><button type="button" onclick="setDonation('1.00');" class="btn btn-primary btn-lg">1.00</button></div>
					  <div class="col-md-4"><button type="button" onclick="setDonation('5.00');" class="btn btn-primary btn-lg">5.00</button></div>
					  <div class="col-md-4"><button type="button" onclick="setDonation('10.00');" class="btn btn-primary btn-lg">10.00</button></div>
					</div>
					<p>&nbsp;</p>
					<div class="row text-center">
					  <div class="col-md-4"><button type="button" onclick="setDonation('25.00');" class="btn btn-primary btn-lg">25.00</button></div>
					  <div class="col-md-4"><button type="button" onclick="setDonation('50.00');" class="btn btn-primary btn-lg">50.00</button></div>
					  <div class="col-md-4"><button type="button" onclick="setDonation('100.00');" class="btn btn-primary btn-lg">100.00</button></div>
					</div>

					<p>&nbsp;</p>
					<div class="row">
						<div class="col-md-6">
							<div class="input-group input-group-lg">
							  <p><small>Occupation</small></p>
							  <input type="text" id="occupation" placeholder="Occupation" class="form-control" aria-label="Occupation">
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group input-group-lg">
							  <p><small>Employer</small></p>
							  <input type="text" id="employer" placeholder="Employer" class="form-control" aria-label="Employer" >
							</div>
						</div>
					</div>


					<p>&nbsp;</p>
					<p class="lead">Other Amount:</p>
					<div class="row">
						<div class="col-md-6">
							<div class="input-group input-group-lg">
							  <span class="input-group-addon">$</span>
							  <input type="number" min="1.00" max="2500.00"  id="other_amount" name="other_amount" class="form-control" aria-label="Amount (to the nearest dollar)">
							  <!-- <span class="input-group-addon">.00</span> -->
							</div>
						</div>
						<div class="col-md-6">
							<button type="button" class="btn btn-primary btn-lg" id="donateButton" disabled>Donate</button>
						</div>
					</div>
				</div>
		  </div>
		  <div class="col-md-6">
		  	<div class="well">
		  		<p class="lead">Send checks to:</p>
		  		<p>
		  		<address>
		  			<strong>Shea Silverman</strong><br />
		  			3412 Rider Place<br />
		  			Orlando, FL 32817<br />
		  		</address>

			</div>
		  </div>
		</div>
		<?php echo $success; echo $error; ?>
		<hr />
		<div style="padding: 5px; text-align: center; border: solid 1px black">
			<?php echo $footer; ?>
		</div>

	</div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <script src="https://checkout.stripe.com/checkout.js"></script>
	<script>
				
				$('#occupation, #employer', '#other_amount').on("keyup", action);

				$("body").on('keyup', "#occupation", action);
				$("body").on('keyup', "#employer", action); 
				$("body").on('keyup', "#other_amount", action);     

				$('#other_amount').on("change", action);

				function action() {
					console.log("Running");
				    if( $('#occupation').val().length > 0 && $('#employer').val().length > 0 && $('#other_amount').val() != '' ) {
				        $('#donateButton').prop("disabled", false);
				    } else {
				        $('#donateButton').prop("disabled", true);
				    }   
				}

				var handler = StripeCheckout.configure({
					key: '<?php echo $STRIPE_PUBLIC_KEY; ?>',
					//image: '/img/documentation/checkout/marketplace.png',
					locale: 'auto',
					token: function(token) {
						// Use the token to create the charge with a server-side script.
						// You can access the token ID with `token.id`
						
						var newForm = jQuery('<form>', {
					        'action': '#',
					        'target': '_top',
					        'method': 'POST',
					    }).append(jQuery('<input>', {
					        'name': 'stripe_token',
					        'value': token.id,
					        'type': 'hidden'
					    })).append(jQuery('<input>', {
					        'name': 'occupation',
					        'value': $('#occupation').val(),
					        'type': 'hidden'
					    })).append(jQuery('<input>', {
					        'name': 'employer',
					        'value': $('#employer').val(),
					        'type': 'hidden'
					    })).append(jQuery('<input>', {
					        'name': 'csrfmiddlewaretoken',
					        'value': getCookie('csrftoken'),
					        'type': 'hidden'
					    })).append(jQuery('<input>', {
					        'name': 'amount',
					        'value': $('#other_amount').val() * 100,
					        'type': 'hidden'
					    }));

					    newForm.submit();
					
					}
				});

				$('#donateButton').on('click', function(e) {
					// Open Checkout with further options
					var amount = $("#other_amount").val();
					amount = amount * 100;
					handler.open({
					  name: 'Shea Silverman',
					  description: 'Campaign Donation',
					  amount: amount,
					  billingAddress: true,
					  
					});
					e.preventDefault();
				});


				var setDonation = function(amount) {
					$("#other_amount").val(amount);
					action();
				}

				// Close Checkout on page navigation
				$(window).on('popstate', function() {
					handler.close();
				});


				function getCookie(name) {
				    var cookieValue = null;
				    if (document.cookie && document.cookie != '') {
				        var cookies = document.cookie.split(';');
				        for (var i = 0; i < cookies.length; i++) {
				            var cookie = jQuery.trim(cookies[i]);
				            // Does this cookie string begin with the name we want?
				            if (cookie.substring(0, name.length + 1) == (name + '=')) {
				                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
				                break;
				            }
				        }
				    }
				    return cookieValue;
				}

	</script>
  </body>
</html>







