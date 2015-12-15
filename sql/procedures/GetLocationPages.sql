DROP PROCEDURE IF EXISTS GetLocationPages;
CREATE PROCEDURE `GetLocationPages`( IN in_locale VARCHAR(2) )
BEGIN

   SELECT l.location_id, CONCAT('/', IFNULL(t2.value, pl.slug), '/', IFNULL(t.value, l.slug)) AS url
   FROM   LOCATION l 
   	    LEFT JOIN TRANSLATION t ON (l.location_id = t.identifier AND t.table_name = 'LOCATION' AND t.column_name = 'slug' AND t.locale = in_locale), 
   	    LOCATION pl 
   	    LEFT JOIN TRANSLATION t2 ON (pl.location_id = t2.identifier AND t2.table_name = 'LOCATION' AND t2.column_name = 'slug' AND t2.locale = in_locale)
   WHERE  l.location_parent_id = pl.location_id
   AND    IFNULL(NULL, l.location_parent_id) = l.location_parent_id
   AND    pl.status != 'I'
   AND    l.status != 'I'
   AND    pl.slug IS NOT NULL
   ORDER  BY IFNULL(t2.value, pl.slug), IFNULL(t.value, l.slug);
   
END;