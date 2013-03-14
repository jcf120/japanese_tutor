$(document).ready(function(){
  
  // Hide the last cell for JavaScript enabled browsers.
  $('#verbs td:last-child').hide();

  // Apply a class on mouse over and remove it on mouse out.
  $('#verbs tr:not(:first)').hover(
  function() {$(this).addClass('highlight');},
  function() {$(this).removeClass('highlight');}
  );

  // Assign a click handler that grabs the URL 
  // from the last cell and redirects the user.
  $('#verbs tr:not(:first)').click(function ()
  {
    location.href = $(this).find('td a').attr('href');
    $(this).removeClass('highlight');
  });
  
  $('#new-verb input[type="submit"]').click(function()
  {
    // form will submit if it remains valid
    var valid = true;
    var english = $('#new-verb input[name="english"]');
    if (english.val()=='') {
      valid = false;
      english.parent().addClass('error');
    }
    var type = $('#new-verb select');
    if (type.val()=='none') {
      valid = false;
      type.parent().addClass('error');
    }
    var dictionary = $('#new-verb input[name="dictionary"]');
    if (dictionary.val()=='') {
      valid = false;
      dictionary.parent().addClass('error');
    }
    return valid;
  });

});