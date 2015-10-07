-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`tmihalis_park`@`localhost` FUNCTION `GetPrice`(p_parking_id INT, p_rate_type VARCHAR(1), p_date_from DATETIME, p_date_to DATETIME) RETURNS decimal(8,2)
BEGIN # Get the price based on the given parking ID, rate type (H=Hourly, C=Calendar day, D=Daily) and dates

	DECLARE v_dur_hours, v_dur_days, v_free_mins INT;
	DECLARE v_price, v_offer DECIMAL(8,2);

	SET v_dur_hours = TIMESTAMPDIFF(HOUR, p_date_from, p_date_to);
	SET v_dur_days 	= CEIL((TIMESTAMPDIFF(MINUTE, p_date_from, p_date_to)/60)/24);

	IF p_rate_type = 'C' THEN # If we have a (C)alendar daily calculation
		SET v_dur_days 	= TIMESTAMPDIFF(DAY, DATE_FORMAT(p_date_from,'%Y-%m-%d'), DATE_FORMAT(p_date_to,'%Y-%m-%d')) + 1;
	END IF;

	IF p_rate_type = 'H' THEN
		SELECT TRUNCATE(IFNULL(rh.price,0) + ((v_dur_hours - MOD(v_dur_hours, 24))/24)* rh2.price, 2)
		INTO   v_price
		FROM   RATE_HOURLY rh2 LEFT JOIN RATE_HOURLY rh ON rh2.parking_id = rh.parking_id AND rh.hours = MOD(v_dur_hours, 24)
		WHERE  rh2.parking_id = p_parking_id
		AND    rh2.hours = 24;
	ELSEIF p_rate_type IN ('C', 'D') THEN # C=(C)alendar day, D=(D)aily (measures duration in days)
		IF p_parking_id = 23 THEN
			
			SELECT value
			INTO   v_free_mins
			FROM   CONFIGURATION
			WHERE  parking_id = p_parking_id
			AND	   conf_name = 'FREE_MINUTES';

			SET v_dur_days 	= CEIL(((TIMESTAMPDIFF(MINUTE, p_date_from, p_date_to)-IFNULL(v_free_mins,0))/60)/24);

			SELECT rd.price + CASE WHEN (v_dur_days/30) < 1 THEN (v_dur_days - MOD(v_dur_days,30)) ELSE (MOD(v_dur_days,30)) END *2 price
			INTO   v_price
			FROM RATE_DAILY rd
			WHERE rd.parking_id = p_parking_id
			AND rd.day = CASE WHEN (v_dur_days/30) < 1 THEN v_dur_days ELSE 30 END;

		ELSE

			SELECT TRUNCATE(IFNULL(rd.price,0) + ((v_dur_days - MOD(v_dur_days, 31))/31)* rd2.price, 2)
			INTO   v_price
			FROM   RATE_DAILY rd2 LEFT JOIN RATE_DAILY rd ON rd2.parking_id = rd.parking_id AND rd.day = MOD(v_dur_days, 31)
			WHERE  rd2.parking_id = p_parking_id
			AND    rd2.day = (SELECT MAX(day) 
							  FROM 	 RATE_DAILY rd3
							  WHERE  rd3.parking_id = rd2.parking_id);
		END IF;
	END IF;


RETURN v_price;

END