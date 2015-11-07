<?php
   if (!defined('IS_ADMIN_FLAG')) {
       die('Illegal Access');
   }
   if($this_is_home_page && FORUM_SIDEBOX_ENABLED){
	   $forum_db=new queryFactory();
	   if($forum_db->connect(FORUM_DB_SERVER,FORUM_DB_SERVER_USERNAME,FORUM_DB_SERVER_PASSWORD,FORUM_DB_DATABASE,FORUM_USE_PCONNECT, false)){
		  $forum_article_sql='select topic_id,forum_id,topic_title
							  from   topics 
							  where topic_approved=1 
							  order by topic_views desc,topic_time desc limit 3';
		  $forum_article_db=$forum_db->Execute($forum_article_sql);
		  if($forum_article_db->RecordCount()>0){
			 $forum_articles=array();
			 while(!$forum_article_db->EOF){
				  $tmp_topic_link=sprintf(FORUM_ARTICLE_LINK,$forum_article_db->fields['forum_id'],$forum_article_db->fields['topic_id']);
				  $forum_articles[]=array('topic_title'=>$forum_article_db->fields['topic_title'],
										  'topic_link'=>$tmp_topic_link
										  );
				  $forum_article_db->MoveNext();					 
			 }
			 require($template->get_template_dir('tpl_forum_articles.php',
												 DIR_WS_TEMPLATE, 
												 $current_page_base,
												 'sideboxes'). '/tpl_forum_articles.php');
		  }
	   }
	   unset($forum_db);
	   unset($forum_article_db);
   }
?>
