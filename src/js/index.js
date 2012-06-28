
function load_data() {

	// reset
	$('#loading').show();
	$('#rolls_todo').empty();
	$('#rolls_done > div').empty();
	$('.accordion').hide();
	$('.submit').removeClass('disabled').hide();
	
  // load data
  $.getJSON('getrolls.php', function(data) {
    $.each(data, function(i, roll) {
      var html_roll = $($('#tmpl_roll').render(roll));
      if (roll.exported == false) {
        html_roll.find('input[type=checkbox]').check();
        html_roll.find('.untag').css('visibility', 'visible');
        html_roll.find('.badge').addClass('badge-success');
      }
      $(roll.exported ? '#rolls_done > div' : '#rolls_todo').append(html_roll);
    });
    
    // show some stuff and activate
    $('#loading').hide();
    if ($('#rolls_todo .roll').length == 0) {
      $('#rolls_todo').append('<div class="alert">No new event to process</div>');
      $('.submit').addClass('disabled');
    }
    if ($('#rolls_done .roll').length > 0) {
      $('.accordion').show();
    }
    $('.submit').show();
    $('.untag').tooltip();
  })
	
}

$(document).ready(function() {
  
	// do this right now
	load_data();
	
  // export
  $(document).on('change', '.roll input[type=checkbox]', function() {
    
    // update badge
    var roll = $(this).closest('.roll');
    if ($(this).is(':checked')) {
      roll.find('.badge').addClass('badge-success');
    } else {
      roll.find('.badge').removeClass('badge-success');
    }
    
    // export enabled?
    if ($('.roll input:checked').length > 0) {
      $('.submit').removeClass('disabled');
    } else {
      $('.submit').addClass('disabled');
    }
  });
  
  // untag
  $(document).on('click', '.untag', function() {
    var roll = $(this).closest('.roll');
    $.ajax({
      url: 'mark.php?id='+roll.attr('data-id'),
      success: function() {
        roll.find('input[type=checkbox]').click();
        roll.find('.untag').css('visibility', 'hidden');
      }
    });
  });
  
  // disabled submit
  $('.submit').on('click', function() {
    if ($(this).hasClass('disabled')) {
      return false;
    }
  });
  
  // submit
  $('#dryrun').on('click', function() {
  	$('input[name=dryrun]').val(1);
  })
  $('#submit').on('click', function() {
  	$('input[name=dryrun]').val(0);
  })
  
  // options
  $('#options form').ajaxForm(function() {
		$('#options').modal('hide');
  });

  // clear alerts on options
  $('#options').on('hidden', function() {
  	$(this).find('.alert').remove();
  });
  
  // clear history
  $('#options #clear').on('click', function() {
    $.ajax({
      url: 'mark.php?id=none',
      success: function() {
      	$.alert('History cleared', $('#options .modal-body'), 'alert-info');
      	load_data();
      }
    });
  })
  
  // mark all
  $('#options #mark').on('click', function() {
    $.ajax({
      url: 'mark.php?id=all',
      success: function() {
      	$.alert('All events marked as exported', $('#options .modal-body'), 'alert-info');
      	load_data();
      }
    });
  })
  
});