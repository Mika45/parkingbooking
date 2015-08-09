-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`tmihalis_park`@`localhost` FUNCTION `GetPrice`(p_parking_id INT, p_rate_type VARCHAR(1), p_date_from DATETIME, p_date_to DATETIME) RETURNS decimal(8,2)
BEGIN

	DECLARE v_dur_mins, v_dur_hours INT;
	DECLARE v_price, v_offer DECIMAL(8,2);

	SET v_dur_mins = TIMESTAMPDIFF(MINUTE, p_date_from, p_date_to);
	SET v_dur_hours = TIMESTAMPDIFF(HOUR, p_date_from, p_date_to);

	IF p_rate_type = 'H' THEN
		SELECT TRUNCATE(IFNULL(rh.price,0) + ((v_dur_hours - MOD(v_dur_hours, 24))/24)* rh2.price, 2)
		INTO   v_price
		FROM   RATE_HOURLY rh2 LEFT JOIN RATE_HOURLY rh ON rh2.parking_id = rh.parking_id AND rh.hours = MOD(v_dur_hours, 24)
		WHERE  rh2.parking_id = p_parking_id
		AND    rh2.hours = 24;
	ELSEIF p_rate_type = 'D' THEN
		SELECT ROUND( MIN(rd.day * rd.price), 2)
		INTO   v_price
		FROM   RATE_DAILY rd
		WHERE  rd.parking_id = p_parking_id
		AND    rd.day > ( DATEDIFF(p_date_to, p_date_from) + 1 );
	END IF;


RETURN v_price;

END