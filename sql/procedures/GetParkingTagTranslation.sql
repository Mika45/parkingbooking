DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetParkingTagTranslation`(IN `in_locale` VARCHAR(2), IN `in_parking_id` INT)
BEGIN

	SELECT tr.value AS name, ta.icon_filename, ta.tag_id
   FROM   TRANSLATION tr, TAG ta
   WHERE  tr.identifier = ta.tag_id
   AND    tr.table_name = 'TAG'
   AND    tr.column_name = 'name'
   AND    tr.locale = in_locale
   AND    tr.identifier IN (SELECT tag_id
                            FROM   PARKING_TAG pt
                            WHERE  pt.parking_id = in_parking_id);

END$$
DELIMITER ;
