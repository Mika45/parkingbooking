DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetLocations`( IN in_type VARCHAR(10), IN in_location_id INT, IN in_locale VARCHAR(2) )
BEGIN

	IF in_type = 'all' THEN
		
		SELECT l.location_id, IFNULL(t.value, l.name) as name, pl.location_id parent_id, IFNULL(t2.value, pl.name) AS optgroup
		FROM   LOCATION l 
			   LEFT JOIN TRANSLATION t ON (l.location_id = t.identifier AND t.table_name = 'LOCATION' AND t.column_name = 'name' AND t.locale = in_locale), 
			   LOCATION pl 
			   LEFT JOIN TRANSLATION t2 ON (pl.location_id = t2.identifier AND t2.table_name = 'LOCATION' AND t2.column_name = 'name' AND t2.locale = in_locale)
		WHERE  l.location_parent_id = pl.location_id
		AND    IFNULL(in_location_id, l.location_parent_id) = l.location_parent_id
	    AND    pl.status != 'I'
		AND    l.status != 'I'
		ORDER  BY 3, 2;

	ELSEIF in_type = 'one' THEN

		SELECT l.location_id, IFNULL(t.value, l.name) as name, IFNULL(t2.value, pl.name) AS parent, l.lat, l.lng, pl.currency, pl.currency_order
		FROM   LOCATION l 
			   LEFT JOIN TRANSLATION t ON (l.location_id = t.identifier AND t.table_name = 'LOCATION' AND t.column_name = 'name' AND t.locale = in_locale), 
			   LOCATION pl 
			   LEFT JOIN TRANSLATION t2 ON (pl.location_id = t2.identifier AND t2.table_name = 'LOCATION' AND t2.column_name = 'name' AND t2.locale = in_locale)
		WHERE  l.location_parent_id = pl.location_id
		AND	   l.location_id = in_location_id
		ORDER  BY 3, 2;

	ELSEIF in_type = 'parent' THEN

		SELECT l.location_id, 
			   IFNULL(t.value, l.name) as name,
			   IFNULL(t2.value, l.slug) as slug
		FROM   LOCATION l 
			   LEFT JOIN TRANSLATION t ON (l.location_id = t.identifier AND t.table_name = 'LOCATION' AND t.column_name = 'name' AND t.locale = in_locale)
			   LEFT JOIN TRANSLATION t2 ON (l.location_id = t2.identifier AND t2.table_name = 'LOCATION' AND t2.column_name = 'slug' AND t2.locale = in_locale)
		WHERE  IFNULL(l.location_parent_id, 0) = 0
		AND	   l.slug IS NOT NULL
		ORDER  BY l.location_id;

	ELSEIF in_type = 'child' THEN

		SELECT l.location_id, 
			   IFNULL(t.value, l.name) as name,
			   IFNULL(t2.value, l.slug) as slug,
			   IFNULL(t3.value, pl.slug) AS parent_slug
		FROM   LOCATION l 
			   LEFT JOIN TRANSLATION t ON (l.location_id = t.identifier AND t.table_name = 'LOCATION' AND t.column_name = 'name' AND t.locale = in_locale)
			   LEFT JOIN TRANSLATION t2 ON (l.location_id = t2.identifier AND t2.table_name = 'LOCATION' AND t2.column_name = 'slug' AND t2.locale = in_locale),
			   LOCATION pl 
			   LEFT JOIN TRANSLATION t3 ON (pl.location_id = t3.identifier AND t3.table_name = 'LOCATION' AND t3.column_name = 'slug' AND t3.locale = in_locale)
		WHERE  l.location_parent_id = in_location_id
		AND    l.location_parent_id = pl.location_id
		AND	   l.slug IS NOT NULL
		ORDER  BY l.location_id;

	END IF;

END$$
DELIMITER ;
