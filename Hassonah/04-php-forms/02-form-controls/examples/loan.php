<html>
<head><title></title></head>
<body>
<b> Loan Application Form</b>
<br>
<br>

<?php
// Form example
$SalaryAllowance = $_POST["Salary"] / 5;
$AgeAllowance = $_POST["Age"] / 10 - ($_POST["Age"] % 10) / 10 - 1;
$LoanAllowance = $SalaryAllowance * $AgeAllowance;
echo "Loan wanted:$_POST[Loan]<br>";
echo "Loan amount we will allow:$LoanAllowance<br><br>";
if ($_POST["Loan"] < $LoanAllowance) {
    echo "Yes, $_POST[FirstName]
$_POST[LastName], we are delighted to accept your application";
}
if ($_POST["Loan"] > $LoanAllowance) {
    echo "Sorry, $_POST[FirstName]
$_POST[LastName], we cannot accept your application at this time";
}
?>
</body>
</html>


