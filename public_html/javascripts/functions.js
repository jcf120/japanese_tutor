function bind(scope, fn, args) {
      return function() {
        var cbnArgs = Array.prototype.slice.call(arguments);
        cbnArgs = cbnArgs.concat(args);
        fn.apply(scope, cbnArgs);
      };
}
      
function log(message) {$('#log').append(message+'<br>')}

String.prototype.replaceAt = function(i, c) {
      return this.substr(0, i) + c + this.substr(i+c.length);
}

String.prototype.reverse = function() {
    var s = "";
    var i = this.length;
    while (i>0) {
        s += this.substring(i-1,i);
        i--;
    }
    return s;
}

// matches one or more hiragana characters
String.prototype.isHrgn = function(){
    return !!this.match(/^[\u3040-\u3096]+$/)
}



function markedToRuby(marked) {
    var ruby = "";
    for (var i=0; i<marked.length; i++) {
        var character = marked.substring(i,i+1);
        if (character=="「") {
            ruby += "<ruby>";
        } else if (character=="（") {
            ruby += "<rt>";
        } else if (character=="）") {
            ruby += "</rt></ruby>";
        } else {
            ruby += character;
        }
    }
    return ruby;
}

// GUI elements

////////////////////////////////////////////////////////////////////////
/////////////////////////// Push Button ////////////////////////////////
////////////////////////////////////////////////////////////////////////

function make$button(name, click) {
      $butt = $("<a></a>");
      $butt.addClass('button');
      $butt.text(name);
      $butt.attr('href','javascript:void(0)');
      $butt.click(click);
      return $butt;
}

function $linkToConfirmButton($a) {
    var url = $a.attr('href');
    $a.attr('href','javascript:void(0)');
    $a.addClass('button');
    
    $a.click(function() {
       $confirm = $("<a class='button'></a>");
       $confirm.text('Confirm '+$a.text());
       $confirm.attr('href',url);
       $a.replaceWith($confirm);
    });
}


////////////////////////////////////////////////////////////////////////
////////////////////////// Dropdown Menu ///////////////////////////////
////////////////////////////////////////////////////////////////////////

function JSelect (ops, vals, sel) {
      this.options = ops;
      this.values = vals;
      this.selected = typeof(sel) != 'undefined' ? sel : 0;
      this.popped = false;
      
      this.$ul = null;
      
      this.value = function() {return this.values[this.selected];}
      
      this.selectionChanged = function() {}
      
      this.select = function(event,index) {
            if (this.selected != index) {
                  this.selected = index;
                  this.$a.html(this.options[this.selected]+' &#9663;');
                  this.selectionChanged();
            }
            this.popDown();
      }
      
      this.popDown = function() {
            this.$ul.remove();
            this.popped = false;
      }
      
      this.popUp = function() {
            
            if (this.popped) return;
            this.popped = true;
            
            this.$ul = $("<ul class='jselect'></ul>");
            for (var i=0; i<this.options.length; i++) {
                  var $li = $("<li></li>");
                  $li.text(this.options[i]);
                  if (i==this.selected) $li.addClass('selected');
                  $li.click(bind(this,this.select,i));
                  this.$ul.append($li);
            }
            this.$ul.mouseleave(bind(this, this.popDown));
      
            var pos = this.$a.offset();
            var height = this.$a.height();
            this.$ul.css({
                  "left":(pos.left)+"px",
                  "top":(pos.top-((this.selected+1)*height))+"px"
                  });
            $('body').append(this.$ul);
      }
      
      this.$a = $("<a class='jselect'></a>");
      this.$a.attr('href','javascript:void(0)');
      this.$a.html(this.options[sel]+' &#9663;'); // html instead of text for correct encoding
      
      this.$a.click(bind(this,this.popUp));
      
      this.$html = function() {return this.$a};
}

function $selectToJSelect($s) {
      var ops = new Array();
      var vals = new Array();
      var sel = 0;
      $s.children().each(function() {
            ops.push($(this).text());
            vals.push($(this).attr('value'));
            if ($(this).attr('selected')=='selected') {
                  sel = ops.length-1;
            }
      });
      
      var jSelect = new JSelect(ops, vals, sel);
      $s.replaceWith(jSelect.$html());
      
      return jSelect;
}


////////////////////////////////////////////////////////////////////////
////////////////////////////// Checkbox ////////////////////////////////
////////////////////////////////////////////////////////////////////////

function JCheckBox (title, name, state) {
      this.title = title;
      this.name = name;
      this.state = state;
      
      this.toggle = function() {
            if (this.state) {
                  this.state = false;
                  this.$a.find('#box').html('');
            } else {
                  this.state = true;
                  this.$a.find('#box').html('&#10004');
            }
      }
      
      this.$a = $("<a class='jcheckbox'><div id='box'></div>"+this.title+"</a>");
      if (this.state) {
            this.$a.find('#box').html('&#10004');
      }
      
      this.$a.click(bind(this,this.toggle));
      
      this.$html =  function() {return this.$a};
}





























