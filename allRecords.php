<?php
    $dbServerName = "localhost";
    $dbUserName = "root";
    $dbpassword = "";
    $dbName = "practice";

    $conn = mysqli_connect($dbServerName, $dbUserName, $dbpassword, $dbName);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Document</title>

    <style>
        th{
            color: black;
            background-color: gray;
        }
    </style>
</head>
<body>      
    <?php
        //for employee records table
        $sql = "SELECT * from employee;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        
        //for accounts table
        $sql1 = "SELECT * FROM accounts;";
        $result1 = mysqli_query($conn, $sql1);

        //for status table
        $sql2 = "SELECT * from status;";
        $result2 = mysqli_query($conn, $sql2);

        //join query for seeing position of Trainees employees in each division..
        $sql3 = "SELECT employee.division as 'Division' , count(status.position) as 'Total Trainees' from employee 
        inner join status on employee.emp_id=status.emp_id 
        WHERE status.position='trainee' group by employee.division;";
        $result3 = mysqli_query($conn, $sql3);
        $output = mysqli_num_rows($result3);

        //join query for seeing position of Full-time employees in each division..
        $sql4 = "SELECT employee.division as 'Division' , count(status.position) as 'Total Fulltime' from employee 
        inner join status on employee.emp_id=status.emp_id 
        WHERE status.position='full-time' group by employee.division;";
        $result4 = mysqli_query($conn, $sql4);

        //employee with maximum and minimum salary
        $sql5 = "SELECT employee.name as 'Employee', max(accounts.salary) as 'Max-Salary' from employee inner join accounts
        on employee.emp_id=accounts.emp_id;";

        $sql6 = "SELECT employee.name as 'Employee', min(accounts.salary) as 'Min-Salary' from employee inner join accounts
        on employee.emp_id=accounts.emp_id;";

        $result5 = mysqli_query($conn, $sql5);
        $result6 = mysqli_query($conn, $sql6);

        //Average pay per division
        $sql7 = "SELECT employee.division as 'Division', avg(accounts.salary) as 'Avg Salary' from employee
        inner join accounts on employee.emp_id=accounts.emp_id group by division order by accounts.salary desc;";
        $result7 = mysqli_query($conn, $sql7);

        //trainees ko avg salaries kya mile
        $sql8 = "SELECT status.position as 'Position', avg(accounts.salary) as 'Avg Salary' from status inner join
        accounts on status.emp_id=accounts.emp_id WHERE status.position='trainee';";
        $result8 = mysqli_query($conn, $sql8);
        
        //full-time ko avg salaries kya mile
        $sql9 = "SELECT status.position as 'Position', avg(accounts.salary) as 'Avg Salary' from status inner join
        accounts on status.emp_id=accounts.emp_id WHERE status.position='full-time';";
        $result9 = mysqli_query($conn, $sql9);
    ?>

    <div class="container">
        <h2 class="heading" style="text-align: center;"> <ins>Database Employee Table</ins> </h2>
        <br>
        <table class="table table-striped table-dark">
            <tr>
                <th>Emp ID</th>
                <th>Name</th>
                <th>Division</th>
                <th>Email</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($result)) { 
            ?>
                <tr>
                    <td><?php echo $row['emp_id'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['division'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                </tr>
            <?php
            }
            ?>
            
        </table>

        <br><br>
        <h2 class="heading" style="text-align: center;"> <ins>Database Accounts Table</ins> </h2>
        <br>
        <table class="table table-striped table-dark">
            <tr>
                <th>Emp ID</th>
                <th>Salary</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($result1)) { 
            ?>
                <tr>
                    <td><?php echo $row['emp_id'] ?></td>
                    <td><?php echo $row['salary'] ?></td>
                </tr>
            <?php
            }
            ?>
            
        </table>

        <br><br>
        <h2 class="heading" style="text-align: center;"> <ins>Database Status Table</ins> </h2>
        <br>
        <table class="table table-striped table-dark">
            <tr>
                <th>Emp ID</th>
                <th>Position</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($result2)) { 
            ?>
                <tr>
                    <td><?php echo $row['emp_id'] ?></td>
                    <td><?php echo $row['position'] ?></td>
                </tr>
            <?php
            }
            ?>
            
        </table>

        <br><br>
        <h2 class="heading" style="text-align: center;"> <ins>Trainees in Every Division</ins> </h2>
        <br>
        <table class="table table-striped table-dark">
            <tr>
                <th>Division</th>
                <th>No: of Trainees</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($result3)) { 
            ?>
                <tr>
                    <td><?php echo $row['Division'] ?></td>
                    <td><?php echo $row['Total Trainees'] ?></td>
                </tr>
            <?php
            }
            ?>
            
        </table>

        <br><br>
        <h2 class="heading" style="text-align: center;"> <ins>Full-time in Every Division</ins> </h2>
        <br>
        <table class="table table-striped table-dark">
            <tr>
                <th>Division</th>
                <th>No: of Full-time</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($result4)) { 
            ?>
                <tr>
                    <td><?php echo $row['Division'] ?></td>
                    <td><?php echo $row['Total Fulltime'] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>

        <br><br>
        <h2 class="heading" style="text-align: center;"> <ins>Employee with Maximum Salary</ins> </h2>
        <br>
        <table class="table table-striped table-dark">
            <tr>
                <th>Employee</th>
                <th>Max-Salary</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($result5)) { 
            ?>
                <tr>
                    <td><?php echo $row['Employee'] ?></td>
                    <td><?php echo $row['Max-Salary'] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>

        <br><br>
        <h2 class="heading" style="text-align: center;"> <ins>Employee with Minimum Salary</ins> </h2>
        <br>
        <table class="table table-striped table-dark">
            <tr>
                <th>Employee</th>
                <th>Min-Salary</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($result6)) { 
            ?>
                <tr>
                    <td><?php echo $row['Employee'] ?></td>
                    <td><?php echo $row['Min-Salary'] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>

        <br><br>
        <h2 class="heading" style="text-align: center;"> <ins>Divisions with Average Salaries</ins> </h2>
        <br>
        <table class="table table-striped table-dark">
            <tr>
                <th>Division</th>
                <th>Avg Salary</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($result7)) { 
            ?>
                <tr>
                    <td><?php echo $row['Division'] ?></td>
                    <td><?php echo $row['Avg Salary'] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>

        <br><br>
        <h2 class="heading" style="text-align: center;"> <ins>Position with Average Salaries</ins> </h2>
        <br>
        <table class="table table-striped table-dark">
            <tr>
                <th>Position</th>
                <th>Avg Salary</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($result8)) { 
            ?>
                <tr>
                    <td><?php echo $row['Position'] ?></td>
                    <td><?php echo $row['Avg Salary'] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>

        <br><br>
        <h2 class="heading" style="text-align: center;"> <ins>Position with Average Salaries</ins> </h2>
        <br>
        <table class="table table-striped table-dark">
            <tr>
                <th>Position</th>
                <th>Avg Salary</th>
            </tr>
            <?php
                while($row = mysqli_fetch_assoc($result9)) { 
            ?>
                <tr>
                    <td><?php echo $row['Position'] ?></td>
                    <td><?php echo $row['Avg Salary'] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>

    </div>
    
</body>
</html>