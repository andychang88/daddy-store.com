<?php
   if (!defined('IS_ADMIN_FLAG')) {
       die('Illegal Access');
   }
  if($this_is_home_page && BLOG_SIDEBOX_ENABLED){
	   $blog_db=new queryFactory();
	   if($blog_db->connect(BLOG_DB_SERVER,BLOG_DB_SERVER_USERNAME, BLOG_DB_SERVER_PASSWORD, BLOG_DB_DATABASE,BLOG_USE_PCONNECT, false)){
		  $blog_article_sql='select post_title,id,post_content,post_author,post_date
							 from   wp_posts 
							 where  post_type="post" 
							 and    post_parent=0 
							 order by comment_count desc limit 2';
		  $blog_article_db=$blog_db->Execute($blog_article_sql);
		  if($blog_article_db->RecordCount()>0){
			 $blog_articles=array();
			 while(!$blog_article_db->EOF){
				  $blog_postdate=$blog_article_db->fields['post_date'];
				  $blog_postdate=explode(' ',$blog_postdate);
				  $blog_postdate=$blog_postdate[0];
				  $blog_link=sprintf(BLOG_ARTICLE_LINK,$blog_article_db->fields['id']);
				  $blog_articles[]=array('title'=>$blog_article_db->fields['post_title'],
										 'blog_link'=>$blog_link,
										 'content'=>$blog_article_db->fields['post_content'],
										 'author'=>$blog_article_db->fields['post_author'],
										 'date'=>$blog_postdate
										 );
				  $blog_article_db->MoveNext();					 
			 }
			/*$blog_articles=array('title'=>$blog_article_db->fields['post_title'],
								 'id'=>$blog_article_db->fields['id'],
								 'content'=>$blog_article_db->fields['post_content'],
								 //'author'=>$blog_article_db->fields['post_author'],
								 'date'=>$blog_article_db->fields['post_date']
								 );*/
			 require($template->get_template_dir('tpl_blog_articles.php',
												 DIR_WS_TEMPLATE, 
												 $current_page_base,
												 'sideboxes'). '/tpl_blog_articles.php');
		  }
	   }
	   unset($blog_db);
	   unset($blog_article_db);
   }
?>
