var random = true;
var scorePlus = 20;
var minQuest = 4;

var questAr;

$.getJSON("getQuest.php").done(function (json) {
	questAr = json;
})

function newQuest (coin, id = '') {
	frozen = true;
	$form = $('form');
	if (!$form.length) {
		
		if (random == true) id = Math.floor(Math.random() * questAr.length);
		else if (!id) {
			alert('Your code has missing paramemters error!');
			return false;
		}

		questBox = game.add.sprite(50, 50, 'questBox'); // questbox width 700, height 500
		questBox.scale.setTo(1.5, 1.5);
		questBox.fixedToCamera = true;
		questText = game.add.text(160, 160, '', { fontSize: '28px', fill: '#222' });
		questText.fixedToCamera = true;
		questText.text = questAr[id].quest;

		iHTML = '<input type="text" name="answer" id="a'+id+'" autocomplete="off" style="width:100%;height:34px;color:#222!important"/>';
		iHTML += '<input type="text" readonly name="q" id="q'+id+'" value="'+id+'" style="display:none!important"/>';

		sHTML = '<input type="submit" class="btn btn-success" value="Submit"/>';

		fHTML = '<form id="q'+id+'">';
		fHTML += iHTML;
		fHTML += sHTML;
		fHTML += '</form>';

		// add the form inside the body
		$("body").append(fHTML);   //using jQuery or
	//	document.getElementsByTagName('body')[0].appendChild(f); //pure javascript
		submitQuest(id, coin)
	}

}

function submitQuest (id, coin) {
	$form = $('form#q'+id);
	$game = $('canvas');
	fWidth = 600;
	fHeight = 100;
	fTop = ($game.offset().top + $game.height() - fHeight)/2;
	fLeft = ($game.offset().left + $game.width() - fWidth)/2;
	$form.css({
		'position': 'absolute',
		'top': fTop,
		'left': fLeft,
		'width': fWidth,
		'height': fHeight,
//		'background': '#fbfbfb',
//		'padding': 20
	});
	$form.submit(function () {
		$.ajax({
			url: 'submit.php',
			type: 'post',
			data: $form.serialize()+'&q='+id,
			success: function (data) {
				console.log(data);
				frozen = false;
				questBox.destroy();
				questText.destroy();
				if (data == 1) {
					correct++;
					score += scorePlus;
					scoreText.text = 'Score: ' + score;
					correctText.text = 'Correct: ' + correct;
				}
				$form.remove()
				coin.kill();
			}
		});
		return false
	})
}
