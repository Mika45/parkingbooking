DROP PROCEDURE IF EXISTS GetParkingProductsTranslations;
CREATE PROCEDURE `GetParkingProductsTranslations`(IN `in_locale` VARCHAR(2), IN `in_parking_id` INT)
BEGIN

	SELECT GROUP_CONCAT(IF(column_name = 'name', value, NULL)) AS name,
          GROUP_CONCAT(IF(column_name = 'description', value, NULL)) AS description,
          tr.identifier AS product_id
   FROM   TRANSLATION tr
   WHERE  tr.table_name = 'PRODUCT'
   AND    tr.column_name IN ('name', 'description')
   AND    tr.locale = in_locale
   AND    tr.identifier IN (SELECT product_id
                            FROM   PRODUCT pr
                            WHERE  pr.parking_id = in_parking_id)
   GROUP  BY tr.identifier;

END;