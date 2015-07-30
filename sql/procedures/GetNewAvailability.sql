DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetNewAvailability`(IN `in_booking_id` INT, IN `in_date_from` VARCHAR(10), IN `in_hour_from` VARCHAR(10), IN `in_date_to` VARCHAR(10), IN `in_hour_to` VARCHAR(10))
BEGIN

  SELECT t.parking_id, 
		   t.parking_name,
		   t.active_status,
		   t.min_remain_slots, 
		   t.time_start,
		   t.time_end,
		   CASE
		     WHEN in_hour_from < t.time_start THEN 'N'
		     WHEN in_hour_to > t.time_end THEN 'N'
			 ELSE 'Y'
		   END available,
           t.gt_early_bkg,
		   t.gt_min_dur,
		   t.price,
		   t.price2,
		   t.utc,
		   t.description,
		   t.find_it,
		   t.image_count,
		   t.address,
		   t.reserve_notes,
		   t.gmaps,
		   t.lat,
		   t.lng
	  FROM (
				SELECT p.parking_id,
					    p.parking_name,
					    MIN(a.status) active_status,
					    MIN(a.remaining_slots) min_remain_slots,
					    (SELECT a2.time_start
						  FROM   AVAILABILITY a2 
						  WHERE  a2.parking_id = a.parking_id
						  AND    a2.date = in_date_from) time_start,
					    (SELECT a2.time_end 
						  FROM   AVAILABILITY a2 
						  WHERE  a2.parking_id = a.parking_id
						  AND    a2.date = in_date_to) time_end,
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
         											  AND    rt12.day <= (DATEDIFF(in_date_to , in_date_from) + 1)) )
					       WHEN p.rate_type='H' THEN
      						 (SELECT ROUND( CEIL(TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) )/60)*rt2.price, 2 )
      						  FROM   RATE_HOURLY rt2 
      						  WHERE  rt2.parking_id = p.parking_id
      						  AND    rt2.hours = (SELECT MAX(rt12.hours) 
            											  FROM   RATE_HOURLY rt12 
            											  WHERE  rt12.parking_id = rt2.parking_id
            											  AND    rt12.hours <= CEIL(TIMESTAMPDIFF( MINUTE, CONCAT(in_date_from, ' ', in_hour_from), CONCAT(in_date_to, ' ', in_hour_to) )/60) ) )
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
   					   p.address,
   					   p.reserve_notes,
   					   p.gmaps,
   					   p.lat,
   					   p.lng
   				FROM  PARKING p, 
   					   AVAILABILITY a,
                     BOOKING b
   				WHERE  b.booking_id = in_booking_id
               AND    p.parking_id = b.parking_id
   				AND    p.parking_id = a.parking_id
   				AND    p.status = 'A'
   				AND    a.status = 'A'
   				AND    a.date BETWEEN in_date_from AND in_date_to               
   				#AND    a.remaining_slots > 0
               AND    ( a.remaining_slots > 0 OR a.date BETWEEN DATE(b.checkin) AND DATE(b.checkout) )
   				GROUP  BY p.parking_id, p.parking_name
   				HAVING COUNT(a.parking_id) = DATEDIFF(in_date_to , in_date_from) + 1
               ) t;

END$$
DELIMITER ;
