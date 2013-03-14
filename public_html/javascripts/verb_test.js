function Question(eng, form, ans) {
    this.english = eng;
    this.form = form;
    this.correctAnswer = ans;
    this.userAnswer = '';
}


function VerbTester() {
    
    this.id = null;
    this.difficulty = 'b'; // beginner level default
    this.english = '';
    this.form = '';
    this.answer = '';
    this.correctAnswer = '';
    this.questions = new Queue();
    this.answeredQuestions = new Array();
    
    this.currentQuestion = null;
    this.nextQuestion = null;
    
    this.score = 0;
    
    this.timer = null;
    this.duration = 10;
    this.countDown = 0;
    this.isRunning = false;
    
    this.$currentCard = null;
    this.$nextCard = null;
    
    this.quesKey = new Array();
    this.quesKey['pln_pres'] =          'Plain Present';
    this.quesKey['plt_pres'] =          'Polite Present';
    this.quesKey['pln_pres_neg'] =      'Plain Present Negative';
    this.quesKey['plt_pres_neg'] =      'Polite Present Negative';
    this.quesKey['pln_past'] =          'Plain Past';
    this.quesKey['plt_past'] =          'Polite Past';
    this.quesKey['pln_past_neg'] =      'Plain Past Negative';
    this.quesKey['plt_past_neg'] =      'Polite Past Negative';
    this.quesKey['pln_pres_prog'] =     'Plain Present Progressive';
    this.quesKey['plt_pres_prog'] =     'Polite Present Progressive';
    this.quesKey['pln_pres_prog_neg'] = 'Plain Present Progressive Negative';
    this.quesKey['plt_pres_prog_neg'] = 'Polite Present Progressive Negative';
    this.quesKey['pln_vol'] =           'Plain Volitional';
    this.quesKey['plt_vol'] =           'Polite Volitional';
    this.quesKey['pln_vol_neg'] =       'Plain Volitional Negative';
    this.quesKey['plt_vol_neg'] =       'Polite Volitional Negative';
    
    this.testingForms = new Array();
    
    
    
/*                                                                 */
/*                           Progression                           */
/*                                                                 */



    this.setup = function() {
        // Request test id from server and assign playlist.
        
        // Implode verb forms
        var implodedForms = new String();
        for (var i=0; i<this.testingForms.length; i++) {
            implodedForms += this.testingForms[i];
            if (i!=this.testingForms.length-1) {
                implodedForms += ',';
            }
        }
        
        $.ajax({url:"forms/verb_test_setup.php",
               success:bind(this, this.receiveTestID),
               data:{diff:this.difficulty,
                     forms:implodedForms}});
    }
    
    this. receiveTestID = function(result) {
        if (result != 'false') {
            this.id = parseInt(result);
            this.requestQuestions();
        }
    }
    
    this.begin = function() {
        this.displayCardTable()
        
        this.currentQuestion = this.questions.dequeue();
        this.$currentCard = this.buildCard(this.currentQuestion);
        this.$currentCard.css({'left':$('#card-table').offset().left+'px'});
        
        this.nextQuestion = this.questions.dequeue();
        this.$nextCard = this.buildCard(this.nextQuestion);
        this.$nextCard.css({'left':($('#card-table').offset().left+600)+'px',
                           'opacity':0.3});
        
        this.displayCard(this.$currentCard);
        this.displayCard(this.$nextCard);
        
        this.countDown = this.duration;
        this.timer = setInterval(bind(this, this.tick), 1000);
        this.displayTime();
        
        this.displayAnswer()
        
        this.isRunning = true;
    }
    
    this.tick = function() {
        this.countDown--;
        this.displayTime();
        if (this.countDown <= 0) {
            this.finish();
        }
    }
    
    this.finish = function() {
        this.isRunning = false;
        clearInterval(this.timer);
        this.hideTest();
        this.displayResults();
        
        // Tell server to remove playlist from session
        $.ajax({url:'forms/verb_test_setup.php',
                data:{test_id:this.id,
                      finished:'true'}});
    }
    
    this.checkAnswer = function() {
        if (this.answer == this.currentQuestion.correctAnswer) {
            this.score++;
            this.displayScore();
            return true;
        } else {
            return false;
        }
    }
    
    this.skipCard = function() {
        if (!this.animating) {
            this.nextCard();
        }
    }
    
    this.finishedAnimating = function() {this.animating = false;}
    
    this.nextCard = function() {
        
        if (this.questions.getLength()==0) {
            log('communication error');
            this.finish();
        }
        
        this.currentQuestion.userAnswer = this.answer;
        this.answeredQuestions.push(this.currentQuestion);
        
        this.animating = true;
        var aniDuration = 300;
        
        // animate out old
        this.$currentCard.animate({left:'-=600',
                                  opacity: 0},
                                aniDuration,
                                function(){$(this).remove()});
        
        // bring next card to forground
        this.currentQuestion = this.nextQuestion;
        this.$currentCard = this.$nextCard;
        this.$currentCard.animate({left:'-=600',
                                opacity:1},
                                aniDuration,
                                function(){});
        
        // bring following card to background
        this.nextQuestion = this.questions.dequeue();
        this.$nextCard = this.buildCard(this.nextQuestion)
        this.$nextCard.css({'left':($('#card-table').offset().left+1200)+'px',
                           'opacity':0})
        this.displayCard(this.$nextCard);
        this.$nextCard.animate({left:'-=600',
                                opacity:0.5},
                                aniDuration,
                                bind(this, this.finishedAnimating));
        
        this.clearAnswer();
        
        // request additional questions if running low
        if (this.questions.getLength() < 7) {
            this.requestQuestions();
        }
    }
    
    
/*                                                                 */
/*                             Questions                           */
/*                                                                 */


    
    this.requestQuestions = function() {
        $.ajax({url:"forms/next_verb.php",
               success:bind(this, this.receiveQuestions),
               data:{test_id:this.id,
                     quantity:10}});
    }
    
    this.receiveQuestions = function(xml) {
        $xml = $($.parseXML(xml));
        $xml.find('verb').each(bind(this, this.processQuestion));
        
        if (!this.currentQuestion) this.begin();
    }
    
    this.processQuestion = function(i, verb) {
        var ques = new Question($(verb).find('english').text(),
                                $(verb).find('form').text(),
                                $(verb).find('answer').text());
        this.questions.enqueue(ques);
    }
    
    this.buildCard = function(ques) {
        var $card = $("<div class='test-card'></div>");
        
        var $english = $("<h2></h2>");
        $english.text(ques.english);
        $card.append($english);
        
        var $form = $("<h3></h3>");
        $form.text(this.quesKey[ques.form]);
        $card.append($form);
        
        var $answer = $("<p class='empty'>Begin Typing</p>");
        $card.append($answer);
        
        return $card;
    }
    
    
    
/*                                                                 */
/*                             Display                             */
/*                                                                 */

    this.displayCardTable = function(card) {
        $('#tester').append("<div id='card-table'></div>");
    }
    
    this.displayCard = function(card) {
        $('#card-table').append(card);
    }
    
    this.displayTime = function() {
        var min = Math.floor(this.countDown/60);
        if (min<10) min = '0'+min;
        var sec = this.countDown%60;
        if (sec<10) sec = '0'+sec;
        $('#time').text(min+':'+sec);
    }
    
    this.displayScore = function() {
        $('#score').text('Score: '+this.score);
    }
    
    this.displayAnswer = function() {
        $answer = this.$currentCard.find('p');
        if (this.answer != ''){
            $answer.removeClass('empty');
            $answer.text(this.answer);
        } else {
            $answer.addClass('empty');
            $answer.text('Begin Typing');
        }
    }
    
    this.clearAnswer = function() {
        this.answer = '';
        this.displayAnswer();
    }
    
    this.hideTest = function() {
        $('#time').remove();
        $('#score').remove();
        $('#card-table').remove();
    }


/*                                                                 */
/*                              Input                              */
/*                                                                 */


    
    this.inputChar = function(c) {
        this.answer += c;
        
        // first character can't be space
        if (this.answer == ' ') this.answer = '';
        
        this.answer = romToHrgn(this.answer);
        this.displayAnswer();
    }
    
    this.deleteChar = function() {
        if (this.answer.length > 0) {
            this.answer = this.answer.substr(0,this.answer.length-1);
            this.displayAnswer()
        }
    }
    

/*                                                                 */
/*                             Results                             */
/*                                                                 */
    
    this.displayResults = function() {
        $div = $("<div id='results'></div>")
        $table = $("<table></table>");
        
        for (var i in this.answeredQuestions) {
            var q = this.answeredQuestions[i];
            $tr = $("<tr></tr>");
            
            $tr.append("<td>"+q.english+"</td>")
            $tr.append("<td>"+this.quesKey[q.form]+"</td>")
            if (q.correctAnswer == q.userAnswer) {
                //$tr.append("<td>Correct</td>");
                $tr.append("<td>"+q.userAnswer+" &#10004;"+"</td>");
                $tr.addClass('correct');
            } else {
                //$tr.append("<td>Incorrect</td>");
                var a = q.userAnswer+" &#10008;";
                if (q.userAnswer == '') a = 'Unanswered';
                $tr.append("<td>"+a+" ("+q.correctAnswer+")</td>");
                $tr.addClass('incorrect');
            }
            $table.append($tr);
        }
        
        $div.append($table);
        
        var apm = (this.score/this.duration)*60;
        $div.append("<p>"+this.score+'/'+this.answeredQuestions.length
                    +" at "+apm+" correct answers per minute</p>");
        
        $('#tester').append($div);
    }
    
}

/*                                                                 */
/*                        Document Loading                         */
/*                                                                 */

$(document).ready(function() {
    var verbTester = new VerbTester();
    
    // Disable backspace back
    $(document).keydown(function(event){
        if (event.keyCode == 8) {
            verbTester.deleteChar();
            return false;
        } else {
            return true;
        }
    });
    
    $(document).keypress(function(event){
        
        // Ignore input before and after test
        if (!verbTester.isRunning) return;
        
        // Pause input if animating
        if (verbTester.animating) return;
        
        var code = event.charCode;
        
        // return or space key
        if (code==13 || code==32) {
            // catch unconverted "n" hiragana
            verbTester.inputChar(' ');
            verbTester.checkAnswer();
            verbTester.skipCard();
        }
        
        // catch characters
        if ( code>=97&& code<=122) {
            var c = String.fromCharCode(code);
            verbTester.inputChar(c);
            if (verbTester.checkAnswer()) {
                verbTester.nextCard();
            }
        }
    })
    
    // form checkboxs
    var checkBoxes = new Array();
    /*var plnCheck = new JCheckBox('Plain Present','pln_pres',true);
    checkBoxes.push(plnCheck);
    var pltCheck = new JCheckBox('Polite Present','plt_pres',true);
    checkBoxes.push(pltCheck);*/
    
    var i=0;
    for (var key in verbTester.quesKey) {
        var cb;
        if (i<8){
            cb = new JCheckBox(verbTester.quesKey[key],key,true);    
        } else {
            cb = new JCheckBox(verbTester.quesKey[key],key,false);
        }
        
        checkBoxes.push(cb);
        i++;
    }
    
    // Level select
    var diffSelect = new JSelect(['Beginner', 'Intermediate', 'Advanced'],
                                 ['b', 'i', 'a'],
                                 0);
    
    // Timer select
    var timeSelect = new JSelect(['10 sec', '1 min', '5 min', '10 min'],
                                 [10, 60, 300, 600],
                                 2);
    
    var $start = make$button('Start', function() {
        verbTester.difficulty = diffSelect.value()
        verbTester.duration = timeSelect.value();
        diffSelect.$html().remove();
        timeSelect.$html().remove();
        
        for (var i=0; i<checkBoxes.length; i++) {
            var cb = checkBoxes[i];
            if (cb.state) verbTester.testingForms.push(cb.name);
            cb.$html().remove();
        }
        $start.remove();
        
        verbTester.setup();
        verbTester.displayScore();
    });
    
    for (var i=0; i<checkBoxes.length; i++) {
        $('#tester').append(checkBoxes[i].$html());
    }
    $('#tester').append(diffSelect.$html());
    $('#tester').append(timeSelect.$html());
    $('#tester').append($start);
    
});