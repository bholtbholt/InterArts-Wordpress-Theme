<form id="ContactForm" role="form" method="post">
<div class="form-group">
	<label class="sr-only" for="name">Name</label>
	<input type="text" class="form-control" id="name" name="name" required placeholder="Name">
</div>
<div class="form-group">
	<label class="sr-only" for="email">Email</label>
	<input type="email" class="form-control" id="email" name="email" required placeholder="Email">
</div>
<div class="form-group">
	<label class="sr-only" for="message">Your Message</label>
	<textarea class="form-control" rows="3" id="message" name="message" required placeholder="Tell us about it"></textarea>
</div>
<div class="form-group">
	<button type="submit" id="submit" class="btn btn-clear">Submit</button>
</div>
	<div id="form-messages"></div>
</form>