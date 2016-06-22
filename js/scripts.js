webshim.setOptions("forms", {
	lazyCustomMessages: true,
	customDatalist: "auto",
	list: {
		"filter": "^"
	}
});
webshim.polyfill('forms');

jQuery(document).ready(function($) {
	// Mailto Anti Spam logic
	// Use: <a class="mailto" data-domain="youneeq.ca" data-prefix="info" ></a>
  $('.mailto').each(function() {
      prefix = $(this).data('prefix');
      domain = $(this).data('domain');
      $(this).attr('href', 'mailto:'+prefix+'@'+domain).append(prefix+'@'+domain);
  });

  // Show search box
  var isSearchVisible = false;
  $('#search-trigger').click(function(event){
		event.preventDefault();
		searchBarLength = $(window).width() > 992 ? 532 : 465;
		if (!isSearchVisible) {
			$('.nav-searchform').animate({right:0}, 0, function() {
				$('.nav-searchform').animate({right:30}, 550);
				$('#nav-searchform input').animate({width:searchBarLength}, 600);
				$('#nav-searchform input').focus();
				isSearchVisible = true;
			});
		} 
	});
	$('#nav-searchform input').focusout(function(event){
		if (isSearchVisible) {
			$('.nav-searchform').animate({right:-1000}, 600, function() {
				$('#nav-searchform input').animate({width:0});
				isSearchVisible = false;
			});
		}
	});

	// Enable link to tab
	var hash = document.location.hash;
	var prefix = "tab_";
	if (hash) {
	  $('.nav-tabs a[href='+hash.replace(prefix,"")+']').tab('show');
	} 
	// Change hash for page-reload
	$('.nav-tabs a').on('shown.bs.tab', function (e) {
	  window.location.hash = e.target.hash.replace("#", "#" + prefix);
	});

	//Fix Masonry and Bootstrap Tab height problem
	/*$('a[data-toggle=tab]').on('shown.bs.tab', function (e) {
	    $(window).trigger("resize");
	});
	$(window).resize(function(){
	    $this = $('.masonry-container');
	    $this.masonry({ itemSelector: '.media-box' });               
	});*/

	//Ajax contact form
	$(function() {
		var form = $('#ContactForm');
		var formMessages = $('#form-messages');

		$(form).submit(function(event) {
			event.preventDefault();
			var formData = $(form).serialize();

			$.ajax({  
				type: "POST",
				data: formData,
				url: interarts_scripts_vars.template_path + '/forms/contactForm.php'				
			}).done(function(response) {
		    // Set the message text.
		    $(formMessages).text(response);

		    // Clear the form.
		    $('#name').val('');
		    $('#email').val('');
		    $('#message').val('');
			}).fail(function(data) {
		    // Set the message text.
		    if (data.responseText !== '') {
	        $(formMessages).text(data.responseText);
		    } else {
	        $(formMessages).text('Oops! An error occurred and your message could not be sent.');
		    }
			})
		});
	})


	// Display Search Results in a Carousel
	function searchResults() {
		if ($(window).width() > 768) {
			groupSearchResults(3);  //3 services in the banner for medium displays
		} else {
			$(".single-search-result").wrap("<div class='item'></div>");  //single services in the banner for small displays
			$("#search-results-carousel .carousel-inner div:first").addClass("active");    //activate the carousel
		}
	}
	// Wrap search results in groups of 3
	function groupSearchResults(split) {
		var $singleService = $('.single-search-result');
		var servicesLength = $singleService.length;
		for (var i = 0;i < servicesLength;i+=split){
			$singleService.filter(':eq('+i+'),:lt('+(i+split)+'):gt('+i+')').wrapAll("<div class='item'></div>");  //add item wrappers
		}
		$("#search-results-carousel .carousel-inner div:first").addClass("active");  //activate the carousel
	}
	searchResults();
});