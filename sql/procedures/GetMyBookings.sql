DROP PROCEDURE IF EXISTS tmihalis_parkdem.GetMyBookings;
CREATE PROCEDURE tmihalis_parkdem.`GetMyBookings`(IN `in_email` VARCHAR(50), IN in_user_id INT )
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
          CASE 
            WHEN checkin < SYSDATE() THEN 'N' 
            WHEN TIMESTAMPDIFF(HOUR, SYSDATE(), b.checkin) < IFNULL(c.value,0) THEN 'N'
            ELSE 'Y' 
          END AS can_amend
   FROM   BOOKING b,
        PARKING p
          LEFT JOIN CONFIGURATION c ON (p.parking_id = c.parking_id AND c.conf_name = 'CANCEL_THRESHOLD')
   WHERE  b.parking_id = p.parking_id
   AND   (b.email = in_email OR b.user_id = in_user_id)
   AND   IFNULL(b.status,'A') != 'C' /* Not Cancelled */
   ORDER  BY b.booking_id DESC;

END;