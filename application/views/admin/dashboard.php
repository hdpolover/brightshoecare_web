<?php 

?>
<!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-12 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Transaksi Laundry</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $this->db->count_all('transaksi',0); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-12 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Transaksi di Proses</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                
                <?php 
                $this->db->from('transaksi');
                $this->db->where('status',0);
                echo $this->db->count_all_results(); ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="far fa-hourglass fa-2x text-warning"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-12 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Transaksi Selesai</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                    <?php 
                $this->db->from('transaksi');
                $this->db->where('status',1);
                echo $this->db->count_all_results(); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-check fa-2x text-success"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div> <!-- END ROW-->


<div class="row">
    <div class="col-xl-12">
    	<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Pendapatan Perbulan</h6>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
              </div>
              <hr>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url('assets/')?>js/Chart.min.js"></script>
<script src="<?=base_url('assets/')?>js/demo/chart-area-demo.js"></script>

