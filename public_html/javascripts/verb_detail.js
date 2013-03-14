

$(document).ready(function(){
    $linkToConfirmButton($('#delete'));
    var difficultySelect = $selectToJSelect($("select[name='difficulty']"));
    difficultySelect.selectionChanged = function() {
        var verbID = $("input[name='id']").attr('value');
        var href = 'forms/edit_verb.php?id='+verbID+'&difficulty='+difficultySelect.value();
        //window.location = url;
        $.ajax({url:href});
    }
    $("input[value='Change Level']").remove();
    $('#wrapper').css('visibilty','visible');
    
    document.getElementById('wrapper').style.visibility = 'visible';
});