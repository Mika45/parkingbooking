DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetAvailability`(IN `in_location_id` INT, IN `in_date_from` VARCHAR(10), IN `in_hour_from` VARCHAR(10), IN `in_date_to` VARCHAR(10), IN `in_hour_to` VARCHAR(10), IN `in_locale` VARCHAR(10))
BEGIN

   SELECT u.parking_id, 
		    u.parking_name,
          u.timezone,
          u.early_booking,
		    u.active_status,
		    u.min_remain_slots,
          u.available_at_dropoff,
          u.available_at_pickup,
		    CASE
		       WHEN available_at_dropoff = 0 THEN 'N'
             WHEN available_at_pickup = 0 THEN 'N'
             WHEN gt_min_dur = 0 THEN 'N'
             WHEN price IS NULL THEN 'N'             
			    ELSE 'Y'
		    END available,
          u.gt_early_bkg,
		    u.gt_min_dur,
		    u.price,
		    u.price2,
		    u.utc,
		    u.description,
		    u.find_it,
		    u.image_count,
		    u.address,
		    u.reserve_notes,
		    u.gmaps,
		    u.lat,
		    u.lng,
          u.currency,
          u.currency_order
	  FROM (
              SELECT p.parking_id,
					      p.parking_name,
					      MIN(a.status) active_status,
					      MIN(a.remaining_slots) min_remain_slots,
					      (SELECT COUNT(*)
                      FROM   AVAILABILITY a2
                      WHERE  a2.parking_id = a.parking_id
                      AND    a2.date = in_date_from
                      AND    in_hour_from BETWEEN IFNULL(a2.time_start,'00:00') AND IFNULL(a2.time_end,'23:59')) available_at_dropoff,
                     (SELECT COUNT(*)
                      FROM   AVAILABILITY a2
                      WHERE  a2.parking_id = a.parking_id
                      AND    a2.date = in_date_to
                      AND    in_hour_to BETWEEN IFNULL(a2.time_start,'00:00') AND IFNULL(a2.time_end,'23:59')) available_at_pickup,
					      CASE 
						      WHEN TIMESTAMPDIFF( HOUR, UTC_TIMESTAMP, CONCAT(in_date_from, ' ', in_hour_from) ) >= p.early_booking THEN 1 
						      ELSE 0 
					      END gt_early_bkg,
					      CASE 
						      WHEN TIMESTAMPDIFF( HOUR, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) >= p.min_duration THEN 1 
						      ELSE 0 
					      END gt_min_dur,
					      CASE 
						      WHEN p.rate_type='D' THEN
						         (SELECT ROUND( (DATEDIFF(in_date_to , in_date_from) + 1)*rt1.price, 2)
      							 FROM   RATE_DAILY rt1 
      							 WHERE  rt1.parking_id = p.parking_id
      							 AND    rt1.day = (SELECT MAX(rt12.day) 
         											    FROM   RATE_DAILY rt12 
         											    WHERE  rt12.parking_id = rt1.parking_id
         											    AND    rt12.day <= (DATEDIFF(in_date_to , in_date_from) + 1)))
					         WHEN p.rate_type='H' AND ((TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ))/60) >= 720 THEN
                        #
                         /*(SELECT TRUNCATE(u.base_price + ((u.d-MOD(u.d,24))/24)*u.price, 2)
                           FROM   (
         						         SELECT MOD((TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60, 24), 
                                           (TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60 AS d,
                                           (27-MOD(27, 24))/24 AS d_mod_d,
                                           rh.price, rh.hours, rh.parking_id,
                                           IFNULL((SELECT rh2.price
                                                   FROM   RATE_HOURLY rh2 
                                                   WHERE  rh2.parking_id = rh.parking_id
                                                   AND    rh2.hours = MOD((TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60, 24)),0) base_price
                                    FROM   RATE_HOURLY rh
                                    WHERE  rh.parking_id = 11
                                    AND    rh.hours = 24
                                 ) u WHERE u.parking_id = p.parking_id)*/
                           
                           # duration = 800 hours
                          ( SELECT TRUNCATE((
                                  (u.off / 720) * u.offer_month
                                  +
                                  (u.off_basic / 24) * (SELECT rhu.price
                                                        FROM   RATE_HOURLY rhu
                                                        WHERE  rhu.parking_id = u.parking_id
                                                        AND    rhu.hours = 24)
                                  +
                                  IFNULL(rh2.price, 0)),2) AS offer
                           FROM (
                                    SELECT MOD((TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60,720) rem,
                                           (TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60 - MOD((TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60,720) off,
                                           MOD(MOD((TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60,720),24) rem_basic,
                                           MOD((TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60,720) - MOD(MOD((TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60,720),24) off_basic,
                                           c.value AS offer_month,
                                           c.parking_id,
                                           (TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60 dur_h
                                    FROM   CONFIGURATION c, RATE_HOURLY rh
                                   # WHERE  c.parking_id = 11
                                    WHERE    c.conf_name = 'OFFER_MONTH'
                                    AND c.parking_id = rh.parking_id
                                    AND   rh.hours = 24
                                 ) u LEFT JOIN RATE_HOURLY rh2
                           ON (rh2.parking_id = u.parking_id
                           AND   rh2.hours = u.rem_basic)
                           #WHERE u.parking_id = p.parking_id
                           )
                           WHEN p.rate_type='H' THEN
                              (SELECT TRUNCATE(u.base_price + ((u.d-MOD(u.d,24))/24)*u.price, 2)
                                 FROM   (
               						         SELECT MOD((TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60, 24), 
                                                 (TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60 AS d,
                                                 rh.price, rh.hours, rh.parking_id,
                                                 IFNULL((SELECT rh2.price
                                                         FROM   RATE_HOURLY rh2 
                                                         WHERE  rh2.parking_id = rh.parking_id
                                                         AND    rh2.hours = MOD((TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) ) - IFNULL(rh.free_mins,0))/60, 24)),0) base_price
                                          FROM   RATE_HOURLY rh
                                          WHERE  rh.parking_id = 11
                                          AND    rh.hours = 24
                                       ) u WHERE u.parking_id = p.parking_id)
					         END price,
					      CASE 
						      WHEN p.rate_type='D' THEN
						         (SELECT ROUND( MIN(rt1.day*rt1.price), 2)
      							 FROM   RATE_DAILY rt1 
      							 WHERE  rt1.parking_id = p.parking_id
      							 AND    rt1.day > (DATEDIFF( in_date_to , in_date_from )+1) )
						      WHEN p.rate_type='H' THEN
      						   (SELECT ROUND( MIN(rt2.hours*rt2.price), 2 )
      							 FROM   RATE_HOURLY rt2 
      							 WHERE  rt2.parking_id = p.parking_id
      							 AND    rt2.hours > CEIL(TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) )/60) )
					      END price2,
					      UTC_TIMESTAMP utc,
					      p.description,
					      p.find_it,
					      p.image_count,
					      IFNULL(t.value, p.address) AS address,
					      p.reserve_notes,
					      p.gmaps,
					      p.lat,
					      p.lng,
                     p.timezone,
                     p.early_booking,
                     c.currency,
                     c.currency_order
				  FROM   PARKING p 
                     LEFT JOIN TRANSLATION t ON (p.parking_id = t.identifier AND t.table_name = 'PARKING' AND t.column_name = 'address' AND t.locale = in_locale)
					      LEFT JOIN (SELECT c.parking_id,
                                       GROUP_CONCAT(if(c.conf_name = 'CURRENCY', c.value, NULL)) AS currency,
                                       GROUP_CONCAT(if(c.conf_name = 'CURRENCY_ORDER', c.value, NULL)) AS currency_order
                                FROM   CONFIGURATION c
                                WHERE  c.conf_name LIKE 'CURRENCY%'
                                GROUP  BY c.parking_id) c ON (p.parking_id = c.parking_id),
                     PARKING_LOCATION pl, 
					      AVAILABILITY a
   			  WHERE  p.parking_id = pl.parking_id
   			  AND    p.parking_id = a.parking_id
   			  AND    p.status = 'A'
   			  AND    pl.status = 'A'
   			  AND    a.status = 'A'
   			  AND    pl.location_id = in_location_id
   			  AND    a.date BETWEEN in_date_from AND in_date_to
   			  AND    a.remaining_slots > 0
   			  GROUP  BY p.parking_id, p.parking_name
   			  HAVING COUNT(a.parking_id) >= DATEDIFF(in_date_to , in_date_from) + 1
           ) u;

END$$
DELIMITER ;
