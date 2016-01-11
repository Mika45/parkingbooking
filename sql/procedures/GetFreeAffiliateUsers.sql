DROP PROCEDURE IF EXISTS GetFreeAffiliateUsers;
CREATE PROCEDURE GetFreeAffiliateUsers()
BEGIN

	SELECT u.user_id, u.email, u.firstname, u.lastname 
   FROM   USER u
   WHERE  u.is_affiliate = 'Y'
   AND    u.status = 'A'
   AND    NOT EXISTS (SELECT NULL
                      FROM   AFFILIATE a
                      WHERE  a.user_id = u.user_id);

END;