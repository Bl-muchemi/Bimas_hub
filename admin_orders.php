<?php
include "includes/db.php";
?>

<h2>Admin Orders Dashboard</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Order ID</th>
    <th>Phone</th>
    <th>Total</th>
    <th>Status</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");

while($row = $result->fetch_assoc()){
?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['phone'] ?></td>
    <td>KES <?= number_format($row['total_amount']) ?></td>
    <td><?= $row['status'] ?></td>
    <td><?= $row['created_at'] ?></td>
    <td>
        <form method="POST" action="update_status.php">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <select name="status">
                <option>Pending</option>
                <option>Processing</option>
                <option>Delivered</option>
            </select>
            <button>Update</button>
        </form>
    </td>
</tr>
<?php } ?>

</table>