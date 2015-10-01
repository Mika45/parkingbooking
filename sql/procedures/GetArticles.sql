-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetArticles`(IN in_locale VARCHAR(2))
BEGIN

	SELECT IFNULL(GROUP_CONCAT(IF(column_name = 'title', value, NULL)), a.title) AS title,
		   IFNULL((SELECT value 
				   FROM   TRANSLATION 
				   WHERE  identifier = a.article_id 
				   AND    column_name = 'body'
				   AND	  locale = in_locale), a.body) AS body,
		   IFNULL(GROUP_CONCAT(IF(column_name = 'slug', value, NULL)), a.slug) AS slug
	FROM   ARTICLE a
		   LEFT JOIN TRANSLATION t ON (t.identifier = a.article_id AND t.locale = in_locale)
	GROUP  BY a.article_id
	ORDER  BY a.article_id DESC;

END