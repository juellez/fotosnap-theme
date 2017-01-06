<?php global $post; ?>

<p>A landing page will automatically be generated from the information you enter here. The title will NOT be used and is for internal use only. SNAP.</p>

<h3>Custom Landing Page URL</h3> 
<p>http://fotosnap.co/friends/<input id="post_name_id" type="text" placeholder="unique slug"  name="post_name" value="<?= $post->post_name ?>"/></p>

<h3>Custom Message</h3>

<p>You've been invited by <input id="referrer_name_id" type="text" placeholder="referrer name" name="referrer_name" value="<?= $referrer_name ?>"/>
to FotoSnap your profile.</p>

<p>__{content from above, e.g.: You get 15% off your first booking.}__</p>

<p>Book now using referral code:
<input id="zozi_referral_code_id" type="text" placeholder="zozi referral code"  name="zozi_referral_code" value="<?= $zozi_referral_code ?>"/></p>

<small>Remember: this must match what's entered into Zozi as the promotional code.</small>
