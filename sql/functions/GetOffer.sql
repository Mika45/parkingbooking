-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`tmihalis_park`@`localhost` FUNCTION `GetOffer`(p_parking_id INT, p_rate_type VARCHAR(1), p_date_from DATETIME, p_date_to DATETIME) RETURNS decimal(8,2)
BEGIN

	DECLARE v_dur_mins, v_dur_hours, v_dur_days, v_month_hours, v_year_hours, v_month_days, v_year_days INT;
	DECLARE v_offer DECIMAL(8,2);

	SET v_dur_mins = TIMESTAMPDIFF(MINUTE, p_date_from, p_date_to);
	SET v_dur_hours = TIMESTAMPDIFF(HOUR, p_date_from, p_date_to);
	SET v_dur_days 	= CEIL((TIMESTAMPDIFF(MINUTE, p_date_from, p_date_to)/60)/24);

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
					 AND    c.parking_id = p_parking_id
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
					 AND    c.parking_id = p_parking_id
					 AND    rh.hours = 24
				   ) u LEFT JOIN RATE_HOURLY rh2 ON (rh2.parking_id = u.parking_id AND rh2.hours = u.rem_basic);
		END IF;
	WHEN p_rate_type = 'D' THEN
		SET v_month_days = 31;
		SET v_year_days = 300;
		IF v_dur_days BETWEEN 300 AND 365 THEN
			SET v_dur_days = 300;
		END IF;

		SELECT offer_year*years + offer_month*months + day_price AS offer
		INTO   v_offer
		FROM
		( 
			SELECT FLOOR(v_dur_days/v_year_days) years,
				   FLOOR( MOD(v_dur_days, v_year_days) / v_month_days) months,
				   MOD(MOD(v_dur_days, v_year_days), v_month_days) days_left,
				   GROUP_CONCAT(if(conf_name = 'OFFER_MONTH', value, NULL)) AS offer_month,
				   GROUP_CONCAT(if(conf_name = 'OFFER_YEAR', value, NULL)) AS offer_year,
				   IFNULL(rd.price,0) day_price
			FROM   CONFIGURATION c 
				   LEFT JOIN RATE_DAILY rd ON (c.parking_id = rd.parking_id AND rd.day = MOD(MOD(v_dur_days, v_year_days), v_month_days))
			WHERE  c.parking_id = p_parking_id
			AND    c.conf_name IN ('OFFER_MONTH', 'OFFER_YEAR')
			GROUP  BY c.parking_id
		) u;
	ELSE 
		SET v_offer = 0;
	END CASE;

RETURN IFNULL(v_offer,0);
END