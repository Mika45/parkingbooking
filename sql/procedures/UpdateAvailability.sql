DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `UpdateAvailability`( IN in_parking_id INT, 
																		   IN in_date_from  VARCHAR(10),
																		   IN in_date_to 	VARCHAR(10),
																		   IN in_action 	VARCHAR(1) )
BEGIN

	IF in_action = 'D' THEN
		UPDATE AVAILABILITY 
		   SET remaining_slots = remaining_slots - 1
		 WHERE parking_id = in_parking_id
		   AND date BETWEEN in_date_from AND in_date_to
		   AND remaining_slots > 0 
		   AND status = 'A';
	ELSEIF in_action = 'I' THEN
		UPDATE AVAILABILITY 
		   SET remaining_slots = remaining_slots + 1
		 WHERE parking_id = in_parking_id
		   AND date BETWEEN in_date_from AND in_date_to
		   AND status = 'A';
	END IF;
END$$
DELIMITER ;
