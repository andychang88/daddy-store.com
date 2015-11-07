<div class="blog">
    <h6><?php echo BOX_HEADING_BLOG;?></h6>
	<?php foreach($blog_articles as $blog_article){?>
	    <p>
		   <b>
		    <a href="<?php echo $blog_article['blog_link'];?>"  target="_blank">
			  <?php echo zen_trunc_string($blog_article['title'],30,true);?>
			</a>
		   </b>
		</p>
		<p>
		   <i>
			   <a href="<?php echo $blog_article['blog_link'];?>" target="_blank">
				  "<?php echo zen_trunc_string(zen_clean_html($blog_article['content']),50,true);?>"
			   </a>
		   </i>
		</p>
		<p class="red">
			<?php echo (zen_not_null($blog_article['author']))?$blog_article['author']:'';?> 
			<?php echo $blog_article['date'];?>
		</p>
	<?php }?>
    <p class="p_s"><a href="<?php echo BLOG_URL;?>"><?php echo TEXT_MORE_CONTENT;?></a></p>
</div>