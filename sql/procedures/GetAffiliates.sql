DROP PROCEDURE IF EXISTS GetAffiliates;
CREATE PROCEDURE GetAffiliates()
BEGIN

	SELECT a.*, u.email AS user_email
   FROM   AFFILIATE a
          LEFT JOIN USER u ON (a.user_id = u.user_id);

END;