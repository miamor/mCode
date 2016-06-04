<div class="col-lg-3">
	<h4 class="left">Questions</h4>
	<ul class="files-saved-more right">
		<li class="dropdown">
			<a class="dropdown-toggle" id="new-file" data-toggle="dropdown" href="#" aria-expanded="false" title="Add new submission"><span class="fa fa-plus"></span></a>
			<ul class="dropdown-menu new-file">
				<li role="presentation"><a role="menuitem" tabindex="-1" id="c_cpp" href="#">Choice</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" id="c_cpp" href="#">Text</a></li>
			</ul>
		</li>
	</ul>
	<ul class="list-group me-sub-test-list me-files quest-list clearfix">
	</ul>
</div>

<div class="col-lg-9">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#assets" data-toggle="tab">Assets</a></li>
			<li><a href="#evts" data-toggle="tab">Event sheets</a></li>
			<li><a href="#code" data-toggle="tab">Coding</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="assets">
				<div id="gcanvas">
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Add sprite</button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add a sprite</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="col-lg-3">Name</div>
					<div class="col-lg-9">
						<input name="name"/>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
					<div class="clearfix"></div>
				</div>
			</div><!-- /.tab-pane -->

			<div class="tab-pane" id="evts">
			</div><!-- /.tab-pane -->

			<div class="tab-pane" id="code">
				<textarea id="sub-code" name="code" class="hide"></textarea>
				<textarea id="sub-code-formatted" name="code-formatted" class="hide"></textarea>
				<div id="me-sub-code-area" class="aceditor"><? //echo htmlentities($mySubmit->codeContent) ?></div>
			</div><!-- /.tab-pane -->
		</div><!-- /.tab-content -->
	</div>
</div>

<div class="clearfix"></div>


<script>var gid = 1;</script>
