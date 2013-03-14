var hrgnKeys = new Array();
hrgnKeys['a'] = 'あ';
hrgnKeys['i'] = 'い';
hrgnKeys['u'] = 'う';
hrgnKeys['e'] = 'え';
hrgnKeys['o'] = 'お';

hrgnKeys['ak'] = 'か';
hrgnKeys['ik'] = 'き';
hrgnKeys['uk'] = 'く';
hrgnKeys['ek'] = 'け';
hrgnKeys['ok'] = 'こ';
hrgnKeys['ag'] = 'が';
hrgnKeys['ig'] = 'ぎ';
hrgnKeys['ug'] = 'ぐ';
hrgnKeys['eg'] = 'げ';
hrgnKeys['og'] = 'ご';

hrgnKeys['as'] = 'さ';
hrgnKeys['ihs'] = 'し';
hrgnKeys['is'] = 'し';
hrgnKeys['us'] = 'す';
hrgnKeys['es'] = 'せ';
hrgnKeys['os'] = 'そ';
hrgnKeys['az'] = 'ざ';
hrgnKeys['iz'] = 'じ';
hrgnKeys['ij'] = 'じ';
hrgnKeys['uz'] = 'ず';
hrgnKeys['ez'] = 'ぜ';
hrgnKeys['oz'] = 'ぞ';

hrgnKeys['at'] = 'た';
hrgnKeys['it'] = 'ち';
hrgnKeys['ihc'] = 'ち';
hrgnKeys['ut'] = 'つ';
hrgnKeys['ust'] = 'つ';
hrgnKeys['et'] = 'て';
hrgnKeys['ot'] = 'と';
hrgnKeys['ad'] = 'だ';
hrgnKeys['id'] = 'ぢ';
hrgnKeys['ud'] = 'づ';
hrgnKeys['ed'] = 'で';
hrgnKeys['od'] = 'ど';

hrgnKeys['an'] = 'な';
hrgnKeys['in'] = 'に';
hrgnKeys['un'] = 'ぬ';
hrgnKeys['en'] = 'ね';
hrgnKeys['on'] = 'の';

hrgnKeys['ah'] = 'は';
hrgnKeys['ih'] = 'ひ';
hrgnKeys['uh'] = 'ふ';
hrgnKeys['uf'] = 'ふ';
hrgnKeys['eh'] = 'へ';
hrgnKeys['oh'] = 'ほ';
hrgnKeys['ab'] = 'ば';
hrgnKeys['ib'] = 'び';
hrgnKeys['ub'] = 'ぶ';
hrgnKeys['eb'] = 'べ';
hrgnKeys['ob'] = 'ぼ';
hrgnKeys['ap'] = 'ぱ';
hrgnKeys['ip'] = 'ぴ';
hrgnKeys['up'] = 'ぷ';
hrgnKeys['ep'] = 'ぺ';
hrgnKeys['op'] = 'ぽ';

hrgnKeys['am'] = 'ま';
hrgnKeys['im'] = 'み';
hrgnKeys['um'] = 'む';
hrgnKeys['em'] = 'め';
hrgnKeys['om'] = 'も';

hrgnKeys['ay'] = 'や';
hrgnKeys['uy'] = 'ゆ';
hrgnKeys['oy'] = 'よ';

hrgnKeys['ar'] = 'ら';
hrgnKeys['al'] = 'ら';
hrgnKeys['ir'] = 'り';
hrgnKeys['il'] = 'り';
hrgnKeys['ur'] = 'る';
hrgnKeys['ul'] = 'る';
hrgnKeys['er'] = 'れ';
hrgnKeys['el'] = 'れ';
hrgnKeys['or'] = 'ろ';
hrgnKeys['ol'] = 'ろ';

hrgnKeys['aw'] = 'わ';
hrgnKeys['ow'] = 'を';
hrgnKeys[' n'] = 'ん';
hrgnKeys[' m'] = 'ん';
hrgnKeys['nn'] = 'ん';
hrgnKeys['mm'] = 'ん';
hrgnKeys['*n'] = 'ん*';
hrgnKeys['*m'] = 'ん*';

hrgnKeys['ayk'] = 'きゃ';
hrgnKeys['uyk'] = 'きゅ';
hrgnKeys['oyk'] = 'きょ';

hrgnKeys['ays'] = 'しゃ';
hrgnKeys['ahs'] = 'しゃ';
hrgnKeys['uys'] = 'しゅ';
hrgnKeys['uhs'] = 'しゅ';
hrgnKeys['oys'] = 'しょ';
hrgnKeys['ohs'] = 'しょ';

hrgnKeys['ayc'] = 'ちゃ';
hrgnKeys['ahc'] = 'ちゃ';
hrgnKeys['uyc'] = 'ちゅ';
hrgnKeys['uhc'] = 'ちゅ';
hrgnKeys['oyc'] = 'ちょ';
hrgnKeys['ohc'] = 'ちょ';

hrgnKeys['ayn'] = 'にゃ';
hrgnKeys['uyn'] = 'にゅ';
hrgnKeys['oyn'] = 'にょ';

hrgnKeys['ayh'] = 'ひゃ';
hrgnKeys['uyh'] = 'ひゅ';
hrgnKeys['oyh'] = 'ひょ';

hrgnKeys['aym'] = 'みゃ';
hrgnKeys['uym'] = 'みゅ';
hrgnKeys['oym'] = 'みょ';

hrgnKeys['ayr'] = 'りゃ';
hrgnKeys['uyr'] = 'りゅ';
hrgnKeys['oyr'] = 'りょ';

hrgnKeys['ayg'] = 'ぎゃ';
hrgnKeys['uyg'] = 'ぎゅ';
hrgnKeys['oyg'] = 'ぎょ';

hrgnKeys['aj'] = 'じゃ';
hrgnKeys['ayj'] = 'じゃ';
hrgnKeys['ayz'] = 'じゃ';
hrgnKeys['uj'] = 'じゅ';
hrgnKeys['uyj'] = 'じゅ';
hrgnKeys['uyz'] = 'じゅ';
hrgnKeys['oj'] = 'じょ';
hrgnKeys['oyj'] = 'じょ';
hrgnKeys['oyz'] = 'じょ';

hrgnKeys['ayb'] = 'びゃ';
hrgnKeys['uyb'] = 'びゅ';
hrgnKeys['oyb'] = 'びょ';

hrgnKeys['ayp'] = 'ぴゃ';
hrgnKeys['uyp'] = 'ぴゅ';
hrgnKeys['oyp'] = 'ぴょ';

hrgnKeys['ayx'] = 'ゃ';
hrgnKeys['uyx'] = 'ゅ';
hrgnKeys['oyx'] = 'ょ';

hrgnKeys['ustx'] = 'っ';
hrgnKeys['utx'] = 'っ';
hrgnKeys['§§'] = 'っ*';

function romToHrgn(roman) {
    if (roman.length==0) return roman;
    
    // Store last 4 letters reversed
    var blockSize = 4;
    if (roman.length<blockSize) blockSize=roman.length;
    var block = roman.substr(roman.length-blockSize,blockSize).reverse();
    
    
    // Compare block to all keys
    var matchedKey = '';
    
    for (var key in hrgnKeys) {
        if (key.length>block.length) continue;
        
        var match = true;
        for (var i=0; i<key.length; i++) {
            var k = key.charAt(i);
            var b = block.charAt(i);
            if (k!=b && k!='*') {
                match = false;
                break;
            }
        }
        if (match) {
            if (key.length > matchedKey.length) {
                matchedKey = key;
            }
        }
    }
    
    // detect double roman consonant that isn't n
    var fc = block.charAt(0);
    if (fc==block.charAt(1)&&!fc.isHrgn()) {
        if (fc!='a'&&fc!='i'&&fc!='u'&&fc!='e'&&fc!='o'&&fc!='n') {
            matchedKey = '§§';
        }
    }
    
    // Seperate ending for editing
    var hrgn = roman.substr(0,roman.length-blockSize);
    var romanEnding = block.reverse();
    var hrgnEnding = romanEnding.substr(0,blockSize-matchedKey.length);;
    
    if (matchedKey!='') {
        var matchedHrgn = hrgnKeys[matchedKey];
        for (var i=0; i<matchedHrgn.length; i++) {
            h = matchedHrgn.charAt(i);
            if (h!='*') {
                hrgnEnding += h;
            } else {
                hrgnEnding += romanEnding.charAt(blockSize-matchedHrgn.length+i);
            }
        }
    }
    
    // Rejoin edited ending
    hrgn += hrgnEnding;
    
    return hrgn;
}