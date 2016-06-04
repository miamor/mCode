__root = 'http://localhost/mgame/';

var viewname, editorAce, editorResult, old = '', fileName1 = '', fileName2 = '', converted = '', json = '', editor, isXmlData = true,
paragraphFlag = false, oldData = "", highlightedText = '', popupStatus = 0,canvas,context;
var loading = '<div class="center loading">Loading <img src="'+IMG+'/loadingIcon.gif"/></div>';
//ace.require("ace/ext/language_tools");
var editor = ace.edit('me-sub-code-area');
var meCode = 'javascript';

var _subjects = '', _sprites = '';

function setOutputMsg(msg) {
	$("#outputMsg").html("Result : " + msg);
}

function FormatWithOption (editor) {
//	var editor = ace.edit(codeAreaID);
//	editor.setTheme("ace/theme/chrome");
	var oldformat = editor.getValue() , newformat = "";
	indent_size = $('#index').val();
	if (!indent_size) indent_size = 0;
	newformat = js_beautify(oldformat,{
		"indent_size": indent_size,
		"indent_char": " ",
		"other": " ",
		"indent_level": 0,
		"indent_with_tabs": false,
		"preserve_newlines": true,
		"max_preserve_newlines": 2,
		"jslint_happy": true,
		"indent_handlebars": true
	});
	return newformat
}

function loadEvts (gid) {
	_gRoot = __root+'game/'+gid+'/';
	$gC = $('#gcanvas');
	$.ajax({
		url : MAIN_URL+'/make.php',
		type: 'post',
		data: 'gid='+gid,
		success : function (data) {
			data = $.parseJSON(data);
			console.log(data);
		}
	});
}

function loadAssets (gid) {
	file = __root+'game/'+gid+'/js/game.js';
	_gRoot = __root+'game/'+gid+'/';
	$gA = $('#gcanvas');
	$gE = $('#evts');
	$.ajax({
		url : '?do=getFile',
		type: 'post',
		data: 'gid='+gid,
		success : function (data) {
			data = $.parseJSON(data);
			console.log(data);
			editor.getSession().setValue(data.code);
			_objects = data.objects;
			_groups = data.groups;
			_events = data.events;
			_sprites = _objects.sprites;
			for (var i in _sprites) {
				spr = _sprites[i];
				spr.id = i;
				ani = spr.animations;
				if (spr.id == 'map') htm = '<img title="'+spr.id+'" alt="'+spr.asset+'" src="'+MAIN_URL+'/assets/dist/img/json.gif"/>';
				else htm = '<img title="'+spr.id+'" alt="'+spr.asset+'" src="'+_gRoot+spr.asset+'"/>';
				if (ani) aniHTML = '<div class="animation"></div>';
				$gA.append('<div class="one-asset" id="'+i+'"><div class="right sprite-info"></div><div class="sprite-id">'+spr.id+' </div> '+htm+' <a href="#" class="italic">Change asset</a> </div>');
			}
			// evts of objects
			for (var id in _events.objects) {
				evt = _events.objects[id];
				for (var ob in evt) {
					evOb = evt[ob];
					$gE.append('<div class="one-evt" id="'+ob+'">\
						<div class="col-lg-2 evt-name no-padding-left bold" id="'+ob+'">'+ob+'</div>\
						<div class="col-lg-10 evt-evts no-padding" id="'+ob+'_evt"></div>\
						<div class="clearfix"></div>\
					</div>');
					for (var i in evOb) {
						evObSettings = evOb[i];
						if ($.type(data) == 'object' || $.type(data) == 'array') child = 'yes';
						else child = 'no';
						$('#'+ob+'_evt').append('<div class="evt '+ob+'_'+i+'" child="'+child+'"><div class="evtTitle">'+i+'</div>\
							<div class="evtContent" id="'+ob+'_'+i+'"></div>\
							<div class="clearfix"></div>\
						</div>');
						show(evObSettings, i, ob);
					}
				}
			}
/*			for (var id in _events.objects) {
				evt = _events.objects[id];
				for (var ob in evt) {
					evOb = evt[ob];
					$gE.append('<div class="one-evt" id="'+ob+'">\
						<div class="col-lg-2 evt-name no-padding-left bold" id="'+ob+'">'+ob+'</div>\
						<div class="col-lg-10 evt-evts no-padding" id="'+ob+'_evt"></div>\
						<div class="clearfix"></div>\
					</div>');
					obEvt = '';
					for (var i in evOb) {
						evObSettings = evOb[i];
						$('#'+ob+'_evt').append('<div class="obEvt '+ob+'_'+i+'"><div class="obEvtMain">'+i+'</div>\
							<div class="ob-evt-settings">\
						<div class="col-lg-1 no-padding-left" id="'+ob+'_'+i+'_name"></div>\
						<div class="col-lg-11 no-padding" id="'+ob+'_'+i+'_evt"></div>\
						<div class="clearfix"></div>\
							</div>\
						</div>');
						show(evObSettings, i, ob);
					}
//					show(evOb, ob, 1);
//					console.log(evOb);
				}
			}
*/		}
	});
}

function show (data, pid, ppid) {
	if ($.type(data) == 'object' || $.type(data) == 'array') {
		for (var j in data) {
			childData = data[j];
			console.log(childData);
			if ($.type(childData) == 'object' || $.type(childData) == 'array') childD = 'yes';
			else childD = 'no';
			$('.evtContent#'+ppid+'_'+pid).append('<div class="evt '+pid+'_'+j+'" child="'+childD+'"><div class="evtTitle">'+j+'</div>\
								<div class="evtContent" id="'+pid+'_'+j+'"></div>\
								<div class="clearfix"></div>\
							</div>');
			show(childData, j, pid);
		}
	} else $('.evtContent#'+ppid+'_'+pid).html(data);
}

/*
					for (var i in evOb) {
						evObSettings = evOb[i];
						$('#'+ob+'_evt').append('<div class="obEvt '+ob+'_'+i+'"><div class="obEvtTitle">'+i+'</div>\
							<div class="ob-evt-settings">\
						<div class="col-lg-1 no-padding-left" id="'+ob+'_'+i+'_name"></div>\
						<div class="col-lg-11 no-padding" id="'+ob+'_'+i+'_evt"></div>\
						<div class="clearfix"></div>\
							</div>\
						</div>');
						console.log(evObSettings);
						console.log(i+' ~~~ '+$.type(evObSettings));
						if ($.type(evObSettings) == 'object' || $.type(evObSettings) == 'array') {
							for (var j in evObSettings) {
								evObSet = evObSettings[j];
					//			console.log(evObSet);
								$('#'+ob+'_'+i+'_evt').append('<div id="'+ob+'_'+i+'_'+j+'">'+evObSet+'</div>');
								$('#'+ob+'_'+i+'_name').append('<div id="'+ob+'_'+i+'_'+j+'">'+j+'</div>');
							}
						}
					}
*/

function loadQuests (gid) {
	_gRoot = __root+'game/'+gid+'/';
	file = _gRoot+'/getQuest.php';
	var questAr;

	$.getJSON(file).done(function (json) {
		questAr = json;
		for (var i in questAr) {
			q = questAr[i];
			$('.quest-list').prepend('<a class="list-group-item media me-file" data-q="'+i+'">\
				<div class="quest">'+q.quest+'</div>\
				<div class="ans">'+q.answer+'</div>\
			</a>');
		}
	});
}

$(document).ready(function () {
	editor.setTheme("ace/theme/chrome");
	editor.getSession().setMode("ace/mode/"+meCode);
	loadAssets(gid);
//	loadEvts(gid);
	loadQuests(gid);
})
