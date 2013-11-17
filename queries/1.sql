insert into criteria (name, fetch_type, fetch_value, multiplier, calculation_type, year_limit)
  VALUES(
    "test criteria",
    "sql",
    "SELECT
    count(*)
    FROM
    ka_publ p,
    ka_publ_types t,
    ka_publ_staff s
    WHERE
    t.id = p.type_id
    AND s.publ_id = p.id
    AND t.id IN (8,9) -- монографии
    AND p.volume>=7 -- не менее 7 страниц
    AND p.period_id >= @from_period_id@
    AND p.period_id <= @to_period_id@
    AND s.staff_id = @staff_id@",
    "100",
    "sum",
    0)