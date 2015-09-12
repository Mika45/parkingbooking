-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetResultTranslations`(IN in_parking_ids VARCHAR(65535), IN in_locale VARCHAR(2))
BEGIN

	DECLARE v_query VARCHAR(2000);

	SET v_query = CONCAT('SELECT p.parking_id, 
								 IFNULL(GROUP_CONCAT(IF(column_name = "parking_name", value, NULL)), p.parking_name) AS parking_name,
								 IFNULL(GROUP_CONCAT(IF(column_name = "address", value, NULL)), p.address) AS address
						  FROM   PARKING p 
								 LEFT JOIN TRANSLATION t ON (p.parking_id = t.identifier AND t.table_name = "PARKING" AND t.locale = "', in_locale, '")
						  WHERE  p.parking_id IN (', in_parking_ids, ')
						  GROUP  BY p.parking_id');

	SET @sql = v_query;
	PREPARE stmt FROM @sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;

END