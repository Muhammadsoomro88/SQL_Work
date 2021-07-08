-- procedure with no parameters
CREATE PROCEDURE ShowContourEmp ()
BEGIN
select * from employee.details where company='Contour' OR company='contour';
END

-- procedure with parameters
create procedure showEmp(in comp char(5))
BEGIN
   select * from employee.detail where company=comp;
END

-- procedure call
call showEmp('Cake');

-- function with parameter
create function get_salary(salary interger)
returns varchar(10)
deterministic
BEGIN
  if salary>35000 THEN
   RETURN ("Good");
  ELSE
   RETURN ("Not Good");
  END IF;
END

-- calling function
SELECT get_salary(35000);

-- view
create cakecomp as
  select name from table where company='Cake';
  
  select * from cakecomp;

