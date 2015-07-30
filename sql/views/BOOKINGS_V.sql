CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `tmihalis_park`@`localhost` 
    SQL SECURITY DEFINER
VIEW `BOOKINGS_V` AS
    select 
        `b`.`booking_id` AS `booking_id`,
        `b`.`booking_ref` AS `booking_ref`,
        `b`.`user_id` AS `user_id`,
        `b`.`parking_id` AS `parking_id`,
        `p`.`parking_name` AS `parking_name`,
        date_format(`b`.`checkin`, '%d/%m/%Y %H:%i') AS `checkin`,
        date_format(`b`.`checkout`, '%d/%m/%Y %H:%i') AS `checkout`,
        `b`.`price` AS `price`,
        `b`.`title` AS `title`,
        `b`.`firstname` AS `firstname`,
        `b`.`lastname` AS `lastname`,
        `b`.`mobile` AS `mobile`,
        `b`.`email` AS `email`,
        `b`.`car_make` AS `car_make`,
        `b`.`car_model` AS `car_model`,
        `b`.`car_reg` AS `car_reg`,
        `b`.`car_colour` AS `car_colour`,
        `b`.`passengers` AS `passengers`,
        `b`.`status` AS `status`,
        date_format(`b`.`created_at`, '%d/%m/%Y %H:%i') AS `created_at`,
        date_format(`b`.`updated_at`, '%d/%m/%Y %H:%i') AS `updated_at`
    from
        (`BOOKING` `b`
        join `PARKING` `p`)
    where
        (`b`.`parking_id` = `p`.`parking_id`)
    order by `b`.`booking_id` desc