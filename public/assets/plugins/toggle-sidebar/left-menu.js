(function($) {
	"use strict";
	
	// ______________Active Class
	$(".app-sidebar a").each(function() {
	  var pageUrl = window.location.href.split(/[?#]/)[0];
		if (this.href == pageUrl) { 
			$(this).addClass("active");
			$(this).parent().addClass("active"); // add active to li of the current link
			$(this).parent().parent().prev().addClass("active"); // add active class to an anchor
			$(this).parent().parent().prev().click(); // click the item to make it drop
		}
	}); 
	
	
	//Active Class
	$(".app-sidebar a").each(function() {
		var pageUrl = window.location.href.split(/[?#]/)[0];
		if (this.href == pageUrl) {
			$(this).addClass("active");
			$(this).parent().addClass("active"); // add active to li of the current link
			$(this).parent().addClass("resp-tab-content-active"); // add active to li of the current link
			$(this).parent().parent().parent().prev().addClass("active"); // add active class to an anchor
			$(this).parent().parent().parent().prev().click(); // click the item to make it drop
		}
	});
	
	$(".app-sidebar li a").each(function() {
		var pageUrl = window.location.href.split(/[?#]/)[0];
		if (this.href == pageUrl) {
			$(this).addClass("active");
			$(this).parent().parent().parent().parent().parent().addClass("active"); // add active to li of the current link
			$(this).parent().parent().parent().parent().parent().addClass("resp-tab-content-active"); // add active to li of the current link
			$(this).parent().parent().parent().prev().addClass("active"); // add active class to an anchor
			$(this).parent().parent().parent().prev().click(); // click the item to make it drop
		}
	});
	
	$(document).ready(function(){		
			
		if ($('.home-hogo.active').hasClass('active'))
        $('li.home-hogo').addClass('active');
	
		if ($('.apps-hogo.active').hasClass('active'))
        $('li.apps-hogo').addClass('active');
	
		if ($('.widget-hogo.active').hasClass('active'))
        $('li.widget-hogo').addClass('active');
	
		if ($('.charts-hogo.active').hasClass('active'))
        $('li.charts-hogo').addClass('active');
		
		if ($('.elements-hogo.active').hasClass('active'))
        $('li.elements-hogo').addClass('active');
	
		if ($('.advanced-hogo.active').hasClass('active'))
        $('li.advanced-hogo').addClass('active');
	
		if ($('.forms-hogo.active').hasClass('active'))
        $('li.forms-hogo').addClass('active');
	
		if ($('.icons-hogo.active').hasClass('active'))
        $('li.icons-hogo').addClass('active');
	
		if ($('.calendar-hogo.active').hasClass('active'))
        $('li.calendar-hogo').addClass('active');
		
		if ($('.tables-hogo.active').hasClass('active'))
        $('li.tables-hogo').addClass('active');
		
		if ($('.pages-hogo.active').hasClass('active'))
        $('li.pages-hogo').addClass('active');
	
		if ($('.ecommerce-hogo.active').hasClass('active'))
        $('li.ecommerce-hogo').addClass('active');
	
		if ($('.custom-hogo.active').hasClass('active'))
        $('li.custom-hogo').addClass('active');
	
		if ($('.error-hogo.active').hasClass('active'))
        $('li.error-hogo').addClass('active');
	
	});
	
	
	// VerticalTab
	$('#sidemenu-Tab').easyResponsiveTabs({
		type: 'vertical',
		width: 'auto', 
		fit: true, 
		closed: 'accordion',
		tabidentify: 'hor_1',
		activate: function(event) {
			var $tab = $(this);
			var $info = $('#nested-tabInfo2');
			var $name = $('span', $info);
			$name.text($tab.text());
			$info.show();
		}
	});
	
	
})(jQuery);