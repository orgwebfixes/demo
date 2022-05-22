<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<style type="text/css" media="screen">
			table, th, td {
			    border: 1px solid black;
			    border-collapse: collapse;
			}
			th, td {
			    padding: 5px;
			    text-align: left;
			}
		</style>
	</head>
	<body>
		<table style="width: 100%;border: 1px solid black;border-collapse: collapse;">
			<tr>
				<th style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">Department</th>
				<td style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">{{number_format($department,2)}}</td>
			</tr>
			<tr>
				<th style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">Form Master</th>
				<td style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">{{number_format($form,2)}}</td>
			</tr>
			<tr>
				<th style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">Operator</th>
				<td style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">{{number_format($operator,2)}}</td>
			</tr>
			<tr>
				<th style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">Agency</th>
				<td style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">{{number_format($agency,2)}}</td>
			</tr>
			<tr>
				<th style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">Locker</th>
				<td style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">{{number_format($locker,2)}}</td>
			</tr>
			<tr>
				<th style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">Form Fillup</th>
				<td style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">{{number_format($formfillup,2)}}</td>
			</tr>
			<tr>
				<th style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">Aadhar Pvc Card</th>
				<td style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">{{number_format($pvccard,2)}}</td>
			</tr>
			<tr>
				<th style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">Wallet Balance</th>
				<td style="border: 1px solid black;border-collapse: collapse;padding: 5px;text-align: left;">{{number_format($wallet,2)}}</td>
			</tr>
		</table>
    </body>
</html>