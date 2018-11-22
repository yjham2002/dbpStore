<div class="pager">
	<?
	if( $json->isPrevBlock)
	{
		echo '<a href="#" class="jPage" page="1"><<</a>';
		echo '<a href="#" class="pager_prev jPage" page="' . ($json->startBlock - 1) . '">이전</a>';
	}

	for($i = $json->startPage ; $i <= $json->endPage  ; $i++ )
	{
		if( $json->page == $i )
			echo '<a href="#" class="btn btn-primary select">'.$i.'</a>' ;
		else
			echo '<a href="#" class="jPage btn btn-secondary" page="'.$i.'">'.$i.'</a>' ;
	}

	if( $json->isNextBlock)
	{
		echo '<a href="#" class="pager_next jPage" page="' . ($json->endBlock + 1) . '">다음</a>';
		echo '<a href="#" class="jPage" page="' . ($json->endPage) . '">>></a>';
	}
	?>
</div>