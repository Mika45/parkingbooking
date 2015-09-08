-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetResults`(IN in_location_id INT,
																  IN in_date_from   VARCHAR(10),
																  IN in_hour_from   VARCHAR(10),
																  IN in_date_to 	VARCHAR(10),
																  IN in_hour_to     VARCHAR(10),
																  IN in_locale      VARCHAR(10))
BEGIN

	DECLARE v_from_datetime, v_to_datetime DATETIME;
	SET 	v_from_datetime = CONCAT(in_date_from, ' ', in_hour_from);
	SET 	v_to_datetime 	= CONCAT(in_date_to, ' ', in_hour_to);
	
	SELECT u.parking_id,
		   u.parking_name,
		   u.timezone, 
		   u.early_booking, 
		   u.status AS active_status, 
		   CASE WHEN (IFNULL(u.price,0) <= 0) THEN 'N'
		   WHEN ( u.slots <= IFNULL(u.checked_in, 0) OR u.slots <= IFNULL(u.checked_in ,0) ) THEN 'N'
		   ELSE GetAvailability(u.parking_id, in_date_from, in_hour_from, in_date_to, in_hour_to) END AS available,
		   u.gt_early_bkg, 
		   u.gt_min_dur, 
		   IF (IFNULL(u.offer, 0) > 0, u.offer, u.price) AS price, 
		   u.utc, 
		   u.description, 
		   u.find_it, 
		   u.address, 
		   u.reserve_notes,
		   u.gmaps,
		   u.lat,
		   u.lng,
		   u.currency, 
		   u.currency_order
	FROM   (
			SELECT p.*,
				   b.checked_in,
				   CASE WHEN TIMESTAMPDIFF( HOUR, UTC_TIMESTAMP, v_from_datetime ) >= p.early_booking THEN 1 
				   ELSE 0 
				   END AS gt_early_bkg,
				   CASE WHEN TIMESTAMPDIFF( HOUR, v_from_datetime, v_to_datetime ) >= p.min_duration THEN 1 
				   ELSE 0 
				   END AS gt_min_dur,
				   GetPrice(pl.parking_id, p.rate_type, v_from_datetime, v_to_datetime) AS price,
				   GetOffer(pl.parking_id, p.rate_type, v_from_datetime, v_to_datetime) AS offer,
				   UTC_TIMESTAMP AS utc,
				   c.currency,
				   c.currency_order
			FROM   PARKING_LOCATION pl 
				   LEFT JOIN 
					 (SELECT parking_id,
							 SUM( IF(v_from_datetime BETWEEN checkin AND checkout, 1, 0) ) AS checked_in,
							 SUM( IF(v_to_datetime BETWEEN checkin AND checkout, 1, 0) ) AS checked_out
					  FROM   BOOKING
					  WHERE  IFNULL(status, 'X') != 'C'
					  GROUP  BY parking_id) b ON b.parking_id = pl.parking_id, 
				   PARKING p LEFT JOIN (SELECT c.parking_id,
											   GROUP_CONCAT(if(c.conf_name = 'CURRENCY', c.value, NULL)) AS currency,
											   GROUP_CONCAT(if(c.conf_name = 'CURRENCY_ORDER', c.value, NULL)) AS currency_order
										FROM   CONFIGURATION c
										WHERE  c.conf_name LIKE 'CURRENCY%'
										GROUP  BY c.parking_id) c ON (p.parking_id = c.parking_id)
			WHERE  pl.location_id = in_location_id
			AND    pl.parking_id = p.parking_id
			AND    p.status = 'A'
			AND    pl.status = 'A'
			) u
	ORDER   BY available DESC, -u.price DESC;

END