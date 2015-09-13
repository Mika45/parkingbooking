DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetTranslation`(IN `in_locale` VARCHAR(2), IN `in_name` VARCHAR(50), IN `in_table` VARCHAR(50), IN `in_identifier` VARCHAR(50))
BEGIN

	IF in_name IS NOT NULL THEN
		SELECT value
		FROM   TRANSLATION
		WHERE  locale = in_locale
		AND    column_name = in_name
		AND    table_name = in_table
		AND    identifier = in_identifier;
	ELSEIF in_name IS NULL AND in_table = 'PARKING' THEN
		SELECT column_name, value, NULL AS attributes
		FROM   TRANSLATION
		WHERE  locale = in_locale
		AND    table_name = in_table
		AND    identifier = in_identifier
		UNION
		SELECT CASE WHEN column_name IN ('name','attributes') THEN 'title' ELSE column_name END AS column_name,
			   MAX(value) AS value,
               GROUP_CONCAT(if(column_name = 'attributes', value, NULL)) AS attributes
		FROM   TRANSLATION
		WHERE  locale = in_locale
		AND    table_name = 'FIELD'
		AND    identifier IN (SELECT field_id 
							  FROM 	 PARKING_FIELD 
							  WHERE  parking_id = in_identifier)
      GROUP BY table_name, identifier;
	ELSEIF in_name IS NULL THEN
		SELECT column_name, value, identifier
		FROM   TRANSLATION
		WHERE  locale = in_locale
		AND    table_name = in_table
		AND    identifier = IFNULL(in_identifier,identifier);
	END IF;
END$$
DELIMITER ;
