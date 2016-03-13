DROP PROCEDURE IF EXISTS tmihalis_park.GetResults;
CREATE PROCEDURE tmihalis_park.`GetResults`(IN in_location_id INT,
														  IN in_date_from   VARCHAR(10),
														  IN in_hour_from   VARCHAR(10),
														  IN in_date_to 	  VARCHAR(10),
														  IN in_hour_to     VARCHAR(10),
														  IN in_booking_id  INT,
														  IN in_locale      VARCHAR(10))
BEGIN

	DECLARE v_from_datetime, v_to_datetime DATETIME;
	DECLARE v_parking_id INT;

	SET 	v_from_datetime = CONCAT(in_date_from, ' ', in_hour_from);
	SET 	v_to_datetime 	= CONCAT(in_date_to, ' ', in_hour_to);
	
	IF in_booking_id IS NOT NULL THEN
		SELECT parking_id INTO v_parking_id
		FROM   BOOKING
		WHERE  booking_id = in_booking_id;
	END IF;

	SELECT u.parking_id,
		    u.parking_name,
		    u.timezone, 
		    u.early_booking, 
		    u.status AS active_status, 
		    CASE WHEN ( u.slots <= IFNULL(u.checked_in, 0) OR u.slots <= IFNULL(u.checked_out, 0) ) THEN 'N'
             WHEN ( IFNULL(u.24hour,'N') = 'N' ) AND ( in_available = 0 OR out_available = 0 ) THEN 'N'
             WHEN ( gt_min_dur = 0 ) THEN 'N'
				ELSE 'Y' 
		    END AS available,
		    u.in_available,
		    u.out_available,
          u.rate_type,
          CEIL(TIMESTAMPDIFF(MINUTE, v_from_datetime, v_to_datetime)/60) AS duration_hours,
          CASE WHEN (u.rate_type = 'D') THEN
            CEIL(((TIMESTAMPDIFF(MINUTE, v_from_datetime, v_to_datetime) - u.free_minutes)/60)/24)
          WHEN (u.rate_type = 'C') THEN
            TIMESTAMPDIFF(DAY, DATE_FORMAT(in_date_from,'%Y-%m-%d'), DATE_FORMAT(in_date_to,'%Y-%m-%d')) + 1
          ELSE
            CEIL(((TIMESTAMPDIFF(MINUTE, v_from_datetime, v_to_datetime))/60)/24)
          END AS duration_days,
		    u.gt_early_bkg,
		    u.gt_min_dur,
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
   				     b.checked_out,
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
   				     c.currency_order,
                    IFNULL(c.free_minutes,0) AS free_minutes,
   				     (SELECT COUNT(*)
   					  FROM   DUAL
   					  WHERE  EXISTS (SELECT 1 
      								     FROM   PARKING_SCHEDULE ps
      								     WHERE  ps.parking_id = p.parking_id
      								     AND    ps.driving LIKE '%I%'
      								     AND 	ps.day = DAYOFWEEK(in_date_from)
      								     AND 	in_hour_from BETWEEN from_hour AND to_hour)) AS in_available,
   				     (SELECT COUNT(*)
   					   FROM   DUAL
   					   WHERE  EXISTS (SELECT 1 
         								   FROM   PARKING_SCHEDULE ps
         								   WHERE  ps.parking_id = p.parking_id
         								   AND    ps.driving LIKE '%O%'
         								   AND 	 ps.day = DAYOFWEEK(in_date_to)
         								   AND 	 in_hour_to BETWEEN from_hour AND to_hour)) AS out_available
   			 FROM   PARKING_LOCATION pl 
   				     LEFT JOIN 
   					    (SELECT parking_id,
         						   SUM( IF(v_from_datetime BETWEEN checkin AND checkout, 1, 0) ) AS checked_in,
         							SUM( IF(v_to_datetime BETWEEN checkin AND checkout, 1, 0) ) AS checked_out
         				  FROM   BOOKING
         				  WHERE  IFNULL(status, 'X') != 'C'
         				  AND	   booking_id != IFNULL(in_booking_id, 0)
         				  GROUP  BY parking_id) b ON b.parking_id = pl.parking_id,
   				     PARKING p LEFT JOIN (SELECT c.parking_id,
            											   GROUP_CONCAT(if(c.conf_name = 'CURRENCY', c.value, NULL)) AS currency,
            											   GROUP_CONCAT(if(c.conf_name = 'CURRENCY_ORDER', c.value, NULL)) AS currency_order,
                                                GROUP_CONCAT(if(c.conf_name = 'FREE_MINUTES', c.value, NULL)) AS free_minutes
            									  FROM   CONFIGURATION c
                                         WHERE  c.conf_name IN ('CURRENCY', 'CURRENCY_ORDER', 'FREE_MINUTES')
            									  GROUP  BY c.parking_id) c ON (p.parking_id = c.parking_id)
   			 WHERE  pl.location_id = in_location_id
   			 AND    pl.parking_id = p.parking_id
   			 AND    p.parking_id = IFNULL(v_parking_id, p.parking_id)
   			 AND    p.status = 'A'
   			 AND    pl.status = 'A'
   	    ) u
	ORDER  BY available DESC, -(CASE WHEN IFNULL(u.offer, 0) > 0 THEN u.offer ELSE u.price END) DESC;

END;
