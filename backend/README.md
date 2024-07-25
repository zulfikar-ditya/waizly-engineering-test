## Please use pgsql, not mysql

Tested work 100% on Datagrip Console.

```sql
CREATE TABLE employees (
  employee_id INT PRIMARY KEY,
  name VARCHAR(255),
  job_title VARCHAR(255),
  salary DECIMAL(10,2),
  department VARCHAR(255),
  joined_date DATE,
  sales_id INT
);

CREATE TABLE sales_data (
  id INT PRIMARY KEY,
  employee_id INT,
  sales DECIMAL(10,2),
  FOREIGN KEY (employee_id) REFERENCES employees(employee_id)
);

INSERT INTO employees (employee_id, name, job_title, salary, department, joined_date, sales_id)
VALUES (1, 'John Smith', 'Manager', 60000.00, 'Sales', '2022-01-15', 1),
       (2, 'Jane Doe', 'Analyst', 45000.00, 'Marketing', '2022-02-01', 2),
       (3, 'Mike Brown', 'Developer', 55000.00, NULL, '2022-03-10', 3),
       (4, 'Anna Lee', 'Manager', 65000.00, 'Sales', '2021-12-05', NULL),
       (5, 'Mark Wong', 'Developer', 50000.00, '۱۳', '2023-05-20', NULL),
       (6, 'Emily Chen', 'Analyst', 48000.00, 'Marketing', '2023-06-02', NULL);

INSERT INTO sales_data (id, employee_id, sales)
VALUES (1, 1, 15000.00),
       (2, 2, 12000.00),
       (3, 3, 18000.00),
       (4, 1, 20000.00),
       (5, 4, 22000.00),
       (6, 5, 19000.00),
       (7, 6, 13000.00),
       (8, 2, 14000.00);

-- 1
SELECT * FROM employees;

-- 2
SELECT COUNT(*) FROM employees where job_title = 'Manager';

-- 3
SELECT name, salary FROM employees WHERE department IN ('Sales', 'Marketing');

-- 4
SELECT AVG(salary) AS avg_salary FROM employees WHERE joined_date >= CURRENT_DATE - interval '5 year';

-- 5
SELECT e.name, SUM(s.sales) AS total_sales FROM employees e JOIN sales_data s ON e.employee_id = s.employee_id GROUP BY e.employee_id, e.name ORDER BY total_sales DESC LIMIT 5;

-- 6
SELECT e.name, e.salary,
  (SELECT AVG(salary) FROM employees AS emp2 WHERE emp2.department = e.department) AS avg_dept_salary
FROM employees e
WHERE (SELECT AVG(salary) FROM employees AS emp2 WHERE emp2.department = e.department) >
  (SELECT AVG(salary) FROM employees);

-- 7
SELECT e.name, SUM(s.sales) AS total_sales,
  DENSE_RANK() OVER (ORDER BY SUM(s.sales) DESC) AS rank
FROM employees e
JOIN sales_data s ON e.employee_id = s.employee_id
GROUP BY e.employee_id, e.name
ORDER BY rank;

-- 8
SELECT e.name, SUM(e.salary) AS total_salary FROM employees e WHERE department = '<department_name>' GROUP BY e.employee_id, e.name;
```
