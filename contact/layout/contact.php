<?php 
/**
 *  Contact layout
 *
 *  @package: Bludit
 *  @subpackage: Contact
 *  @author: Frédéric K.
 *  @copyright: 2015-2016 Frédéric K.
 *  @info: Duplicate this layout in your themes/YOUR_THEME/php/ 
 *	for a custom template.
 */		
?>
<form method="post" action="<?php echo $Site->url(). $Page->slug(); ?>" class="contact pure-form">
		<fieldset class="pure-group">
			<input type="hidden" name="token" value="<?php echo $Security->printTokenCSRF(); ?>">
			<input id="name" type="text" name="name" value="<?php echo sanitize::html($name); ?>" placeholder="<?php echo $Language->get('Name'); ?>" class="pure-input-1-2">
			<input id="email" type="email" name="email" value="<?php echo sanitize::email($email); ?>" placeholder="<?php echo $Language->get('Email'); ?>" class="pure-input-1-2">
			<textarea id="message" rows="6" name="message" placeholder="<?php echo $Language->get('Message'); ?>" class="pure-input-1-2"><?php echo sanitize::html($message); ?></textarea>
		</fieldset>
		<input type="checkbox" name="interested">
		<button id="submit" name="submit" type="submit" class="pure-button pure-button-primary"><?php echo $Language->get('Send'); ?></button>
</form>