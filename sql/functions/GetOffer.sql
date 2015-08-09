-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`tmihalis_park`@`localhost` FUNCTION `GetOffer`(p_parking_id INT, p_rate_type VARCHAR(1), p_date_from DATETIME, p_date_to DATETIME) RETURNS decimal(8,2)
BEGIN

	DECLARE v_dur_mins, v_dur_hours INT;
	DECLARE v_offer DECIMAL(8,2);

	SET v_dur_mins = TIMESTAMPDIFF(MINUTE, p_date_from, p_date_to);
	SET v_dur_hours = TIMESTAMPDIFF(HOUR, p_date_from, p_date_to);

	CASE WHEN p_rate_type = 'H' THEN
		IF v_dur_hours BETWEEN 720 AND 8759 THEN # we have an offer here
			SELECT TRUNCATE( (
								(u.off / 720) * u.offer_month + (u.off_basic / 24) * (SELECT rhu.price
																					  FROM   RATE_HOURLY rhu
																					  WHERE  rhu.parking_id = u.parking_id
																					  AND    rhu.hours = 24)
								 + IFNULL(rh2.price, 0)), 2)
			INTO   v_offer
			FROM  (
					 SELECT MOD(( v_dur_mins - IFNULL(rh.free_mins,0))/60,720) rem,
							(v_dur_mins - IFNULL(rh.free_mins,0))/60 - MOD((v_dur_mins - IFNULL(rh.free_mins,0))/60,720) off,
							MOD(MOD((v_dur_mins - IFNULL(rh.free_mins,0))/60,720),24) rem_basic,
							MOD((v_dur_mins - IFNULL(rh.free_mins,0))/60,720) - MOD(MOD((v_dur_mins - IFNULL(rh.free_mins,0))/60,720),24) off_basic,
							c.value AS offer_month,
							c.parking_id,
							(v_dur_mins - IFNULL(rh.free_mins,0))/60 dur_h
					 FROM   CONFIGURATION c, RATE_HOURLY rh
					 WHERE  c.conf_name = 'OFFER_MONTH'
					 AND    c.parking_id = rh.parking_id
					 AND    rh.hours = 24
				   ) u LEFT JOIN RATE_HOURLY rh2 ON (rh2.parking_id = u.parking_id AND rh2.hours = u.rem_basic);
		ELSEIF v_dur_hours >= 8760 THEN # we have an offer here (year)
			SELECT TRUNCATE( (
								(u.off / 8760) * u.offer_month + (u.off_basic / 24) * (SELECT rhu.price
																					   FROM   RATE_HOURLY rhu
																					   WHERE  rhu.parking_id = u.parking_id
																					   AND    rhu.hours = 24)
								 + IFNULL(rh2.price, 0)), 2)
			INTO   v_offer
			FROM  (
					 SELECT MOD(( v_dur_mins - IFNULL(rh.free_mins,0))/60, 8760) rem,
							(v_dur_mins - IFNULL(rh.free_mins,0))/60 - MOD((v_dur_mins - IFNULL(rh.free_mins,0))/60, 8760) off,
							MOD(MOD((v_dur_mins - IFNULL(rh.free_mins,0))/60, 8760), 24) rem_basic,
							MOD((v_dur_mins - IFNULL(rh.free_mins,0))/60, 8760) - MOD(MOD((v_dur_mins - IFNULL(rh.free_mins,0))/60, 8760),24) off_basic,
							c.value AS offer_month,
							c.parking_id,
							(v_dur_mins - IFNULL(rh.free_mins,0))/60 dur_h
					 FROM   CONFIGURATION c, RATE_HOURLY rh
					 WHERE  c.conf_name = 'OFFER_YEAR'
					 AND    c.parking_id = rh.parking_id
					 AND    rh.hours = 24
				   ) u LEFT JOIN RATE_HOURLY rh2 ON (rh2.parking_id = u.parking_id AND rh2.hours = u.rem_basic);
		END IF;
	ELSE 
		SET v_offer = 0;
	END CASE;

RETURN v_offer;
END