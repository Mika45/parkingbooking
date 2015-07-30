DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetMyBookings`(IN `in_user_id` VARCHAR(50) )
BEGIN

	SELECT b.booking_id, 
		   b.parking_id, 
		   DATE_FORMAT(b.checkin, '%d/%m/%Y %H:%i') AS checkin, 
		   DATE_FORMAT(b.checkout, '%d/%m/%Y %H:%i') AS checkout, 
		   b.price, 
		   b.car_reg,
		   #DATE_FORMAT(b.created_at, '%d/%m/%Y %H:%i') AS booked_at,
         DATE_FORMAT(b.created_at, '%d/%m/%Y') AS booked_at,
		   p.parking_name
	FROM   BOOKING b,
		   PARKING p
	WHERE  b.parking_id = p.parking_id
	AND	   b.user_id = in_user_id
	AND	   IFNULL(b.status,'A') != 'C' /* Not Cancelled */
	ORDER  BY b.booking_id DESC;

END$$
DELIMITER ;
