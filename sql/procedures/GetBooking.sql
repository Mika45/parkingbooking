DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetBooking`(IN `in_booking_id` INT )
BEGIN

	SELECT b.booking_id,
		   b.booking_ref,
		   b.parking_id,
           p.parking_name,
           p.address,
		   DATE_FORMAT(b.checkin, '%d/%m/%Y %H:%i') AS checkin, 
		   DATE_FORMAT(b.checkout, '%d/%m/%Y %H:%i') AS checkout, 
		   b.price, 
		   b.title,
		   b.firstname,
		   b.lastname,
		   b.mobile,
		   b.email,
		   b.car_reg,
		   DATE_FORMAT(b.created_at, '%d/%m/%Y %H:%i') AS booked_at,
		   p.description,
		   p.reserve_notes,
		   p.find_it,
		   p.phone1,
		   p.phone2,
		   p.mobile
	FROM   BOOKING b, PARKING p
	WHERE  b.parking_id = p.parking_id
    AND    b.booking_id = in_booking_id;

END$$
DELIMITER ;
