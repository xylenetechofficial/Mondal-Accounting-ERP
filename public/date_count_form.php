<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <?php

                $string = '2022-10-13, 2022-10-16, 2022-10-25, 2022-10-28';

                $tags = explode(', ', $string);


                foreach ($tags as $i => $key) {
                    $i >= 1;
                    echo $i . ' ' . $key . '</br>';
                    echo count($tags);

                    $sql = "INSERT INTO `emp_attendance`(`emp_id`, `emp_no`, `attendance`, `in_time`, `in_time_latitude`, `in_time_longitude`, `in_time_location`, `out_time`, `out_time_latitude`, `out_time_longitude`, `out_time_location`, `hours`, `tot_hours`, `ot_hours`, `is_logged_in`, `date`, `created_at`, `updated_at`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]','[value-14]','[value-15]','[value-16]','[value-17]','[value-18]','[value-19]')";

                }

                ?>
            </div><!-- /.box -->
        </div>
    </div>
</section>