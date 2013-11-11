SELECT 
s.staff_id, s.author, p.name, staff.name
FROM
ka_publ p,
ka_publ_types t,
ka_publ_staff s
WHERE
t.id = p.type_id
AND s.publ_id = p.id
AND t.id IN (8,9)

-- PERIOD!
-- AND p.journal = 