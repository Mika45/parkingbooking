DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetMyBookings`(IN `in_email` VARCHAR(50) )
BEGIN

	SELECT b.booking_id, 
		    b.parking_id, 
		    DATE_FORMAT(b.checkin, '%d/%m/%Y %H:%i') AS checkin, 
		    DATE_FORMAT(b.checkout, '%d/%m/%Y %H:%i') AS checkout, 
		    b.price, 
		    b.car_reg,
		    DATE_FORMAT(b.created_at, '%d/%m/%Y') AS booked_at,
		    p.parking_name,
          CASE WHEN checkin < SYSDATE() THEN 'N' ELSE 'Y' END AS can_view,
          CASE WHEN checkin < SYSDATE() THEN 'N' ELSE 'Y' END AS can_amend
	FROM   BOOKING b,
		    PARKING p
	WHERE  b.parking_id = p.parking_id
	AND	 b.email = in_email
	AND	 IFNULL(b.status,'A') != 'C' /* Not Cancelled */
	ORDER  BY b.booking_id DESC;

END$$
DELIMITER ;
