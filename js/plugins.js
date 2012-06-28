window.log = function f(){ log.history = log.history || []; log.history.push(arguments); if(this.console) { var args = arguments, newarr; args.callee = args.callee.caller; newarr = [].slice.call(args); if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);}};
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());

(function( $ ) {
  
  // mustache rendering
  $.fn.render = function(data) {
    return $.render(this.html(), data);
  };
  
  // mustache rendering
  $.render = function(tmpl, data) {
    return Mustache.render(tmpl, data)
  }
  
  // check
  $.fn.check = function() {
    return this.attr('checked', true);
  }
  $.fn.uncheck = function() {
    return this.attr('checked', false);
  }
  
  // set thumbnail center cropped
  $.fn.loadThumb = function(url, fallback) {

  	// check
  	if (this.attr('src') == url) {
  		return this;
  	}
  	
  	// save
  	var self = $(this);
  	var id = self.attr('id');
  	var div = self.parent();
  	
  	// to make sure we are going to set the right image
  	self.attr('data-src', url);
  	
  	// build a new image
    var img = $('<img class="hide" />').appendTo('body');
    
    // error management
    img.on('error', function() {
    	
    	// check that it is really for us
    	if (self.attr('data-src') != url) {
    		return;
    	}
    	
    	// if already fallback remove else fallback
    	if (fallback == null || $(this).attr('src') == fallback) {
    		$(this).remove();
    	} else {
        $(this).attr('src', fallback);
    	}
    });
    
    // loaded
    img.on('load', function() {
    	
    	// check that it is really for us
    	if (self.attr('data-src') != url) {
    		return;
    	}
    	
      // dimensions
      var width = $(this).width();
      var height = $(this).height();
      var new_width = div.width();
      var new_height = div.height();
      var margin_left = 0;
      var margin_top = 0;

      // zoom and crop
      if (width > height) {
        new_width = width / height * new_height;
        margin_left = (new_height - new_width) / 2;
      } else if (height > width) {
        new_height = height / width * new_width;
        margin_top = (new_width - new_height) / 2;
      } else if (width < new_width) {
        margin_left = (new_width - width) / 2;
        margin_top = (new_height - height) / 2;
        new_width = width;
        new_height = height;
      }

      // set style
      $(this).css({
        'width' : new_width+'px',
        'height' : new_height+'px',
        'margin-left' : margin_left+'px',
        'margin-top' : margin_top+'px'
      });

      // done
    	$('#'+id).replaceWith($(this));
    	$(this).attr('id', id);
    	$(this).show();
    	
    });
    
    // do it
    img.attr('src', url);
    return this;
  }
  
  // show alert
  $.alert = function(msg, parent, klass) {
  	
  	var alert = $('<div id="mark-confirm" class="alert"></div>');
  	alert.append('<button class="close" data-dismiss="alert">×</button>');
  	alert.append('<span>'+msg+'</span>');
  	alert.addClass(klass);
  	parent.prepend(alert);
  	
  }
		
})( jQuery );

