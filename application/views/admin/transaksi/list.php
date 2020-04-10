<table class="table table-bordered"> 
<thead>
	<tr class="bg-success">
		<th>NO</th>
		<th>CUSTOMER</th>
		<th>KODE</th>
		<th>TANGGAL</th>
		<th>JUMLAH TOTAL</th>
		<th>JUMLAH ITEM</th>
		<th>STATUS BAYAR</th>
		<th>STATUS KIRIM</th>
		<th>ACTION</th>
	</tr>
</thead>
<tbody>
	
	<?php $i=1; foreach($header_transaksi as $header_transaksi) { ?>
	<tr>
		<td><?php echo $i ?></td>
		<td><?php echo $header_transaksi->nama_customer ?>
			<br><small>
				Telepon: <?php echo $header_transaksi->telepon ?>
				<br>Email: <?php echo $header_transaksi->email ?>
				<br>Alamat Kirim: <br><?php echo nl2br($header_transaksi->alamat)  ?>
			</small>
		</td>
		<td><?php echo $header_transaksi->kode_transaksi ?></td>
		<td><?php echo date('d-m-Y',strtotime($header_transaksi->tanggal_transaksi)) ?></td>
		<td><?php echo number_format($header_transaksi->jumlah_transaksi) ?></td>
		<td><?php echo $header_transaksi->total_item ?></td>
		<td><?php echo $header_transaksi->status_bayar ?></td>
		<td><?php echo $header_transaksi->status_kirim ?></td>
		<td>
			<div class="btn-group">
				<a href="<?php echo base_url('admin/transaksi/detail/'.$header_transaksi->kode_transaksi) ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i>Detail</a>

				<a href="<?php echo base_url('admin/transaksi/konfirmasi/'.$header_transaksi->kode_transaksi) ?>" class="btn btn-info btn-sm"><i target="_blank" class="fa fa-upload"></i>Konfirmasi kirim</a>
			</div>
		</td>
	</tr>
	<?php $i++; } ?>
</tbody>
</table>
