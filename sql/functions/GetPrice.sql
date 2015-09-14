-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`tmihalis_park`@`localhost` FUNCTION `GetPrice`(p_parking_id INT, p_rate_type VARCHAR(1), p_date_from DATETIME, p_date_to DATETIME) RETURNS decimal(8,2)
BEGIN

	DECLARE v_dur_hours, v_dur_days INT;
	DECLARE v_price, v_offer DECIMAL(8,2);

	SET v_dur_hours = TIMESTAMPDIFF(HOUR, p_date_from, p_date_to);
	SET v_dur_days 	= CEIL((TIMESTAMPDIFF(MINUTE, p_date_from, p_date_to)/60)/24);

	IF p_rate_type = 'H' THEN
		SELECT TRUNCATE(IFNULL(rh.price,0) + ((v_dur_hours - MOD(v_dur_hours, 24))/24)* rh2.price, 2)
		INTO   v_price
		FROM   RATE_HOURLY rh2 LEFT JOIN RATE_HOURLY rh ON rh2.parking_id = rh.parking_id AND rh.hours = MOD(v_dur_hours, 24)
		WHERE  rh2.parking_id = p_parking_id
		AND    rh2.hours = 24;
	ELSEIF p_rate_type = 'D' THEN
		/*SELECT ROUND( MIN(rd.day * rd.price), 2)
		INTO   v_price
		FROM   RATE_DAILY rd
		WHERE  rd.parking_id = p_parking_id
		AND    rd.day > ( DATEDIFF(p_date_to, p_date_from) + 1 );*/
		SELECT TRUNCATE(IFNULL(rd.price,0) + ((v_dur_days - MOD(v_dur_days, 31))/31)* rd2.price, 2)
		INTO   v_price
		FROM   RATE_DAILY rd2 LEFT JOIN RATE_DAILY rd ON rd2.parking_id = rd.parking_id AND rd.day = MOD(v_dur_days, 31)
		WHERE  rd2.parking_id = p_parking_id
		AND    rd2.day = (SELECT MAX(day) 
						  FROM 	 RATE_DAILY rd3
						  WHERE  rd3.parking_id = rd2.parking_id);
	END IF;


RETURN v_price;

END