DROP PROCEDURE IF EXISTS GetLocationParkings;
CREATE PROCEDURE `GetLocationParkings`( IN in_location_id INT )
BEGIN

	SELECT p.*, 0 AS price
	FROM   PARKING_LOCATION pl, PARKING p
	WHERE  pl.parking_id = p.parking_id
	AND    pl.location_id = in_location_id;

END;