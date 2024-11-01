<?php

/**
 * Events view
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Strobe
 * @subpackage Strobe/public/partials
 */

$gal_id = uniqid("gallery-");

?>

<div class="strobe-events-container">
	<?php foreach ($sales as $sale) : ?>
		<div class="strobe-event-wrapper">
			<div class="strobe-event-image">
				<a class="venobox" href="<?= '#' . $gal_id . '-' . $sale->id?>" title="<?=$sale->name?>" data-gall="<?=$gal_id?>" data-vbtype="inline" data-css="strobe-overlay">
					<img src="<?=$sale->images->banner?>" alt="<?=$sale->name?>"/>
				</a>
			</div>
			<div class="strobe-event-details">
				<h3 class="strobe-event-name">
				<a href="<?= "https://" . $org->ticketing_domain . "/details/" . $sale->id ?>" target="_blank">
					<?=$sale->name?>
				</a>
				</h3>
				<p><?=date($attrs['time_format'], $sale->event->date)?></p>
				<div class="strobe-event-venue">
					<p>
						<?php if(!empty($sale->event->facebook->event)) :?>
							<a href="<?= $sale->event->facebook->event->link ?>" target="_blank">
								<b><?= $sale->event->facebook->event->name ?></b>
							</a>
						<?php else: ?>
							<b><?=$sale->event->venue->name?></b>
						<?php endif; ?>
						<br/>
						<?= $sale->event->venue->location->address->street ?>
						<br/>
						<?= $sale->event->venue->location->address->city . ", " . $sale->event->venue->location->address->state . " " . $sale->event->venue->location->address->zip?>
						<a href="<?= "https://maps.google.com?saddr=Current+Location&daddr=" . $sale->event->venue->location->point->coordinates[1] . "," . $sale->event->venue->location->point->coordinates[0] ?>" target="_blank">
							Map
						</a>
					</p>
				</div>
				<p class="strobe-event-description"><?=$sale->description?></p>
				<?php if(!empty($sale->event->facebook->event)) :?>
					<br/>
					<p><?=$sale->event->facebook->event->interested . " interested  · " . $sale->event->facebook->event->attending . " going"?></p>
				<?php endif; ?>
			</div>
			<div class="strobe-event-links">
				<a href="<?= "https://" . $org->ticketing_domain . "/details/" . $sale->id ?>" target="_blank">
					Buy Tickets
				</a>
				<?php if(!empty($sale->event->facebook->event)) :?>
					<a href="<?=$sale->event->facebook->event->link?>" target="_blank">
						View on Facebook
					</a>
				<?php endif; ?>
			</div>
			<div id="<?=$gal_id . '-' . $sale->id?>" style="display:none">
				<img src="<?=$sale->images->banner?>" alt="<?=$sale->name?>" class="figlio"/>
				<div class="strobe-events-overlay-data-container">
					<span class="strobe-event-time"><?=date($attrs['time_format'], $sale->event->date)?></span>
					<?php if(!empty($sale->event->facebook->event)) :?>
						<a class="strobe-link" href="<?=$sale->event->facebook->event->link?>" target="_blank">
							View on Facebook
						</a>
					<?php endif; ?>
					<a class="strobe-overlay-close"></a>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
