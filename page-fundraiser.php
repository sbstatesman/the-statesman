<?php
/*
Template Name: fundraiser
*/

$donationsComputers = 100;

?>

<?php get_header();?>
<main class="row">

	<main class="main vline-medium">
		<header class="row">
			<p class="headline"><?php the_title(); ?></p>
		</header>
		<div class="hline hline-medium"></div>
		<div class="articletext large-text">
			<p>The Statesman is a student-run newspaper serving Stony Brook University. 
			The Statesman Association is a non-profit organization and 
			is funded by both advertising and the Stony Brook University Undergraduate Student Government.</p>
			<p>New stories are published online Monday through Friday. 
			A print issue is published every Monday during the academic year and is distributed to on-campus locations, 
			the Stony Brook University Hospital and more than 70 off-campus locations.</p>
			<p>The Statesman and its editors have been recognized for their work by the Society for Professional Journalists, Newsday, 
			the Martin Buskin Committee for Campus Journalism and the Society for News Design, among other organizations. 
			Many of its editors have gone on to enjoy distinguished careers in journalism.</p>
		</div>
		<div class="hline hline-medium"></div>
		<article class="hmedia hmedia-list">
			<h1>Computers</h1>				
			<div class="articletext large-text">
				<p>All of our current computers have existed since 1995, and are prone to natural disasters. They will always shut down or show a blank screen, and all our keyboards are known to stop working. We need these computers to create fancy paper. When our staff has to try and bring a nonexistant computer back to life they lose valuable time that should be spent watching cat videos on YouTube. New computers would allow us to save time and work with unprecedented technology. We would like to raise $9 to buy thirty MacBook Airs.</p>
			</div>
			<div class="row">
				<h3>Goal: $100</h3>	
				<div class="progressbarcontainer">
			    <div class="thermometer thermometer-config" data-percent="<?php echo($donationsComputers+"");?>"></div>
			  </div>
		  </div>
			<div class="row">
			  <!-- Secure method to pay with PayPal 
			  		https://www.paypal.com/webapps/mpp/get-started/donate-button -->
				<form class="inline-form" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
					<button class="button metatext">Buy 1 Computer: $100</button>
				</form>		
				<form class="inline-form" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
					<button class="button metatext">Donate custom amount</button>	
				</form>
			</div>
		</article>
		<div class="hline hline-medium"></div>
	</main>

	<article class="sidebar">
		<div class="thermometeroutercontainer">
				<div class="hline"></div>	  
				<div class="goal">
					Goal: $999
				</div>	
				<div class="thermometercontainer">
					<img src="<?php bloginfo(template_url); ?>/images/thermometer-percent.png">
			    	<div class="thermometer thermometer-config" data-percent="<?php echo($donationsTotal);?>" data-orientation="vertical"></div>
			    </div>  
			    Amount received: $<?php echo("$"+999);?>
		</div>
	</article>

</main>
<div class="hline hline-medium"></div>
<script src="<?php bloginfo(template_url); ?>/js/jquery.thermometer.js"></script>
<script>
  (function($) {
    $(function() {      
      /* thermometers with no config */
      $('.thermometer-noconfig').thermometer();
      
      /* thermometers with config */
      $('.thermometer-config').thermometer({
        percent: 0, 
        speed: 'slow'
      })
    });
  })(jQuery);
</script>

<?php get_footer(); ?>