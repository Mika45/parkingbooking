-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`tmihalis_park`@`localhost` FUNCTION `GetAvailability`(p_parking_id INT, p_date_from VARCHAR(10), p_hour_from VARCHAR(10), p_date_to VARCHAR(10), p_hour_to VARCHAR(10)) RETURNS varchar(1) CHARSET latin1
BEGIN

	DECLARE v_status VARCHAR(1) DEFAULT 'Y';
	DECLARE v_from_datetime, v_to_datetime DATETIME;

	SET 	v_from_datetime = CONCAT(p_date_from, ' ', p_hour_from);
	SET 	v_to_datetime 	= CONCAT(p_date_to, ' ', p_hour_to);

	CASE WHEN p_parking_id = 11 THEN
		CASE 
			WHEN DATE_FORMAT(p_date_from, '%w') IN (1, 3, 5) THEN
				# If it's Monday, Wednesday or Friday
				IF (p_hour_from NOT BETWEEN '08:00' AND '15:00' AND p_hour_from NOT BETWEEN '17:00' AND '22:00') THEN
					SET v_status = 'N';
				END IF;
			WHEN DATE_FORMAT(p_date_from, '%w') IN (2, 4, 6) THEN
				# If it's Tuesday, Thursday or Saturday
				IF (p_hour_from NOT BETWEEN '08:00:00' AND '15:00:00') THEN
					SET v_status = 'N';
				END IF;
			WHEN DATE_FORMAT(p_date_from, '%w') = 0 THEN 
				# Closed on Sundays
				SET v_status = 'N';
		END CASE;

		CASE
			# Time to check the pick-up datetime
			WHEN DATE_FORMAT(p_date_to, '%w') IN (1, 3, 5) THEN
				# If it's Monday, Wednesday or Friday
				IF (p_hour_to NOT BETWEEN '08:00' AND '15:00' AND p_hour_to NOT BETWEEN '17:00' AND '22:00') THEN
					SET v_status = 'N';
				END IF;
			WHEN DATE_FORMAT(p_date_to, '%w') IN (2, 4, 6) THEN
				# If it's Tuesday, Thursday or Saturday
				IF (p_hour_to NOT BETWEEN '08:00:00' AND '15:00:00') THEN
					SET v_status = 'N';
				END IF;
			WHEN DATE_FORMAT(p_date_to, '%w') = 0 THEN 
				# Closed on Sundays
				SET v_status = 'N';
		END CASE;

	WHEN p_parking_id = 16 THEN # Parking Kentavron & Ifestou Larisa
		CASE 
			WHEN DATE_FORMAT(p_date_from, '%w') BETWEEN 1 AND 5 THEN
				# From Monday to Friday
				IF (p_hour_from NOT BETWEEN '08:00' AND '23:00') THEN
					SET v_status = 'N';
				END IF;
			WHEN DATE_FORMAT(p_date_from, '%w') IN (6) THEN
				# On Saturday
				IF (p_hour_from NOT BETWEEN '08:00' AND '16:00') THEN
					SET v_status = 'N';
				END IF;
			WHEN DATE_FORMAT(p_date_from, '%w') = 0 THEN 
				# Closed on Sundays
				SET v_status = 'N';
		END CASE;

		CASE
			# Time to check the pick-up datetime
			WHEN DATE_FORMAT(p_date_to, '%w') BETWEEN 1 AND 5 THEN
				# From Monday to Friday
				IF (p_hour_to NOT BETWEEN '08:00' AND '23:00') THEN
					SET v_status = 'N';
				END IF;
			WHEN DATE_FORMAT(p_date_to, '%w') IN (6) THEN
				# On Saturday
				IF (p_hour_to NOT BETWEEN '08:00' AND '16:00') THEN
					SET v_status = 'N';
				END IF;
			WHEN DATE_FORMAT(p_date_to, '%w') = 0 THEN 
				# Closed on Sundays
				SET v_status = 'N';
		END CASE;

	WHEN p_parking_id IN (15,17) THEN
	
		CASE 
			WHEN DATE_FORMAT(p_date_from, '%w') BETWEEN 1 AND 5 THEN
				# From Monday to Friday
				IF (DATE_FORMAT(v_from_datetime,'%H:%i') NOT BETWEEN '07:30' AND '16:00') THEN
					SET v_status = 'N';
				END IF;
			ELSE SET v_status = 'N';
		END CASE;

		CASE
			# Time to check the pick-up datetime
			WHEN DATE_FORMAT(p_date_to, '%w') BETWEEN 0 AND 6 THEN
				# From Monday to Friday
				IF (DATE_FORMAT(v_to_datetime,'%H:%i') NOT BETWEEN '07:30' AND '23:59') THEN
					SET v_status = 'N';
				END IF;
		END CASE;

	ELSE SET v_status = 'Y';
	END CASE;

RETURN v_status;
END