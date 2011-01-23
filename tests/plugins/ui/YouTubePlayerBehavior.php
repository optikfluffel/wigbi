<div class="box">
	<div class="box title">YouTubePlayerBehavior</div>
	<div id="ytp_target">
		<?php YouTubePlayer::add("ytp", "http://www.youtube.com/v/gcsk1X9mLzs?fs=1&amp;hl=sv_SE", 480, 390); ?>
	</div>
	<div class="fc">
		<div class="box add">
			URL: <input type="text" id="ytp_url" />
			Width: <input type="text" id="ytp_width" />
			Height: <input type="text" id="ytp_height" />
			<button id="ytp_addButton" onclick="YouTubePlayer.add('ytp', $('#ytp_url').val(), $('#ytp_width').val(), $('#ytp_height').val(), 'ytp_target', addDone);">Add</button>
		</div>
	</div>
</div>