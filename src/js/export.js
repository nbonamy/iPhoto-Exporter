
$(document).ready(function() {

	// default thumbnail
	$('#thumb').loadThumb(g_default_thumb, null);
	
	// report display
	$(document).on('click', '#show_report, table.report', function() {
		$('#show_report').toggle();
		$('table.report').toggle();
	})
	
  // abort
  $('#abort').on('click', function() {
    if ($(this).hasClass('loading') == false) {
      $('#abort').addClass('loading');
      $.ajax({
        url: 'abort.php',
        success: function() {
        }
      });
    }
  });
  
  // run process
  $.ajax({
    url: 'process.php',
    success: function(data) {
      $('#progress').parent().removeClass('active');
      $('#fullrun').css('display', 'inline');
      $('#abort').hide();
      $('#back').show();
      $('#log').show();
    }
  });
  
  // get progress
  var interval = setInterval(function() {
    
    $.getJSON('status.php', function(data) {

    	// easy stuff
      $('#status').show();
      $('#title').html(data.title);
      $('#total').text(data.total);
      $('#processed').text(data.processed);
      $('#progress').css('width', (data.processed/data.total*100)+'%');
      $('#thumb').loadThumb('thumb.php?path='+data.thumb, g_default_thumb);
      
      // process status 
      if (data.status != 'pending' && data.status != 'running') {
        clearInterval(interval);
        $('#title').html(data.status).css('text-transform', 'capitalize');
        if (data.status == 'completed') {
        	$('#thumb').loadThumb('img/tick.png', null);
        	$('#report').html(data.report).show();
        	$('#report *[rel=tooltip]').tooltip();
        } else {
        	$('#thumb').loadThumb('img/error.png', null);
        }
      }
    });
    
    
  }, 1000);
  
  
});