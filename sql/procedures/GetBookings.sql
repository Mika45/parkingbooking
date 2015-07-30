DELIMITER $$
CREATE DEFINER=`tmihalis_park`@`localhost` PROCEDURE `GetBookings`()
BEGIN

   SELECT b.booking_id, b.booking_ref, b.user_id, 
          b.parking_id, p.parking_name,
          DATE_FORMAT(b.checkin, '%d/%m/%Y %H:%i') AS checkin, 
          DATE_FORMAT(b.checkout, '%d/%m/%Y %H:%i') AS checkout, 
          b.price, 
          b.title, 
          b.firstname, 
          b.lastname, 
          b.mobile, 
          b.email,
          b.car_make, b.car_model, b.car_reg, b.car_colour, b.passengers, b.status, 
          DATE_FORMAT(b.created_at, '%d/%m/%Y %H:%i') AS created_at,
          DATE_FORMAT(b.updated_at, '%d/%m/%Y %H:%i') AS updated_at
   FROM   BOOKING b,
          PARKING p
   WHERE  b.parking_id = p.parking_id
   ORDER  BY b.booking_id DESC;

END$$
DELIMITER ;
