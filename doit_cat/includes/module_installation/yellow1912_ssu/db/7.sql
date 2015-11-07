SET @t4=0;
SELECT (@t4:=configuration_group_id) as t4 
FROM configuration_group
WHERE configuration_group_title= 'Simple SEO URL';

INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
('Set SSU Multi Language Status', 'SSU_MULTI_LANGUAGE_STATUS', 'false', 'Do not turn this on unless your site uses multi-languages', @t4, 1, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),'),
('Set Query Key\'s Exclude List', 'SSU_QUERY_EXCLUDE_LIST', 'zenid,gclid,number_of_uploads,number_of_downloads,action,sort,page,disp_order,filter_id,alpha_filter_id', 'Set the query keys that you want SSU to avoid converting, separated by comma with no blank space', @t4, 1, NOW(), NOW(), NULL, NULL);