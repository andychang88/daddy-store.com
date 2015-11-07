<div class="bewertungen">
    <h6><?php echo BOX_HEADING_FORUM;?></h6>
	<?php foreach($forum_articles as $forum_article){?>	    
		<p>
		   <i>
			   <a href="<?php echo $forum_article['topic_link'];?>" target="_blank">
				  "<?php echo zen_trunc_string(zen_clean_html($forum_article['topic_title']),50,true);?>"
			   </a>
		   </i>
		</p>
	<?php }?>
    <p class="p_s"><a href="<?php echo FORUM_URL;?>"><?php echo TEXT_MORE_CONTENT;?></a></p>
</div>