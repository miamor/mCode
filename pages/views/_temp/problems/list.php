<section class="problems-list">
<? foreach ($problemsList as $row) {
	extract($row); ?>
	<article class="problem-one">
		<div class="problem-left">
			<div class="problem-author">
				<a href="#"> <img title="<? echo $author['name'] ?>" src="<? echo $author['avatar'] ?>" class="img-circle"/></a>
			</div>
			<div class="problem-ranking"><a class="text-warning" title="Normal">
				<strong class="problem-ranking-score" title="Difficult score">2.5</strong>
				<? for ($i = 1; $i <= 5; $i++) {
					if ($i < 3) echo '<span class="fa fa-star"></span>';
					else if ($i == 3) echo '<span class="fa fa-star-half-o"></span>';
					else echo '<span class="fa fa-star-o"></span>';
				} ?></a>
			</div>
		</div>

		<div class="problem-info">
			<div class="problem-title"><a href="./p/<? echo $code ?>"><? echo $title ?> <span class="gensmall"><? echo $code ?></span></a></div>
			<div class="problem-content">
				<div class="shorten"><? echo $content ?></div>
			</div>
			<div class="problem-sta">
				<div class="problem-view" title="Views"><i class="fa fa-eye"></i> <? echo $views ?></div>
				<div class="problem-submission" title="Submissions"><span class="left"><i class="fa fa-list"></i> <? echo $submissions ?></span>
					<div class="problem-submission-details right" title="Submissions details">
						<div class="s-bar s-bar-error label-danger" style="width:<? echo 7/20*100 .'%' ?>" title="7 error"></div>
						<div class="s-bar s-bar-success label-success" style="width:<? echo 13/20*100 .'%' ?>" title="13 success"></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		
		<div class="clearfix"></div>
	</article>
<? } ?>
</section>
