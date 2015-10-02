DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetParkingFields`( IN in_parking_id INT )
BEGIN

	SELECT pf.parking_id, pf.field_id, f.field_name, pf.required, f.type, f.attributes, f.label
	FROM   PARKING_FIELD pf, FIELD f
	WHERE  pf.field_id = f.field_id
	AND    parking_id = in_parking_id
	ORDER  BY -f.sortorder DESC;

END$$
DELIMITER ;
