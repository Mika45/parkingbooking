CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `tmihalis_park`@`localhost` 
    SQL SECURITY DEFINER
VIEW `LOCATIONS_V` AS
    select 
        `la`.`location_id` AS `location_id`,
        `la`.`name` AS `name`,
        (case
            when (`la`.`status` = 'A') then 'Active'
            when (`la`.`status` = 'I') then 'Inactive'
        end) AS `status`,
        (select 
                `lb`.`name`
            from
                `LOCATION` `lb`
            where
                (`lb`.`location_id` = `la`.`location_parent_id`)) AS `parent_name`,
        `la`.`lat` AS `lat`,
        `la`.`lng` AS `lng`,
        `la`.`currency` AS `currency`,
        `la`.`currency_order` AS `currency_order`
    from
        `LOCATION` `la`
    order by (select 
            `lb`.`name`
        from
            `LOCATION` `lb`
        where
            (`lb`.`location_id` = `la`.`location_parent_id`)) , `la`.`name`