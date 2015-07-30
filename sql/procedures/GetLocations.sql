DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetLocations`( IN in_type VARCHAR(10), IN in_location_id INT, IN in_locale VARCHAR(2) )
BEGIN

	IF in_type = 'all' THEN
		/*SELECT l.location_id, l.name, pl.name AS optgroup
		FROM   LOCATION l, LOCATION pl
		WHERE  l.location_parent_id = pl.location_id
		ORDER  BY pl.name, l.name;*/
		
		SELECT l.location_id, IFNULL(t.value, l.name) as name, pl.location_id parent_id, IFNULL(t2.value, pl.name) AS optgroup
		FROM   LOCATION l 
			   LEFT JOIN TRANSLATION t ON (l.location_id = t.identifier AND t.table_name = 'LOCATION' AND t.column_name = 'name' AND t.locale = in_locale), 
			   LOCATION pl 
			   LEFT JOIN TRANSLATION t2 ON (pl.location_id = t2.identifier AND t2.table_name = 'LOCATION' AND t2.column_name = 'name' AND t2.locale = in_locale)
		WHERE  l.location_parent_id = pl.location_id
		ORDER  BY 3, 2;

	ELSEIF in_type = 'one' THEN
		/*SELECT l.location_id, l.name, pl.name AS optgroup
		FROM   LOCATION l, LOCATION pl
		WHERE  l.location_parent_id = pl.location_id
		AND    l.location_id = in_location_id
		ORDER  BY pl.name, l.name;*/

		SELECT l.location_id, IFNULL(t.value, l.name) as name, IFNULL(t2.value, pl.name) AS parent, l.lat, l.lng, pl.currency, pl.currency_order
		FROM   LOCATION l 
			   LEFT JOIN TRANSLATION t ON (l.location_id = t.identifier AND t.table_name = 'LOCATION' AND t.column_name = 'name' AND t.locale = in_locale), 
			   LOCATION pl 
			   LEFT JOIN TRANSLATION t2 ON (pl.location_id = t2.identifier AND t2.table_name = 'LOCATION' AND t2.column_name = 'name' AND t2.locale = in_locale)
		WHERE  l.location_parent_id = pl.location_id
		AND	   l.location_id = in_location_id
		ORDER  BY 3, 2;
	END IF;

END$$
DELIMITER ;
