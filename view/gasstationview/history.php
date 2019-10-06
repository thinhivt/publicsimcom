<?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
    include_once "{$base_dir}/layout/masteradmin.php";
?>
   <div class="card border bg-white rounded px-2 py-2">
        <div >
            <h5 class="">Lịch sử vận hành</h5>
        </div>
        <div  class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr class="bg-info text-white">
                        <th class="font-weight-bold text-center">STT</th>
                        <th class="font-weight-bold text-center">Xe</th>
                        <th class="font-weight-bold text-center">Người dùng</th>
                        <th class="font-weight-bold text-center">Nhiên liệu thêm</th>
                        <th class="font-weight-bold text-center">Thời gian</th>
                        <th class="font-weight-bold text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach ($statisticlist as $statistic): ?>
                    <tr>
                        <td class="text-center"><?php echo $i;  ?></td>
                        <td class="text-left"><?php echo $statistic->name;?></td>
                        <td class="text-left"><?php echo $statistic->hoten;?></td>
                        <td class="text-center"><?php echo $statistic->solit;?></td>
                        <td class="text-center"><?php echo $statistic->time;?></td>
                        <td class="text-center">
                            <form action="../../controller/UserController.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $parameter->id;?>">
                                <input type="hidden" name="action" value="workshift">
                                <button class="btn btn-danger btn-sm" type="submit">Kết thúc</button>
                            </form>
                        </td>
                    </tr>
                    <?php $i++;  ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
    include_once "{$base_dir}/layout/footeradmin.php";
?>