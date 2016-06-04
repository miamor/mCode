<div class="p-view">
	<h2 class="p-title"><? echo $problem->title ?>
	<strong class="p-code"><a href='../<? echo $problem->code ?>'><? echo $problem->code ?></a></strong></h2>
	<section class="col-lg-8 no-padding">
		<div class="p-detail">
			<div class="p-content">
				<? echo $problem->content ?>
			</div>
			<div class="p-samples">
				<h4>Samples</h4>
				<div class="p-input col-lg-6">
					<div class="labels">Input</div>
					<pre style="margin-top: 5px;" id="input_<? echo $problem->iid ?>"><? echo $problem->input ?></pre>
				</div>
				<div class="p-output col-lg-6">
					<div class="labels">Output</div>
					<pre style="margin-top: 5px;" id="output_<? echo $problem->iid ?>"><? echo $problem->output ?></pre>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		
		<div class="p-author right">
			<a href=""><img src="http://localhost/LTE/assets/dist/img/user2-160x160.jpg" class="left p-author-img"/></a>
			<div class="p-author-name"><a href="<? echo $problem->author['link'] ?>"><? echo $problem->author['name'] ?></a></div>
			<div class="gensmall p-author-rank">Ranking: <? echo $problem->author['rank'] ?></div>
		</div>
		
		<div class="problem-sta p-sta">
			<div class="problem-view" title="Views"><i class="fa fa-eye"></i> <? echo $problem->views ?></div>
			<div class="problem-submission" title="Submissions"><span class="left"><i class="fa fa-list"></i> <? echo $problem->submissions ?></span>
				<div class="problem-submission-details right" title="Submissions details">
					<div class="s-bar s-bar-error label-danger" style="width:<? echo 7/20*100 .'%' ?>" title="7 error"></div>
					<div class="s-bar s-bar-success label-success" style="width:<? echo 13/20*100 .'%' ?>" title="13 success"></div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</section>
	
	<section class="col-lg-4 no-padding-right">
		<div class="p-info panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">Problem Info</div>
			</div>
			<div class="panel-body">
				<div class="p-info-txt">
					<p style="margin-left: 5px">Score type: <strong title="It's either 'Accepted' or 'Not accepted'."><? echo $problem->score ?></strong></p>
					<p style="margin-left: 5px">Time limit: <strong><? echo $problem->time_limit ?></strong></p>
					<p style="margin-left: 5px">Memory Limit: <strong><? echo $problem->memory_limit ?></strong></p>
					<p style="margin-left: 5px">Input: <strong>Standard Input</strong></p>
					<p style="margin-left: 5px">Output: <strong>Standard Output</strong></p>
				</div>
			</div>
		</div>
		<div class="p-rating">
			<strong><? echo $problem->ratings ?></strong>
		</div>
	</section>
	<div class="clearfix"></div>
</div>

<div class="me-submission">
	<h3>Your Submissions</h3>
	<? include 'submissions.php';
	//include 'submit.php' ?>
	<div class="clearfix"></div>
</div>

<div class="p-submissions">
	<section class="col-lg-3 p-submissions-list no-padding-left">
		<h3>Top Submissions</h3>
	<? if (count($topSubmissions) > 0) {
		foreach ($topSubmissions as $sK => $subO) {
			$sK++;
			if ($sK <= 3) { ?>
			<div class="ranker rank-<? echo $sK ?>" data-id="<? echo $subO['id'] ?>">
				<a class="ranker-avt" href="<? echo $subO['author']['link'] ?>"><img class="ranker-avt-img img-circle <? if ($sK > 1) echo 'img-sm' ?>" src="<? echo $subO['author']['avatar'] ?>"/>
					<span class="rank-num"><? echo $sK ?></span>
				</a>
				<div class="ranker-info">
					<div class="ranker-name left"><a href="<? echo $subO['author']['link'] ?>"><? echo $subO['author']['name'] ?></a> <div class="gensmall ranker-rank">Ranking: <? echo $subO['author']['rank'] ?></div></div>
					<div class="ranker-det right">
						<div class="ranker-score <? if ($subO['score'] == '100') echo 'label label-success'; else echo 'text-'.$subO['scoreTxtCorlor'] ?> ac-<? echo $subO['score'] ?>"><? echo $subO['score'] ?></div>
						<div class="ranker-sta gensmall">
							<div class="ranker-length" title="Code length"><? echo $subO['length'] ?>KB</div>
							<div class="ranker-memory" title="Memory"></div>
							<div class="ranker-time" title="Execution time"><? echo $subO['time_taken'] ?>s</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		<? 	} else { ?>
			<div class="ranker rank-<? echo $sK ?> ranker-info">
				<div class="ranker-name left"><a href="<? echo $subO['author']['link'] ?>"><? echo $subO['author']['name'] ?></a> <span class="gensmall ranker-rank"><? echo $subO['author']['rank'] ?></span></div>
					<div class="ranker-det right">
						<div class="ranker-score <? if ($subO['score'] == '100') echo 'label label-success'; else echo 'text-'.$subO['scoreTxtCorlor'] ?> ac-<? echo $subO['score'] ?>"><? echo $subO['score'] ?></div>
					</div>
				<div class="clearfix"></div>
			</div>
		<? 	}
		}
		} else echo 'Be the first one to make submission!' ?>
	</section>

	<section class="col-lg-9 p-submission-details no-padding-right">
		<div class="col-lg-8 p-sub no-padding">
		</div>

		<div class="col-lg-4 p-sub-score no-padding-right">
		</div>
		<div class="clearfix"></div>
	</section>

	<div class="clearfix"></div>
</div>
