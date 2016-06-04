var viewname, editorAce, editorResult, old = '', fileName1 = '', fileName2 = '', converted = '', json = '', editor, isXmlData = true,
paragraphFlag = false, oldData = "", highlightedText = '', popupStatus = 0,canvas,context;
var loading = '<div class="center loading">Loading <img src="'+IMG+'/loadingIcon.gif"/></div>';
//ace.require("ace/ext/language_tools");
var editor = ace.edit(codeAreaID);
var meCode;

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

function openFile (id, lang, uid, reload = false) {
	$('.code-sub-area').show();
	$meFile = $('.me-files > .me-file[data-id="'+id+'"][data-lang="'+lang+'"]');
	if (!$meFile.hasClass('active') || reload == true) {
	$('.me-files > .me-file').removeClass('active');
	$meFile.addClass('active');
	meCode = $meFile.attr('data-mode');
	submit = $meFile.attr('data-submit');
	$form = $('form.code-area');
	uc = '';
	if (uid) uc = '&uid='+uid;
	$.ajax({
		url: '?do=getfile',
		type: 'POST',
		data: 'fid='+id+'&lang='+lang+uc,
		success: function (data) {
			if (data == -1) {
				mtip('', 'error', '', 'No files found.');
			} else {
				$('#sub-num').val(id);
				$form.attr('id', id);
				editor.getSession().setMode("ace/mode/"+meCode);
				editor.getSession().setValue(data);
				if (submit == 0) {
					compileCode();
					submitCode();
					enable(editor);
					$('.me-sub-code-alerts').html('');
					$('.code-tool').html('<ul class="nav nav-tabs">\
			<li><a href="#noti" data-toggle="tab">Notification</a></li>\
			<li class="active"><a href="#console" data-toggle="tab">Console</a></li>\
			<li class="pull-right">\
				<div id="code-submit" class="btn btn-success right">Submit</div>\
				<div id="code-compile" class="btn btn-danger right">Compile</div>\
				<div id="mode" class="right">'+lang+'</div>\
				<select name="mode" id="mode" class="form-control right hide" style="width:250px" size="1">\
					<option value="cpp">C++</option><option value="c">C</option><option value="csharp">C#</option><option value="java">Java</option><option value="pascal">Pascal</option>\
				</select>\
			</li>\
		</ul>\
		<div class="tab-content">\
			<div class="tab-pane" id="noti">\
				<div class="me-sub-compile" id="me-sub-noti"></div>\
			</div><!-- /.tab-pane -->\
			<div class="tab-pane active" id="console">\
				<div class="me-sub-compile" id="me-sub-compile"></div>\
			</div><!-- /.tab-pane -->\
		</div><!-- /.tab-content -->');
					$('select#mode').val(lang).prop('disabled', 'disabled');
					$('input#mode').val(lang);
					if ($form.attr('id') == id) compileCode();
				} else {
					disable(editor);
					$('.me-sub-code-alerts').html('<div class="alert alert-warning alert-dismissable">\
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\
						<h4><i class="icon fa fa-warning"></i> No permissions found!</h4>\
						This file has been submitted. Therefore, you don\'t have permission to edit and compile this file again. <br/>Please create a new file and make a new submission.\
					  </div>');
					$('.code-tool').html('<ul class="nav nav-tabs">\
			<li class="active"><a href="#noti" data-toggle="tab">Test cases</a></li>\
			<li><a href="#console" data-toggle="tab">Console</a></li>\
			<li class="pull-right">\
				<div id="mode" class="right">'+lang+'</div>\
				<select name="mode" id="mode" class="form-control right hide" style="width:250px" size="1">\
					<option value="cpp">C++</option><option value="c">C</option><option value="csharp">C#</option><option value="java">Java</option><option value="pascal">Pascal</option>\
				</select>\
			</li>\
		</ul>\
		<div class="tab-content">\
			<div class="tab-pane active" id="noti">\
				<div class="me-sub-compile" id="me-sub-noti">'+loading+'</div>\
			</div><!-- /.tab-pane -->\
			<div class="tab-pane" id="console">\
				<div class="me-sub-compile" id="me-sub-compile">'+loading+'</div>\
			</div><!-- /.tab-pane -->\
		</div><!-- /.tab-content -->');
					$('select#mode').val(lang).prop('disabled', 'disabled');
					$('input#mode').val(lang);
					var code = data;
					newformat = FormatWithOption(editor);
					$('textarea#sub-code').val(code);
					$('textarea#sub-code-formatted').val(newformat);
					$.ajax({
						url: '?do=compile',
						type: 'POST',
						data: $('.code-area').serialize()+'&mode='+meCode+'&all=true',
						success: function (data) {
							if ($form.attr('id') == id) {
								data = $.parseJSON(data);
								data.checkText = '';
								activeTab('noti');
								showCompile(data, $('#me-sub-compile'), false);
								testCases = '<div class="tc-one thead"><div class="tc-test">Test</div><div class="tc-input">Input</div><div class="tc-output">Output</div><div class="tc-soutput">Expected</div><div class="tc-time">Time taken</div><div class="tc-result">Result</div><div class="clearfix"></div></div>';
								tests = data.tests;
								for (var i in tests) {
									test = tests[i];
//									if (test['checkTxt'] == 'AC') test['checkText'] = '<div class="media-heading">Test <a href="#t1">#1</a>: <span class="submission-scored submission-AC">Accepted</span> <strong class="right" title="Time taken"></strong></div>';
									testCases += '<div class="tc-one tc-'+test['checkTxt']+'"><div class="tc-test">#'+i+'</div><div class="tc-input">'+test['input']+'</div><div class="tc-output">'+test['output']+'</div><div class="tc-soutput">'+test['soutput']+'</div><div class="tc-time">'+test['time']+'</div><div class="tc-result submission-scored submission-'+test['checkTxt']+'"><img class="media-object" src="'+IMG+'/'+test['checkTxt']+'.png" width="12" height="12"> '+test['checkTxt']+'</div><div class="clearfix"></div></div>';
								}
								$('#me-sub-noti').html(testCases)
							}
						}
					})
				}
			}
		}
	})
	}
}

function enable (editor) {
	editor.setOptions({
		readOnly: false,
		highlightActiveLine: true,
		highlightGutterLine: true
	});
	editor.renderer.$cursorLayer.element.style.opacity = 1;
	editor.textInput.getElement().disabled = false;
//	editor.commands.commmandKeyBinding = {};
}
function disable (editor) {
	editor.setOptions({
		readOnly: true,
		highlightActiveLine: false,
		highlightGutterLine: false
	});
	editor.renderer.$cursorLayer.element.style.opacity = 0;
	editor.textInput.getElement().disabled = true;
//	editor.commands.commmandKeyBinding = {};
}

function _popupSimi (siO) {
	html = '<div class="popup-section section-light simi-info">';
	html += '<div class="si-one thead"> <div class="tit">Type</div> <div class="file-1">Your file</div> <div class="file-2">'+siO.uname+'\'s file</div> <div class="percent">Similarity</div> <div class="clearfix"></div> </div>';
	lcls = tcls = '';
/*	if (siAr.lines[2] == 100) lcls = 'bold danger';
	else if (siAr.lines[2] >= 90) lcls = 'danger';
	else if (siAr.lines[2] >= 70) lcls = 'warning';
*/	if (siAr.tokens[2] == 100) tcls = 'bold danger';
	else if (siAr.tokens[2] >= 90) tcls = 'danger';
	else if (siAr.tokens[2] >= 70) tcls = 'warning';
//	html += '<div class="si-one '+lcls+'"> <div class="tit">Lines</div> <div class="file-1">'+siAr.lines[0]+'</div> <div class="file-2">'+siAr.lines[1]+'</div> <div class="percent">'+siAr.lines[2]+'</div> <div class="clearfix"></div> </div>';
	html += '<div class="si-one '+tcls+'"> <div class="tit">Tokens</div> <div class="file-1">'+siAr.tokens[0].length+'</div> <div class="file-2">'+siAr.tokens[1].length+'</div> <div class="percent">'+siAr.tokens[2]+'</div> <div class="clearfix"></div> </div>';
	html += '<div class="si-one thead"> <div class="line"></div> <div class="file-1">Your file</div> <div class="line"></div> <div class="file-2">'+siO.uname+'\'s file</div> <div class="percent">Similarity</div> <div class="clearfix"></div> </div>';
//	console.log(siAr.diff);
	for (var i in siAr.diff) {
		ocls = '';
		if (siAr.diff[i][2] == 100) ocls = 'bold danger';
		else if (siAr.diff[i][2] >= 90) ocls = 'danger';
		else if (siAr.diff[i][2] >= 70) ocls = 'warning';
		j = Number(i)+1; 
		f1 = siAr.diff[i][0].split('~');
		f2 = siAr.diff[i][1].split('~');
		html += '<div class="si-one '+ocls+'"> <div class="line">'+f1[0]+'</div> <div class="file-1">'+f1[1]+'</div> <div class="line">'+f2[0]+'</div> <div class="file-2">'+f2[1]+'</div> <div class="percent">'+siAr.diff[i][2]+'%</div> <div class="clearfix"></div> </div>';
	}
	html += '</div>';
	popup_html(html);
}

function simiDetail () {
		$('.simi-detail').click(function () {
			i = $(this).attr('id').split('-')[1];
			lang = $(this).closest('.simi').children('b').text();
			u = $('.pladt').attr('data-for');
			myfnum = $('#me-sub-code').attr('data-id');
			formData = 'mode='+lang+'&u='+u+'&num='+i+'&fnum='+myfnum;
			$.ajax({
				url: '?do=plchecker',
				type: 'post',
				data: formData,
				success: function (data) {
					siO = $.parseJSON(data);
					siAr = siO.sAr;
					_popupSimi(siO);
				}
			});
		})
}

function selectCode(a) {
    var y = a.parentNode.parentNode.getElementsByTagName('CODE')[0];
    if(window.getSelection) {
        var i = window.getSelection();
        if(i.setBaseAndExtent) {
            i.setBaseAndExtent(y, 0, y, y.innerText.length - 1)
        } else {
            if(window.opera && y.innerHTML.substring(y.innerHTML.length - 4) == '<BR>') {
                y.innerHTML = y.innerHTML + ' '
            }
            var r = document.createRange();
            r.selectNodeContents(e);
            i.removeAllRanges();
            i.addRange(r)
        }
    } else if(document.getSelection) {
        var i = document.getSelection();
        var r = document.createRange();
        r.selectNodeContents(e);
        i.removeAllRanges();
        i.addRange(r)
    } else if(document.selection) {
        var r = document.body.createTextRange();
        r.moveToElementText(y);
        r.select()
    }
}
if(text) {} else {
    var text = 'Selecionar todos'
}


function lineComment () {
	$('.line-comment').each(function () {
		$(this).children('span').hide().click(function () {
			console.log('woo');
			$li = $(this).closest('li.line');
			id = Number($li.attr('id'));
			line = id + 1;
			te = $(this).closest('.p-sub').attr('id');
			if ($li.children('form.add-comment-line').length <= 0) {
				$li.append('<form method="post" class="add-comment-line" id="' + id + '"> <div class="comment-line-textarea" id="comment-line-'+te+id+'"><textarea name="comment-line-'+te+id+'" style="height:150px"></textarea></div> <div class="comment-line-note">Adding comments line <b>'+line+'</b> <a href="#" class="fa fa-times-circle close-add-cmt" title="Close"></a> <div class="add-comment-line-action right"><input type="submit" value="Submit" class="btn-xs"/></div></div> </form>');
				sce('comment-line-'+te+id); 
				flatApp();
				$('.close-add-cmt').click(function () {
					$(this).closest('form.add-comment-line').remove();
					$('.tooltip').remove();
					return false
				});
				$('form.add-comment-line').submit(function () {
					action = $('.plain.answer').attr('data-action');
//					console.log($("form.add-comment-line").serialize());
					$.ajax({
						url: '?do=addcomment',
						type: 'POST',
						data: 'line='+id+'&'+$("form.add-comment-line").serialize(),
						datatype: 'json',
						success: function (data) {
							$('.wind-cmts').prepend(data);
						},
						error: function (xhr) {
							$('.add-comment-line').find('.done-data').html('<div class="alerts alert-error">'+xhr+'. Please contact the administrators for help.</div>')
						}
					});
					return false
				})
			}
		})
	})
}

function showCompile (data, $compileArea, output = true) {
	console.log(data);
	if (data.status == 'error') $compileArea.html('<div class="console error"><div class="csl-main"><b>Errors fetched</b> '+data.content+'</div></div>');
	else {
		$compileArea.html('<div class="console success"><div class="csl-main"><b>Compile success</b> Compile completed. <span class="strong">Time taken:</span> '+data.time+'</div></div>');
		if (output == true) {
			if (data.check == true) $compileArea.append('<div class="console success"><div class="csl-main"><b>Correct</b> Output accepted</div><div class="output">'+data.output+'</div><div class="clearfix"></div></div>');
			else $compileArea.append('<div class="console error"><div class="csl-main"><b>Wrong output</b> '+data.output+'</div></div>');
		}
		checkLocal = data.checkLocal.similar;
		checkOnline = data.checkOnline.items;
		if (checkLocal.length || (data.checkOnline.status == 'success' && checkOnline && checkOnline.length)) {
			$compileArea.append('<div class="console warning console-similar"><div class="similar-detected csl-main"><b>Plagiarism detected</b>: Bro, we found something similar to your code was submitted before. You might wanna recheck the copyright?</div></div>');
			if (checkLocal.length) {
				$compileArea.find('.console-similar').append('<label class="checkLocal">Check Local</label>');
				for (var i in checkLocal) {
					siL = checkLocal[i];
					$compileArea.find('.console-similar').append('<div class="simi"><a class="bold" href="../u/'+siL.uname+'">@'+siL.uname+'</a> <b>cpp</b> file <div class="siper-bar"><span width="'+siL.per+'%"></span></div><span class="siper" title="Plagiarism detected">'+siL.per+'%</span> <a class="simi-detail" id="simi-'+i+'">Details</a></div>');
					siAr = siL.sAr;
					$('.simi-detail#simi-'+i).click(function () {
						_popupSimi(siL)
					})
				}
			}
			if (data.checkOnline.status == 'success' && checkOnline.length) {
				$compileArea.find('.console-similar').append('<label class="checkOnline">Check Online</label>');
				for (var j in checkOnline) {
					siO = checkOnline[j];
					$compileArea.find('.console-similar').append('<div class="simi">\
						<div class="simi-title">\
							<a class="simi-link gensmall italic right" href="'+siO.link+'">'+siO.link+'</a>\
							<a class="bold" title="'+siO.link+'" href="'+siO.link+'">'+siO.title+'</a>\
						</div>\
						<div class="simi-html-snippet">'+siO.htmlSnippet+'</div>\
					</div>');
				}
			} else if (data.checkOnline.status == 'error') 
				$compileArea.find('.console-similar').append('<label class="checkOnline">Check Online</label>\
					<div class="text-error italic">No internet connection</div>');
		}
	//	if (data.output.0 == 0) $compileArea.append('<div class="console success"><b>Test 1</b>: Accepted!<br/>You must submit to check with all test cases.</div>');
	/*	for (var i in data.output) {
			console.log(i);
			if (i == 0) $compileArea.append('<div class="console success"><b>Test 1</b>: Accepted!</div>');
		}*/
	}
}

function submissionList () {
	$('.p-submissions-list > .ranker').click(function () {
		sid = $(this).attr('data-id');
		$pSub = $('.p-sub');
		$pScore = $pSub.next('.p-sub-score');
		$pSub.html(loading);
		$pScore.html('');
		$.ajax({
			url: '?do=getsubmission',
			type: 'POST',
			data: 'sid='+sid,
			success: function (data) {
				data = $.parseJSON(data);
				au = data.author;
				console.log(data);
				$pSub.attr('id', sid).html('<h4>Select a submission</h4>\
			<div class="p-sub-code" style="display:none">\
				<dl class="codebox contcode hidecode">\
					<dt style="border: none;">Code:</dt>\
					<dd class="code_content"></dd>\
				</dl>\
			</div>');
				$pSub.find('h4').text(au.name+'\'s submission').next('.p-sub-code').show();
				$pSubCode = $pSub.find('.code_content');
				$pSubCode.html('<code>'+data.codeContent.replace(/(?:\r\n|\r|\n)/g, '<br />')+'</code>');
				
				$pScore.html('<div class="me-sub-overview">\
				<div class="left me-sub-score"></div>\
				<div class="me-sub-graph">\
					<h4 class="text-center">Total: <strong class="total_accepted"></strong> tests</h4>\
					<div class="progress prog-ac"></div>\
				</div>\
				<div class="clearfix"></div>\
			</div>\
			<ul class="list-group me-sub-test-list">\
			</ul>');
				if (data.score >= 80) stt = 'success';
				else if (data.score >= 50) stt = 'warning';
				else stt = '';
				$pScore.find('.me-sub-score').html('<span class="text-'+stt+'">'+data.score+'</span>');
				$pScore.find('.me-sub-score').html('<span class="text-'+stt+'">'+data.score+'</span>');
				data.AC = Number(data.AC);
				var per = Math.round(data.AC/data.tests * 100, 2);
				$pScore.find('.total_accepted').html(data.AC+'/'+data.tests);
				$pScore.find('.prog-ac').html('<div class="progress-bar progress-bar-'+stt+' progress-bar-striped active" role="progressbar" aria-valuenow="'+data.AC+'" aria-valuemin="0" aria-valuemax="'+data.tests+'" style="width: '+per+'%"></div>');
				cdt = data.compile_details;
				$pScore.find('.me-sub-test-list').html('');
				for (var i = 0; i < cdt.length; i++) {
					j = i+1;
					if (cdt[i] == 'AC') {
						cTit = '<span class="submission-scored submission-AC">Accepted</span>';
						cTxt = 'Correct!';
					} else if (cdt[i] == 'WA') {
						cTit = '<span class="submission-scored submission-WA">Wrong Answer</span>';
						cTxt = 'Wrong Answer: Unmatching output!';
					} else if (cdt[i] == 'RTE') {
						cTit = '<span class="submission-scored submission-RTE">Runtime Error</span>';
						cTxt = 'Runtime error: Process returned exit code 1!';
					}
					$pScore.find('.me-sub-test-list').append('<li class="list-group-item media me-sub-test">\
					<div class="media-left left"><img class="media-object" src="'+ASSETS+'/dist/img/'+cdt[i]+'.png" width="12" height="12"></div>\
					<div class="media-body">\
						Test <a href="#t'+j+'">#'+j+'</a>: '+cTit+' <strong class="right" title="Time taken"></strong></div>\
					</div></li>');
				}
				$compileArea = $('.p-submission-details #me-sub-compile');

				if ($(".codebox.contcode dd").filter(function () {
					var a = $(this).text().indexOf("["),
						b = $(this).text().indexOf("]"),
						c = $(this).text().indexOf("[/"),
						d = $(this).text().indexOf("<"),
						e = $(this).text().indexOf('"'),
						f = $(this).text().indexOf("'"),
						g = $(this).text().indexOf("/");
					return a == -1 || b == -1 || c == -1 || a > b || b > c || d != -1 && d < a || e != -1 && e < a || f != -1 && f < a || g != -1 && g < a
				}).each(function () {
					$(this).wrapInner('<pre class="prettyprint' + ($(this).text().indexOf("<") == -1 && /[\s\S]+{[\s\S]+:[\s\S]+}/.test($(this).text()) ? " lang-css" : "") + ' linenums" />')
				}).length) {
					var s = document.createElement("script");
					s.type = "text/javascript";
					s.async = !0;
					s.src = ASSETS+"/dist/js/prettifier.js";
					document.getElementsByTagName("head")[0].appendChild(s)
				}
				$("code:not(:has(br))").closest(".codebox").replaceWith(function () {
					return '<code class="min-code">' + $(this).find("code").html() + "</code>"
				}), $("code").not(".min-code").addClass("prettyprint").closest('dd.code_content').prev().attr({
					onclick: "selectCode(this)",
					title: "Select all",
					style: "cursor:pointer"
				});
				codes = $("code").not(".min-code");
				for (var i = 0; i < codes.length; i++) {
					codesAr = codes[i].innerHTML.split(/\<br\s?\/?\>/);
					codes[i].innerHTML = '';
					for (k = 0; k < codesAr.length; k++) {
						codes[i].innerHTML += '<li class="line code L'+k+'" id="'+k+'"><div class="line-comment"><span class="fa fa-comment"></span></div><code>'+codesAr[k]+'</code></li>';
					}
					codes[i].innerHTML = '<ol class="wind">'+codes[i].innerHTML+'</ol>';
				}
				lineComment()
			}
		})
	})
}

function compileCode () {
		$('#code-compile').click(function () {
			$compileArea = $('#me-sub-compile');
			$compileArea.html(loading);
			var code = editor.getValue();
			newformat = FormatWithOption(editor);
			$('textarea#sub-code').val(code);
			$('textarea#sub-code-formatted').val(newformat);
			formData = $('.code-area').serialize();
			$.ajax({
				url: '?do=compile',
				type: 'POST',
				data: formData,
				success: function (data) {
					data = $.parseJSON(data);
					activeTab('console');
					showCompile(data, $compileArea);
				}
			})
		})
}

function submitCode () {
		$('#code-submit').click(function () {
			$notiArea = $('#me-sub-noti');
			$notiArea.html(loading);
			var code = editor.getValue();
			newformat = FormatWithOption(editor);
			$('textarea#sub-code').val(code);
			$('textarea#sub-code-formatted').val(newformat);
			$.ajax({
				url: '?do=submit',
				type: 'POST',
				data: $('.code-area').serialize(),
				success: function (data) {
					data = $.parseJSON(data);
					activeTab('noti');
					if (data.status == 'error') 
						$notiArea.html('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-warning"></i> Errors fetched!</h4> '+data.content+'</div>');
					else {
						$notiArea.html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="icon fa fa-warning"></i> Success!</h4> Your submission has been submitted successfully.</div>');
						redirect();
					}
				}
			})
		})
}

function newFile () {
		$('.new-file > li > a').click(function () {
			ext = $(this).attr('id');
			$.ajax({
				url: '?do=newfile',
				type: 'POST',
				data: 'lang='+ext,
				success: function (data) {
					$('#sub-num').val(data);
					if (ext == 'c_cpp') ext = 'cpp';
					$('.me-files > .me-file').removeClass('active');
					$('.me-files').prepend('<a class="list-group-item media me-file active" data-id="'+data+'" data-lang="'+ext+'"><img style="margin:2px 4px -1px 0" class="media-object left" src="'+IMG+'/'+ext+'.png" width="12" height="12"> '+data+'.'+ext+'<div class="clearfix"></div></a>');
					$('.me-files > .me-file[data-id="'+data+'"][data-lang="'+ext+'"]').click(function () {
						openFile(data, ext);
					}).click();
					editor.getSession().setValue('');
					editor.getSession().setMode("ace/mode/"+ext);
				}
			});
			return false
		})
}


$(document).ready(function () {
	$('.code-sub-area').hide();
	newFile();

	disable(editor);
	
	submissionList();

/*	if (codeAreaID == 'me-sub-code') {
		disable(editor);
		simiDetail();
	} else {
		compileCode();
		submitCode();
		newFile();
	}
*/
	$('.me-files > .me-file').click(function () {
		openFile($(this).attr('data-id'), $(this).attr('data-lang'));
	});
	$('.me-files > .me-file:first').each(function () {
		openFile($(this).attr('data-id'), $(this).attr('data-lang'), '', true);
	});

});
