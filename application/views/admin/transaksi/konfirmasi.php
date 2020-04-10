
<!-- Content page -->
<section class="bgwhite p-t-55 p-b-65">
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
			<div class="leftbar p-r-20 p-r-0-sm">
				<!--  -->
			</div>
		</div>

		<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
				
				<h1><?php echo $title ?></h1>
				<hr>
				<p>Berikut adalah konfirmasi pengiriman</p>

				<?php 
				// kalau ada transaksi, tampilkan tabel
				if($header_transaksi) { 
				?>

				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="20%">KODE TRANSAKSI</th>
							<th>: <?php echo $header_transaksi->kode_transaksi ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Jumlah total</td>
							<td>: <?php echo number_format($header_transaksi->jumlah_transaksi) ?></td>
						</tr>
						<tr>
							<td>Status bayar</td>
							<td>: <?php echo $header_transaksi->status_bayar. "(".$header_transaksi->tanggal_bayar.")";?></td>
						</tr>
						<tr>
							<td>Status kirim</td>
							<td>: 
									<?php echo $header_transaksi->status_kirim; ?>
							</td>
						</tr>
						<tr>
							<td>Tanggal kirim</td>
							<td>: <?php echo date('d-m-Y',strtotime($header_transaksi->tanggal_kirim)) ?></td>
						</tr>
							<tr>
							<td>Bukti kirim</td>
							<td>: <?php if($header_transaksi->bukti_kirim !="") { ?><img src="<?php echo base_url('assets/upload/image/'.$header_transaksi->bukti_kirim) ?>" class="img img-thumbnail" width="200">
							<?php }else{ echo 'Belum ada bukti kirim'; } ?>
							</td>
						</tr>
					</tbody>
				</table>

				<?php 
				// Error upload
				if(isset($error)) {
					echo '<p class="alert alert-warning">'.$error.'</p>';
				}

				// Notif error
				echo validation_errors('<p class="alert alert-warning">','</p>');

				// Form open 
				echo form_open_multipart(base_url('admin/transaksi/konfirmasi/'.$header_transaksi->kode_transaksi));

				 ?>

				 <table class="table">
				 	<thead>
				 		</tr>
				 	<tbody>
				 		<tr>
				 			<td>Tanggal Kirim</td>
				 			<td>
				 				<input type="text" name="tanggal_kirim" class="form-control-lg" placehoder="dd-mm-yyyy" value="<?php if(isset($_POST['tanggal_kirim'])) { echo set_value('tanggal_kirim'); }elseif($header_transaksi->tanggal_kirim!="") { echo $header_transaksi->tanggal_kirim; }else{ echo date('d-m-Y'); } ?>">
				 			</td>
				 		</tr>
				 		<!--
				 		<tr>
				 			<td>Jumlah Pembayaran</td>
				 			<td>
				 				<input type="number" name="jumlah_bayar" class="form-control-lg" placehoder="jumlah pembayaran" value="<?php if(isset($_POST['jumlah_bayar'])) { echo set_value('jumlah_bayar'); }elseif($header_transaksi->jumlah_bayar!="") { echo $header_transaksi->jumlah_bayar; }else{ echo $header_transaksi->jumlah_transaksi; } ?>">
				 			</td>
				 		<tr>
				 			<td>Nomor Rekening</td>
				 			<td>
				 				<input type="text" name="rekening_pembayaran" class="form-control" value="<?php echo $header_transaksi->rekening_pembayaran ?>" placeholder="Nomor Rekening">
				 			</td>
				 		</tr>
				 		<tr>
				 			<td>Nama Pemilik Rekening</td>
				 			<td>
				 				<input type="text" name="rekening_customer" class="form-control" value="<?php echo $header_transaksi->rekening_customer ?>" placeholder="Nama pemilik Rekening">
				 			</td>
				 		</tr> 
				 		-->
				 		<tr>
				 		<td>Upload Bukti Kirim</td>
				 			<td>
				 				<input type="file" name="bukti_kirim" class="form-control" placeholder="Upload Bukti Kirim">
				 			</td>
				 		</tr>
				 		<tr>
				 			<td></td>
				 			<td>
				 				<div class="btn-group">
				 					<button class="btn btn-success btn-lg" type="submit" name="submit"><i class="fa fa-upload"></i>Submit</button>

				 					<button class="btn btn-info btn-lg" type="reset" name="reset"><i class="fa fa-times"></i>Reset</button>
				 				</div>
				 			</td>
				 		</tr>
				 	</tbody>
				 </table>

				<?php 
				// FORM CLOSE
				echo form_close();

				// kalau ga ada tampilkan notifikasi
				}else{ ?>

					<p class="alert alert-success">
						<i class="fa fa-warning"></i> Belum ada data transaksi</p>
					</p>

				<?php } ?>
			
		</div>
	</div>
</div>
</section>
