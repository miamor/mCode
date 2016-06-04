<div class="files-saved col-lg-2 no-padding">
	<h4 class="left">Your files</h4>
	<ul class="files-saved-more right">
		<li class="dropdown">
			<a class="dropdown-toggle" id="new-file" data-toggle="dropdown" href="#" aria-expanded="false" title="Add new submission"><span class="fa fa-plus"></span></a>
			<ul class="dropdown-menu new-file">
				<li role="presentation"><a role="menuitem" tabindex="-1" id="c_cpp" href="#">C++</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" id="c" href="#">C</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" id="java" href="#">Java</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" id="python" href="#">Python 2.7</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" id="python" href="#">Python 3.2</a></li>
			</ul>
		</li>
	</ul>
	<ul class="list-group me-sub-test-list me-files clearfix">
<? if (count($listFiles) > 0) {
	foreach ($listFiles as $mk => $file) { ?>
		<a class="list-group-item media me-file <? if ($mk == 0) echo 'active' ?>" data-id="<? echo $file['filename'] ?>" data-lang="<? echo $file['ext'] ?>" data-mode="<? echo $file['mode'] ?>" data-submit="<? echo $file['submit'] ?>">
			<img style="margin:2px 4px -1px 0" class="media-object left" src="<? echo ASSETS ?>/dist/img/<? echo $file['ext'] ?>.png" width="12" height="12"> 
			<? echo end(explode('/', $file['dir'])) ?>
			<div class="clearfix"></div>
		</a>
<? }
} ?>
	</ul>
</div>
<form class="code-area col-lg-10 no-padding-right">
	<div class="alert alert-info alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		Choose a file from left panel to start editing, compiling and submitting.
	</div>
	<div class="me-sub-code-alerts"></div>
	<div class="code-sub-area">
	<input id="sub-num" name="fnum" class="hide" value="<? echo count($listFiles) ?>"/>
	<input id="mode" name="mode" class="hide" value=""/>
	<textarea id="sub-code" name="code" class="hide"></textarea>
	<textarea id="sub-code-formatted" name="code-formatted" class="hide"></textarea>
	<div id="me-sub-code-area" class="aceditor"><? //echo htmlentities($mySubmit->codeContent) ?></div>
	<div class="code-tool nav-tabs-custom">
	</div><!-- nav-tabs-custom -->
	</div> <!-- code-sub-area -->
</form>

<script>var codeAreaID = 'me-sub-code-area';</script>
