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
		   GROUP_CONCAT(if(c.conf_name = 'CURRENCY', value, NULL)) AS currency,
		   GROUP_CONCAT(if(c.conf_name = 'CURRENCY_ORDER', value, NULL)) AS currency_order,
		   b.title,
		   b.firstname,
		   b.lastname,
		   b.mobile,
		   b.email,
		   b.car_make,
		   b.car_model,
		   b.car_reg,
		   b.car_colour,
		   b.passengers,
		   DATE_FORMAT(b.created_at, '%d/%m/%Y %H:%i') AS booked_at,
		   p.description,
		   p.reserve_notes,
		   p.find_it,
		   p.phone1,
		   p.phone2,
		   p.mobile AS pmobile,
		   pc.code AS phone_code
	FROM   BOOKING b
		   LEFT JOIN PHONE_CODE pc ON (pc.country_id = b.country_id),
		   PARKING p
		   LEFT JOIN CONFIGURATION c ON (c.parking_id = p.parking_id AND c.conf_name in ('CURRENCY', 'CURRENCY_ORDER'))
	WHERE  b.parking_id = p.parking_id
    AND    b.booking_id = in_booking_id
	GROUP  BY c.parking_id;

END$$
DELIMITER ;
