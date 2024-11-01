<?php

/**
 * Error view
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Strobe
 * @subpackage Strobe/public/partials
 */

?>

<div class="strobe-error-container">
	<?=$error->getMessage()?>&nbsp;
	<b><?="#".$error->getCode()?></b>
</div>
